# Frontend SCSS Framework

Reference for the shared Sass framework in `wp-content/mu-plugins/process/sass/frontend`.

This document covers the reusable framework folders only:

- `base`
- `utilities`
- `docs`

The `site` folder is intentionally excluded because it is project-specific.

A visual reference page is available at `frontend/docs/docs.html`. It loads the compiled docs stylesheet from `dist/css/docs.min.css`.

## Repo Setup

Treat `wp-content/mu-plugins/process/sass/frontend` as the reusable framework repo folder. The framework tracks default Sass values, documentation, and examples, while each project keeps its own local token overrides out of version control.

One-time setup for a new project:

```sh
cd wp-content/mu-plugins/process/sass/frontend
cp base/_project-local.example.scss base/_project-local.scss
```

Then edit `base/_project-local.scss` for the project brand values. That file is ignored by `frontend/.gitignore`, so project-specific colors and button values do not require source changes to the reusable framework.

Tracked token files:

- `base/_project-defaults.scss` contains framework fallback values.
- `base/_project-local.example.scss` is the project setup template.
- `base/_tokens.scss` emits CSS custom properties from the local project config.

Ignored token file:

- `base/_project-local.scss` contains the actual project values.


## Build Entry

The docs stylesheet entry point is:

```scss
frontend/docs/docs.scss
```

The gulpfile compiles it through `stylesClasses()` and writes:

```text
dist/css/docs.min.css
```

`docs.scss` imports the reusable framework files first, then adds styling used only by the documentation page.

```scss
@use "../base/breakpoints";
@use "../base/mixins";
@use "../base/variables" as *;
@use "../base/tokens";
@use "../base/typography";
@use "../base/layout";
@use "../base/spacing";
@use "../base/alerts";
@use "../utilities/color-utilities";
@use "../utilities/utilities";
@use "../utilities/buttons";
```

## Folder Structure

```text
frontend/
  base/
    _alerts.scss
    _breakpoints.scss
    _layout.scss
    _mixins.scss
    _project-defaults.scss
    _project-local.example.scss
    _project-local.scss ignored
    _shadows.scss
    _spacing.scss
    _tokens.scss
    _typography.scss
    _variables.scss
  utilities/
    _buttons.scss
    _color-utilities.scss
    _utilities.scss
  docs/
    SCSS Framework.md
    docs.html
    docs.scss
```

## Tokens And Maps

Framework structure values are defined in `base/_variables.scss`. Project-specific color and button values are configured through `base/_project-local.scss` and emitted as CSS custom properties in `base/_tokens.scss`.

### Font Sizes

Sass map:

```scss
$font-sizes: (
  xs: clamp(0.75rem, 1vw + 0.5rem, 0.875rem),
  sm: clamp(0.875rem, 1.2vw + 0.5rem, 1rem),
  base: clamp(1rem, 1.5vw + 0.5rem, 1.125rem),
  md: clamp(1.125rem, 2vw + 0.5rem, 1.25rem),
  lg: clamp(1.25rem, 2.5vw + 0.5rem, 1.5rem),
  xl: clamp(1.5rem, 3vw + 0.5rem, 2rem),
  xxl: clamp(2rem, 4vw + 0.5rem, 3rem),
);
```

Generated CSS variables:

```css
--fs-xs
--fs-sm
--fs-base
--fs-md
--fs-lg
--fs-xl
--fs-xxl
```

Generated classes:

```html
<p class="fs-base">Body text</p>
<h2 class="fs-xl lh-tight fw-bold">Heading</h2>
```

### Spacing

Sass map:

```scss
$spacing: (
  0: 0,
  xs: 0.25rem,
  sm: 0.5rem,
  md: 1rem,
  lg: 2rem,
  xl: 4rem,
  xxl: 6rem,
);
```

Generated CSS variables:

```css
--space-0
--space-xs
--space-sm
--space-md
--space-lg
--space-xl
--space-xxl
```

Generated classes include margin, padding, and gap utilities:

```html
<section class="mt-lg mb-xl p-md gap-md">...</section>
<section class="p-sm p-md-lg gap-sm gap-lg-xl">...</section>
```

### Color Tokens

