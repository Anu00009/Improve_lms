<?php
require 'dbcon.php';

if ($_SERVER["REQUEST_METHOD"] == "POST"  && isset($_POST['edit'])) {
    

    
    $cid = $_POST['cid'];
    $cname = $_POST['name'];
    $desc = $_POST['description'];
    $duration = $_POST['duration'];
    $keywords = $_POST['keywords'];

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
        echo "Course updated successfully!";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    // Display form with existing data
//     $cid = $_REQUEST['cid'];
//     $stmt = $pdo->prepare("SELECT * FROM course WHERE cid = :cid");
//     $stmt->execute(['cid' => $cid]);
//     $course = $stmt->fetch();
// ?>

<!-- <form method="post" action="edit_course.php">
    <input type="hidden" name="cid" value="<?php echo htmlspecialchars($course['cid']); ?>">
    Name: <input type="text" name="cname" value="<?php echo htmlspecialchars($course['cname']); ?>"><br>
    Description: <textarea name="desc"><?php echo htmlspecialchars($course['desc']); ?></textarea><br>
    Duration: <input type="text" name="duration" value="<?php echo htmlspecialchars($course['duration']); ?>"><br>
    Keywords: <input type="text" name="keywords" value="<?php echo htmlspecialchars($course['keywords']); ?>"><br>
    <button type="submit">Update Course</button>
</form> -->


<?php } ?>
