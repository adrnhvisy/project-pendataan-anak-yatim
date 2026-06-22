---
name: Compassionate Care Systems
colors:
  surface: '#f8f9ff'
  surface-dim: '#cbdbf5'
  surface-bright: '#f8f9ff'
  surface-container-lowest: '#ffffff'
  surface-container-low: '#eff4ff'
  surface-container: '#e5eeff'
  surface-container-high: '#dce9ff'
  surface-container-highest: '#d3e4fe'
  on-surface: '#0b1c30'
  on-surface-variant: '#434655'
  inverse-surface: '#213145'
  inverse-on-surface: '#eaf1ff'
  outline: '#737686'
  outline-variant: '#c3c6d7'
  surface-tint: '#0053db'
  primary: '#004ac6'
  on-primary: '#ffffff'
  primary-container: '#2563eb'
  on-primary-container: '#eeefff'
  inverse-primary: '#b4c5ff'
  secondary: '#006c49'
  on-secondary: '#ffffff'
  secondary-container: '#6cf8bb'
  on-secondary-container: '#00714d'
  tertiary: '#784b00'
  on-tertiary: '#ffffff'
  tertiary-container: '#996100'
  on-tertiary-container: '#ffeedd'
  error: '#ba1a1a'
  on-error: '#ffffff'
  error-container: '#ffdad6'
  on-error-container: '#93000a'
  primary-fixed: '#dbe1ff'
  primary-fixed-dim: '#b4c5ff'
  on-primary-fixed: '#00174b'
  on-primary-fixed-variant: '#003ea8'
  secondary-fixed: '#6ffbbe'
  secondary-fixed-dim: '#4edea3'
  on-secondary-fixed: '#002113'
  on-secondary-fixed-variant: '#005236'
  tertiary-fixed: '#ffddb8'
  tertiary-fixed-dim: '#ffb95f'
  on-tertiary-fixed: '#2a1700'
  on-tertiary-fixed-variant: '#653e00'
  background: '#f8f9ff'
  on-background: '#0b1c30'
  surface-variant: '#d3e4fe'
typography:
  display-lg:
    fontFamily: Inter
    fontSize: 32px
    fontWeight: '700'
    lineHeight: 40px
    letterSpacing: -0.02em
  headline-md:
    fontFamily: Inter
    fontSize: 24px
    fontWeight: '600'
    lineHeight: 32px
    letterSpacing: -0.01em
  headline-sm:
    fontFamily: Inter
    fontSize: 20px
    fontWeight: '600'
    lineHeight: 28px
  body-lg:
    fontFamily: Inter
    fontSize: 18px
    fontWeight: '400'
    lineHeight: 28px
  body-md:
    fontFamily: Inter
    fontSize: 16px
    fontWeight: '400'
    lineHeight: 24px
  body-sm:
    fontFamily: Inter
    fontSize: 14px
    fontWeight: '400'
    lineHeight: 20px
  label-md:
    fontFamily: Inter
    fontSize: 14px
    fontWeight: '600'
    lineHeight: 20px
    letterSpacing: 0.01em
  label-sm:
    fontFamily: Inter
    fontSize: 12px
    fontWeight: '500'
    lineHeight: 16px
  headline-md-mobile:
    fontFamily: Inter
    fontSize: 20px
    fontWeight: '600'
    lineHeight: 28px
rounded:
  sm: 0.25rem
  DEFAULT: 0.5rem
  md: 0.75rem
  lg: 1rem
  xl: 1.5rem
  full: 9999px
spacing:
  base: 4px
  xs: 4px
  sm: 8px
  md: 16px
  lg: 24px
  xl: 32px
  2xl: 48px
  gutter: 24px
  margin-mobile: 16px
  margin-desktop: 32px
---

## Brand & Style

The design system is centered on the values of compassion, clarity, and structural reliability. Designed specifically for orphanage data management, the visual language prioritizes the human element of the data. The target audience includes social workers, administrators, and donors who require a high-density information environment that doesn't feel cold or institutional.

The chosen style is **Modern Minimalism with a Soft Humanist Touch**. By combining generous white space with gentle shadows and rounded geometry, the UI reduces cognitive load and emotional stress. The interface should feel like a supportive tool—quiet, efficient, and deeply organized—ensuring that the focus remains on the well-being of the children.

