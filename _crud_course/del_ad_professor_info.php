<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "database_project";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $pId = $_POST['pId'];

    $sql = "DELETE FROM professor_info WHERE pId = :pId";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':pId', $pId);

    if ($stmt->execute()) {
        echo "成功刪除教授資料。";
    } else {
        echo "刪除失敗。";
    }
} catch (PDOException $e) {
    echo "發生錯誤：" . $e->getMessage();
}
$conn = null;
?>
