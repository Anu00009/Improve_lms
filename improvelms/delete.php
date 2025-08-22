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
