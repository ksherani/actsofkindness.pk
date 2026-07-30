<?php
/**
 * Email Configuration Tester
 * Use this file to verify your email setup works correctly
 */

echo "<!DOCTYPE html>";
echo "<html>";
echo "<head>";
echo "<meta charset='UTF-8'>";
echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
echo "<title>Email Configuration Tester - Acts of Kindness</title>";
echo "<style>";
echo "body { font-family: Arial, sans-serif; max-width: 900px; margin: 50px auto; padding: 20px; }";
echo "h1 { color: #10b981; }";
echo ".test { margin: 20px 0; padding: 15px; border: 1px solid #ddd; border-radius: 5px; }";
echo ".pass { background: #dcfce7; border-left: 4px solid #10b981; }";
echo ".fail { background: #fee2e2; border-left: 4px solid #ef4444; }";
echo ".warning { background: #fef3c7; border-left: 4px solid #f59e0b; }";
echo "code { background: #f3f4f6; padding: 2px 6px; border-radius: 3px; font-family: monospace; }";
echo "a { color: #10b981; text-decoration: none; }";
echo "a:hover { text-decoration: underline; }";
echo "</style>";
echo "</head>";
echo "<body>";

echo "<h1>✉️ Email Configuration Tester</h1>";
echo "<p>Use this page to verify your email setup is working correctly.</p>";

echo "<h2>1. Basic Checks</h2>";

// Check PHP mail function
echo "<div class='test " . (function_exists('mail') ? 'pass' : 'fail') . "'>";
echo "<strong>PHP mail() function:</strong> ";
if (function_exists('mail')) {
    echo "✅ Available";
} else {
    echo "❌ NOT Available - Contact your hosting provider";
}
echo "</div>";

// Check file permissions
$api_file = 'api/send-email.php';
echo "<div class='test " . (file_exists($api_file) ? 'pass' : 'fail') . "'>";
echo "<strong>API File exists:</strong> ";
if (file_exists($api_file)) {
    echo "✅ $api_file found";
} else {
    echo "❌ $api_file NOT found";
}
echo "</div>";

// Check logs directory
$logs_dir = 'logs/';
echo "<div class='test " . (is_dir($logs_dir) || is_writable(dirname($logs_dir)) ? 'pass' : 'warning') . "'>";
echo "<strong>Logs directory:</strong> ";
if (is_dir($logs_dir)) {
    echo "✅ $logs_dir exists";
    if (is_writable($logs_dir)) {
        echo " (writable)";
    } else {
        echo " (NOT writable - may need to chmod 755)";
    }
} else {
    echo "⚠️ $logs_dir doesn't exist - will be created on first submission";
}
echo "</div>";

echo "<h2>2. Configuration Check</h2>";

// Read PHP file
$php_content = file_get_contents('api/send-email.php');

// Check for email configuration
if (strpos($php_content, "'recipient_email' => 'volunteer@actsofkindness.pk'") !== false) {
    echo "<div class='test warning'>";
    echo "<strong>⚠️ Default email addresses detected</strong><br>";
    echo "You MUST update the email addresses in <code>api/send-email.php</code><br>";
    echo "Look for these lines (around line 27-30):<br>";
    echo "<code>\$config = [<br>";
    echo "&nbsp;&nbsp;'recipient_email' => 'volunteer@actsofkindness.pk',<br>";
    echo "&nbsp;&nbsp;'sender_email' => 'noreply@actsofkindness.pk',<br>";
    echo "&nbsp;&nbsp;'admin_notification_email' => 'info@actsofkindness.pk'<br>";
    echo "];</code>";
    echo "</div>";
} else {
    echo "<div class='test pass'>";
    echo "<strong>✅ Custom email addresses configured</strong>";
    echo "</div>";
}

echo "<h2>3. Server Information</h2>";

echo "<div class='test'>";
echo "<strong>PHP Version:</strong> " . phpversion() . "<br>";
echo "<strong>Server:</strong> " . $_SERVER['SERVER_SOFTWARE'] . "<br>";
echo "<strong>OS:</strong> " . php_uname() . "<br>";
echo "</div>";

