<?php
session_start();

if (!isset($_SESSION['stu_Name']) || $_SESSION['access'] !== 'admin') {
    echo json_encode(["error" => "你沒有訪問權限。"]);
    exit;
}

$conn = new PDO('mysql:dbname=database_project;host=localhost', 'root', '');
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

function fetchData($conn, $table) {
    $stmt = $conn->prepare("SELECT * FROM $table");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['table'])) {
    $table = $_GET['table'];
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $stmt = $conn->prepare("SELECT * FROM $table WHERE Id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        echo json_encode($stmt->fetch(PDO::FETCH_ASSOC));
    } else {
        echo json_encode(fetchData($conn, $table));
    }
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $table = $_POST['table'];
    $action = $_POST['action'];

    if ($action == 'add' || $action == 'edit') {
        $fields = array_keys($_POST);
        $fields = array_diff($fields, ['table', 'action']);
        $fieldNames = implode(", ", $fields);
        $fieldValues = implode(", ", array_map(function($field) { return ":$field"; }, $fields));

        if ($action == 'add') {
            $sql = "INSERT INTO $table ($fieldNames) VALUES ($fieldValues)";
        } else if ($action == 'edit') {
            $id = $_POST['Id'];
            $updateFields = implode(", ", array_map(function($field) { return "$field = :$field"; }, $fields));
            $sql = "UPDATE $table SET $updateFields WHERE Id = :Id";
        }

        $stmt = $conn->prepare($sql);
        foreach ($fields as $field) {
            $stmt->bindValue(":$field", $_POST[$field]);
        }
        if ($action == 'edit') {
            $stmt->bindValue(':Id', $id);
        }
        $stmt->execute();

        echo json_encode(["success" => $action == 'add' ? "資料已成功添加。" : "資料已成功更新。"]);
    } else if ($action == 'delete') {
        $id = $_POST['Id'];
        $stmt = $conn->prepare("DELETE FROM $table WHERE Id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        echo json_encode(["success" => "資料已成功刪除。"]);
    }
    exit;
}
?>

