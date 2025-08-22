<?php
session_start();
require 'dbcon.php';
 
if (!isset($_SESSION['userid'])) {
    header('Location: login.php');
    exit;
}
 
if (!isset($_GET['cid'])) {
    echo "No course selected.";
    exit;
}
 
$uid = $_SESSION['userid'];
$cid = $_GET['cid'];
 
// Fetch course details
$stmt = $pdo->prepare("SELECT * FROM course WHERE cid = :cid");
$stmt->execute([':cid' => $cid]);
$course = $stmt->fetch();
 
if (!$course) {
    echo "Course not found.";
    exit;
}
 
// Check enrollment status
$checkStmt = $pdo->prepare("SELECT * FROM user_course_status WHERE uid = :uid AND cid = :cid");
$checkStmt->execute([':uid' => $uid, ':cid' => $cid]);
$enrollment = $checkStmt->fetch();
 
$enrolled = $enrollment ? true : false;
$completed = $enrollment ? $enrollment['completed'] : 0;
 
// Handle enrollment
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['enroll'])) {
    if (!$enrolled) {
        $enrollStmt = $pdo->prepare("INSERT INTO user_course_status (uid, cid, completed) VALUES (:uid, :cid, 0)");
        $enrollStmt->execute([':uid' => $uid, ':cid' => $cid]);
        $enrolled = true;
        $completed = 0;
    }
}
 
// Handle mark as completed
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['mark_completed'])) {
    if ($enrolled && !$completed) {
        $updateStmt = $pdo->prepare("UPDATE user_course_status SET completed = 1 WHERE uid = :uid AND cid = :cid");
        $updateStmt->execute([':uid' => $uid, ':cid' => $cid]);
        $completed = 1;
    }
}
?>
 
<!DOCTYPE html>
<html>
<head>
    <title>Course Details</title>
    <link rel="stylesheet" href="mystyles.css">
</head>
<body>
    <h2>Course Details</h2>
    <ul>
        <li><strong>Course ID:</strong> <?= htmlspecialchars($course['cid']) ?></li>
        <li><strong>Name:</strong> <?= htmlspecialchars($course['cname']) ?></li>
        <li><strong>Description:</strong> <?= htmlspecialchars($course['desc']) ?></li>
        <li><strong>Duration:</strong> <?= htmlspecialchars($course['duration']) ?></li>
        <li><strong>Keywords:</strong> <?= htmlspecialchars($course['keywords']) ?></li>
        <li><strong>Enrollment Status:</strong> <?= $enrolled ? 'Enrolled' : 'Not Enrolled' ?></li>
        <li><strong>Completion Status:</strong> <?= $completed ? 'Completed' : 'Not Completed' ?></li>
    </ul>
 
    <?php if (!$enrolled): ?>
        <form method="post">
            <button type="submit" name="enroll">Enroll</button>
        </form>
    <?php elseif (!$completed): ?>
        <form method="post">
            <button type="submit" name="mark_completed">Mark as Completed</button>
        </form>
    <?php else: ?>
        <p style="color: green;"><strong>You have completed this course.</strong></p>
    <?php endif; ?>
 
    <p><a href="index.php">Back to Courses</a></p>
</body>
</html>
 