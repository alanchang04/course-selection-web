<?php
try {
    $id = $_POST['id'];
    $stuId = $_POST['stuId'];

    $conn = new PDO('mysql:dbname=database_project;host=localhost', 'root', '');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sqlDelete = "DELETE FROM total_course_record WHERE Id = :id AND sId = :stuId";
    $stmtDelete = $conn->prepare($sqlDelete);
    $stmtDelete->bindParam(':id', $id);
    $stmtDelete->bindParam(':stuId', $stuId);
    $stmtDelete->execute();

    if ($stmtDelete->rowCount() > 0) {
        echo "成功刪除課程記錄。";
    } else {
        echo "刪除失敗，未找到符合條件的課程記錄。";
    }
} catch (PDOException $e) {
    echo "發生錯誤：" . $e->getMessage();
}
?>
