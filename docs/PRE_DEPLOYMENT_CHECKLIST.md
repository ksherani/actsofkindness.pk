# Pre-Deployment Checklist - Email System

## 🚀 Before You Upload to cPanel - DO THIS FIRST!

### Step 1: Configure Email Addresses (CRITICAL!)

**Edit this file:** `api/send-email.php`

**Find line ~27 and update these 3 email addresses:**

```php
$config = [
    'recipient_email' => 'volunteer@actsofkindness.pk',    // ← Change this
    'sender_email' => 'noreply@actsofkindness.pk',         // ← Change this
    'admin_notification_email' => 'info@actsofkindness.pk' // ← Change this
];
```

**What each email does:**
- `recipient_email` = Volunteers get their confirmation here
- `sender_email` = Emails come FROM this address
- `admin_notification_email` = You get alerts at this address

**Example of properly configured:**
```php
$config = [
    'recipient_email' => 'new-volunteers@actsofkindness.pk',
    'sender_email' => 'system@actsofkindness.pk',
    'admin_notification_email' => 'ateeq@actsofkindness.pk'
];
```

---

## 📋 Pre-Deployment Checklist

### Before Uploading to cPanel:

- [ ] **Email addresses updated** in `api/send-email.php`
  - Recipient email ✅
  - Sender email ✅
  - Admin email ✅

- [ ] **Files present:**
  - [ ] `api/send-email.php` exists
  - [ ] `js/script.js` updated
  - [ ] `index.html` unchanged
  - [ ] `test-email.php` included (for testing)

### After Uploading to cPanel:

- [ ] **Verify file structure:**
  - [ ] `public_html/api/send-email.php` exists
  - [ ] Can access file (no 404 errors)
  - [ ] `logs/` folder will be auto-created

- [ ] **Test email system:**
  - [ ] Visit: `yourdomain.com/test-email.php`
  - [ ] Check "PHP mail() function" = ✅ Available
  - [ ] Check "API File exists" = ✅ Found
  - [ ] Send test email to yourself

- [ ] **Test the form:**
  - [ ] Fill out "Join Our Movement" form
  - [ ] Click submit
  - [ ] See success message: "✅ Thank you for your interest..."
  - [ ] Check email - should have confirmation

- [ ] **Verify admin gets notified:**
  - [ ] Check admin email inbox
  - [ ] Should have application details

---

## 🎯 Critical Configuration

### You MUST Change:

**File:** `api/send-email.php`
**Lines:** 27-30

**Current (DEFAULT):**
```php
'recipient_email' => 'volunteer@actsofkindness.pk',
'sender_email' => 'noreply@actsofkindness.pk',
'admin_notification_email' => 'info@actsofkindness.pk'
```

**Change TO YOUR REAL EMAILS:**
```php
'recipient_email' => '[YOUR REAL EMAIL]',
'sender_email' => '[YOUR REAL EMAIL OR NOREPLY]',
'admin_notification_email' => '[YOUR REAL EMAIL]'
```

---

## ⚠️ Common Mistakes (Avoid These!)

❌ **Mistake 1:** Forgetting to change email addresses
- **Result:** Emails go to wrong person or bounce
- **Fix:** Update addresses before uploading

❌ **Mistake 2:** Deleting `api/` folder
- **Result:** Form shows "Network error"
- **Fix:** Keep `api/` folder and `send-email.php`

❌ **Mistake 3:** Not setting file permissions
- **Result:** Form submits but emails don't send
- **Fix:** Ensure `api/` folder is readable (755)

❌ **Mistake 4:** Deleting test-email.php before confirming emails work
- **Result:** Can't diagnose issues
- **Fix:** Keep it until you verify everything works

❌ **Mistake 5:** Ignoring warning about email configuration
- **Result:** No emails sent
- **Fix:** Read EMAIL_SETUP.md carefully

---

## 🧪 Testing Sequence

### Test 1: Configuration Check
```
1. Upload files to server
2. Visit: yourdomain.com/test-email.php
3. Verify:
   - PHP mail() = ✅
   - API file found = ✅
   - Email addresses = ✅ (should be your emails, not defaults)
```

### Test 2: Send Test Email
```
1. On test-email.php page
2. Enter YOUR email address
3. Click "Send Test Email"
4. Wait 1-2 minutes
5. Check email (inbox and spam folder)
```

### Test 3: Form Submission
```
1. Go to website
2. Find "Join Our Movement" section
3. Fill form completely:
   - Full Name: Your Name
   - Email: Your Email
   - Phone: Your Phone
   - City: Islamabad
   - Profession: Student
   - Interests: Check any
   - Availability: Select any
   - Message: (optional) I want to volunteer
   - Check "I agree to terms"
4. Click "Submit Application"
5. Should see green success message
6. Check email for confirmation
```

### Test 4: Admin Notification
```
1. Submit form with YOUR email
2. Check admin email address (from config)
3. Should receive notification with your details
```

---

## ✅ Success Criteria

**Email system is working when:**

✅ Test email arrives in your inbox
✅ Form submission shows success message
✅ Volunteer receives confirmation email
✅ Admin receives notification email
✅ Submissions saved in logs/ folder

---

## 🔧 Quick Fixes

### If test email doesn't arrive:
1. Check spam folder
2. Verify email address is correct
3. Check email format (must be valid email)
4. Contact hosting provider about mail server

### If form shows "Network error":
1. Check `api/send-email.php` exists
2. Check folder structure
3. Reload page
4. Check browser console (F12) for errors

### If emails send but content looks wrong:
1. May be email client issue
2. Try different email provider
3. Check text vs HTML email setting

---

## 📞 Getting Help

**If email system doesn't work:**

1. **Run test-email.php first** to diagnose
2. **Check EMAIL_SETUP.md** for common issues
3. **Contact your hosting provider** and ask:
   - "Is PHP mail() enabled?"
   - "Is mail server configured?"
   - "Can I see mail server logs?"

---

## 🎯 One-Minute Summary

1. **Edit** `api/send-email.php` - change 3 email addresses
2. **Upload** all files to cPanel
3. **Test** with `test-email.php`
4. **Verify** form works
5. **Delete** test-email.php (optional, for security)
6. **Done!** 🎉

---

## 📝 Notes

- Keep `test-email.php` on server until fully confident
- Create backup of `api/send-email.php` before making changes
- Monitor `logs/submissions_*.json` files regularly
- Delete old log files after 30-90 days (optional)

---

## 🚀 You're Ready!

Once you complete this checklist:
- ✅ Email system is configured
- ✅ Email system is tested
- ✅ Form is working
- ✅ Volunteers can submit

**Website is live and ready!** 🎊

---

**Last Updated:** 2024
**Status:** Ready for Deployment
