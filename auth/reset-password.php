<?php require_once '../app.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <div class="form-container">
        <div class="form-wrapper">
            <div class="form-header"></div>
            <?php if ($user->error['msg']) : ?>
                <div class="message success">
                    <?php echo $user->error['msg']; ?>
                </div>
            <?php endif; ?>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="input-group">
                    <input type="email" name="email" placeholder="Email Address">
                    <span><?php echo $user->error['email']; ?></span>
                </div>
                <div class="input-group">
                    <input type="password" name="newPassword" placeholder="New Password">
                    <span><?php echo $user->error['password']; ?></span>
                </div>
                <div class="input-group">
                    <input type="password" name="confirmPassword" placeholder="Re-enter New Password">
                    <span><?php echo $user->error['confirm']; ?></span>
                </div>
                <input type="submit" value="Reset Password" name="reset">
            </form>
            <div class="link">
                <a href="login.php" class="reset-link mb-2">Back to login</a>
            </div>
        </div>
    </div>
</body>

</html>