## Colors

This design system utilizes a palette that balances professional authority with empathetic warmth.

- **Primary (Soft Blue):** Used for primary actions, navigation states, and branding. It evokes trust and stability.
- **Secondary (Gentle Green):** Dedicated to positive growth indicators, "active" status markers, and health-related data points.
- **Tertiary (Amber):** Reserved for moderate alerts and pending statuses, providing a soft contrast to the cooler primary tones.
- **Neutral (Slate Grays):** A sophisticated range of grays manages the information hierarchy. Use #F8FAFC for backgrounds to maintain a "breathable" feel, and #1E293B for primary text to ensure high legibility.
- **Surface Colors:** Pure white (#FFFFFF) is used for cards and data containers to create a clear "layer" above the soft gray background.

## Typography

The typography system relies on **Inter** for its exceptional legibility and neutral, modern tone. 

- **Hierarchy:** Use bold weights (700) sparingly for page titles. Semi-bold (600) should be the standard for section headers and data labels to provide clear scannability in dense data tables.
- **Body Text:** Standardize on `body-md` for general information. For data-heavy tables, `body-sm` may be used to increase information density without sacrificing clarity.
- **Readability:** Maintain a generous line-height (1.5x) for body text to ensure that long descriptions of child progress or medical history remain easy to read for staff members.

## Layout & Spacing

The layout uses a **Fluid Grid** system with a focus on logical grouping and "Z-pattern" scanning.

- **Sidebar:** A fixed-width navigation sidebar (260px) on desktop provides consistent access to main modules (Children Records, Health, Education, Donors).
- **Metric Cards:** Use a 4-column layout on desktop, reflowing to a 1-column layout on mobile.
- **Data Tables:** These should be allowed to scroll horizontally on small screens. Use `lg` (24px) padding within card containers to prevent the data from feeling cramped.
- **Consistency:** All spacing must be a multiple of the 4px base unit. 16px is the standard padding for internal components, while 24px is used for separating distinct content blocks.

## Elevation & Depth

To maintain a friendly and approachable feel, this design system avoids harsh borders and high-contrast shadows.

- **Surface Tiers:** The main background is a very light neutral (#F8FAFC). Cards and forms sit on a white (#FFFFFF) surface.
- **Ambient Shadows:** Use a single, soft shadow style for cards: `0px 4px 6px -1px rgba(0, 0, 0, 0.05), 0px 2px 4px -2px rgba(0, 0, 0, 0.03)`. This creates a subtle "lift" that suggests the items can be interacted with.
- **Hover States:** Interactive elements like table rows or navigation items should use a subtle background color shift (e.g., to a lighter blue tint) rather than a shadow change, keeping the interface feeling calm and stable.

## Shapes

The shape language is consistently "Rounded" to reinforce the feeling of safety and care.

- **Standard Elements:** Buttons, input fields, and search bars use a 0.5rem (8px) corner radius.
- **Large Containers:** Content cards and modals use 1rem (16px) for `rounded-lg` to soften the overall screen composition.
- **Status Pills:** Badges for "Active," "Graduated," or "Medical" status should use `rounded-full` (pill shape) to distinguish them from interactive buttons.

## Components

### Data Tables
Tables are the heart of the system. Use "zebra-striping" with a very faint gray (#F1F5F9) on even rows. The header should be a light gray with uppercase labels using `label-sm`. Actions (Edit/View) should be grouped in the final right-hand column using icon buttons.

### Metric Cards
Simple, high-level summary cards showing "Total Children," "Active Health Issues," etc. Use a large `headline-md` for the number and the primary blue or secondary green for a small accompanying icon.

### Input Forms
Fields must have clear top-aligned labels. Use a 1px border (#E2E8F0) that thickens and changes to the primary blue on focus. Error states must use a soft red (#EF4444) for both the border and the helper text.

### Navigation Sidebar
A clean, vertical bar. Active states are indicated by a subtle background color (#EFF6FF) and a 4px vertical "marker" on the left edge in the primary blue. Icons should be linear and consistent in stroke weight.

### Action Buttons
- **Primary:** Solid Blue with white text.
- **Secondary:** White background with a gray border and gray text for "Cancel" or "Go Back" actions.
- **Success:** Solid Green for "Approve" or "Complete" actions.