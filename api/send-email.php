<?php
/**
 * Acts of Kindness Pakistan - Email Form Handler
 * Processes volunteer membership form submissions and sends emails
 */

// Set JSON response header
header('Content-Type: application/json');

// Enable CORS for local testing (disable in production)
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Only accept POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit();
}

// Get JSON input
$input = file_get_contents('php://input');
$data = json_decode($input, true);

// Validate required fields
$required_fields = ['fullname', 'email', 'phone', 'city', 'profession'];
foreach ($required_fields as $field) {
    if (empty($data[$field])) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => "Missing required field: $field"]);
        exit();
    }
}

// Sanitize inputs
$fullname = sanitize_input($data['fullname']);
$email = filter_var($data['email'], FILTER_SANITIZE_EMAIL);
$phone = sanitize_input($data['phone']);
$city = sanitize_input($data['city']);
$profession = sanitize_input($data['profession']);
$interests = isset($data['interests']) && is_array($data['interests']) ? $data['interests'] : [];
$availability = sanitize_input($data['availability'] ?? '');
$message = sanitize_input($data['message'] ?? '');

// Validate email format
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid email address']);
    exit();
}

// Configuration - UPDATE THESE WITH YOUR ACTUAL EMAIL ADDRESSES
$config = [
    'recipient_email' => 'volunteer@actsofkindness.pk',  // WHERE FORM SUBMISSIONS GO
    'sender_email' => 'noreply@actsofkindness.pk',        // FROM EMAIL ADDRESS
    'from_name' => 'Acts of Kindness Pakistan',
    'admin_notification_email' => 'info@actsofkindness.pk' // ADMIN EMAIL FOR NOTIFICATIONS
];

// Create email body for volunteers
$volunteer_subject = "🤝 Welcome to Acts of Kindness Pakistan!";
$volunteer_message = create_volunteer_email($fullname, $email, $phone, $city, $profession, $interests, $availability, $message);

// Create email body for admin
$admin_subject = "📝 New Volunteer Application - $fullname";
$admin_message = create_admin_email($fullname, $email, $phone, $city, $profession, $interests, $availability, $message);

// Email headers
$headers = "MIME-Version: 1.0\r\n";
$headers .= "Content-type: text/html; charset=UTF-8\r\n";
$headers .= "From: " . $config['from_name'] . " <" . $config['sender_email'] . ">\r\n";
$headers .= "Reply-To: " . $email . "\r\n";
$headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";

// Send email to volunteer
$volunteer_sent = mail(
    $email,
    $volunteer_subject,
    $volunteer_message,
    $headers
);

// Send email to admin
$admin_headers = "MIME-Version: 1.0\r\n";
$admin_headers .= "Content-type: text/html; charset=UTF-8\r\n";
$admin_headers .= "From: " . $config['from_name'] . " <" . $config['sender_email'] . ">\r\n";
$admin_headers .= "Reply-To: " . $email . "\r\n";

$admin_sent = mail(
    $config['admin_notification_email'],
    $admin_subject,
    $admin_message,
    $admin_headers
);

// Log the submission (optional - for your records)
log_submission($data);

// Return response
if ($volunteer_sent && $admin_sent) {
    http_response_code(200);
    echo json_encode([
        'success' => true,
        'message' => 'Thank you for your interest! We\'ve sent a confirmation email to your inbox.',
        'data' => [
            'name' => $fullname,
            'email' => $email,
            'timestamp' => date('Y-m-d H:i:s')
        ]
    ]);
} else {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'There was an error processing your application. Please try again or contact us directly.'
    ]);
}

// ========== HELPER FUNCTIONS ==========

/**
 * Sanitize user input
 */
