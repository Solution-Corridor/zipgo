<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Email - BotaEx</title>
    <style>
        /* Add your custom styling here */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #084AA2;
        }

        p {
            color: #555555;
        }

        .otp {
            font-size: 24px;
            font-weight: bold;
            color: #e74c3c;
            text-align: center;
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            margin-top: 20px;
            background-color: #084AA2;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
        }

        .footer {
            margin-top: 20px;
            color: #777777;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 align="center">BotaEx</h1>
        <p>Dear User,</p>
        <p>Your One-Time Password (OTP) for Funds Transfer at BotaEx is:</p>
        <p class="otp">{{$otp}}</p>
        <p>This OTP is valid for a limited time. Please do not share it with anyone.</p>

        <div class="footer">
            <p>Best regards,<br> BotaEx</p>
            <p><a href="https://botaex.com">botaex.com</a></p>
        </div>
    </div>
</body>
</html>
