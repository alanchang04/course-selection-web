<?php
$conn = new PDO('mysql:dbname=database_project;host=localhost', 'root', '');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['courseId']) && isset($_POST['name']) && isset($_POST['access'])) {
        $studentId = $_POST['courseId'];
        $name = $_POST['name'];
        $access = $_POST['access'];

        $checkSql = "SELECT * FROM student WHERE stu_Id = :studentId";
        $checkStmt = $conn->prepare($checkSql);
        $checkStmt->bindParam(':studentId', $studentId);
        $checkStmt->execute();

        if ($checkStmt->rowCount() > 0) {
            $updateSql = "UPDATE student SET stu_Name = :name, access = :access WHERE stu_Id = :studentId";
            $stmt = $conn->prepare($updateSql);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':access', $access);
            $stmt->bindParam(':studentId', $studentId);

            if ($stmt->execute()) {
                if ($stmt->rowCount() > 0) {
                    echo "學生已成功更新。";
                } else {
                    echo "找不到要更新的學生。";
                }
            } else {
                echo "更新學生時出現問題，請重試。";
            }
        } else {
            echo "找不到要更新的學生。";
        }
    } else {
        echo "未提供足夠的信息進行更新。";
    }
} else {
    echo "請使用 POST 方法訪問此頁面。";
}
?>
