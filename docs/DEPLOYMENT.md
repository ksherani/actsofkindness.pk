# Acts of Kindness Pakistan - cPanel Deployment Guide

Quick step-by-step guide to deploy your website on cPanel.

## Quick Start (5 minutes)

### Step 1: Prepare Files

1. Navigate to your project folder: `C:\_git-archive\actsofkindness_website`
2. Select all files:
   - `index.html`
   - `css/` folder
   - `js/` folder
   - (optional) `README.md`, `claude.md`, `DEPLOYMENT.md`
3. Right-click → Compress to ZIP
4. Name it: `actsofkindness.zip`

### Step 2: Login to cPanel

1. Go to: `https://your-domain.com:2083` or your hosting provider's cPanel URL
2. Enter your cPanel username and password
3. Click "Log In"

### Step 3: Upload Files

1. Click **File Manager** in the cPanel dashboard
2. Navigate to **public_html** folder
3. Click **Upload** button
4. Select your `actsofkindness.zip` file
5. Click **Upload File**
6. Wait for upload to complete

### Step 4: Extract Files

1. Right-click the uploaded `actsofkindness.zip`
2. Click **Extract**
3. Confirm the extraction location (should be `public_html`)
4. Click **Extract File(s)**
5. Wait for extraction to complete

### Step 5: Verify Installation

1. Open your web browser
2. Visit: `https://actsofkindness.pk` (or your actual domain)
3. Website should load and be fully functional
4. Test navigation, forms, and responsive design

### Step 6: Clean Up (Optional)

1. In File Manager, delete the `actsofkindness.zip` file
2. Delete any unnecessary files not needed on production

## Troubleshooting

### Issue: Website shows "404 Not Found"
**Solution**:
- Verify files are in `public_html` folder
- Ensure `index.html` is in the root of `public_html`
- Check file permissions (should be 644 for files, 755 for folders)
- Clear browser cache and try again

### Issue: Styles or JavaScript not loading
**Solution**:
- Verify folder structure is correct (`css/` and `js/` folders exist)
- Check file permissions (644)
- Clear browser cache (Ctrl+F5 or Cmd+Shift+R)
- Check browser console for 404 errors (F12)

### Issue: Form not working
**Solution**:
- See README.md for form configuration options
- Implement FormSubmit or backend integration
- Test locally first in browser console

### Issue: Images not showing (when added)
**Solution**:
- Verify image paths in HTML are relative
- Ensure image files are uploaded
- Check file permissions and extensions

## File Permissions

If you need to set file permissions manually via SSH:

```bash
# Login via SSH
ssh username@your-domain.com

# Navigate to public_html
cd public_html

# Set correct permissions
chmod 644 *.html *.css
chmod 755 css js
chmod 644 css/*.css
chmod 644 js/*.js

# Verify
ls -la
```

## Using Different Domain

If your domain is different from `actsofkindness.pk`:

1. Update all email links in `index.html`:
   ```html
   <!-- Change from -->
   info@actsofkindness.pk

   <!-- To -->
   info@yourdomain.com
   ```

2. Update social media links if needed
3. Update contact section address if needed
4. Redeploy updated files

## Custom Domain Setup

If domain isn't configured yet:

1. In cPanel, go to **Addon Domains** or **Domains**
2. Add your domain: `actsofkindness.pk`
3. Point DNS at your hosting provider
4. Wait 24-48 hours for DNS propagation
5. Website will become accessible at your domain

## SSL Certificate (HTTPS)

Most hosting providers offer free SSL (Let's Encrypt):

1. In cPanel, go to **AutoSSL** or **SSL/TLS Status**
2. Click **Manage** for your domain
3. Install SSL certificate
4. Wait a few minutes for activation
5. Website will be accessible via HTTPS

## Email Configuration

To enable form email notifications:

### Option 1: FormSubmit (Easiest - No Backend Needed)

Edit `index.html` around line 272:

```html
<!-- Change from: -->
<form id="membership-form" class="bg-white...">

<!-- To: -->
<form id="membership-form" action="https://formsubmit.co/your-email@actsofkindness.pk" method="POST" class="bg-white...">
```

Replace `your-email@actsofkindness.pk` with actual email address.

The first submission will require email verification from FormSubmit.

### Option 2: Backend Email Integration

If you have server-side scripting (PHP, Node.js, etc.):

1. Update form action to point to your backend endpoint
2. Implement email sending on backend
3. See `claude.md` for integration details

## CDN & Performance

The website uses these CDNs:
- Flowbite CSS/JS - `cdn.jsdelivr.net`
- Google Fonts - `fonts.googleapis.com`
- GSAP Library - `cdnjs.cloudflare.com`

These are all public, widely-used CDNs and should work without configuration.

If CDN access is restricted:
1. Download libraries locally
2. Place in `js/` and `css/` folders
3. Update script/link tags to point to local files

## Analytics Setup (Google Analytics)

To track visitor statistics:

1. Get Google Analytics code from your Analytics account
2. Add to `<head>` section of `index.html` before `</head>`:

```html
<!-- Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=YOUR_GA_ID"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', 'YOUR_GA_ID');
</script>
```

Replace `YOUR_GA_ID` with your actual Google Analytics ID.

## Regular Maintenance

### Weekly
- Check website is loading
- Verify form submissions work
- Monitor error logs

### Monthly
- Update contact information if needed
- Add new team members
- Post news or updates

### Quarterly
- Review analytics
- Update images/content
- Test all links

## Backups

Before making changes:

1. In cPanel, download entire website:
   - File Manager → Select all files → Download
2. Keep local backup copy
3. Only modify one section at a time
4. Revert quickly if issues occur

## Advanced: Subdomain Setup

To deploy at a subdomain (e.g., `volunteer.actsofkindness.pk`):

1. In cPanel, go to **Subdomains**
2. Create subdomain: `volunteer`
3. Set document root to: `/public_html/volunteer`
4. Create `volunteer` folder
5. Upload website files there

## Support & Help

- **cPanel Tutorials**: https://docs.cpanel.net/
- **Hosting Provider Support**: Contact your hosting provider
- **General Web Issues**: Check browser console (F12)

## Deployment Checklist

Before going live:

- [ ] Files uploaded and extracted
- [ ] index.html loads in browser
- [ ] All pages accessible
- [ ] Navigation works
- [ ] Responsive design works on mobile (test with F12)
- [ ] Links point to correct URLs
- [ ] Email addresses updated
- [ ] Social media links correct
- [ ] Form submission configured
- [ ] SSL certificate installed (HTTPS)
- [ ] Analytics configured (optional)
- [ ] Backup created

## Final Notes

- The website is fully static (no database needed)
- No backend programming knowledge required
- Content updates require editing HTML directly
- For frequent content changes, consider CMS in future
- Website works on all modern browsers
- Mobile responsive and tested

---

**Last Updated**: 2024
**Status**: Ready for Deployment

Need help? Check README.md for full documentation or contact your hosting provider's support team.
