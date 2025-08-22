<?php
require 'dbcon.php';

$success = '';
$error = '';
$user = null;

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['updateuser'])) {
    $id = $_POST['id'] ?? '';
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $roleid = $_POST['roleid'] ?? '';

    if ($id && $name && $email && $roleid) {
        $sql = "UPDATE user SET name = :name, email = :email, roleid = :roleid WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        try {
            $stmt->execute([
                'id' => $id,
                'name' => $name,
                'email' => $email,
                'roleid' => $roleid
            ]);
            $success = "User updated successfully!";
        } catch (PDOException $e) {
            $error = "Error: " . $e->getMessage();
        }
    } else {
        $error = "Please fill in all fields.";
    }
}

// Load user data
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $stmt = $pdo->prepare("SELECT * FROM user WHERE id = :id");
    $stmt->execute(['id' => $_GET['id']]);
    $user = $stmt->fetch();
}
?>

<h2>Edit User</h2>
<?php if ($success): ?>
    <p style="color: green;"><?= $success ?></p>
<?php elseif ($error): ?>
    <p style="color: red;"><?= $error ?></p>
<?php endif; ?>

<?php if ($user): ?>
<form method="POST" action="">
    <input type="hidden" name="id" value="<?= htmlspecialchars($user['id']) ?>">
    Name: <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>" required><br><br>
    Email: <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required><br><br>
    Role ID: <input type="number" name="roleid" value="<?= htmlspecialchars($user['roleid']) ?>" required><br><br>
    <button name="updateuser" type="submit">Update User</button>
</form>
<?php else: ?>
    <p>User not found.</p>
<?php endif; ?>
<?php
require 'dbcon.php';

$success = '';
$error = '';
$user = null;

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['updateuser'])) {
    $id = $_POST['id'] ?? '';
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $roleid = $_POST['roleid'] ?? '';

    if ($id && $name && $email && $roleid) {
        $sql = "UPDATE user SET name = :name, email = :email, roleid = :roleid WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        try {
            $stmt->execute([
                'id' => $id,
                'name' => $name,
                'email' => $email,
                'roleid' => $roleid
            ]);
            $success = "User updated successfully!";
        } catch (PDOException $e) {
            $error = "Error: " . $e->getMessage();
        }
    } else {
        $error = "Please fill in all fields.";
    }
}

// Load user data
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $stmt = $pdo->prepare("SELECT * FROM user WHERE id = :id");
    $stmt->execute(['id' => $_GET['id']]);
    $user = $stmt->fetch();
}
?>

<h2>Edit User</h2>
<?php if ($success): ?>
    <p style="color: green;"><?= $success ?></p>
<?php elseif ($error): ?>
    <p style="color: red;"><?= $error ?></p>
<?php endif; ?>

<?php if ($user): ?>
<form method="POST" action="">
    <input type="hidden" name="id" value="<?= htmlspecialchars($user['id']) ?>">
    Name: <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>" required><br><br>
    Email: <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required><br><br>
    Role ID: <input type="number" name="roleid" value="<?= htmlspecialchars($user['roleid']) ?>" required><br><br>
    <button name="updateuser" type="submit">Update User</button>
</form>
<?php else: ?>
    <p>User not found.</p>
<?php endif; ?>
