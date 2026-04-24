<!DOCTYPE html>
<html>
<head>
    <title>Password Reset OTP</title>
</head>
<body style="font-family: Arial, sans-serif; background:#0A0A0F; color:#fff; padding:20px;">
    <div style="max-width:500px; margin:auto; background:#111; padding:30px; border-radius:12px; border:1px solid #333;">
        <h2 style="color:#7c3aed;">Password Reset Request</h2>
        <p>Hello <?php echo e($name); ?>,</p>
        <p>Use this OTP to reset your password:</p>
        <h1 style="font-size:42px; letter-spacing:8px; color:#7c3aed; text-align:center; margin:30px 0;">
            <?php echo e($otp); ?>

        </h1>
        <p>This OTP is valid for <strong>10 minutes</strong>.</p>
        <p>If you did not request this, ignore this email.</p>
        <p style="color:#888; font-size:12px; margin-top:40px;">
            Thanks,<br>Your App Team
        </p>
    </div>
</body>
</html><?php /**PATH E:\xampp\htdocs\zipGo\resources\views/emails/password-reset-otp.blade.php ENDPATH**/ ?>