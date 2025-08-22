<?php
if (isset($_GET['action']) && $_GET['action'] == "courses") {
    echo "<h2>List of Courses</h2>";
 
    $sql = "SELECT * FROM course";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $results = $stmt->fetchAll();
 
   
echo "<table border=1>
<tr>
<th>CID</th>
<th>desc</th>
<th>duration</th>
<th>Keywords</th>
<th>Action</th>
</tr>";
foreach ($results as $row) {
  echo "<tr>";
  echo "<td>" . $row['cid'] . "</td>";
  echo "<td>" . $row['desc'] . "</td>";
  echo "<td>" . $row['duration'] . "</td>";
  echo "<td>" . $row['keywords'] . "</td>";
  echo "<td>" . " <a href='index.php?action=enroll&cid=".$row['cid']."'class='w3-bar-item w3-button'>Enroll</a>". "</td>";
 
 
  echo "</tr>";
}
echo "</table>";
}