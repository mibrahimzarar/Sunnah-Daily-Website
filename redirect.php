<?php
// Device detection and app store redirection script
// This script detects the user's device and redirects them to the appropriate app store

// Get the user agent string
$userAgent = $_SERVER['HTTP_USER_AGENT'];

// Check for Android devices
if (stripos($userAgent, 'Android') !== false) {
    // Redirect to Google Play Store
    // Replace YOUR_APP_ID with your actual Google Play Store app ID
    header('Location: https://play.google.com/store/apps/details?id=YOUR_APP_ID');
    exit;
} 
// Check for iOS devices (iPhone, iPad, iPod)
elseif (stripos($userAgent, 'iPhone') !== false || 
        stripos($userAgent, 'iPad') !== false || 
        stripos($userAgent, 'iPod') !== false) {
    // Redirect to Apple App Store
    // Replace YOUR_APP_ID with your actual Apple App Store app ID
    header('Location: https://apps.apple.com/app/idYOUR_APP_ID');
    exit;
} 
// For all other devices (desktop, other mobile platforms)
else {
    // Redirect to your website
    // Replace with your actual website URL
    header('Location: https://yourwebsite.com');
    exit;
}
?>