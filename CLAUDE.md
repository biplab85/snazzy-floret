# Snazzy Floret - WooCommerce Website Development Guide

---

## 1. Project Goal

Build a premium, modern, and unique WooCommerce website for **Snazzy Floret** — a Dhaka-based clothing brand specializing in family matching dresses, mother-daughter combos, panjabi sets for boys, and customized dresses for travel, party, and office wear.

The site must use **default WordPress + WooCommerce only** (NO headless architecture). All customizations must be done through PHP-based theme development, WooCommerce hooks/filters, and custom CSS/JS. The end result must look nothing like a generic WooCommerce store — it should feel like a high-end fashion brand website.

### Brand Profile
- **Brand Name:** Snazzy Floret
- **Location:** Dhaka, Bangladesh
- **Category:** Clothing Brand / Women's Clothes / Family Matching Apparel
- **Specialties:** Family matching dresses, mother-daughter combos, panjabi sets, customized dresses
- **Wear Types:** Travel Wear, Party Wear, Office Wear
- **Target Audience:** Bangladeshi families, primarily women aged 20-45
- **Facebook:** https://www.facebook.com/snazzyfloret (82K followers)
- **Instagram:** @snazzyfloret
- **Email:** snazzyfloret@gmail.com
- **Phone:** 01621-008533
- **Price Range:** Mid-range (££)
- **Reviews:** 98% recommend (29 reviews on Facebook)
- **Currency:** BDT (Bangladeshi Taka - ৳)

---

## 2. Tech Stack

| Technology | Purpose |
|---|---|
| WordPress 6.9.4 | CMS |
| WooCommerce 10.6.2 | E-commerce engine |
| PHP 8.4 | Server-side logic |
| MySQL 8.4 | Database (`snazzy_floret`) |
| Custom Child Theme | All frontend customization |
| WP-CLI 2.12.0 | CLI management |
| WampServer | Local development environment |

### Critical Rules
- **NO headless architecture** — everything runs through WordPress/WooCommerce
- **NO page builders** (Elementor, WPBakery, etc.) — custom theme code only
- All customization through child theme's `functions.php`, template overrides, and custom CSS/JS
- Use WooCommerce REST API only for AJAX operations within the theme, not for decoupled frontend

---

## 3. Design Guidelines

### Design Reference
- **Figma:** https://www.figma.com/design/MCOqwRfRqUc1hu5fy56xAF/Snazzy-Floret-Website?node-id=0-1&p=f
- **Brand Reference:** https://www.facebook.com/snazzyfloret
- Follow Figma design strictly for layout, spacing, and component structure

### Color Palette
```
Primary:        #2C2C2C  (Rich Black — text, headers)
Secondary:      #8B6F4E  (Warm Gold/Bronze — accents, buttons, highlights)
Accent:         #D4A76A  (Soft Gold — hover states, badges)
Background:     #FAFAF8  (Warm Off-White — page background)
Card BG:        #FFFFFF  (Pure White — product cards, containers)
Text Primary:   #1A1A1A  (Near Black — body text)
Text Secondary: #6B6B6B  (Medium Gray — descriptions, meta)
Border:         #E8E4DF  (Warm Light Gray — dividers, borders)
Success:        #4CAF50  (Green — stock status, success)
Error:          #E53935  (Red — errors, sale badges)
```
> Adjust colors after reviewing the Figma file. These are initial suggestions based on brand aesthetic.

### Typography
```
Headings:    'Playfair Display', serif — elegant, premium feel
Body:        'Inter', sans-serif — clean, modern readability
```

### Spacing System (8px base)
```
xs:   4px
sm:   8px
md:   16px
lg:   24px
xl:   32px
2xl:  48px
3xl:  64px
4xl:  96px
```

### Design Principles
- **Premium first** — every element should feel high-end (like Apple/Nike store)
- **Whitespace is key** — generous padding, no cramped layouts
- **Consistent shadows** — subtle, layered shadows for depth
- **Rounded corners** — 8px-12px for cards, 4px-6px for buttons
- **Photography-focused** — large, high-quality product images drive the design
- **Mobile-first** — design for mobile (375px), then scale up
- **Avoid** default WooCommerce look entirely — override all default styles

