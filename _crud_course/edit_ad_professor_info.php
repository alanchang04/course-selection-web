<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "database_project";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $pId = $_POST['pId'];
    $gender = $_POST['gender'];
    $departmentId = $_POST['department_Id'];
    $status = $_POST['status'];
    $name = $_POST['name'];

    $sql = "UPDATE professor_info SET gender = :gender, department_Id = :departmentId, status = :status, name = :name WHERE pId = :pId";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':pId', $pId);
    $stmt->bindParam(':gender', $gender);
    $stmt->bindParam(':departmentId', $departmentId);
    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':name', $name);

    if ($stmt->execute()) {
        echo "成功更新教授資料。";
    } else {
        echo "更新失敗。";
    }
} catch (PDOException $e) {
    echo "發生錯誤：" . $e->getMessage();
}
$conn = null;
?>
