<?php
include 'config/config.php';
$query = mysqli_query($conn, "SELECT username, level FROM user");
if (!$query) {
    die("Query failed: " . mysqli_error($conn));
}
echo "Full User List:\n";
while($row = mysqli_fetch_assoc($query)) {
    echo "- Username: " . $row['username'] . " | Level: " . $row['level'] . "\n";
}
?>
