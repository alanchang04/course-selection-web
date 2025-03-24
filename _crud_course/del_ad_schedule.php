<?php
try {
    $id = $_POST['id'];

    $conn = new PDO('mysql:dbname=database_project;host=localhost', 'root', '');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sqlDelete = "DELETE FROM class_schedule WHERE Id = :id";
    $stmtDelete = $conn->prepare($sqlDelete);
    $stmtDelete->bindParam(':id', $id);
    $stmtDelete->execute();

    if ($stmtDelete->rowCount() > 0) {
        echo "成功刪除課表。";
    } else {
        echo "刪除失敗，未找到符合條件的課表。";
    }
} catch (PDOException $e) {
    echo "發生錯誤：" . $e->getMessage();
}
?>