Project-specific color token values live in `base/_project-local.scss`. The tracked defaults live in `base/_project-defaults.scss`, and the copyable setup template is `base/_project-local.example.scss`.

Base RGB tokens are defined in `base/_tokens.scss`:

```css
--color-primary-rgb
--color-secondary-rgb
--color-base-rgb
--color-action-rgb
--color-action-alt-rgb
--color-background-rgb
--color-accent-rgb
```

Each token generates opacity stops:

```css
--color-primary-10
--color-primary-25
--color-primary-50
--color-primary-75
--color-primary-90
--color-primary-100
```

Usage:

```scss
.card {
  background: var(--color-primary-10);
  border-color: var(--color-primary-25);
  color: var(--color-base-100);
}
```

### Buttons And Intent Tokens

Button tokens use this pattern:

```css
--button-primary
--button-primary-hover
--button-primary-text
```

Available button color names:

- `primary`
- `secondary`
- `accent`
- `success`
- `danger`

Semantic intent aliases are also available for alerts. These are intentionally separate from the button palette so alerts keep clear info, warning, success, and error states even when project button colors change:

```css
--intent-info
--intent-warning
--intent-notice
--intent-success
--intent-error
```

### Breakpoints

The `$breakpoints` map in `base/_variables.scss` powers responsive generated utilities:

```scss
$breakpoints: (
  sm: 576px,
  md: 768px,
  lg: 1024px,
  xl: 1280px,
);
```

`base/_breakpoints.scss` defines mixin-specific values:

```scss
$screen-sm-min: 480px;
$screen-md-min: 768px;
$screen-lg-min: 992px;
$screen-xl-min: 1280px;
```

Note: generated utilities are mostly `min-width`; the mixins are `max-width`.

## Responsive Mixins

File: `base/_mixins.scss`

```scss
@include sm { ... }  // max-width: 480px
@include md { ... }  // max-width: 768px
@include lg { ... }  // max-width: 992px
@include xl { ... }  // max-width: 1280px
@include rwd(640) { ... }
```

Example:

```scss
.panel {
  display: grid;
  grid-template-columns: 2fr 1fr;

  @include md {
    grid-template-columns: 1fr;
  }
}
```

## Typography Utilities

File: `base/_typography.scss`

Font size classes:

```css
.fs-xs
.fs-sm
.fs-base
.fs-md
.fs-lg
.fs-xl
.fs-xxl
```

Line-height classes:

```css
.lh-tight
.lh-normal
.lh-relaxed
```

Font-weight classes:

```css
.fw-light
.fw-regular
.fw-medium
.fw-bold
```

Text alignment classes:

```css
.text-left
.text-center
.text-right
.text-justify
.text-sm-left
.text-md-center
.text-lg-right
.text-xl-justify
```

Style classes:

```css
.italic
.not-italic
```

## Layout Utilities

File: `base/_layout.scss`

### Containers

```html
<div class="container">...</div>
<div class="container-slim">...</div>
```

`.container` is full width, centered, padded, and capped at `1280px`.

### Flex

```html
<div class="flex flex-col flex-md-row items-md-center justify-between gap-md">
  <div>One</div>
  <div>Two</div>
</div>
```

Base classes:

```css
.flex
.flex-power
.flex-col
```

Responsive direction classes:

```css
.flex-sm-row
.flex-sm-col
.flex-md-row
.flex-md-col
.flex-lg-row
.flex-lg-col
.flex-xl-row
.flex-xl-col
```

Alignment classes:

```css
.items-start
.items-end
.items-center
.items-baseline
.items-stretch
```

Justification classes:

```css
.justify-start
.justify-end
.justify-center
.justify-between
.justify-around
.justify-evenly
```

Responsive alignment and justification use an infix breakpoint:

```html
<div class="flex items-md-center justify-lg-between">...</div>
```

### Grid

```html
<div class="grid grid-1 grid-md-2 grid-lg-4 gap-md">
  <article>...</article>
</div>
```

Column classes:

```css
.grid-1 through .grid-6
.grid-sm-1 through .grid-sm-6
.grid-md-1 through .grid-md-6
.grid-lg-1 through .grid-lg-6
.grid-xl-1 through .grid-xl-6
```

Auto-fit helpers:

```css
.grid-auto-fit
.grid-auto-fill
```

Span classes:

