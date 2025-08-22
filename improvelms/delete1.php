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
	
    <!-- Right-sided navbar links. Hide them on small screens -->
    <<div class="w3-right w3-hide-small">
      <?php if(isset($_SESSION['userid']) && $_SESSION['roleid'] == 1) { ?>
      <a href="adduser.php" class="w3-bar-item w3-button">AddUser</a>
      <a href="addcourse.php" class="w3-bar-item w3-button">AddCourse</a>
      <?php } elseif(isset($_SESSION['userid']) && $_SESSION['roleid'] == 2) { ?>

        <!-- <a href="edit.php" class="w3-bar-item w3-button">EditCourse</a> -->
        <!-- <a href="viewuser.php" class="w3-bar-item w3-button">ViewUser</a> -->
      <a href="addcourse.php" class="w3-bar-item w3-button">AddCourse</a>
      <a href="delete1.php" class="w3-bar-item w3-button">ViewCourse</a>
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
<header class="w3-display-container w3-content w3-wide" style="max-width:1600px;min-width:500px" id="home">

</header>

<!-- Page content -->
<div class="w3-content" style="max-width:1100px">
  <!-- About Section  -->
  <div class="w3-row w3-padding-64" id="about">
	</br>
	
    <?php
require 'dbcon.php';

// Handle deletion if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_cid'])) {
    $delete_cid = $_POST['delete_cid'];

    $sql = "DELETE FROM course WHERE cid = :cid";
    $stmt = $pdo->prepare($sql);

    try {
        $stmt->execute(['cid' => $delete_cid]);
        echo "<p style='color: green;'>Course with ID $delete_cid deleted successfully.</p>";
    } catch (PDOException $e) {
        echo "<p style='color: red;'>Error deleting course: " . $e->getMessage() . "</p>";
    }
}

// Fetch all courses
$stmt = $pdo->query("SELECT * FROM course");
$courses = $stmt->fetchAll();
?>

<h2>Available Courses</h2>

<?php if (count($courses) > 0): ?>
    <table border="1" cellpadding="10">
        <tr>
            <th>CID</th>
            <th>Name</th>
            <th>Description</th>
            <th>Duration</th>
            <th>Keywords</th>
            <th>Action</th>
            <th>Action</th>
        </tr>
        <?php foreach ($courses as $course): ?>
            <tr>
                <td><?php echo htmlspecialchars($course['cid']); ?></td>
                <td><?php echo htmlspecialchars($course['cname']); ?></td>
                <td><?php echo htmlspecialchars($course['desc']); ?></td>
                <td><?php echo htmlspecialchars($course['duration']); ?></td>
                <td><?php echo htmlspecialchars($course['keywords']); ?></td>
                <td>
                    <form method="POST" onsubmit="return confirm('Are you sure you want to delete this course?');">
                        <input type="hidden" name="delete_cid" value="<?php echo htmlspecialchars($course['cid']); ?>">
                        <button type="submit">Delete</button>
                    </form>
                </td>
                <td>
                    <form method="POST" action ="edit1.php">
                        <!-- <input type="hidden" name="delete_cid" value="<?php echo htmlspecialchars($course['cid']); ?>"> -->
                        <button name="edit" type="submit">Edit</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php else: ?>
    <p>No courses found.</p>
<?php endif; ?>

  </div>
<!-- End page content -->
</div>

<!-- Footer -->
<footer class="w3-center w3-light-grey w3-padding-32">
  <p>Powered by <a href="https://www.cognizant.com/" title="Cognizant" target="_blank" class="w3-hover-text-green">Cognizant	</a></p>
</footer>

</body>
</html>
