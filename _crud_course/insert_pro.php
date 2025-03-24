<?php

session_start(); // 確保會話已經啟動

// 確認學生名稱已經存儲在會話中
if (!isset($_SESSION['stu_Name'])) {
    echo "未找到學生名稱，請重新登錄。";
    exit;
}

$stu_Name = $_SESSION['stu_Name']; // 從會話中獲取學生名稱
$stuId = $_SESSION['stu_Id'];
try {
    // 設置資料庫連接
    $conn = new PDO('mysql:dbname=database_project;host=localhost', 'root', '');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 從 student 表中獲取學生ID
    $sql = "SELECT stu_Id FROM student WHERE stu_Name = :stu_Name";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':stu_Name', $stu_Name);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $student = $stmt->fetch(PDO::FETCH_ASSOC);
        $studentId = $student['stu_Id'];

        // 確認請求中是否包含教授名稱、評論和評分
        if (
            isset($_POST['professorName']) && $_POST['professorName'] !== '' &&
            isset($_POST['comment']) && $_POST['comment'] !== '' &&
            isset($_POST['grade']) && $_POST['grade'] !== ''
        ) {

            $professorName = $_POST['professorName'];
            $comment = $_POST['comment'];
            $grade = $_POST['grade'];

            // 查詢該 sId 的學生目前使用到的最大 Id 數字
            $sqlMaxId = "SELECT MAX(Id) AS max_id FROM professor WHERE sId = :studentId";
            $stmtMaxId = $conn->prepare($sqlMaxId);
            $stmtMaxId->bindParam(':studentId', $studentId);
            $stmtMaxId->execute();
            $resultMaxId = $stmtMaxId->fetch(PDO::FETCH_ASSOC);
            $newId = $resultMaxId['max_id'] + 1;

            // 插入教授評論
            $sqlInsert = "INSERT INTO professor (Id,name, comment, credits, sId) VALUES (:newId , :professorName, :comment, :grade, :studentId)";
            $stmtInsert = $conn->prepare($sqlInsert);
            $stmtInsert->bindParam(':newId', $newId);
            $stmtInsert->bindParam(':professorName', $professorName);
            $stmtInsert->bindParam(':comment', $comment);
            $stmtInsert->bindParam(':grade', $grade);
            $stmtInsert->bindParam(':studentId', $studentId);
            $stmtInsert->execute();

            if ($stmtInsert->rowCount() > 0) {
                echo "評論已成功插入。";
            } else {
                echo "插入失敗，請重試。";
            }
        } else {
            echo "請填寫所有字段！";
        }
    } else {
        echo "未找到對應的學生記錄。";
    }
} catch (PDOException $e) {
    echo "資料庫錯誤: " . $e->getMessage();
}
