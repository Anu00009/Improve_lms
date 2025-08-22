<?php
require 'dbcon.php';

$success = '';
$error = '';
$course = null;

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['updatecourse'])) {
    $cid = $_POST['cid'] ?? '';
    $cname = $_POST['name'] ?? '';
    $desc = $_POST['description'] ?? '';
    $duration = $_POST['duration'] ?? '';
    $keywords = $_POST['keywords'] ?? '';

    if ($cid && $cname && $desc && $duration) {
        $sql = "UPDATE course SET cname = :cname, `desc` = :desc, duration = :duration, keywords = :keywords WHERE cid = :cid";
        $stmt = $pdo->prepare($sql);
        try {
            $stmt->execute([
                'cid' => $cid,
                'cname' => $cname,
                'desc' => $desc,
                'duration' => $duration,
                'keywords' => $keywords
            ]);
            $success = "Course updated successfully!";
        } catch (PDOException $e) {
            $error = "Error: " . $e->getMessage();
        }
    } else {
        $error = "Please fill in all fields.";
    }
}

// Load course data
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['cid'])) {
    $stmt = $pdo->prepare("SELECT * FROM course WHERE cid = :cid");
    $stmt->execute(['cid' => $_GET['cid']]);
    $course = $stmt->fetch();
}
?>

<h2>Edit Course</h2>
<?php if ($success): ?>
    <p style="color: green;"><?= $success ?></p>
<?php elseif ($error): ?>
    <p style="color: red;"><?= $error ?></p>
<?php endif; ?>

<?php if ($course): ?>
<form method="POST" action="">
    <input type="hidden" name="cid" value="<?= htmlspecialchars($course['cid']) ?>">
    Name: <input type="text" name="name" value="<?= htmlspecialchars($course['cname']) ?>" required><br><br>
    Description: <textarea name="description" required><?= htmlspecialchars($course['desc']) ?></textarea><br><br>
    Duration: <input type="text" name="duration" value="<?= htmlspecialchars($course['duration']) ?>" required><br><br>
    Keywords: <input type="text" name="keywords" value="<?= htmlspecialchars($course['keywords']) ?>"><br><br>
    <button name="updatecourse" type="submit">Update Course</button>
</form>
<?php else: ?>
    <p>Course not found.</p>
<?php endif; ?>
