# Acts of Kindness Pakistan Website

A modern, responsive, and polished static website for Acts of Kindness Pakistan - a youth-centric non-profit organization dedicated to spreading kindness and social impact across Pakistan.

**Website URL:** https://actsofkindness.pk

## Overview

This website showcases the mission, vision, programs, and team of Acts of Kindness Pakistan. It features volunteer enrollment, team member profiles, and comprehensive information about the organization's initiatives.

## Features

### ✨ Core Sections

- **Hero Section** - Eye-catching landing area with animated call-to-action buttons
- **Mission & Vision** - Clear presentation of organizational values
- **Key Programs** - Showcase of 6 main initiatives:
  - Medical Camps
  - Health Awareness Campaigns
  - Youth Mobilization
  - Community Support
  - Awareness Campaigns
  - Random Acts of Kindness

- **Team Section** - Profiles of 6 leadership team members with social media links
- **Membership Enrollment** - Comprehensive volunteer registration form with:
  - Personal information collection
  - Interest areas selection
  - Availability scheduling
  - Motivation statement

- **Contact Section** - Address, email, and social media links
- **Newsletter Subscription** - Email signup for updates

### 🎨 Design Features

- **Modern Design**: Clean, professional aesthetic with gradients and smooth transitions
- **Responsive Layout**: Fully responsive design that works on desktop, tablet, and mobile
- **Smooth Animations**: GSAP and CSS animations for enhanced user experience
- **Accessibility**: Keyboard navigation, focus states, and semantic HTML
- **Typography**:
  - Cormorant Garamond for headings (elegant serif)
  - Lato for body text (clean sans-serif)
- **Color Scheme**: Emerald and teal gradients with professional gray tones

### 🚀 Technical Stack

- **HTML5** - Semantic markup
- **CSS3** - Modern styling with flexbox and grid
- **Vanilla JavaScript** - No frameworks or build tools required
- **GSAP 3** - Smooth animations and scroll triggers
- **Flowbite** - UI component library (via CDN)
- **Google Fonts** - Custom typography

## File Structure

```
actsofkindness_website/
├── index.html              # Main HTML file
├── css/
│   └── styles.css          # Custom styles and animations
├── js/
│   └── script.js           # JavaScript functionality
├── README.md               # This file
└── claude.md               # Development notes and enhancement guide
```

## Getting Started

### No Installation Required

This is a static website with no dependencies to install. Simply upload the files to your hosting:

1. **Extract the project files** to your local machine
2. **Open `index.html`** in a browser to preview locally
3. **Upload to cPanel**:
   - Create a ZIP file of all project files
   - Extract the ZIP in your public_html folder via cPanel
   - Access your website at your domain

### Local Preview

```bash
# On Windows (CMD)
start index.html

# On macOS (Terminal)
open index.html

# Or use any local server
python -m http.server 8000
# Then visit http://localhost:8000
```

## Browser Support

- Chrome/Edge (latest)
- Firefox (latest)
- Safari (latest)
- Mobile browsers (iOS Safari, Chrome Mobile)

## Deployment

### CPanel Deployment

1. **Create ZIP file**:
   - Select all files and folders
   - Compress to `actsofkindness_website.zip`

2. **Upload via CPanel**:
   - Access File Manager
   - Navigate to `public_html`
   - Upload the ZIP file
   - Extract using CPanel's extract tool

3. **Verify installation**:
   - Check that `index.html` is in `public_html`
   - Visit your domain to confirm it loads

### Environment Variables

No environment variables needed. All configuration is static.

### DNS Setup

Ensure your domain (`actsofkindness.pk`) is properly configured:
- Point your domain to your hosting provider's nameservers
- Update DNS A record to point to your server IP
- Wait for DNS propagation (can take 24-48 hours)

## Form Handling

The membership form currently logs data to browser console. To enable actual submissions:

### Option 1: Use FormSubmit (No Backend Required)

Update the form action in `index.html`:

