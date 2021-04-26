<?php
session_start();
require_once 'app/Database.php';
require_once 'app/User.php';
require_once 'app/Course.php';

$database = new Database;
$user = new User($database);
$course = new Course($database);


if (isset($_SESSION['id'])) {
    $course->user_id = $_SESSION['id'];
}



if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['register'])) {
        $user->firstname = $_POST['firstname'];
        $user->lastname = $_POST['lastname'];
        $user->email = $_POST['email'];
        $user->password = $_POST['password'];
        $user->confirmPassword = $_POST['confirmPassword'];
        if ($user->register()) {
            header('Location: login.php');
        }
    }

    if (isset($_POST['login'])) {
        $user->email = $_POST['email'];
        $user->password = $_POST['password'];
        $loggedInUser = $user->login();
        if ($loggedInUser) {
            init_session($loggedInUser);
        }
    }

    if (isset($_POST['logout'])) {
        $user->logout();
    }

    if (isset($_POST['reset'])) {
        $user->email = $_POST['email'];
        $user->password = $_POST['newPassword'];
        $user->confirmPassword = $_POST['confirmPassword'];

        if ($user->resetPassword()) {
            $user->error['msg'] = 'Password updated';
        }
    }

    if (isset($_POST['add'])) {

        $course->course_name = $_POST['course_name'];
        $course->course_code = $_POST['course_code'];
        $course->course_desc = $_POST['course_desc'];

        if ($course->addCourse()) {
            $course->message['success'] = 'Course successfully added';
        }
    }

    if (isset($_POST['update'])) {

        if (isset($_GET['id'])) {

            $course->course_id = $_GET['id'];
            $course->course_name = $_POST['course_name'];
            $course->course_code = $_POST['course_code'];
            $course->course_desc = $_POST['course_desc'];

            if ($course->editCourse()) {
                $course->message['success'] = 'Course successfully updated';
            }
        }
    }

    if (isset($_POST['delete'])) {
        $course->course_id = $_POST['course_id'];
        if ($course->deleteCourse()) {
            $course->message['success'] = 'Course deleted successfully';
        }
    }
}

function init_session($user)
{
    $_SESSION['id'] = $user->id;
    $_SESSION['message'] = 'Howdy! ' . $user->firstname;
    header('Location: dashboard.php');
}


function isInSession()
{
    if (isset($_SESSION['id'])) {
        return true;
    }
    return false;
}