---

## 4. Development Rules

### WordPress Coding Standards
- Follow [WordPress PHP Coding Standards](https://developer.wordpress.org/coding-standards/wordpress-coding-standards/php/)
- Use proper escaping: `esc_html()`, `esc_attr()`, `esc_url()`, `wp_kses_post()`
- Use nonces for all form submissions
- Prefix all custom functions with `sf_` (Snazzy Floret)
- Use proper text domain: `snazzy-floret`

### Theme Architecture
```
snazzy-floret-theme/          (Child theme of Twenty Twenty-Five or custom theme)
├── style.css                 (Theme header + custom styles)
├── functions.php             (Theme setup, hooks, filters, enqueues)
├── header.php                (Custom header)
├── footer.php                (Custom footer)
├── front-page.php            (Homepage)
├── page.php                  (Generic page template)
├── single.php                (Single post)
├── archive.php               (Archive/blog)
├── 404.php                   (Custom 404)
├── searchform.php            (Custom search)
├── /assets/
│   ├── /css/
│   │   ├── main.css          (Main stylesheet)
│   │   ├── woocommerce.css   (WooCommerce overrides)
│   │   └── responsive.css    (Media queries)
│   ├── /js/
│   │   ├── main.js           (Main scripts)
│   │   ├── ajax-cart.js      (AJAX cart functionality)
│   │   └── product-gallery.js(Product image gallery)
│   ├── /images/              (Theme images, icons, logos)
│   └── /fonts/               (Custom fonts if self-hosted)
├── /inc/
│   ├── theme-setup.php       (Theme supports, menus, sidebars)
│   ├── enqueue.php           (Script & style enqueuing)
│   ├── woocommerce.php       (WooCommerce hooks & filters)
│   ├── security.php          (Security rules, role restrictions)
│   ├── custom-post-types.php (If needed for lookbooks, etc.)
│   └── ajax-handlers.php     (AJAX endpoints)
├── /woocommerce/             (WooCommerce template overrides)
│   ├── archive-product.php   (Shop/product listing page)
│   ├── content-product.php   (Product card in loop)
│   ├── single-product.php    (Product detail page)
│   ├── cart/
│   │   └── cart.php          (Cart page)
│   ├── checkout/
│   │   └── form-checkout.php (Checkout page)
│   ├── myaccount/
│   │   ├── dashboard.php     (Account dashboard)
│   │   ├── orders.php        (Order list)
│   │   └── view-order.php    (Order detail with tracking)
│   └── /emails/              (Custom email templates)
└── /template-parts/
    ├── hero-banner.php
    ├── product-card.php
    ├── category-showcase.php
    ├── testimonials.php
    └── newsletter-signup.php
```

### Development Principles
- **NEVER modify WordPress or WooCommerce core files**
- Use WooCommerce hooks and filters (`woocommerce_before_shop_loop`, `woocommerce_single_product_summary`, etc.)
- Override WooCommerce templates by copying to `theme/woocommerce/` directory
- Write modular, reusable template parts
- Use `wp_enqueue_script()` and `wp_enqueue_style()` — never hardcode `<script>` or `<link>` tags
- Use WordPress transients for caching expensive queries
- All AJAX must use `wp_ajax_` and `wp_ajax_nopriv_` hooks with proper nonce verification
- Use `get_template_part()` for reusable components
- Database queries via `$wpdb` must use prepared statements

---

## 5. Feature Task List

### Phase 1: Foundation

#### 1.1 Theme Setup
- [ ] Create child theme with proper `style.css` header
- [ ] Set up `functions.php` with theme supports (title-tag, thumbnails, menus, woocommerce)
- [ ] Register navigation menus (primary, footer, mobile)
- [ ] Register widget areas (sidebar, footer columns)
- [ ] Enqueue Google Fonts (Playfair Display, Inter)
- [ ] Set up custom image sizes for product cards, hero banners, category thumbnails
- [ ] Configure WooCommerce support in theme (gallery zoom, lightbox, slider)

#### 1.2 Header & Navigation
- [ ] Sticky header with brand logo (left), navigation (center), icons (right)
- [ ] Search icon with slide-down or modal search bar
- [ ] Mini cart icon with item count badge and dropdown preview
- [ ] User account icon with dropdown (login/register or dashboard)
- [ ] Mobile hamburger menu with slide-in drawer navigation
- [ ] Announcement bar at top (dismissible) for offers/shipping info

#### 1.3 Footer
- [ ] Multi-column footer: About, Quick Links, Customer Care, Contact
- [ ] Social media icons (Facebook, Instagram)
- [ ] Newsletter signup form
- [ ] Payment method icons
- [ ] Copyright bar with links
- [ ] "Back to top" smooth scroll button

### Phase 2: Core Pages

#### 2.1 Homepage (`front-page.php`)
- [ ] Hero banner/slider with CTA buttons
- [ ] Featured categories section (Mother-Daughter, Panjabi Sets, Party Wear, etc.)
- [ ] New arrivals product grid (4 items)
- [ ] Collection/lookbook banner section
- [ ] Best sellers product grid
- [ ] Testimonials/reviews carousel
- [ ] Instagram feed or gallery section
- [ ] Newsletter signup section
- [ ] "Why Choose Us" features bar (Free shipping, Custom sizing, Quality fabric, etc.)

#### 2.2 Product Listing / Shop Page
- [ ] Clean grid layout (2 cols mobile, 3 cols tablet, 4 cols desktop)
- [ ] Modern product card design:
  - Product image with hover second-image swap
  - Quick view button on hover
  - Product name (clean typography)
  - Price (with sale price styling)
  - "Add to Cart" button (appears on hover)
  - Wishlist heart icon
  - "New" / "Sale" / "Sold Out" badges
- [ ] Sidebar filters: Category, Price range, Size, Color, Availability
- [ ] AJAX filtering (no page reload)
- [ ] Sorting dropdown (newest, price low-high, price high-low, popularity)
- [ ] AJAX "Load More" or infinite scroll pagination
- [ ] Products per page selector
- [ ] Active filter tags with remove option
- [ ] Empty state design for no results

#### 2.3 Product Details Page
- [ ] Large image gallery with thumbnail navigation and zoom
- [ ] Image lightbox on click
- [ ] Product title, price, short description
- [ ] Size selector with size chart modal
- [ ] Color/variant swatches (visual, not dropdown)
- [ ] Quantity selector (styled +/- buttons)
- [ ] "Add to Cart" button (prominent, full-width on mobile)
- [ ] "Buy Now" button (direct to checkout)
- [ ] Wishlist button
- [ ] Accordion tabs: Description, Additional Info, Reviews, Shipping & Returns
- [ ] Related products carousel
- [ ] "You may also like" section
- [ ] Social share buttons
- [ ] SKU, Category, Tags display
- [ ] Stock status indicator
- [ ] Sticky add-to-cart bar on scroll (mobile)

#### 2.4 Cart Page
- [ ] Clean, modern cart table layout
- [ ] Product thumbnail, name, price, quantity, subtotal per row
- [ ] Styled quantity selector (+/- buttons)
- [ ] Remove item button with confirmation
- [ ] AJAX quantity update (no page reload)
- [ ] Coupon code input field
- [ ] Cart totals summary sidebar
- [ ] "Continue Shopping" button
- [ ] "Proceed to Checkout" button (prominent)
- [ ] Cross-sell products section ("You might also like")
- [ ] Empty cart state with CTA to shop
- [ ] Free shipping progress bar ("Add ৳X more for free shipping!")

#### 2.5 Checkout Page
- [ ] Simplified, distraction-free layout (minimal header/footer)
- [ ] Two-column layout: Form (left), Order Summary (right)
- [ ] Minimal form fields:
  - Full Name
  - Phone Number (required — primary contact in BD)
  - Email
  - Division / District / Area (Bangladesh address format)
  - Full Address
  - Order Notes
- [ ] Order summary with product thumbnails, quantities, totals
- [ ] Payment method selection (styled radio buttons)
- [ ] Coupon code field
- [ ] Place Order button (large, prominent)
- [ ] Form validation with inline error messages
- [ ] Auto-save form fields (localStorage)
- [ ] Guest checkout enabled by default
- [ ] "Create an account" checkbox option

#### 2.6 Order Confirmation / Thank You Page
- [ ] Order success message with checkmark animation
- [ ] Order number and details summary
- [ ] Expected delivery info
- [ ] "Continue Shopping" CTA
- [ ] Account creation prompt (if guest checkout)

### Phase 3: User Account

#### 3.1 Login / Register
- [ ] Custom login page (NOT wp-login.php for customers)
- [ ] Clean, centered form design
- [ ] Social login buttons (if applicable)
- [ ] Password strength indicator on register
- [ ] "Forgot Password" flow
- [ ] Redirect to "My Account" after login (not wp-admin)

#### 3.2 User Account Dashboard (`/my-account/`)
- [ ] Custom dashboard layout (sidebar navigation + content area)
- [ ] Dashboard overview: Recent orders, account details summary
- [ ] **Orders:** Order list with status badges, view order details, reorder button
- [ ] **Order Detail:** Full order info with timeline/progress tracker
- [ ] **Addresses:** Shipping/billing address management
- [ ] **Account Details:** Edit name, email, phone, password
- [ ] **Wishlist:** Saved products grid with "Add to Cart" option
- [ ] **Logout** with confirmation

#### 3.3 Order Tracking System
- [ ] Visual progress timeline/stepper UI:
  - Order Placed
  - Processing / Confirmed
  - Shipped / In Transit
  - Out for Delivery
  - Delivered
- [ ] Estimated delivery date display
- [ ] Tracking number display (if available)
- [ ] Order status color coding (pending=yellow, processing=blue, shipped=purple, delivered=green, cancelled=red)
- [ ] Order tracking page accessible without login (via order ID + email/phone)

### Phase 4: Enhancements

#### 4.1 Search
- [ ] AJAX live search with product thumbnails in results
- [ ] Search suggestions / autocomplete
- [ ] Search results page with proper product grid

#### 4.2 Wishlist
- [ ] Heart icon toggle on product cards and detail page
- [ ] Wishlist page in user account
- [ ] Wishlist count in header icon
- [ ] Store wishlist in user meta (logged in) or cookies (guest)

#### 4.3 Quick View Modal
- [ ] Product quick view popup from shop page
- [ ] Shows: image, title, price, short description, add to cart, view full product link

#### 4.4 AJAX Mini Cart
- [ ] Slide-in cart drawer from right side
- [ ] Shows cart items with thumbnails
- [ ] Update quantity / remove items
- [ ] Cart totals and checkout button
- [ ] Triggered by header cart icon or after adding product

---

## 6. User Role & Security Rules (CRITICAL)

### Role Management
```php
// Default role for new registrations must be 'customer'
// NEVER assign 'administrator', 'editor', or 'shop_manager' programmatically
```

- All new accounts created during/after checkout: **customer** role only
- WooCommerce registration forms: **customer** role only
- Remove "Role" dropdown from any public-facing forms

### wp-admin Access Restriction
```
Non-admin users (customers) MUST NOT access /wp-admin/
Redirect customers to /my-account/ if they try to access wp-admin
Hide the admin bar for all non-admin users
```

### Security Implementation Checklist
- [ ] Redirect non-admin users away from `/wp-admin/` (except AJAX calls)
- [ ] Hide WordPress admin bar for customers
- [ ] Disable author archives to prevent user enumeration
- [ ] Remove WordPress version from `<head>`
- [ ] Disable XML-RPC if not needed
- [ ] Prevent capability escalation — no user can change their own role
- [ ] Sanitize and validate ALL user inputs
- [ ] Use nonces on every form
- [ ] Implement rate limiting on login attempts
- [ ] Force strong passwords for admin accounts
- [ ] Disable file editing from wp-admin (`DISALLOW_FILE_EDIT`)
- [ ] Protect `wp-config.php` via `.htaccess`
- [ ] Set secure cookie flags

### Authentication Flow
```
Customer Login  →  /my-account/  (NEVER wp-admin)
Admin Login     →  /wp-admin/    (standard WordPress admin)
Customer tries /wp-admin  →  Redirect to /my-account/
```

---

## 7. UI/UX Requirements

### Product Card Design
```
┌─────────────────────────┐
│                         │
│     [Product Image]     │  ← Hover: show 2nd image + quick view button
│     [NEW] [SALE -20%]   │  ← Badges: top-left corner
│     [♡]                 │  ← Wishlist: top-right corner
│                         │
├─────────────────────────┤
│  Product Category       │  ← Small, muted text
│  Product Name           │  ← Bold, 1-2 lines max
│  ৳1,200  ৳1,500        │  ← Sale price + original crossed out
│  [Add to Cart]          │  ← Appears on hover (desktop)
└─────────────────────────┘
```

### Interaction Patterns
- **Hover effects:** Subtle scale (1.02) on cards, image swap, button reveal
- **Transitions:** 0.3s ease for all interactive elements
- **Loading states:** Skeleton screens for AJAX content, not spinners
- **Scroll animations:** Subtle fade-in-up for sections as they enter viewport
- **Button states:** Default, hover, active, disabled — all visually distinct
- **Toast notifications:** Slide-in from top-right for "Added to cart", errors, etc.

### Responsive Breakpoints
```
Mobile:        < 576px   (1 column products, stacked layout)
Mobile Large:  576-767px (2 column products)
Tablet:        768-991px (2-3 column products, sidebar collapses)
Desktop:       992-1199px (3-4 column products)
Large Desktop: >= 1200px (4 column products, max-width container: 1320px)
```

### Accessibility
- Minimum contrast ratio: 4.5:1 for body text, 3:1 for large text
- Focus indicators on all interactive elements
- ARIA labels on icon-only buttons
- Keyboard navigable: tab through all interactive elements
- Screen reader friendly product information
- Skip navigation link

---

## 8. Performance Rules

### Image Optimization
- Use WebP format with JPEG fallback
- Implement lazy loading on all images below the fold (`loading="lazy"`)
- Define proper `width` and `height` attributes to prevent layout shifts
- Use responsive `srcset` for different screen sizes
- Product images: max 800x1000px, < 150KB
- Thumbnails: max 400x500px, < 50KB
- Compress all theme images

### Code Performance
- Minify CSS and JS in production
- Combine CSS files where possible (max 2-3 stylesheets)
- Defer non-critical JavaScript
- Inline critical CSS for above-the-fold content
- Use `wp_enqueue_script` with `in_footer => true`
- Remove unused CSS from WooCommerce default styles
- Avoid jQuery dependency where vanilla JS suffices

### Database
- Use object caching (transients) for expensive queries
- Index custom meta queries
- Limit product queries to necessary fields
- Use pagination, never load all products at once

### Plugin Discipline
- **Keep plugins minimal** — only install what cannot be achieved with custom code
- Active plugins should serve a clear, non-replaceable purpose
- Remove deactivated plugins entirely
- No plugin for functionality that can be achieved with 50 lines of code

### Performance Targets
```
Lighthouse Score:  > 90 (Performance)
First Contentful Paint:  < 1.5s
Largest Contentful Paint: < 2.5s
Cumulative Layout Shift:  < 0.1
Time to Interactive:      < 3.5s
```

---

## 9. AI Behavior Instructions

When working on this project, follow these rules:

### Before Writing Code
1. **Explain** what you're about to do and why
2. **Identify** which files will be created or modified
3. **Confirm** the approach aligns with this guide
4. **Break** the task into small, testable steps

### While Writing Code
1. Write one feature/component at a time
2. Test each piece before moving to the next
3. Follow the theme architecture defined in Section 4
4. Use proper WordPress/WooCommerce hooks — never hack core
5. Comment complex logic, but don't over-comment obvious code
6. Use consistent naming: `sf_` prefix for functions, `snazzy-floret` text domain

### After Writing Code
1. Verify the code works in the browser
2. Check mobile responsiveness
3. Validate no PHP errors or JS console errors
4. Confirm WooCommerce functionality is intact

### Suggesting Improvements
- Proactively suggest UX improvements based on e-commerce best practices
- Flag potential performance issues before they compound
- Recommend accessibility improvements
- Suggest SEO optimizations where relevant

### Communication Style
- Be concise and action-oriented
- Lead with the solution, explain the reasoning briefly
- When presenting options, recommend one and explain why
- Use code snippets in explanations, not just prose

---

## 10. Prohibited Practices

### Never Do
- Edit WordPress core files (`wp-includes/`, `wp-admin/`)
- Edit WooCommerce plugin files directly (`plugins/woocommerce/`)
- Hardcode URLs, paths, or data (use WordPress functions)
- Use inline styles or scripts (use proper enqueuing)
- Install unnecessary plugins for simple functionality
- Use `!important` in CSS unless absolutely unavoidable
- Skip input sanitization or output escaping
- Store sensitive data in plain text
- Use deprecated WordPress/WooCommerce functions
- Ignore mobile responsiveness
- Break WooCommerce default functionality while customizing
- Use `query_posts()` — always use `WP_Query` or `wc_get_products()`
- Echo unescaped user data
- Hardcode Bangla/English text — use translation functions `__()`, `_e()`

### Never Install
- Page builders (Elementor, WPBakery, Divi, etc.)
- All-in-one "mega" plugins that bloat the site
- Nulled/pirated plugins or themes
- Plugins that duplicate WooCommerce built-in features
- Multiple plugins that serve the same purpose

---

## 11. WooCommerce Configuration

### Store Settings
```
Currency:           BDT (৳)
Currency Position:  Left (৳1,200)
Weight Unit:        kg
Dimension Unit:     cm
Country:            Bangladesh
Enable Guest Checkout: Yes
Enable Account Creation During Checkout: Yes
Default Customer Role: Customer
```

### Product Categories (Initial)
```
├── Women's Collection
│   ├── Saree
│   ├── Salwar Kameez
│   ├── Kurti
│   ├── Angarkha
│   └── Western Wear
├── Family Matching
│   ├── Mother-Daughter Combo
│   ├── Father-Son Combo
│   └── Full Family Set
├── Men's Collection
│   ├── Panjabi
│   ├── Fatua
│   └── Shirt
├── Kids' Collection
│   ├── Girls
│   └── Boys
├── By Occasion
│   ├── Party Wear
│   ├── Office Wear
│   ├── Travel Wear
│   ├── Casual Wear
│   └── Festive / Eid Collection
└── Accessories
    ├── Jewelry
    ├── Bags
    └── Scarves
```

### Product Attributes
```
Size:    XS, S, M, L, XL, XXL, Custom
Color:   (Variable per product)
Fabric:  Cotton, Silk, Linen, Georgette, Chiffon, etc.
```

---

## 12. Local Development

### Environment
```
URL:        http://localhost/sklentr/snazzy-floret/
Admin:      http://localhost/sklentr/snazzy-floret/wp-admin/
Database:   snazzy_floret
DB User:    root
DB Pass:    (empty)
PHP:        8.4.15 (E:\wampserver\bin\php\php8.4.15\)
MySQL:      8.4.7 (E:\wampserver\bin\mysql\mysql8.4.7\)
WP-CLI:     C:\Users\ASUS\bin\wp-cli.phar
```

### WP-CLI Quick Reference
```bash
# List plugins
wp plugin list --path=E:\wampserver\www\sklentr\snazzy-floret

# Activate/deactivate theme
wp theme activate snazzy-floret-theme --path=E:\wampserver\www\sklentr\snazzy-floret

# Create product
wp wc product create --name="Product Name" --regular_price=1200 --path=E:\wampserver\www\sklentr\snazzy-floret

# Clear cache
wp cache flush --path=E:\wampserver\www\sklentr\snazzy-floret

# Export/import
wp db export backup.sql --path=E:\wampserver\www\sklentr\snazzy-floret
```

---

## 13. Deployment Checklist (When Ready for Production)

- [ ] Change `WP_DEBUG` to `false`
- [ ] Set strong admin password
- [ ] Configure proper SMTP for emails
- [ ] Set up SSL certificate
- [ ] Update site URL to production domain (snazzyfloret.com)
- [ ] Configure proper `.htaccess` rules
- [ ] Set up automated backups
- [ ] Install security plugin (Wordfence or Sucuri)
- [ ] Configure caching (server-level or plugin)
- [ ] Test all WooCommerce flows: browse → cart → checkout → payment → confirmation
- [ ] Test on multiple devices and browsers
- [ ] Submit sitemap to Google Search Console
- [ ] Configure payment gateways for production
