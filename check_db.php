<?php
include 'config/config.php';
$query = mysqli_query($conn, "SELECT DISTINCT level FROM user");
echo "Available levels in database: ";
while($row = mysqli_fetch_assoc($query)) {
    echo $row['level'] . ", ";
}
echo "\n";

$query = mysqli_query($conn, "SELECT username, level FROM user");
echo "Users in database:\n";
while($row = mysqli_fetch_assoc($query)) {
    echo "- " . $row['username'] . " (" . $row['level'] . ")\n";
}
?>
