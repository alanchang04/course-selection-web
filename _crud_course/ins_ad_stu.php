<?php
try {
    $studentId = $_POST['courseId'];
    $name = $_POST['name'];
    $access = $_POST['access'];

    $conn = new PDO('mysql:dbname=database_project;host=localhost', 'root', '');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sqlInsert = "INSERT INTO student (stu_Id, stu_Name, access) VALUES (:studentId, :studentName, :access)";
    $stmtInsert = $conn->prepare($sqlInsert);
    $stmtInsert->bindParam(':studentId', $studentId);
    $stmtInsert->bindParam(':studentName', $name);
    $stmtInsert->bindParam(':access', $access);
    $stmtInsert->execute();

    if ($stmtInsert->rowCount() > 0) {
        echo "學生已成功插入。";
    } else {
        echo "有問題，請重試。";
    }
} catch (PDOException $e) {
    echo "資料庫錯誤: " . $e->getMessage();
}
?>
