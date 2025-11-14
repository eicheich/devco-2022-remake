<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            background-color: #007bff;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }

        .content {
            background-color: #f8f9fa;
            padding: 30px;
            border-radius: 0 0 5px 5px;
        }

        .otp-code {
            background-color: white;
            border: 2px solid #007bff;
            padding: 20px;
            text-align: center;
            font-size: 32px;
            font-weight: bold;
            letter-spacing: 5px;
            margin: 20px 0;
            border-radius: 5px;
            font-family: 'Courier New', monospace;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            color: #6c757d;
            font-size: 14px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>DevCo {{ $type === 'change' ? 'Change Password' : 'Password Reset' }}</h1>
        </div>
        <div class="content">
            <p>Hello,</p>
            <p>You have requested to {{ $type === 'change' ? 'change your password' : 'reset your password' }}. Please
                use the following OTP code to verify your identity:</p>

            <div class="otp-code">
                {{ $otp }}
            </div>

            <p><strong>Important:</strong></p>
            <ul>
                <li>This OTP will expire in 10 minutes</li>
                <li>Do not share this code with anyone</li>
                <li>If you didn't request this, please ignore this email</li>
            </ul>

            <p>Email: <strong>{{ $email }}</strong></p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} DevCo. All rights reserved.</p>
        </div>
    </div>
</body>

</html>
