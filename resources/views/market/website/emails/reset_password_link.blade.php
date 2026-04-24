<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset Request</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
        }

        h2 {
            color: #1e69b8;
        }

        p {
            margin-bottom: 20px;
        }

        a {
            display: inline-block;
            padding: 15px 32px;
            font-size: 16px;
            text-decoration: none;
            color: #fff;
            background-color: #1e69b8;
            border-radius: 5px;
        }

        a:hover {
            background-color: #15578c;
        }

        .footer {
            margin-top: 20px;
            text-align: center;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Password Reset Request</h2>
        <p>We have received your password reset request. Click the following link to reset your password:</p>

        <a href="{{ url('reset-password/'.$token) }}" style="color:#fff;">Reset Password</a>

        <p>If you didn't apply for a password reset, please ignore this email.</p>
    </div>

    <div class="footer">
        <p>Thank you!</p>
    </div>
</body>
</html>