function sanitize_input($input) {
    if (is_array($input)) {
        return array_map('sanitize_input', $input);
    }
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

/**
 * Create email for volunteer (confirmation)
 */
function create_volunteer_email($fullname, $email, $phone, $city, $profession, $interests, $availability, $message) {
    $interests_list = !empty($interests) ? implode(', ', $interests) : 'Not specified';

    return "
    <!DOCTYPE html>
    <html>
    <head>
        <style>
            body { font-family: 'Lato', Arial, sans-serif; line-height: 1.6; color: #333; }
            .container { max-width: 600px; margin: 0 auto; padding: 20px; }
            .header { background: linear-gradient(135deg, #10b981 0%, #0d9488 100%); color: white; padding: 30px; text-align: center; border-radius: 8px 8px 0 0; }
            .content { background: #f9fafb; padding: 30px; border: 1px solid #e5e7eb; }
            .footer { background: #111827; color: #9ca3af; padding: 20px; text-align: center; border-radius: 0 0 8px 8px; font-size: 12px; }
            h1 { margin: 0; font-size: 28px; }
            h2 { color: #10b981; margin-top: 20px; font-size: 20px; border-bottom: 2px solid #10b981; padding-bottom: 10px; }
            .info-row { margin: 10px 0; }
            .label { font-weight: bold; color: #059669; }
            .cta-button { display: inline-block; background: linear-gradient(135deg, #10b981 0%, #0d9488 100%); color: white; padding: 12px 30px; text-decoration: none; border-radius: 6px; margin: 20px 0; }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                <h1>🤝 Welcome to Acts of Kindness Pakistan!</h1>
            </div>

            <div class='content'>
                <p>Hi <strong>$fullname</strong>,</p>

                <p>Thank you so much for your interest in joining Acts of Kindness Pakistan! We're thrilled to have you on board.</p>

                <h2>Your Application Details</h2>
                <div class='info-row'>
                    <span class='label'>Full Name:</span> $fullname
                </div>
                <div class='info-row'>
                    <span class='label'>Email:</span> $email
                </div>
                <div class='info-row'>
                    <span class='label'>Phone:</span> $phone
                </div>
                <div class='info-row'>
                    <span class='label'>City/Location:</span> $city
                </div>
                <div class='info-row'>
                    <span class='label'>Education/Profession:</span> $profession
                </div>
                <div class='info-row'>
                    <span class='label'>Areas of Interest:</span> $interests_list
                </div>
                <div class='info-row'>
                    <span class='label'>Availability:</span> $availability
                </div>

                <h2>What Happens Next?</h2>
                <p>Our team will review your application and reach out to you within 3-5 business days. We'll discuss volunteer opportunities that match your interests and availability.</p>

                <p>In the meantime, feel free to:</p>
                <ul>
                    <li>Follow us on <a href='https://www.instagram.com/actsofkindnesspk/'>Instagram</a></li>
                    <li>Connect with us on <a href='https://www.facebook.com/actsofkindnesspk'>Facebook</a></li>
                    <li>Check out <a href='https://www.linkedin.com/company/acts-of-kindness/'>LinkedIn</a> for updates</li>
                </ul>

                <p style='margin: 30px 0;'>
                    <a href='https://actsofkindness.pk' class='cta-button'>Visit Our Website</a>
                </p>

                <h2>Questions?</h2>
                <p>If you have any questions, feel free to reach out to us:</p>
                <ul>
                    <li><strong>Email:</strong> volunteer@actsofkindness.pk</li>
                    <li><strong>Phone:</strong> +92 (contact your organization)</li>
                    <li><strong>Address:</strong> Office No. 4, Kashif Plaza, G8 Markaz, Islamabad</li>
                </ul>

                <p style='margin-top: 30px; color: #059669;'>
                    <strong>Let's Share, Support, Promote - Acts of Kindness Together! 💚</strong>
                </p>
            </div>

            <div class='footer'>
                <p>© 2024 Acts of Kindness Pakistan. All rights reserved.</p>
                <p>Spreading kindness across Pakistan since 2016 🇵🇰</p>
            </div>
        </div>
    </body>
    </html>
    ";
}

/**
 * Create email for admin (notification)
 */
function create_admin_email($fullname, $email, $phone, $city, $profession, $interests, $availability, $message) {
    $interests_list = !empty($interests) ? implode(', ', $interests) : 'Not specified';
    $submission_time = date('Y-m-d H:i:s');

    return "
    <!DOCTYPE html>
    <html>
    <head>
        <style>
            body { font-family: 'Lato', Arial, sans-serif; line-height: 1.6; color: #333; }
            .container { max-width: 700px; margin: 0 auto; padding: 20px; }
            .header { background: #111827; color: white; padding: 20px; text-align: center; border-radius: 8px 8px 0 0; }
            .content { background: white; padding: 20px; border: 1px solid #e5e7eb; }
            .section { margin: 20px 0; padding: 15px; background: #f9fafb; border-left: 4px solid #10b981; }
            .label { font-weight: bold; color: #059669; display: inline-block; width: 150px; }
            .footer { background: #f3f4f6; padding: 15px; text-align: center; border-radius: 0 0 8px 8px; font-size: 12px; }
            table { width: 100%; border-collapse: collapse; margin: 10px 0; }
            table td { padding: 8px; border-bottom: 1px solid #e5e7eb; }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                <h1>📝 New Volunteer Application Received</h1>
            </div>

            <div class='content'>
                <p><strong>A new volunteer has applied! Here are the details:</strong></p>

                <div class='section'>
                    <h2 style='margin-top: 0; color: #111827;'>Personal Information</h2>
                    <table>
                        <tr>
                            <td><span class='label'>Name:</span></td>
                            <td>$fullname</td>
                        </tr>
                        <tr>
                            <td><span class='label'>Email:</span></td>
                            <td><a href='mailto:$email'>$email</a></td>
                        </tr>
                        <tr>
                            <td><span class='label'>Phone:</span></td>
                            <td><a href='tel:$phone'>$phone</a></td>
                        </tr>
                        <tr>
                            <td><span class='label'>City:</span></td>
                            <td>$city</td>
                        </tr>
                        <tr>
                            <td><span class='label'>Profession:</span></td>
                            <td>$profession</td>
                        </tr>
                    </table>
                </div>

                <div class='section'>
                    <h2 style='margin-top: 0; color: #111827;'>Volunteer Preferences</h2>
                    <table>
                        <tr>
                            <td><span class='label'>Interests:</span></td>
                            <td>$interests_list</td>
                        </tr>
                        <tr>
                            <td><span class='label'>Availability:</span></td>
                            <td>$availability</td>
                        </tr>
                    </table>
                </div>

                " . (!empty($message) ? "
                <div class='section'>
                    <h2 style='margin-top: 0; color: #111827;'>Motivation</h2>
                    <p>$message</p>
                </div>
                " : "") . "

                <div class='section' style='background: #dbeafe; border-left-color: #0284c7;'>
                    <p><strong>⏰ Submission Time:</strong> $submission_time</p>
                    <p><strong>📧 Reply Email:</strong> <a href='mailto:$email'>$email</a></p>
                </div>

                <p style='margin-top: 20px;'>
                    <strong>Action Items:</strong><br>
                    ☐ Review application<br>
                    ☐ Check for matching volunteer opportunities<br>
                    ☐ Schedule interview/call<br>
                    ☐ Send orientation materials
                </p>
            </div>

            <div class='footer'>
                <p>This is an automated email from the Acts of Kindness Pakistan volunteer system.</p>
                <p>© 2024 Acts of Kindness Pakistan | Office No. 4, Kashif Plaza, G8 Markaz, Islamabad</p>
            </div>
        </div>
    </body>
    </html>
    ";
}

/**
 * Log submission to file for backup records
 */
function log_submission($data) {
    $log_dir = __DIR__ . '/../logs';

    // Create logs directory if it doesn't exist
    if (!is_dir($log_dir)) {
        mkdir($log_dir, 0755, true);
    }

    $log_file = $log_dir . '/submissions_' . date('Y-m-d') . '.json';

    // Read existing logs
    $submissions = [];
    if (file_exists($log_file)) {
        $content = file_get_contents($log_file);
        $submissions = json_decode($content, true) ?? [];
    }

    // Add new submission
    $submissions[] = [
        'timestamp' => date('Y-m-d H:i:s'),
        'data' => $data,
        'ip' => $_SERVER['REMOTE_ADDR'] ?? 'Unknown'
    ];

    // Save updated logs
    file_put_contents($log_file, json_encode($submissions, JSON_PRETTY_PRINT));
}
?>
