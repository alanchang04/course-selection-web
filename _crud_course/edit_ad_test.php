<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "database_project";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("連接失敗: " . $conn->connect_error);
}

$id = $_POST['id'];

$fields = [
    'Change' => isset($_POST['change']) ? $_POST['change'] : "",
    'Description' => isset($_POST['description']) ? $_POST['description'] : "",
    'MultipleCompulsory' => isset($_POST['multipleCompulsory']) ? $_POST['multipleCompulsory'] : "",
    'Department' => isset($_POST['department']) ? $_POST['department'] : "",
    'Number' => isset($_POST['number']) ? $_POST['number'] : "",
    'Grade' => isset($_POST['grade']) ? $_POST['grade'] : "",
    'Class' => isset($_POST['class']) ? $_POST['class'] : "",
    'Name' => isset($_POST['name']) ? $_POST['name'] : "",
    'Url' => isset($_POST['url']) ? $_POST['url'] : "",
    'Credit' => isset($_POST['credit']) ? $_POST['credit'] : "",
    'YearSemester' => isset($_POST['yearSemester']) ? $_POST['yearSemester'] : "",
    'CompulsoryElective' => isset($_POST['compulsoryElective']) ? $_POST['compulsoryElective'] : "",
    'Restrict' => isset($_POST['restrict']) ? $_POST['restrict'] : "",
    'Select' => isset($_POST['select']) ? $_POST['select'] : "",
    'Selected' => isset($_POST['selected']) ? $_POST['selected'] : "",
    'Remaining' => isset($_POST['remaining']) ? $_POST['remaining'] : "",
    'Teacher' => isset($_POST['teacher']) ? $_POST['teacher'] : "",
    'Room' => isset($_POST['room']) ? $_POST['room'] : "",
    '星期一' => isset($_POST['monday']) ? $_POST['monday'] : "",
    '星期二' => isset($_POST['tuesday']) ? $_POST['tuesday'] : "",
    '星期三' => isset($_POST['wednesday']) ? $_POST['wednesday'] : "",
    '星期四' => isset($_POST['thursday']) ? $_POST['thursday'] : "",
    '星期五' => isset($_POST['friday']) ? $_POST['friday'] : "",
    '星期六' => isset($_POST['saturday']) ? $_POST['saturday'] : "",
    '星期天' => isset($_POST['sunday']) ? $_POST['sunday'] : "",
    'Context' => isset($_POST['context']) ? $_POST['context'] : "",
    'Programs' => isset($_POST['programs']) ? $_POST['programs'] : "",
    'EMI' => isset($_POST['emi']) ? $_POST['emi'] : ""
];

$setClause = [];
foreach ($fields as $field => $value) {
    if ($value !== "") {
        $setClause[] = "`$field`='$value'";
    }
}

if (count($setClause) > 0) {
    $setClauseStr = implode(", ", $setClause);
    $sql = "UPDATE test SET $setClauseStr WHERE Id='$id'";

    if ($conn->query($sql) === TRUE) {
        echo "記錄更新成功";
    } else {
        echo "錯誤: " . $sql . "<br>" . $conn->error;
    }
} else {
    echo "沒有需要更新的欄位";
}

$conn->close();
?>