echo "<h2>4. Send Test Email</h2>";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $test_email = $_POST['test_email'] ?? '';

    if (filter_var($test_email, FILTER_VALIDATE_EMAIL)) {
        echo "<div class='test pass'>";
        echo "<strong>Attempting to send test email to: $test_email</strong><br><br>";

        $subject = "🤝 Test Email from Acts of Kindness Pakistan";
        $message = "<!DOCTYPE html>
        <html>
        <head>
        <style>
            body { font-family: Arial, sans-serif; line-height: 1.6; }
            .container { max-width: 600px; margin: 0 auto; padding: 20px; }
            .header { background: linear-gradient(135deg, #10b981 0%, #0d9488 100%); color: white; padding: 20px; text-align: center; border-radius: 5px; }
        </style>
        </head>
        <body>
        <div class='container'>
            <div class='header'>
                <h1>✉️ Test Email</h1>
            </div>
            <p>If you're reading this, your email system is working correctly!</p>
            <p>This test email was sent on: " . date('Y-m-d H:i:s') . "</p>
            <p><strong>Acts of Kindness Pakistan</strong><br>
            Email System Test<br>
            Website: actsofkindness.pk</p>
        </div>
        </body>
        </html>";

        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=UTF-8\r\n";
        $headers .= "From: test@actsofkindness.pk\r\n";

        if (mail($test_email, $subject, $message, $headers)) {
            echo "✅ <strong>Test email sent successfully!</strong><br>";
            echo "Check your email at <strong>$test_email</strong> (may take a minute)<br><br>";
            echo "<strong>Next Steps:</strong><br>";
            echo "1. Check your email inbox<br>";
            echo "2. Check spam folder if not found<br>";
            echo "3. If received, your setup is working!<br>";
            echo "4. Update email addresses in <code>api/send-email.php</code><br>";
            echo "5. Test the actual form on your website";
        } else {
            echo "❌ <strong>Failed to send email</strong><br>";
            echo "This usually means:<br>";
            echo "- PHP mail() is not configured<br>";
            echo "- Server doesn't have a mail server<br>";
            echo "- Email address is invalid<br><br>";
            echo "<strong>Solution:</strong><br>";
            echo "Contact your hosting provider and ask:<br>";
            echo "1. Is PHP mail() function enabled?<br>";
            echo "2. Is there a mail server configured?<br>";
            echo "3. Can I use SMTP instead?";
        }

        echo "</div>";
    } else {
        echo "<div class='test fail'>";
        echo "❌ <strong>Invalid email address</strong>";
        echo "</div>";
    }
}

echo "<div class='test'>";
echo "<form method='POST'>";
echo "<label for='test_email'><strong>Send a test email to:</strong></label><br><br>";
echo "<input type='email' id='test_email' name='test_email' placeholder='your@email.com' required style='padding: 8px; width: 300px; font-size: 16px;'>";
echo " <button type='submit' style='padding: 8px 20px; background: #10b981; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 16px;'>Send Test Email</button>";
echo "</form>";
echo "</div>";

echo "<h2>5. Debugging Tips</h2>";

echo "<div class='test'>";
echo "<strong>If emails aren't working:</strong><br><br>";
echo "1. <strong>Check error logs:</strong><br>";
echo "   - Ask hosting provider for access to mail logs<br>";
echo "   - Usually in <code>/var/log/mail.log</code> or <code>/var/log/exim_mainlog</code><br><br>";
echo "2. <strong>Test with different email:</strong><br>";
echo "   - Try sending to different email provider (Gmail, Outlook, etc)<br><br>";
echo "3. <strong>Check SPF/DKIM:</strong><br>";
echo "   - Emails may be marked as spam without proper DNS records<br><br>";
echo "4. <strong>Contact hosting support:</strong><br>";
echo "   - Ask about: PHP mail(), SMTP, sendmail configuration<br><br>";
echo "5. <strong>Alternative solution:</strong><br>";
echo "   - Use SendGrid, Mailgun, or similar service<br>";
echo "   - Modify <code>api/send-email.php</code> to use their API<br>";
echo "</div>";

echo "<h2>6. Next Steps</h2>";

echo "<div class='test pass'>";
echo "<strong>✅ When emails are working:</strong><br><br>";
echo "1. Delete this test file (<code>test-email.php</code>)<br>";
echo "2. Visit the website<br>";
echo "3. Go to 'Join Our Movement' section<br>";
echo "4. Fill out and submit the form<br>";
echo "5. Check your email for confirmation<br>";
echo "6. Check admin email for notification<br>";
echo "</div>";

echo "<h2>📚 Documentation</h2>";
echo "<p>For more details, see: <a href='EMAIL_SETUP.md'>EMAIL_SETUP.md</a></p>";

echo "</body>";
echo "</html>";
?>
