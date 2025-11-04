exports.handler = async (event, context) => {
  // Get user agent from headers
  const userAgent = event.headers['user-agent'] || '';
  
  // Configuration
  const config = {
    android_app_id: 'com.sunnahdaily.sunnahdaily9jr75at',
    ios_app_id: '6748527320',
    website_url: 'https://sunnah-way-app.netlify.app',
    fallback_url: 'https://sunnah-way-app.netlify.app/index.html'
  };
  
  let redirectUrl;
  
  try {
    // Check for Android devices
    if (userAgent.toLowerCase().includes('android')) {
      redirectUrl = `https://play.google.com/store/apps/details?id=${config.android_app_id}&pcampaignid=web_share`;
    }
    // Check for iOS devices (iPhone, iPad, iPod)
    else if (/iPhone|iPad|iPod/i.test(userAgent)) {
      redirectUrl = `https://apps.apple.com/pk/app/sunnah-daily/id${config.ios_app_id}`;
    }
    // Check for other mobile devices
    else if (/Mobile|Tablet|BlackBerry|Opera Mini/i.test(userAgent)) {
      redirectUrl = config.website_url;
    }
    // Desktop and other devices
    else {
      redirectUrl = config.website_url;
    }
    
    // Return redirect response
    return {
      statusCode: 302,
      headers: {
        'Location': redirectUrl,
        'Cache-Control': 'no-cache'
      },
      body: ''
    };
    
  } catch (error) {
    // Fallback response with manual links
    const fallbackHtml = `
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sunnah Way - App Redirect</title>
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
            margin: 0;
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
        <h1>Sunnah Way</h1>
        <p>Choose your platform to download the app:</p>
        <div class="buttons">
            <a href="https://play.google.com/store/apps/details?id=${config.android_app_id}&pcampaignid=web_share" class="btn">
                📱 Android App
            </a>
            <a href="https://apps.apple.com/pk/app/sunnah-daily/id${config.ios_app_id}" class="btn">
                🍎 iOS App
            </a>
            <a href="${config.website_url}" class="btn">
                🌐 Website
            </a>
        </div>
    </div>
</body>
</html>`;
    
    return {
      statusCode: 200,
      headers: {
        'Content-Type': 'text/html',
        'Cache-Control': 'no-cache'
      },
      body: fallbackHtml
    };
  }
};