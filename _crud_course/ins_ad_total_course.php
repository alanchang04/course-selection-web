<?php
try {
    $id = $_POST['id'];
    $stuId = $_POST['stuId'];
    $cId = $_POST['cId'];
    $totalCredit = $_POST['totalCredit'];
    $grade = $_POST['grade'];

    $conn = new PDO('mysql:dbname=database_project;host=localhost', 'root', '');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sqlInsert = "INSERT INTO total_course_record (Id, sId, cId, totalCredit, grade) VALUES (:id, :stuId, :cId, :totalCredit, :grade)";
    $stmtInsert = $conn->prepare($sqlInsert);
    $stmtInsert->bindParam(':id', $id);
    $stmtInsert->bindParam(':stuId', $stuId);
    $stmtInsert->bindParam(':cId', $cId);
    $stmtInsert->bindParam(':totalCredit', $totalCredit);
    $stmtInsert->bindParam(':grade', $grade);
    $stmtInsert->execute();

    echo "成功插入課程記錄。";
} catch (PDOException $e) {
    echo "發生錯誤：" . $e->getMessage();
}
?>
