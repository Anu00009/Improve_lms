
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
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_uid'])) {
    $stmt = $pdo->prepare("DELETE FROM user WHERE id = :id");
    $stmt->execute(['id' => $_POST['delete_uid']]);
    echo "<p style='color: green;'>User deleted successfully.</p>";
}

// Fetch all users
$stmt = $pdo->query("SELECT * FROM user");
$users = $stmt->fetchAll();
?>

<h2>Registered Users</h2>
<?php if (count($users) > 0): ?>
<table border="1" cellpadding="10">
    <tr>
        <th>User ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Role</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($users as $user): ?>
    <tr>
        <td><?= htmlspecialchars($user['id']) ?></td>
        <td><?= htmlspecialchars($user['name']) ?></td>
        <td><?= htmlspecialchars($user['email']) ?></td>
        <td><?= htmlspecialchars($user['roleid']) ?></td>
        <td>
            <a href="edituser.php?id=<?= $user['id'] ?>">Edit</a> |
            <form method="POST" style="display:inline;" onsubmit="return confirm('Delete this user?');">
                <input type="hidden" name="delete_uid" value="<?= $user['id'] ?>">
                <button type="submit">Delete</button>
           >
    </tr>
    <?php endforeach; ?>
</table>
<?php else: ?>
<p>No users found.</p>
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
