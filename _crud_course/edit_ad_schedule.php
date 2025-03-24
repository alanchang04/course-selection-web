<?php
try {
    $id = $_POST['id'];
    $stuId = $_POST['stuId'];
    $cId = $_POST['cId'];

    $conn = new PDO('mysql:dbname=database_project;host=localhost', 'root', '');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sqlUpdate = "UPDATE class_schedule SET stu_Id = :stuId, cId = :cId WHERE Id = :id";
    $stmtUpdate = $conn->prepare($sqlUpdate);
    $stmtUpdate->bindParam(':id', $id);
    $stmtUpdate->bindParam(':stuId', $stuId);
    $stmtUpdate->bindParam(':cId', $cId);
    $stmtUpdate->execute();

    if ($stmtUpdate->rowCount() > 0) {
        echo "成功更新課表。";
    } else {
        echo "更新失敗，未找到符合條件的課表。";
    }
} catch (PDOException $e) {
    echo "發生錯誤：" . $e->getMessage();
}
?>
