---
name: Pasar.ID Design System
colors:
  surface: '#fbf9f4'
  surface-dim: '#dbdad5'
  surface-bright: '#fbf9f4'
  surface-container-lowest: '#ffffff'
  surface-container-low: '#f5f3ee'
  surface-container: '#f0eee9'
  surface-container-high: '#eae8e3'
  surface-container-highest: '#e4e2dd'
  on-surface: '#1b1c19'
  on-surface-variant: '#42493e'
  inverse-surface: '#30312e'
  inverse-on-surface: '#f2f1ec'
  outline: '#72796e'
  outline-variant: '#c2c9bb'
  surface-tint: '#3b6934'
  primary: '#154212'
  on-primary: '#ffffff'
  primary-container: '#2d5a27'
  on-primary-container: '#9dd090'
  inverse-primary: '#a1d494'
  secondary: '#456800'
  on-secondary: '#ffffff'
  secondary-container: '#bfef73'
  on-secondary-container: '#496d00'
  tertiary: '#52330f'
  on-tertiary: '#ffffff'
  tertiary-container: '#6c4924'
  on-tertiary-container: '#ebba8b'
  error: '#ba1a1a'
  on-error: '#ffffff'
  error-container: '#ffdad6'
  on-error-container: '#93000a'
  primary-fixed: '#bcf0ae'
  primary-fixed-dim: '#a1d494'
  on-primary-fixed: '#002201'
  on-primary-fixed-variant: '#23501e'
  secondary-fixed: '#c2f276'
  secondary-fixed-dim: '#a7d55d'
  on-secondary-fixed: '#121f00'
  on-secondary-fixed-variant: '#334f00'
  tertiary-fixed: '#ffdcbd'
  tertiary-fixed-dim: '#eebd8e'
  on-tertiary-fixed: '#2c1600'
  on-tertiary-fixed-variant: '#61401b'
  background: '#fbf9f4'
  on-background: '#1b1c19'
  surface-variant: '#e4e2dd'
typography:
  headline-xl:
    fontFamily: Be Vietnam Pro
    fontSize: 40px
    fontWeight: '700'
    lineHeight: 48px
    letterSpacing: -0.02em
  headline-lg:
    fontFamily: Be Vietnam Pro
    fontSize: 32px
    fontWeight: '700'
    lineHeight: 40px
    letterSpacing: -0.01em
  headline-lg-mobile:
    fontFamily: Be Vietnam Pro
    fontSize: 24px
    fontWeight: '700'
    lineHeight: 32px
  headline-md:
    fontFamily: Be Vietnam Pro
    fontSize: 24px
    fontWeight: '600'
    lineHeight: 32px
  body-lg:
    fontFamily: Be Vietnam Pro
    fontSize: 18px
    fontWeight: '400'
    lineHeight: 28px
  body-md:
    fontFamily: Be Vietnam Pro
    fontSize: 16px
    fontWeight: '400'
    lineHeight: 24px
  body-sm:
    fontFamily: Be Vietnam Pro
    fontSize: 14px
    fontWeight: '400'
    lineHeight: 20px
  label-md:
    fontFamily: Work Sans
    fontSize: 14px
    fontWeight: '600'
    lineHeight: 16px
    letterSpacing: 0.05em
  label-sm:
    fontFamily: Work Sans
    fontSize: 12px
    fontWeight: '500'
    lineHeight: 14px
    letterSpacing: 0.02em
rounded:
  sm: 0.25rem
  DEFAULT: 0.5rem
  md: 0.75rem
  lg: 1rem
  xl: 1.5rem
  full: 9999px
spacing:
  base: 8px
  xs: 4px
  sm: 12px
  md: 24px
  lg: 40px
  xl: 64px
  gutter: 16px
  margin-mobile: 20px
  margin-desktop: auto
---

## Brand & Style

The design system is built on the philosophy of "Gotong Royong" (communal cooperation) and the sensory richness of the traditional Indonesian marketplace. It bridges the gap between the raw, organic warmth of a physical *pasar* and the efficiency of modern e-commerce. 

The brand personality is **Honest, Nurturing, and Vibrant**. It targets both local MSME (UMKM) sellers who value heritage and modern consumers seeking authentic, locally-sourced products.

