<?php
require_once 'app.php';
if (!isInSession()) {
    header('Location: auth/login.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
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
            <div class="users-table-view">
                <div class="users-table-btn-group">
                    <button class="btn">
                        <span>All Added Courses</span>
                    </button>
                </div>
                <table class="users-table">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Course ID</th>
                            <th>Course Name</th>
                            <th>Course Description</th>
                            <th>Course Code</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($course->getAllCourses() as $course) : ?>
                            <tr>
                                <td></td>
                                <td><?php echo $course->id; ?></td>
                                <td><?php echo $course->name; ?></td>
                                <td><?php echo $course->description; ?></td>
                                <td><?php echo $course->code; ?></td>
                                <td class="form-action">
                                    <a href="edit.php?id=<?php echo $course->id; ?>" class="add-btn">Edit</a>
                                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                        <input type="hidden" name="course_id" value="<?php echo $course->id; ?>">
                                        <input type="submit" value="Delete" name="delete" class="add-btn">
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>

</html>