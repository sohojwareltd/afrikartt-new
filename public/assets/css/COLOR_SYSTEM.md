# Centralized Color System

This document explains the centralized color system used throughout the Sohoj E-commerce application.

## Color Palette

The system uses the following primary colors:

- **Hunter Green**: `#415F42` - Primary brand color
- **Harvest Gold**: `#DE991B` - Accent color
- **Seal Brown**: `#642B0D` - Dark variant
- **Seal Brown 2**: `#562309` - Darker variant
- **Cosmic Latte**: `#FEF6E5` - Light background

## CSS Variables

All colors are defined as CSS variables in `colors.css` and can be easily modified to change the entire theme.

### Primary Colors
```css
--hunter-green: #415F42;
--harvest-gold: #DE991B;
--seal-brown: #642B0D;
--seal-brown-2: #562309;
--cosmic-latte: #FEF6E5;
```

### Semantic Colors
```css
--primary-color: var(--hunter-green);
--primary-dark: var(--seal-brown-2);
--primary-darker: var(--seal-brown);
--accent-color: var(--harvest-gold);
```

### Text Colors
```css
--text-primary: #000000;
--text-secondary: #6c757d;
--text-muted: #8a8a8a;
--text-light: #ffffff;
--text-dark: #2c2c2c;
```

### Background Colors
```css
--bg-primary: var(--cosmic-latte);
--bg-secondary: #ffffff;
--bg-light: #f8f9fa;
--bg-lighter: #e9ecef;
--bg-dark: var(--hunter-green);
--bg-accent: var(--harvest-gold);
```

### Button Colors
```css
--btn-primary: var(--hunter-green);
--btn-primary-hover: var(--seal-brown-2);
--btn-secondary: var(--harvest-gold);
--btn-secondary-hover: #c88a15;
```

### Gradients
```css
--gradient-primary: linear-gradient(135deg, var(--hunter-green), var(--seal-brown-2));
--gradient-accent: linear-gradient(135deg, var(--harvest-gold), var(--accent-light));
--gradient-light: linear-gradient(135deg, var(--bg-light), var(--bg-lighter));
```

## Usage

### In CSS Files
```css
.my-element {
    background-color: var(--primary-color);
    color: var(--text-primary);
    border: 1px solid var(--border-light);
}
```

### In HTML/Blade Templates
```html
<div style="background-color: var(--primary-color); color: var(--text-light);">
    Content
</div>
```

## Theme Switching

To change the entire color scheme, simply modify the CSS variables in `colors.css`. For example:

```css
:root {
    --hunter-green: #2E8B57; /* New green */
    --harvest-gold: #FFD700; /* New gold */
    /* ... other colors */
}
```

## Accessibility Features

The color system includes support for:
- **Dark mode**: Automatic dark theme detection
- **High contrast**: Enhanced contrast for accessibility
- **Reduced motion**: Respects user's motion preferences

## Files Using This System

- `colors.css` - Main color definitions
- `product-cards.css` - Product card styling
- `app.css` - Main application styles
- `style.css` - Global styles

## Best Practices

1. **Always use CSS variables** instead of hardcoded colors
2. **Use semantic variable names** (e.g., `--primary-color` instead of `--green`)
3. **Test with different themes** to ensure accessibility
4. **Document color changes** in this file

## Quick Color Reference

| Purpose | Variable | Default Color |
|---------|----------|---------------|
| Primary | `--primary-color` | `#415F42` |
| Accent | `--accent-color` | `#DE991B` |
| Text | `--text-primary` | `#000000` |
| Background | `--bg-secondary` | `#ffffff` |
| Success | `--success-color` | `#28a745` |
| Warning | `--warning-color` | `#DE991B` |
| Error | `--error-color` | `#dc3545` | 