The visual style is a blend of **Tactile Minimalism**. It utilizes heavy whitespace to maintain clarity while incorporating organic textures—such as woven bamboo (anyaman) and leaf venation—as subtle backgrounds or edge treatments. This approach ensures the UI feels "grounded in the earth" rather than sterile and corporate.

## Colors

The palette is derived from the lifecycle of a banana leaf and the natural materials of a market stall.

*   **Primary (Forest Green):** Represents the deep, waxy shade of a mature banana leaf. Used for core branding, primary actions, and navigation headers.
*   **Secondary (Fresh Leaf):** A vibrant, high-energy green used for success states, highlights, and secondary call-to-actions.
*   **Tertiary (Burlap Brown):** An earthy, grounded tone inspired by jute sacks and wooden stalls. Used for accents and categorical tags.
*   **Neutral (Cream/Rice Paper):** A warm, off-white base that reduces eye strain and provides a more organic feel than pure white.
*   **Functional Colors:** Errors are rendered in a terracotta red, while warnings use a sun-dried turmeric yellow.

## Typography

This design system uses **Be Vietnam Pro** as the primary typeface for its contemporary but approachable character, which scales beautifully from large marketing headlines to dense product descriptions. **Work Sans** is introduced for labels and data-heavy components to provide a grounded, professional contrast.

Headlines should use tight letter-spacing to feel "packed" like a market stall, while body text maintains generous line heights for maximum legibility. For mobile, headline sizes are aggressively reduced to ensure primary information remains "above the fold" without excessive scrolling.

## Layout & Spacing

The layout follows a **Fluid Grid** model with an 8px base unit. 

*   **Mobile:** A 4-column grid with 20px side margins. Content flows vertically with cards spanning the full width of the grid.
*   **Tablet:** An 8-column grid with 32px side margins.
*   **Desktop:** A 12-column fixed-width grid (max-width 1280px) to maintain a comfortable reading eye-span.

Spacing rhythm is "breathable." We prioritize large `lg` (40px) or `xl` (64px) vertical gaps between distinct sections to mimic the open-air feeling of a traditional market, while internal component spacing (`sm` and `xs`) is kept tight to imply kinship between related elements.

## Elevation & Depth

To maintain the tactile, organic feel, this design system avoids heavy, artificial shadows. Instead, it uses **Tonal Layers** and **Soft Ambient Occlusion**.

1.  **Base Layer:** The Cream (`#F9F7F2`) background acts as the "floor."
2.  **Surface Layer:** White containers with a very thin (1px) border in a lightened Burlap Brown.
3.  **Raised State:** Elements like primary buttons or active cards use a very soft, diffused shadow tinted with Forest Green (`rgba(45, 90, 39, 0.08)`) to suggest they are "resting" on a leaf.
4.  **Interaction:** On hover, cards do not lift; instead, their borders thicken slightly or change color to Forest Green, emphasizing a grounded connection rather than a floating one.

## Shapes

The shape language avoids clinical perfection. Corners are **Rounded** (8px base) to reflect the organic curves found in nature. 

*   **Standard Components:** Buttons and Input fields use the `rounded` (0.5rem) setting.
*   **Containment:** Product cards and image containers use `rounded-lg` (1rem) to feel friendly and safe.
*   **Specialty Elements:** Badges and "Seller Tags" use `rounded-xl` or pill-shapes to differentiate them from functional inputs.

## Components

### Buttons
Primary buttons are Forest Green with Cream text, using a subtle "press" animation that reduces scale slightly (98%) to feel tactile. Secondary buttons use a Forest Green outline on the Cream background.

### Cards
Product cards feature a subtle "woven" pattern texture in the header or footer area. The image should be the hero, with a 1:1 aspect ratio, reflecting the abundance of market displays.

### Input Fields
Inputs use a warm-grey border that turns Forest Green on focus. Labels are always positioned above the field in **Work Sans** for a professional, "receipt-like" clarity.

### Chips & Tags
Used for categories (e.g., "Fresh Produce," "Handicrafts"). These should use Tertiary (Burlap Brown) backgrounds with dark text to mimic the look of paper price tags or traditional labels.

### Dividers
Instead of simple grey lines, dividers can occasionally use a subtle "leaf vein" pattern or a broken line that looks like hand-stitching, reinforcing the MSME/hand-made narrative.