<?php

session_start(); // 確保會話已經啟動

// 假設學生名稱已經存儲在會話中，登錄系統已經設置了 $_SESSION['stu_Name']
if (!isset($_SESSION['stu_Name'])) {
    echo "未找到學生名稱，請重新登錄。";
    exit;
}

$stu_Name = $_SESSION['stu_Name']; // 從會話中獲取學生名稱
$stu_Id = $_SESSION['stu_Id'];

$conn = new PDO('mysql:dbname=database_project;host=localhost', 'root', '');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['commentId']) && isset($_POST['professorName']) && isset($_POST['comment']) && isset($_POST['grade'])) {
        $commentId = $_POST['commentId'];
        $cId = $_POST['professorName'];
        $credit = $_POST['comment'];
        $grade = $_POST['grade'];

        // 檢查評論 ID 是否存在於 professor 表中，並且屬於該學生
        $checkSql = "SELECT * FROM total_course_record WHERE Id = :commentId AND sId = :stu_Id";
        $checkStmt = $conn->prepare($checkSql);
        $checkStmt->bindParam(':commentId', $commentId);
        $checkStmt->bindParam(':stu_Id', $stu_Id);
        $checkStmt->execute();

        if ($checkStmt->rowCount() > 0) {
            // 如果評論 ID 存在於 professor 表中，並且屬於該學生，則執行更新操作
            $updateSql = "UPDATE total_course_record SET cId = :newProfessorName, totalCredit = :newComment, grade = :newGrade WHERE Id = :commentId AND sId = :stu_Id";
            $stmt = $conn->prepare($updateSql);
            $stmt->bindParam(':commentId', $commentId);
            $stmt->bindParam(':stu_Id', $stu_Id);
            $stmt->bindParam(':newProfessorName', $cId);
            $stmt->bindParam(':newComment', $credit);
            $stmt->bindParam(':newGrade', $grade);

            if ($stmt->execute()) {
                if ($stmt->rowCount() > 0) {
                    echo "課程已成功更新。";
                } else {
                    echo "找不到要更新的課程或該課程不屬於學生。";
                }
            } else {
                echo "更新課程時出現問題，請重試。";
            }
        } else {

            echo "該課程不屬於學生。";
        }
    } else {
        echo "未提供課程 ID 或學分或成績。";
    }
} else {
    echo "請使用 POST 方法訪問此頁面。";
}
