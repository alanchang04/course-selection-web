<?php
try {
    $id = $_POST['id'];
    $sid = $_POST['sid'];
    $name = $_POST['name'];
    $comment = $_POST['comment'];
    $credits = $_POST['credits'];

    $conn = new PDO('mysql:dbname=database_project;host=localhost', 'root', '');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sqlInsert = "INSERT INTO professor (Id, sId, name, comment, credits) VALUES (:id, :sid, :name, :comment, :credits)";
    $stmtInsert = $conn->prepare($sqlInsert);
    $stmtInsert->bindParam(':id', $id);
    $stmtInsert->bindParam(':sid', $sid);
    $stmtInsert->bindParam(':name', $name);
    $stmtInsert->bindParam(':comment', $comment);
    $stmtInsert->bindParam(':credits', $credits);
    $stmtInsert->execute();

    if ($stmtInsert->rowCount() > 0) {
        echo "成功插入教授評論。";
    } else {
        echo "插入失敗。";
    }
} catch (PDOException $e) {
    echo "發生錯誤：" . $e->getMessage();
}
?>