```css
.col-span-1 through .col-span-6
.col-full
.col-md-span-1 through .col-md-span-6
.col-md-full
.row-span-1 through .row-span-6
```

Order classes:

```css
.order-1
.order-2
.order-first
.order-last
.order-md-1
.order-md-2
.order-md-first
.order-md-last
```

## Spacing Utilities

File: `base/_spacing.scss`

Class pattern:

```text
m, mt, mb, ml, mr
p, pt, pb, pl, pr
gap
```

Examples:

```html
<div class="m-md p-lg">...</div>
<div class="mt-xl mb-lg">...</div>
<div class="grid gap-sm gap-lg-xl">...</div>
```

Responsive spacing uses this pattern:

```text
<property>-<breakpoint>-<spacing>
```

Examples:

```css
.p-md-lg
.mt-lg-xl
.gap-sm-md
```

## Buttons

File: `utilities/_buttons.scss`

Base button:

```html
<a class="btn" href="#">Base button</a>
```

Solid buttons:

```html
<a class="btn btn-primary" href="#">Primary</a>
<a class="btn btn-secondary" href="#">Secondary</a>
<a class="btn btn-accent" href="#">Accent</a>
<a class="btn btn-success" href="#">Success</a>
<a class="btn btn-danger" href="#">Danger</a>
```

Outline buttons:

```html
<a class="btn btn-outline-primary" href="#">Primary outline</a>
<a class="btn btn-outline-danger" href="#">Danger outline</a>
```

Sizes:

```html
<button class="btn btn-primary btn-sm">Small</button>
<button class="btn btn-primary btn-md">Medium</button>
<button class="btn btn-primary btn-lg">Large</button>
```

Radius variants:

```html
<button class="btn btn-primary btn-round-sm">Small radius</button>
<button class="btn btn-primary btn-round-pill">Pill</button>
```

## Alerts

File: `base/_alerts.scss`

Alerts use intent colors for the tint, border, icon, and title while keeping body text on the readable base text color.

Base structure:

```html
<div class="ui-alert ui-alert-info">
  <span class="alert__icon">i</span>
  <div>
    <div class="alert__title">Information</div>
    <div class="alert__body">Helpful alert copy.</div>
  </div>
  <button class="alert__close" type="button">x</button>
</div>
```

Variants:

```css
.ui-alert-info
.ui-alert-notice
.ui-alert-success
.ui-alert-warning
.ui-alert-error
```

Modifiers:

```css
.ui-alert--bordered
.ui-alert--compact
.alert--no-icon
```

## Color Utilities

File: `utilities/_color-utilities.scss`

Base patterns:

```text
bg-<color>-<opacity>
text-<color>-<opacity>
border-<color>-<opacity>
```

Examples:

```html
<div class="bg-primary-10 text-base-100 border-primary-25">...</div>
```

Responsive color utilities use escaped breakpoint prefixes in CSS and normal prefixes in HTML:

```html
<div class="bg-primary-10 md:bg-secondary-25 lg:text-base-100">...</div>
```

```css
.md\:bg-secondary-25
.lg\:text-base-100
```

Extras:

```css
.bg-transparent
.text-inherit
.border-transparent
```

Note: `other` is listed in `_color-utilities.scss`, but matching `--color-other-*` tokens are not currently defined in `_tokens.scss`.

## General Utilities

File: `utilities/_utilities.scss`

Display:

```css
.d-block
.d-inline
.d-flex
.d-grid
.d-none
```

Position:

```css
.relative
.absolute
```

Z-index:

```css
.z-0
.z-10
.z-50
```

Sizing:

```css
.w-full
.h-full
```

Image fill:

```html
<div class="image-fill">
  <img src="image.jpg" alt="">
</div>
```

Rounded corners:

```css
.rounded-sm
.rounded-md
.rounded-lg
.rounded-pill
.rounded-none
```

## Shadows

Shadow tokens and utilities live in `base/_shadows.scss`.

The file contains the core `$shadows` map:

