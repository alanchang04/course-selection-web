<?php

session_start(); // 確保會話已經啟動

// 假設學生名稱已經存儲在會話中，登入系統已經設置了 $_SESSION['stu_Name']
if (!isset($_SESSION['stu_Name'])) {
    echo "未找到學生名稱，請重新登錄。";
    exit;
}

$stu_Name = $_SESSION['stu_Name']; // 從會話中獲取學生名稱
$stu_Id = $_SESSION['stu_Id'];

$conn = new PDO('mysql:dbname=database_project;host=localhost', 'root', '');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['courseId']) && isset($_POST['newCourseId'])) {
        $courseId = $_POST['courseId'];
        $newCourseId = $_POST['newCourseId'];

        // 檢查課程 ID 是否存在於 test 資料表中
        $checkSql = "SELECT * FROM test WHERE Number = :courseId";
        $checkStmt = $conn->prepare($checkSql);
        $checkStmt->bindParam(':courseId', $courseId);
        $checkStmt->execute();

        if ($checkStmt->rowCount() > 0) {
            // 如果課程 ID 存在於 test 資料表中，則執行更新操作
            $updateSql = "UPDATE class_schedule SET cId = :newCourseId WHERE cId = :courseId AND stu_Id = :stu_Id";
            $stmt = $conn->prepare($updateSql);
            $stmt->bindParam(':courseId', $courseId);
            $stmt->bindParam(':stu_Id', $stu_Id);
            $stmt->bindParam(':newCourseId', $newCourseId);

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
            // 如果課程 ID 不存在於 test 資料表中，則提示該課程不在該學期課程中
            echo "該課程不在該學期課程中。";
        }
    } else {
        echo "未提供課程 ID 或新課程 ID。";
    }
} else {
    echo "請使用 POST 方法訪問此頁面。";
}
