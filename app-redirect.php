<?php
/**
 * Enhanced App Store Redirect Script
 * Detects user device and redirects to appropriate app store or website
 * 
 * Usage: Generate QR code pointing to this file's URL
 * Example: https://yourdomain.com/app-redirect.php
 */

// Configuration - Replace these with your actual app IDs and website URL
$config = [
    'android_app_id' => 'com.sunnahdaily.sunnahdaily9jr75at', // Replace with your Google Play Store app ID
    'ios_app_id' => '6748527320',     // Replace with your Apple App Store app ID
    'website_url' => 'https://yourwebsite.com', // Replace with your website URL
    'fallback_url' => 'index.html'    // Local fallback if website URL fails
];

// Get user agent string
$userAgent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';

// Function to perform safe redirect
function safeRedirect($url) {
    if (filter_var($url, FILTER_VALIDATE_URL)) {
        header('Location: ' . $url, true, 302);
        exit;
    }
    return false;
}

// Device detection and redirection logic
try {
    // Check for Android devices
    if (stripos($userAgent, 'Android') !== false) {
        $playStoreUrl = 'https://play.google.com/store/apps/details?id=' . $config['android_app_id'];
        if (!safeRedirect($playStoreUrl)) {
            throw new Exception('Invalid Play Store URL');
        }
    }
    // Check for iOS devices (iPhone, iPad, iPod)
    elseif (preg_match('/(iPhone|iPad|iPod)/i', $userAgent)) {
        $appStoreUrl = 'https://apps.apple.com/app/id' . $config['ios_app_id'];
        if (!safeRedirect($appStoreUrl)) {
            throw new Exception('Invalid App Store URL');
        }
    }
    // Check for other mobile devices
    elseif (preg_match('/(Mobile|Tablet|BlackBerry|Opera Mini)/i', $userAgent)) {
        // For other mobile devices, try website first, then fallback
        if (!safeRedirect($config['website_url'])) {
            safeRedirect($config['fallback_url']);
        }
    }
    // Desktop and other devices
    else {
        if (!safeRedirect($config['website_url'])) {
            safeRedirect($config['fallback_url']);
        }
    }
} catch (Exception $e) {
    // Fallback to local website if all else fails
    header('Location: ' . $config['fallback_url'], true, 302);
    exit;
}

// If we reach here, something went wrong - show a simple page
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sunnah Daily - App Redirect</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
            color: white;
            text-align: center;
            padding: 50px 20px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        .container {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 40px;
            max-width: 500px;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        h1 { margin-bottom: 20px; }
        .buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
            margin-top: 30px;
        }
        .btn {
            padding: 12px 24px;
            background: #f59e0b;
            color: #1e3a8a;
            text-decoration: none;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Sunnah Daily</h1>
        <p>Choose your platform to download the app:</p>
        <div class="buttons">
            <a href="https://play.google.com/store/apps/details?id=<?php echo htmlspecialchars($config['android_app_id']); ?>" class="btn">
                📱 Android App
            </a>
            <a href="https://apps.apple.com/app/id<?php echo htmlspecialchars($config['ios_app_id']); ?>" class="btn">
                🍎 iOS App
            </a>
            <a href="<?php echo htmlspecialchars($config['website_url']); ?>" class="btn">
                🌐 Website
            </a>
        </div>
    </div>
</body>
</html>