```scss
$shadows: (
  sm: "0 1px 2px 0 rgba(var(--color-base-rgb), 0.05)",
  md: "0 4px 6px -1px rgba(var(--color-base-rgb), 0.1), 0 2px 4px -2px rgba(var(--color-base-rgb), 0.1)",
  lg: "0 10px 15px -3px rgba(var(--color-base-rgb), 0.1), 0 4px 6px -4px rgba(var(--color-base-rgb), 0.1)",
  xl: "0 20px 25px -5px rgba(var(--color-base-rgb), 0.1), 0 8px 10px -6px rgba(var(--color-base-rgb), 0.1)",
  inner: "inset 0 2px 4px 0 rgba(var(--color-base-rgb), 0.05)",
  none: "none",
);
```

Core utility classes:

```css
.shadow-sm
.shadow-md
.shadow-lg
.shadow-xl
.shadow-inner
.shadow-none
```

Additional utility families are also available:

- Directional: `.shadow-direction-top`, `.shadow-direction-right`, `.shadow-direction-bottom`, `.shadow-direction-left`, `.shadow-direction-all`
- Elevation: `.shadow-elevation-1` through `.shadow-elevation-8`
- Layered: `.shadow-layered-xs`, `.shadow-layered-md`, `.shadow-layered-xl`, `.shadow-layered-soft`, `.shadow-layered-long`
- Tailwind-like: `.shadow-tailwind-xs`, `.shadow-tailwind-sm`, `.shadow-tailwind-lg`, `.shadow-tailwind-xl`, `.shadow-tailwind-2xl`
- Card: `.shadow-card-sm`, `.shadow-card-md`, `.shadow-card-lg`, `.shadow-card-xl`
- Soft/system: `.shadow-soft-xs`, `.shadow-soft-sm`, `.shadow-soft-md`, `.shadow-github-sm`, `.shadow-github-md`, `.shadow-github-lg`
- Raised/hard/focus: `.shadow-raised-sm`, `.shadow-diffuse`, `.shadow-hard-offset`, `.shadow-focus-ring-dark`, `.shadow-atlassian-raised`
- Pixel/retro/colored: `.shadow-pixel-stair`, `.shadow-rainbow-outline`, `.shadow-retro-drop`, `.shadow-warm-glow-md`

Example:

```html
<article class="p-md rounded-md shadow-card-md">
  Card content
</article>
```

## Common Recipes

### Responsive Card Grid

```html
<section class="container mt-lg mb-xl">
  <div class="grid grid-1 grid-md-2 grid-lg-3 gap-lg">
    <article class="p-md rounded-md bg-background-100">
      <h2 class="fs-lg lh-tight fw-bold">Card title</h2>
      <p class="fs-base lh-relaxed">Card content.</p>
    </article>
  </div>
</section>
```

### Two-Column Layout With Reordering

```html
<section class="container grid grid-1 grid-md-2 gap-lg items-md-center">
  <div class="order-2 order-md-1">
    <h2 class="fs-xl lh-tight">Main copy</h2>
  </div>
  <div class="order-1 order-md-2 image-fill rounded-lg">
    <img src="image.jpg" alt="">
  </div>
</section>
```

### Alert Stack

```html
<div class="ui-alert ui-alert-success ui-alert--bordered">
  <span class="alert__icon">v</span>
  <div>
    <div class="alert__title">Saved</div>
    <div class="alert__body">Your changes were saved.</div>
  </div>
  <button class="alert__close" type="button">x</button>
</div>
```

## Page Builder Overrides

This framework is designed to stay override-friendly. WordPress page builders may output selectors with higher specificity, so builder-specific fixes should live in the project or theme layer after the framework loads. Prefer a wrapper selector, a later stylesheet, or a project partial over changing framework utilities.

Example:

```scss
.builder-content .btn-primary {
  background-color: var(--button-accent);
}
```

## Implementation Notes

- `docs.html` is a static visual reference page and can be opened directly in a browser after gulp has compiled `dist/css/docs.min.css`.
- Generated responsive utilities use `min-width` breakpoints.
- Responsive mixins use `max-width` breakpoints.
- Breakpoint values differ between `_variables.scss`, `_breakpoints.scss`, and `_color-utilities.scss`.
- `_color-utilities.scss` defines its own breakpoint map instead of importing the shared `$breakpoints` map.
- `base/_project-local.scss` is required for Sass compilation but is intentionally ignored by git. Create it from `base/_project-local.example.scss` when setting up a project.
