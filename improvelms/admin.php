<?php
require "dbcon.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['user'])) {
        // Handle Add User
        $id = $_POST['uid'];
        $name = $_POST['name'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        $role = $_POST['role'];

       
     $sql = "INSERT INTO user (`id`, `name`, `username`, `password`, `email`, `roleid`)
     VALUES ('$id', '$name', '$username', '$password', '$email', '$role')";


$statement=$pdo->query($sql);

header('Location: index.php');
    }
}


// if ($_SERVER["REQUEST_METHOD"] == "POST"){
//     if (isset($_POST['addcourse'])){
//         $id = $_POST['cid'];
//         $name = $_POST['name'];
//         $description = $_POST['description'];
//         $duration = $_POST['duration'];
//         $keywords = $_POST['keywords'];

//        print $sql = "INSERT INTO user (`cid`, `cname`, `desc`, `duration`, `keywords`)
//      VALUES ('$id', '$name', '$description', '$duration', '$keywords')";
//         $statement=$pdo->query($sql);

//         header('Location: index.php');
//     }
// }

?>
