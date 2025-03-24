<?php
try {
    $id = $_POST['id'];
    $stuId = $_POST['stuId'];
    $newCId = $_POST['cId'];
    $newTotalCredit = $_POST['totalCredit'];
    $newGrade = $_POST['grade'];

    $conn = new PDO('mysql:dbname=database_project;host=localhost', 'root', '');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sqlUpdate = "UPDATE total_course_record SET cId = :cId, totalCredit = :totalCredit, grade = :grade WHERE Id = :id AND sId = :stuId";
    $stmtUpdate = $conn->prepare($sqlUpdate);
    $stmtUpdate->bindParam(':id', $id);
    $stmtUpdate->bindParam(':stuId', $stuId);
    $stmtUpdate->bindParam(':cId', $newCId);
    $stmtUpdate->bindParam(':totalCredit', $newTotalCredit);
    $stmtUpdate->bindParam(':grade', $newGrade);
    $stmtUpdate->execute();

    if ($stmtUpdate->rowCount() > 0) {
        echo "成功更新課程記錄。";
    } else {
        echo "更新失敗，未找到符合條件的課程記錄。";
    }
} catch (PDOException $e) {
    echo "發生錯誤：" . $e->getMessage();
}
?>
