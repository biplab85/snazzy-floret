<?php
/**
 * Snazzy Floret — Order PDF Generator (mPDF)
 *
 * Generates a branded HTML-styled PDF invoice on order creation,
 * stores it in uploads/sf-orders/, and serves it via a secure endpoint.
 *
 * @package Snazzy_Floret
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once SF_THEME_DIR . '/inc/lib/vendor/autoload.php';

/**
 * Build, save and return the PDF path for an order.
 */
function sf_generate_order_pdf( $order_id ) {
	$order = wc_get_order( $order_id );
	if ( ! $order ) {
		return false;
	}

	$upload_dir = wp_upload_dir();
	$dir        = trailingslashit( $upload_dir['basedir'] ) . 'sf-orders';
	if ( ! file_exists( $dir ) ) {
		wp_mkdir_p( $dir );
		@file_put_contents( $dir . '/index.html', '' );
	}
	$file = $dir . '/order-' . $order_id . '.pdf';

	// Logo as data URI — try common filename variants in the theme.
	$logo_html  = '';
	$candidates = array(
		SF_THEME_DIR . '/assets/images/logo.png',
		SF_THEME_DIR . '/assets/images/Logo.png',
		SF_THEME_DIR . '/assets/images/Logo.svg',
		SF_THEME_DIR . '/assets/images/logo.svg',
	);
	foreach ( $candidates as $cand ) {
		if ( file_exists( $cand ) ) {
			$ext  = strtolower( pathinfo( $cand, PATHINFO_EXTENSION ) );
			$mime = ( 'svg' === $ext ) ? 'image/svg+xml' : 'image/png';
			$logo_html = '<img src="data:' . $mime . ';base64,' . base64_encode( file_get_contents( $cand ) ) . '" style="height:64px;" />';
			break;
		}
	}
	if ( ! $logo_html ) {
		$logo_html = '<div style="font-family:serif;font-size:22px;font-weight:700;color:#2C2C2C;">Snazzy Floret</div>';
	}

	// Pin every formatted price to the order's stored currency so the PDF
	// renders the right symbol regardless of who regenerates it later.
	$price_args = array( 'currency' => $order->get_currency() );

	// Items table rows.
	$rows = '';
	foreach ( $order->get_items() as $item ) {
		$rows .= '<tr>'
			. '<td style="padding:10px 8px;border-bottom:1px solid #E8E4DF;">' . esc_html( $item->get_name() ) . '</td>'
			. '<td style="padding:10px 8px;border-bottom:1px solid #E8E4DF;text-align:center;">' . esc_html( $item->get_quantity() ) . '</td>'
			. '<td style="padding:10px 8px;border-bottom:1px solid #E8E4DF;text-align:right;">' . wp_kses_post( wc_price( $order->get_item_subtotal( $item, false, true ), $price_args ) ) . '</td>'
			. '<td style="padding:10px 8px;border-bottom:1px solid #E8E4DF;text-align:right;">' . wp_kses_post( wc_price( $item->get_total(), $price_args ) ) . '</td>'
			. '</tr>';
	}

	$totals_rows = '';
	$totals      = array(
		'Subtotal' => wc_price( $order->get_subtotal(), $price_args ),
		'Shipping' => wc_price( $order->get_shipping_total(), $price_args ),
	);
	if ( $order->get_total_discount() > 0 ) {
		$totals['Discount'] = '-' . wc_price( $order->get_total_discount(), $price_args );
	}
	if ( $order->get_total_tax() > 0 ) {
		$totals['Tax'] = wc_price( $order->get_total_tax(), $price_args );
	}
	foreach ( $totals as $label => $val ) {
		$totals_rows .= '<tr><td style="padding:4px 8px;text-align:right;color:#6B6B6B;">' . esc_html( $label ) . '</td>'
			. '<td style="padding:4px 8px;text-align:right;width:120px;">' . wp_kses_post( $val ) . '</td></tr>';
	}

	$billing_phone = $order->get_billing_phone() ? '<br>' . esc_html( $order->get_billing_phone() ) : '';
	$billing_email = $order->get_billing_email() ? '<br>' . esc_html( $order->get_billing_email() ) : '';

	$html = '
	<style>
		body{font-family:dejavusans,sans-serif;color:#1A1A1A;font-size:11pt;}
		.brand{color:#2C2C2C;font-family:serif;font-size:20pt;font-weight:700;letter-spacing:1px;}
		.muted{color:#6B6B6B;font-size:9pt;}
		.gold{color:#8B6F4E;}
		.divider{border-top:2px solid #D4A76A;margin:8px 0 14px;}
		h2{font-family:serif;color:#8B6F4E;font-size:13pt;margin:18px 0 6px;border-bottom:1px solid #E8E4DF;padding-bottom:4px;}
		.meta td{padding:2px 0;font-size:10pt;}
		.addr{font-size:10pt;line-height:1.55;border:none;background:none;padding:0;}
		.addr-title{font-family:serif;color:#8B6F4E;font-size:11pt;font-weight:700;margin-bottom:6px;}
		table.items{width:100%;border-collapse:collapse;margin-top:6px;}
		table.items th{background:#F8F4EE;color:#2C2C2C;text-align:left;padding:10px 8px;font-size:10pt;border-bottom:2px solid #D4A76A;}
		table.items th.c{text-align:center;}
		table.items th.r{text-align:right;}
		.grand{font-family:serif;font-size:14pt;font-weight:700;color:#8B6F4E;border-top:2px solid #D4A76A;padding-top:8px;}
		.note{background:#FFF8EC;border-left:3px solid #D4A76A;padding:10px 14px;font-size:10pt;color:#5B5B5B;border-radius:4px;}
	</style>

	<table width="100%" style="margin-bottom:6px;"><tr>
		<td width="60%">' . $logo_html . '
			<div class="brand" style="margin-top:4px;">SNAZZY FLORET</div>
			<div class="muted">Dhaka, Bangladesh<br>+880 1621-008533 &bull; snazzyfloret@gmail.com</div>
		</td>
		<td width="40%" style="text-align:right;vertical-align:top;">
			<div style="font-family:serif;font-size:22pt;color:#2C2C2C;font-weight:700;">INVOICE</div>
			<table class="meta" style="margin-left:auto;text-align:right;">
				<tr><td class="muted">Order #&nbsp;</td><td><strong>' . esc_html( $order->get_order_number() ) . '</strong></td></tr>
				<tr><td class="muted">Date&nbsp;</td><td>' . esc_html( wc_format_datetime( $order->get_date_created() ) ) . '</td></tr>
				<tr><td class="muted">Status&nbsp;</td><td>' . esc_html( wc_get_order_status_name( $order->get_status() ) ) . '</td></tr>
				<tr><td class="muted">Payment&nbsp;</td><td>' . esc_html( $order->get_payment_method_title() ) . '</td></tr>
			</table>
		</td>
	</tr></table>
	<div class="divider"></div>

	<table width="100%"><tr>
		<td width="49%" style="vertical-align:top;">
			<div class="addr">
				<div class="addr-title">Billing Address</div>
				' . wp_kses_post( $order->get_formatted_billing_address( 'N/A' ) ) . $billing_phone . $billing_email . '
			</div>
		</td>
		<td width="2%"></td>
		<td width="49%" style="vertical-align:top;">
			<div class="addr">
				<div class="addr-title">Shipping Address</div>
				' . wp_kses_post( $order->get_formatted_shipping_address( 'N/A' ) ) . '
			</div>
		</td>
	</tr></table>

	<h2>Order Details</h2>
	<table class="items">
		<thead><tr>
			<th>Product</th>
			<th class="c" width="60">Qty</th>
			<th class="r" width="100">Price</th>
			<th class="r" width="110">Total</th>
		</tr></thead>
		<tbody>' . $rows . '</tbody>
	</table>

	<table width="100%" style="margin-top:10px;"><tr>
		<td width="60%"></td>
		<td width="40%">
			<table width="100%">
				' . $totals_rows . '
				<tr><td style="text-align:right;" class="grand">TOTAL</td>
					<td style="text-align:right;" class="grand">' . wp_kses_post( $order->get_formatted_order_total() ) . '</td></tr>
			</table>
		</td>
	</tr></table>
	';

	if ( $order->get_customer_note() ) {
		$html .= '<h2>Order Notes</h2><div class="note">' . wp_kses_post( $order->get_customer_note() ) . '</div>';
	}

	$html .= '<p style="text-align:center;margin-top:30px;font-size:9pt;color:#8B6F4E;font-style:italic;">Thank you for shopping with Snazzy Floret &mdash; we hope you love your order.</p>';

	// Build mPDF.
	$tmp = trailingslashit( $upload_dir['basedir'] ) . 'sf-mpdf-tmp';
	if ( ! file_exists( $tmp ) ) {
		wp_mkdir_p( $tmp );
	}

	try {
		$default_config    = ( new \Mpdf\Config\ConfigVariables() )->getDefaults();
		$default_font_dirs = $default_config['fontDir'];

		$default_font_config = ( new \Mpdf\Config\FontVariables() )->getDefaults();
		$font_data           = $default_font_config['fontdata'];

		$mpdf = new \Mpdf\Mpdf( array(
			'mode'              => 'utf-8',
			'format'            => 'A4',
			'margin_left'       => 14,
			'margin_right'      => 14,
			'margin_top'        => 18,
			'margin_bottom'     => 18,
			'tempDir'           => $tmp,
			'default_font'      => 'dejavusans',
			'fontDir'           => array_merge( $default_font_dirs, array( SF_THEME_DIR . '/inc/lib/fonts' ) ),
			'fontdata'          => $font_data + array(
				'notosansbengali' => array(
					'R'      => 'NotoSansBengali.ttf',
					'useOTL' => 0,
				),
			),
			'backupSubsFont'    => array( 'notosansbengali', 'dejavusanscondensed' ),
			'useSubstitutions'  => true,
		) );

		$mpdf->SetTitle( 'Snazzy Floret Invoice #' . $order->get_order_number() );
		$mpdf->SetAuthor( 'Snazzy Floret' );
		$mpdf->SetCreator( 'Snazzy Floret' );

		// Diagonal text watermark.
		$mpdf->SetWatermarkText( 'SNAZZY FLORET', 0.08 );
		$mpdf->showWatermarkText  = true;
		$mpdf->watermark_font     = 'DejaVuSansCondensed';
		$mpdf->watermarkTextAlpha = 0.07;

		// Force the BDT symbol (৳, U+09F3) to render via Noto Sans Bengali.
		$html = str_replace( '৳', '<span style="font-family: notosansbengali;">৳</span>', $html );
		$mpdf->WriteHTML( $html );
		$mpdf->Output( $file, \Mpdf\Output\Destination::FILE );
	} catch ( \Throwable $e ) {
		error_log( 'SF mPDF error: ' . $e->getMessage() );
		if ( defined( 'WP_CLI' ) && WP_CLI ) {
			echo "MPDF EX: " . $e->getMessage() . "\n" . $e->getTraceAsString() . "\n";
		}
		return false;
	}

	update_post_meta( $order_id, '_sf_invoice_pdf', 'sf-orders/order-' . $order_id . '.pdf' );

	return $file;
}

// Generate PDF when an order is created at checkout.
add_action( 'woocommerce_checkout_order_processed', 'sf_generate_order_pdf', 20, 1 );
add_action( 'woocommerce_store_api_checkout_order_processed', 'sf_generate_order_pdf', 20, 1 );

/**
 * Serve the PDF via a secure download endpoint.
 *  ?sf_invoice=ORDER_ID&key=ORDER_KEY
 */
function sf_handle_invoice_download() {
	if ( empty( $_GET['sf_invoice'] ) || empty( $_GET['key'] ) ) {
		return;
	}
	$order_id = absint( $_GET['sf_invoice'] );
	$order    = wc_get_order( $order_id );
	if ( ! $order || ! hash_equals( $order->get_order_key(), sanitize_text_field( wp_unslash( $_GET['key'] ) ) ) ) {
		wp_die( 'Invalid invoice link.', 'Invoice', array( 'response' => 403 ) );
	}
	$upload_dir = wp_upload_dir();
	$file       = trailingslashit( $upload_dir['basedir'] ) . 'sf-orders/order-' . $order_id . '.pdf';
	if ( ! file_exists( $file ) ) {
		sf_generate_order_pdf( $order_id );
	}
	if ( ! file_exists( $file ) ) {
		wp_die( 'Invoice not available.', 'Invoice', array( 'response' => 404 ) );
	}
	nocache_headers();
	header( 'Content-Type: application/pdf' );
	header( 'Content-Disposition: inline; filename="snazzy-floret-order-' . $order_id . '.pdf"' );
	header( 'Content-Length: ' . filesize( $file ) );
	readfile( $file );
	exit;
}
add_action( 'init', 'sf_handle_invoice_download' );

/**
 * Get a download URL for an order's invoice PDF.
 */
function sf_get_invoice_url( $order ) {
	if ( is_numeric( $order ) ) {
		$order = wc_get_order( $order );
	}
	if ( ! $order ) {
		return '';
	}
	return add_query_arg(
		array(
			'sf_invoice' => $order->get_id(),
			'key'        => $order->get_order_key(),
		),
		home_url( '/' )
	);
}
