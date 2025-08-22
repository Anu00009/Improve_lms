<?php
require 'dbcon.php';
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    if (isset($_POST['addcourse'])){
        $id = $_POST['cid'];
        $name = $_POST['name'];
        $description = $_POST['description'];
        $duration = $_POST['duration'];
        $keywords = $_POST['keywords'];

       print $sql = "INSERT INTO course (`cid`, `cname`, `desc`, `duration`, `keywords`)
     VALUES ('$id', '$name', '$description', '$duration', '$keywords')";
        $statement=$pdo->query($sql);

        header('Location: index.php');
    }
    
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['enroll'])) {
    $uid = $_POST['uid'];
    $cid = $_POST['cid'];
 
    // Debug output (optional)
    echo "User ID: " . htmlspecialchars($uid) . "<br>";
    echo "Course ID: " . htmlspecialchars($cid) . "<br>";
 
    // Check if already enrolled
    $checkSql = "SELECT * FROM user_course_status WHERE uid = :uid AND cid = :cid";
    $checkStmt = $pdo->prepare($checkSql);
    $checkStmt->execute([':uid' => $uid, ':cid' => $cid]);
 
    if ($checkStmt->rowCount() == 0) {
        // Enroll user
        $enrollSql = "INSERT INTO user_course_status (uid, cid) VALUES (:uid, :cid)";
        $enrollStmt = $pdo->prepare($enrollSql);
        $enrollStmt->execute([':uid' => $uid, ':cid' => $cid]);
 
        echo "<script>alert('Enrolled successfully!'); window.location.href='listcourse.php?uid=$uid';</script>";
    } else {
        echo "<script>alert('You are already enrolled in this course.'); window.location.href='listcourse.php?uid=$uid';</script>";
    }
}   SaveUser.php
 
?>
