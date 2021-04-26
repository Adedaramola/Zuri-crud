<?php
require_once 'app.php';
if (!isInSession()) {
    header('Location: auth/login.php');
} else {
    if ($_SESSION['id'] !== $course->getUserByCourseId($_GET['id'])->user_id) {
        header('Location: dashboard.php');
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Course</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="wrapper">
        <aside>
            <div class="aside-inner">
                <nav class="aside-inner-inner">
                    <a href="dashboard.php" class="aside-link">
                        <span>Dashboard</span>
                    </a>
                    <a href="courses.php" class="aside-link">
                        <span>Add Course</span>
                    </a>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="aside-link">
                        <input type="submit" name="logout" value="Logout">
                    </form>
                </nav>
            </div>
        </aside>
        <main role="main">
            <header>
                <div class="alert alert-info">
                    <?php echo $_SESSION['message']; ?>
                </div>
            </header>
            <?php if ($course->message['success']) : ?>
                <div class="alert alert-success">
                    <?php echo $course->message['success']; ?>
                </div>
            <?php endif; ?>
            <div class="course-container">
                <h2 class="form-header">Edit Course <?php echo $course->getOneCourse($_GET['id'])->code; ?></h2>
                <form action="" method="post">
                    <div class="input-group">
                        <label for="" class="form-label">Course Name</label>
                        <input type="text" name="course_name" value="<?php echo $course->getOneCourse($_GET['id'])->name; ?>">
                    </div>
                    <div class="input-group">
                        <label for="" class="form-label">Course Code</label>
                        <input type="text" name="course_code" value="<?php echo $course->getOneCourse($_GET['id'])->code; ?>">
                    </div>
                    <div class="input-group">
                        <label for="" class="form-label">Course Description</label>
                        <input type="text" name="course_desc" value="<?php echo $course->getOneCourse($_GET['id'])->description; ?>">
                    </div>
                    <input type="submit" value="Update" name="update" class="course-btn">
                </form>
            </div>
        </main>
    </div>
</body>

</html>