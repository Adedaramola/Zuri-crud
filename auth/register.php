<?php require_once '../app.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <div class="form-container">
        <div class="form-wrapper">
            <div class="form-header"></div>
            <div class="message"></div>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="input-group">
                    <input type="text" name="firstname" placeholder="Firstname">
                    <span><?php echo $user->error['firstname']; ?></span>
                </div>
                <div class="input-group">
                    <input type="text" name="lastname" placeholder="Lastname">
                    <span><?php echo $user->error['lastname']; ?></span>
                </div>
                <div class="input-group">
                    <input type="email" name="email" placeholder="Email Address">
                    <span><?php echo $user->error['email']; ?></span>
                </div>
                <div class="input-group">
                    <input type="password" name="password" placeholder="Password">
                    <span><?php echo $user->error['password']; ?></span>
                </div>
                <div class="input-group">
                    <input type="password" name="confirmPassword" placeholder="Confirm Password">
                    <span><?php echo $user->error['confirm']; ?></span>
                </div>
                <input type="submit" value="Register" name="register">
            </form>
            <div class="link">
                <a href="login.php" class="reset-link mb-2">Already have an account</a>
            </div>
        </div>
    </div>
</body>

</html>