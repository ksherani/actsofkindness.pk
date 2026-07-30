# Email Configuration Guide - Acts of Kindness Pakistan

## Overview

The website now includes a complete email system for volunteer membership form submissions. Here's how it works:

### How It Works

1. **User submits form** → JavaScript collects data
2. **Data sent to PHP** → `api/send-email.php` processes the submission
3. **Two emails sent**:
   - **Confirmation email** to volunteer (thank you message)
   - **Notification email** to admin (new application alert)
4. **Backup log created** → JSON file stored in `logs/` folder

---

## Setup Instructions

### Step 1: Configure Email Addresses

Edit `api/send-email.php` and update these email addresses (around line 27-30):

```php
$config = [
    'recipient_email' => 'volunteer@actsofkindness.pk',    // ← CHANGE THIS
    'sender_email' => 'noreply@actsofkindness.pk',         // ← CHANGE THIS
    'from_name' => 'Acts of Kindness Pakistan',
    'admin_notification_email' => 'info@actsofkindness.pk' // ← CHANGE THIS
];
```

**Email Addresses to Update:**

| Variable | Purpose | Example |
|----------|---------|---------|
| `recipient_email` | Receives confirmation emails from volunteers | `volunteer@actsofkindness.pk` |
| `sender_email` | Email address that sends the emails | `noreply@actsofkindness.pk` |
| `admin_notification_email` | Admin receives new application alerts | `info@actsofkindness.pk` |

### Step 2: File Permissions

Make sure the `api/` folder has proper permissions:

```bash
chmod 755 api/
chmod 644 api/send-email.php
```

Create logs folder with permissions:

```bash
mkdir -p logs/
chmod 755 logs/
```

### Step 3: Test the Form

1. Open website in browser
2. Navigate to "Join Our Movement" section
3. Fill out the form completely
4. Click "Submit Application"
5. Check your email for confirmation
6. Check admin email for notification

---

## Email Features

### What Volunteers Receive

When a volunteer submits the form, they receive:

✅ **Personalized confirmation email** with:
- Welcome message
- Their submitted information (for reference)
- "What happens next" information
- Links to social media
- Contact details
- Professional branding

### What Admin Receives

When a new volunteer applies, admin receives:

✅ **Notification email** with:
- Volunteer's complete information
- Contact details (clickable links)
- Areas of interest
- Availability
- Motivation statement
- Action items checklist
- Submission timestamp

---

## File Structure

```
actsofkindness_website/
├── api/
│   └── send-email.php          ← Email processing script
├── logs/                       ← Auto-created folder for backups
│   └── submissions_YYYY-MM-DD.json
├── js/
│   └── script.js               ← Updated with email sending
└── index.html
```

---

## How to Access Submissions Backup

Form submissions are automatically saved to JSON files for backup:

**Location:** `logs/submissions_YYYY-MM-DD.json`

Each day creates a new file with all submissions from that day.

**Example content:**
```json
[
  {
    "timestamp": "2024-11-06 14:30:45",
    "data": {
      "fullname": "John Doe",
      "email": "john@example.com",
      "phone": "+92 300 1234567",
      ...
    },
    "ip": "192.168.1.1"
  }
]
```

---

## Troubleshooting

### Issue: "Network error" message when submitting form

**Solutions:**
1. Check that `api/send-email.php` exists
2. Verify folder permissions (755)
3. Check browser console for detailed error (F12)
4. Verify email addresses are correct

### Issue: Emails not being sent

**Check:**
1. ✅ Email addresses in `api/send-email.php` are correct
2. ✅ Hosting provider allows sending emails
3. ✅ PHP mail() function is enabled
4. ✅ Server has mail server configured
5. Contact your hosting provider if issue persists

### Issue: Emails going to spam folder

**Solutions:**
1. Add sender email to whitelist
2. Configure SPF/DKIM records with domain
3. Use a professional email service (SendGrid, Mailgun)
4. Contact hosting provider for mail configuration

### Issue: Special characters showing incorrectly in email

**Solution:** The PHP script uses UTF-8 encoding. If issues persist:
- Check email client supports UTF-8
- Contact hosting provider about server encoding

---

## Advanced Configuration

### Option 1: Using SendGrid (Recommended for Production)

If direct email isn't reliable, use SendGrid:

1. Sign up at https://sendgrid.com/
2. Get API key
3. Install SendGrid PHP library
4. Update `send-email.php` to use SendGrid API

### Option 2: Using PHPMailer

For more control, install PHPMailer:

```bash
composer require phpmailer/phpmailer
```

Then use SMTP for more reliable delivery.

### Option 3: Using Mail Service

Use a mail service like:
- SendGrid
- Mailgun
- Amazon SES
- Postmark

---

## Email Template Customization

The email templates are generated in two functions:

1. **`create_volunteer_email()`** - Confirmation email sent to volunteer
2. **`create_admin_email()`** - Notification email sent to admin

To customize:

1. Open `api/send-email.php`
2. Find the function you want to customize
3. Edit the HTML template
4. Save and test

---

## Security Considerations

✅ **What's Protected:**
- Email addresses validated with `FILTER_VALIDATE_EMAIL`
- All input sanitized with `htmlspecialchars()`
- CORS headers allow only necessary methods
- PHP-level validation before processing

✅ **What You Should Do:**
- Keep email addresses private (not in frontend code)
- Regularly backup JSON logs
- Monitor logs for suspicious activity
- Use HTTPS on your website
- Keep PHP updated

---

## Monitoring & Analytics

### View Daily Submissions

```bash
ls logs/
# Shows: submissions_2024-11-06.json, submissions_2024-11-07.json, etc.
```

### Count Total Submissions

```bash
wc -l logs/submissions_*.json
```

### Extract Specific Email

```bash
grep "email.*john" logs/submissions_*.json
```

---

## Testing Locally

If testing locally without email capability:

1. Comment out mail() functions in `send-email.php`
2. Add logging instead:

```php
// Instead of mail(), log the data
file_put_contents('php://stdout', json_encode($data, JSON_PRETTY_PRINT));
```

---

## Support & Help

If emails aren't working:

1. **Check PHP mail function:**
   ```php
   <?php
   if (function_exists('mail')) {
       echo "Mail function is available";
   } else {
       echo "Mail function is NOT available";
   }
   ?>
   ```

2. **Contact hosting provider:**
   - Ask about mail server configuration
   - Request PHP mail() to be enabled
   - Ask for SMTP credentials if available

3. **Check server logs:**
   - Usually in `/var/log/mail.log`
   - Or `/var/log/exim_mainlog`
   - Ask hosting provider for access

---

## FAQ

**Q: Where do the emails come from?**
A: From the `sender_email` address you configure in the PHP file.

**Q: Can I send emails from a Gmail account?**
A: Not directly via PHP mail(). Use SMTP with PHPMailer or a service like SendGrid.

**Q: How long are submissions stored?**
A: In JSON files indefinitely. Manually delete old files from `logs/` folder.

**Q: Can volunteers see other volunteers' emails?**
A: No. Each volunteer only receives their own confirmation email.

**Q: Is there a limit to form submissions?**
A: No, but server storage is limited. Archive/delete old logs if needed.

---

## Next Steps

1. ✅ Update email addresses in `api/send-email.php`
2. ✅ Test form submission
3. ✅ Verify emails are received
4. ✅ Set up email forwarding if needed
5. ✅ Configure domain SPF/DKIM records
6. ✅ Monitor submissions in `logs/` folder

---

**Version:** 1.0.0
**Last Updated:** 2024
**Status:** Production Ready
