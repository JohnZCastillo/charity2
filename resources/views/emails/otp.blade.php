<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment OTP Verification</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 40px 20px; background: #f8f9fa; }
        .header { text-align: center; padding: 20px 0; }
        .otp-box { background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%); color: white; text-align: center; padding: 40px 20px; border-radius: 12px; margin: 30px 0; }
        .otp-code { font-size: 2.5em; font-weight: bold; letter-spacing: 8px; font-family: monospace; }
        .appointment-details { background: white; border-radius: 8px; padding: 25px; margin: 25px 0; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .detail-row { display: flex; justify-content: space-between; margin: 12px 0; padding: 8px 0; border-bottom: 1px solid #eee; }
        .detail-row:last-child { border-bottom: none; }
        .footer { text-align: center; padding: 20px; color: #666; font-size: 0.9em; }
        .button { display: inline-block; background: #10b981; color: white; padding: 12px 30px; text-decoration: none; border-radius: 6px; margin: 20px 0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Appointment Verification</h1>
        </div>

        <div class="content">
            
            <p>Complete your appointment booking with this one-time password (OTP). This code expires in <strong>5 minutes</strong>.</p>
            
            <div class="otp-box">
                <div class="otp-code">{{ $code }}</div>
                <p style="margin-top: 15px; opacity: 0.9;">Enter this code to confirm your appointment</p>
            </div>

            <p>Didn't book this appointment? Please ignore this email or contact support.</p>
        </div>

        <div class="footer">
            <p>This is an automated message. Please do not reply directly.</p>
        </div>
    </div>
</body>
</html>
