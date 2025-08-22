<?php
session_start();
require 'dbcon.php';
 
if (!isset($_SESSION['userid'])) {
    header('Location: login.php');
    exit;
}
 
$id = $_SESSION['userid'];
 
// Check if the user is an instructor (roleid = 2)
$roleCheck = $pdo->prepare("SELECT roleid, name FROM user WHERE id = :id");
$roleCheck->execute([':id' => $id]);
$userData = $roleCheck->fetch();
 
// if (!$userData || $userData['roleid'] != 2) {
//     echo "Access denied. Only instructors can view this report.";
//     exit;
// }
 
$instructorName = $userData['name'];
 
// Fetch report data
$sql = "
    SELECT
        ucs.uid,
        ucs.cid,
        c.cname AS course_name,
        u.username,
        ucs.completed
    FROM user_course_status ucs
    JOIN user u ON ucs.uid = u.id
    JOIN course c ON ucs.cid = c.cid
    ORDER BY ucs.cid, ucs.uid
";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$report = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
<title>Darwin Dawkins Library</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="mystyles.css">
<style>
body {font-family: "Times New Roman", Georgia, Serif;}
h1, h2, h3, h4, h5, h6 {
  font-family: "Playfair Display";
  letter-spacing: 5px;
}
 
 
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        h2 { color: #333; }
 
</style>
 
</head>
<body>
 
<!-- Navbar (sit on top) -->
<div class="w3-top">
  <div class="w3-bar w3-white w3-padding w3-card" style="letter-spacing:4px;">
    <a href="#home" class="w3-bar-item w3-button">Cognizant Library</a>
	
    <!-- Right-sided navbar links. Hide them on small screens -->
    <<div class="w3-right w3-hide-small">
      <?php if(isset($_SESSION['userid']) && $_SESSION['roleid'] == 1) { ?>
      <a href="adduser.php" class="w3-bar-item w3-button">AddUser</a>
      <a href="addcourse.php" class="w3-bar-item w3-button">AddCourse</a>
      <?php } elseif(isset($_SESSION['userid']) && $_SESSION['roleid'] == 2) { ?>
      <a href="addcourse.php" class="w3-bar-item w3-button">AddCourse</a>
      <a href="report.php" class="w3-bar-item w3-button">Report</a>
      <?php } elseif(isset($_SESSION['userid']) && $_SESSION['roleid'] == 3) { ?>
        <!-- <a href="#contact" class="w3-bar-item w3-button">Course</a> -->
      <a href="listcourse.php" class="w3-bar-item w3-button">Course</a>
      <?php } ?>
      <?php if(isset($_SESSION['userid'])) { ?>
      <a href="logout.php" class="w3-bar-item w3-button">Logout</a>
      <?php } ?>
    </div>        
  </div>
</div>
 
<!-- Header -->
<header class="w3-display-container w3-content w3-wide" style="max-width:1600px;min-width:500px" id="home"></header>
 
<!-- Page content -->
<div class="w3-content" style="max-width:1100px">
  <!-- About Section  -->
  <div class="w3-row w3-padding-64" id="report">        
  <h2>Course Completion Report</h2>
    <p>Instructor: <strong><?= htmlspecialchars($instructorName) ?></strong></>
    <table>
        <tr>
            <th>User ID</th>
            <th>Course ID</th>
            <th>Username</th>
            <th>Course Name</th>
            <th>Completed</th>
        </tr>
        <?php foreach ($report as $row): ?>
        <tr>
            <td><?= htmlspecialchars($row['uid']) ?></td>
            <td><?= htmlspecialchars($row['cid']) ?></td>
            <td><?= htmlspecialchars($row['username']) ?></td>
            <td><?= htmlspecialchars($row['course_name']) ?></td>
            <td><?= $row['completed'] ? 'Completed' : 'In Progress' ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
  </div>
<!-- End page content -->
</div>
 
<!-- Footer -->
<footer class="w3-center w3-light-grey w3-padding-32">
  <p>Powered by <a href="https://www.cognizant.com/" title="Cognizant" target="_blank" class="w3-hover-text-green">Cognizant    </a></p>
</footer>
 
</body>
</html>