```html
<form id="membership-form" action="https://formsubmit.co/your-email@actsofkindness.pk" method="POST">
```

### Option 2: Use Netlify Forms

If deploying to Netlify instead of CPanel, add this attribute:

```html
<form netlify>
```

### Option 3: Backend Integration

Create a backend endpoint and update `js/script.js` in the `submitForm` function:

```javascript
fetch('/api/membership', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(data)
})
.then(response => response.json())
.then(result => {
    // Handle success
})
.catch(error => {
    // Handle error
});
```

## Customization

### Update Organization Info

Edit the following in `index.html`:

- **Contact Info** (Contact Section):
  ```html
  <a href="mailto:your-email@actsofkindness.pk">
  ```

- **Social Media Links** (Footer and Team):
  ```html
  <a href="https://www.instagram.com/actsofkindnesspk/" target="_blank">
  ```

- **Team Members** (Team Section):
  Replace placeholder team cards with real information

### Change Colors

Modify CSS variables in `css/styles.css`:

```css
:root {
    --emerald-500: #10b981;  /* Primary color */
    --teal-600: #0d9488;     /* Secondary color */
}
```

### Update Content

All text content is directly in `index.html`. Simply find and replace:

- Organization name
- Taglines
- Program descriptions
- Team bios
- Contact information

### Fonts

Fonts are loaded from Google Fonts. To change:

1. Update the Google Fonts link in `<head>`
2. Update font-family values in `css/styles.css`

## Performance

- **Load Time**: Optimized for fast loading with CDN resources
- **File Sizes**:
  - HTML: ~25 KB
  - CSS: ~15 KB
  - JS: ~8 KB
- **Optimizations**:
  - Minified CSS and JS available
  - Lazy loading for images (can be added)
  - Efficient animations using GSAP
  - No heavy dependencies

## SEO

The website includes:
- Meta description
- Semantic HTML
- Proper heading hierarchy
- Mobile-responsive meta viewport
- Social media meta tags (can be enhanced)

To improve SEO further:

1. Add Open Graph meta tags in `<head>`
2. Submit to Google Search Console
3. Add sitemap.xml
4. Create robots.txt
5. Implement structured data (schema.org)

## Accessibility

- ✅ Keyboard navigation
- ✅ Focus indicators
- ✅ Semantic HTML
- ✅ Color contrast compliant
- ✅ Form labels properly associated
- ✅ ARIA attributes where needed

## Troubleshooting

### Animations not working?
- Ensure GSAP library is loading from CDN
- Check browser console for errors
- Verify JavaScript is enabled

### Form not submitting?
- Check console for errors
- Ensure form handling is configured (see Form Handling section)
- Verify email addresses if using email-based submission

### Layout issues on mobile?
- Clear browser cache
- Check viewport meta tag is present
- Test in different browsers

### Slow loading?
- Check internet connection
- Verify CDN resources are accessible
- Consider enabling compression on server

## Support & Maintenance

For updates and enhancements, see `claude.md` for detailed development notes.

## Contact

**Organization**: Acts of Kindness Pakistan
**Email**: info@actsofkindness.pk
**Address**: Office No. 4, Kashif Plaza, G8 Markaz, Islamabad, Pakistan
**Website**: https://actsofkindness.pk

### Social Media

- Instagram: [@actsofkindnesspk](https://www.instagram.com/actsofkindnesspk/)
- Facebook: [@actsofkindnesspk](https://www.facebook.com/actsofkindnesspk)
- LinkedIn: [Acts of Kindness](https://www.linkedin.com/company/acts-of-kindness/)
- Twitter/X: [@actsofkindnessp](https://twitter.com/actsofkindnessp)

## License

This website is proprietary to Acts of Kindness Pakistan. All rights reserved.

## Version History

- **v1.0.0** (2024) - Initial launch
  - Full website with all sections
  - Responsive design
  - Form integration ready
  - GSAP animations
  - Flowbite components

---

**Last Updated**: 2024
**Maintained by**: Acts of Kindness Pakistan Team
