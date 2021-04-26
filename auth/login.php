<?php
require_once '../app.php';
if (isInSession()) {
    header('Location: ../dashboard.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <div class="form-container">
        <div class="form-wrapper">
            <div class="form-header"></div>
            <div class="message">
                <span><?php echo $user->error['error']; ?></span>
            </div>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="input-group">
                    <input type="email" name="email" placeholder="Email Address">
                    <span><?php echo $user->error['email']; ?></span>
                </div>
                <div class="input-group">
                    <input type="password" name="password" placeholder="Password">
                    <span><?php echo $user->error['password']; ?></span>
                </div>
                <input type="submit" value="Sign in" name="login">
            </form>
            <div class="link">
                <a href="register.php" class="reset-link mb-2">Don't have an account</a>
                <a href="reset-password.php" class="reset-link">Forgot password</a>
            </div>
        </div>
    </div>
</body>

</html>