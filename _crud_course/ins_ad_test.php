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
$change = isset($_POST['change']) ? $_POST['change'] : "";
$description = isset($_POST['description']) ? $_POST['description'] : "";
$multipleCompulsory = isset($_POST['multipleCompulsory']) ? $_POST['multipleCompulsory'] : "";
$department = isset($_POST['department']) ? $_POST['department'] : "";
$number = isset($_POST['number']) ? $_POST['number'] : "";
$grade = isset($_POST['grade']) ? $_POST['grade'] : "";
$classField = isset($_POST['class']) ? $_POST['class'] : "";
$name = isset($_POST['name']) ? $_POST['name'] : "";
$urlField = isset($_POST['url']) ? $_POST['url'] : "";
$credit = isset($_POST['credit']) ? $_POST['credit'] : "";
$yearSemester = isset($_POST['yearSemester']) ? $_POST['yearSemester'] : "";
$compulsoryElective = isset($_POST['compulsoryElective']) ? $_POST['compulsoryElective'] : "";
$restrict = isset($_POST['restrict']) ? $_POST['restrict'] : "";
$selectField = isset($_POST['select']) ? $_POST['select'] : "";
$selected = isset($_POST['selected']) ? $_POST['selected'] : "";
$remaining = isset($_POST['remaining']) ? $_POST['remaining'] : "";
$teacher = isset($_POST['teacher']) ? $_POST['teacher'] : "";
$room = isset($_POST['room']) ? $_POST['room'] : "";
$monday = isset($_POST['monday']) ? $_POST['monday'] : "";
$tuesday = isset($_POST['tuesday']) ? $_POST['tuesday'] : "";
$wednesday = isset($_POST['wednesday']) ? $_POST['wednesday'] : "";
$thursday = isset($_POST['thursday']) ? $_POST['thursday'] : "";
$friday = isset($_POST['friday']) ? $_POST['friday'] : "";
$saturday = isset($_POST['saturday']) ? $_POST['saturday'] : "";
$sunday = isset($_POST['sunday']) ? $_POST['sunday'] : "";
$context = isset($_POST['context']) ? $_POST['context'] : "";
$programs = isset($_POST['programs']) ? $_POST['programs'] : "";
$emi = isset($_POST['emi']) ? $_POST['emi'] : "";

$sql = "INSERT INTO test (Id, `Change`, Description, MultipleCompulsory, Department, Number, Grade, Class, Name, Url, Credit, YearSemester, CompulsoryElective, `Restrict`, `Select`, Selected, Remaining, Teacher, Room, 星期一, 星期二, 星期三, 星期四, 星期五, 星期六, 星期天, Context, Programs, EMI)  
        VALUES ('$id', '$change', '$description', '$multipleCompulsory', '$department', '$number', '$grade', '$classField', '$name', '$urlField', '$credit', '$yearSemester', '$compulsoryElective', '$restrict', '$selectField', '$selected', '$remaining', '$teacher', '$room', '$monday', '$tuesday', '$wednesday', '$thursday', '$friday', '$saturday', '$sunday', '$context', '$programs', '$emi')";

if ($conn->query($sql) === TRUE) {
    echo "新記錄插入成功";
} else {
    echo "錯誤: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
