
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
require 'dbcon.php';

// Handle deletion
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_cid'])) {
    $stmt = $pdo->prepare("DELETE FROM course WHERE cid = :cid");
    $stmt->execute(['cid' => $_POST['delete_cid']]);
    echo "<p style='color: green;'>Course deleted successfully.</p>";
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
        <th>Actions</th>
    </tr>
    <?php foreach ($courses as $course): ?>
    <tr>
        <td><?= htmlspecialchars($course['cid']) ?></td>
        <td><?= htmlspecialchars($course['cname']) ?></td>
        <td><?= htmlspecialchars($course['desc']) ?></td>
        <td><?= htmlspecialchars($course['duration']) ?></td>
        <td><?= htmlspecialchars($course['keywords']) ?></td>
        <td>
            <a href="editcourse.php?cid=<?= $course['cid'] ?>">Edit</a> |
            <form method="POST" style="display:inline;" onsubmit="return confirm('Delete this course?');">
                <input type="hidden" name="delete_cid" value="<?= $course['cid'] ?>">
                <button type="submit">Delete</button>
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

