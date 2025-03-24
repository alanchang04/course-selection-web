<?php
try {
    $id = $_POST['id'];
    $sid = $_POST['sid'];

    $conn = new PDO('mysql:dbname=database_project;host=localhost', 'root', '');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sqlDelete = "DELETE FROM professor WHERE Id = :id AND sId = :sid";
    $stmtDelete = $conn->prepare($sqlDelete);
    $stmtDelete->bindParam(':id', $id);
    $stmtDelete->bindParam(':sid', $sid);
    $stmtDelete->execute();

    if ($stmtDelete->rowCount() > 0) {
        echo "成功刪除教授評論。";
    } else {
        echo "刪除失敗，未找到符合條件的評論。";
    }
} catch (PDOException $e) {
    echo "發生錯誤：" . $e->getMessage();
}
?>
