<?php
session_start(); // 確保會話已經啟動

// 確認學生名稱和學生ID已經存儲在會話中
if (!isset($_SESSION['stu_Name']) || !isset($_SESSION['stu_Id'])) {
    echo "未找到學生信息，請重新登錄。";
    exit;
}

$stu_Name = $_SESSION['stu_Name']; // 從會話中獲取學生名稱
$stu_Id = $_SESSION['stu_Id']; // 從會話中獲取學生ID

try {
    // 設置資料庫連接
    $conn = new PDO('mysql:dbname=database_project;host=localhost', 'root', '');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 確認是否使用了 POST 方法訪問頁面
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // 檢查是否提供了評論 ID
        if (isset($_POST['commentId'])) {
            $commentId = $_POST['commentId'];

            // 使用評論ID和學生ID執行刪除操作
            $sql = "DELETE FROM total_course_record WHERE Id = :commentId AND sId = :stu_Id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':commentId', $commentId);
            $stmt->bindParam(':stu_Id', $stu_Id);
            if ($stmt->execute()) {
                if ($stmt->rowCount() > 0) {
                    echo "課程已成功刪除。";
                } else {
                    echo "找不到要刪除的課程或該課程不屬於當前學生。";
                }
            } else {
                echo "刪除課程時出現問題，請重試。";
            }
        } else {
            echo "未提供課程 ID。";
        }
    } else {
        echo "請使用 POST 方法訪問此頁面。";
    }
} catch (PDOException $e) {
    echo "資料庫錯誤: " . $e->getMessage();
}
