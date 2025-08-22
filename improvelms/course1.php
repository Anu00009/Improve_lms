<!DOCTYPE html>
<html>
<head>
<title>Cognizant Library</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="mystyles.css">
<style>
body {font-family: "Times New Roman", Georgia, Serif;}
h1, h2, h3, h4, h5, h6 {
  font-family: "Playfair Display";
  letter-spacing: 5px;
}
</style>
</head>
<body>

<!-- Navbar (sit on top) -->
<div class="w3-top">
  <div class="w3-bar w3-white w3-padding w3-card" style="letter-spacing:4px;">
    <a href="#home" class="w3-bar-item w3-button">Cognizant Library</a>
  </div>
</div>

<!-- Header -->
<header class="w3-display-container w3-content w3-wide" style="max-width:1600px;min-width:500px" id="home">

</header>

<!-- Page content -->
<div class="w3-content" style="max-width:1100px">
  <!-- About Section  -->
  <div class="w3-row w3-padding-64" id="about">
	</br>
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
        <a href="viewCertificate.php"><button type="submit" name="certificate completion" >View Certificate</button></a>
        <p style="color: green;"><strong>You have completed this course.</strong></p>
    <?php endif; ?>

 
    <p><a href="index.php">Back to Courses</a></p>
</body>
</html>
 
  </div>
<!-- End page content -->
</div>

<!-- Footer -->
<footer class="w3-center w3-light-grey w3-padding-32">
  <p>Powered by <a href="https://www.cognizant.com/" title="Cognizant" target="_blank" class="w3-hover-text-green">Cognizant	</a></p>
</footer>

</body>
</html>
