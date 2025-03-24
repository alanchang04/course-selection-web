<?php

$conn = new PDO('mysql:dbname=database_project;host=localhost', 'root', '');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['courseId'])) {
        $stu_Id = $_POST['courseId'];

        $sql = "DELETE FROM student  WHERE stu_Id = :stu_Id";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':stu_Id', $stu_Id);
        if ($stmt->execute()) {
            if ($stmt->rowCount() > 0) {
                echo "學生已成功刪除。";
            } else {
                echo "找不到要刪除的學生。";
            }
        } else {
            echo "刪除學生時出現問題，請重試。";
        }
    } else {
        echo "未提供學生 ID。";
    }
} else {
    echo "請使用 POST 方法訪問此頁面。";
}

?>
