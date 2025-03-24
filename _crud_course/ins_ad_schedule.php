<?php
try {
    $id = $_POST['id'];
    $stuId = $_POST['stuId'];
    $cId = $_POST['cId'];

    $conn = new PDO('mysql:dbname=database_project;host=localhost', 'root', '');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sqlInsert = "INSERT INTO class_schedule (Id, stu_Id, cId) VALUES (:id, :stuId, :cId)";
    $stmtInsert = $conn->prepare($sqlInsert);
    $stmtInsert->bindParam(':id', $id);
    $stmtInsert->bindParam(':stuId', $stuId);
    $stmtInsert->bindParam(':cId', $cId);
    $stmtInsert->execute();

    if ($stmtInsert->rowCount() > 0) {
        echo "成功插入課表。";
    } else {
        echo "插入失敗。";
    }
} catch (PDOException $e) {
    echo "發生錯誤：" . $e->getMessage();
}
?>
