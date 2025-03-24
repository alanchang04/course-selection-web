<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "database_project";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("連接失敗: " . $conn->connect_error);
}

$id = $_POST['id'];

$sql = "DELETE FROM test WHERE Id='$id'";

if ($conn->query($sql) === TRUE) {
    echo "記錄刪除成功";
} else {
    echo "錯誤: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
