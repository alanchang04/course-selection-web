<?php
try {
    $id = $_POST['id'];
    $sid = $_POST['sid'];
    $name = $_POST['name'];
    $comment = $_POST['comment'];
    $credits = $_POST['credits'];

    $conn = new PDO('mysql:dbname=database_project;host=localhost', 'root', '');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sqlUpdate = "UPDATE professor SET name = :name, comment = :comment, credits = :credits WHERE Id = :id AND sId = :sid";
    $stmtUpdate = $conn->prepare($sqlUpdate);
    $stmtUpdate->bindParam(':id', $id);
    $stmtUpdate->bindParam(':sid', $sid);
    $stmtUpdate->bindParam(':name', $name);
    $stmtUpdate->bindParam(':comment', $comment);
    $stmtUpdate->bindParam(':credits', $credits);
    $stmtUpdate->execute();

    if ($stmtUpdate->rowCount() > 0) {
        echo "成功更新教授評論。";
    } else {
        echo "更新失敗，未找到符合條件的評論。";
    }
} catch (PDOException $e) {
    echo "發生錯誤：" . $e->getMessage();
}
?>
