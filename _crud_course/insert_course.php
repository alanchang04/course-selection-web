<?php

session_start(); // 確保會話已經啟動

// 假設學生名稱已經存儲在會話中，登入系統已經設置了 $_SESSION['stu_Name']
if (!isset($_SESSION['stu_Name'])) {
    echo "未找到學生名稱，請重新登錄。";
    exit;
}

$stu_Name = $_SESSION['stu_Name']; // 從會話中獲取學生名稱

try {
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

        if (isset($_POST['courseId']) && $_POST['courseId'] !== '') {
            $courseId = $_POST['courseId'];

            // 檢查課程 ID 是否有效，且是否存在於 test 表中
            $sqlCheck = "SELECT COUNT(*) FROM test WHERE Number = :courseId";
            $stmtCheck = $conn->prepare($sqlCheck);
            $stmtCheck->bindParam(':courseId', $courseId);
            $stmtCheck->execute();

            $isValid = $stmtCheck->fetchColumn() > 0;

            if ($isValid) {
                // 檢查課程是否已存在於課表中
                $sqlCheckExist = "SELECT COUNT(*) FROM class_schedule WHERE cId = :courseId";
                $stmtCheckExist = $conn->prepare($sqlCheckExist);
                $stmtCheckExist->bindParam(':courseId', $courseId);
                $stmtCheckExist->execute();

                if ($stmtCheckExist->fetchColumn() > 0) {
                    echo "該課程已存在於課表中。";
                } else {
                    // 插入新課程
                    $sqlInsert = "INSERT INTO class_schedule (cId, stu_Id) VALUES (:courseId, :studentId)";
                    $stmtInsert = $conn->prepare($sqlInsert);
                    $stmtInsert->bindParam(':courseId', $courseId);
                    $stmtInsert->bindParam(':studentId', $studentId);
                    $stmtInsert->execute();

                    if ($stmtInsert->rowCount() > 0) {
                        echo "課程已成功插入。";
                    } else {
                        echo "有問題，請重試。";
                    }
                }
            } else {
                echo "無效的課程 ID。";
            }
        } else {
            echo "無效的課程 ID。";
        }
    } else {
        echo "未找到對應的學生記錄。";
    }
} catch (PDOException $e) {
    echo "資料庫錯誤: " . $e->getMessage();
}
