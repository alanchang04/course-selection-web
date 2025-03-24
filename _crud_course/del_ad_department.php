<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "database_project";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $departCode = $_POST['depart_code_number'];

    $sql = "DELETE FROM department WHERE depart_code_number = :departCode";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':departCode', $departCode);

    if ($stmt->execute()) {
        echo "成功刪除系所。";
    } else {
        echo "刪除失敗。";
    }
} catch (PDOException $e) {
    echo "發生錯誤：" . $e->getMessage();
}
$conn = null;
?>
