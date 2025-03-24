
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "database_project";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $departCode = $_POST['depart_code_number'];
    $dname = $_POST['dname'];

    $sql = "INSERT INTO department (depart_code_number, dname) VALUES (:departCode, :dname)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':departCode', $departCode);
    $stmt->bindParam(':dname', $dname);

    if ($stmt->execute()) {
        echo "成功插入系所。";
    } else {
        echo "插入失敗。";
    }
} catch (PDOException $e) {
    echo "發生錯誤：" . $e->getMessage();
}
$conn = null;
?>
