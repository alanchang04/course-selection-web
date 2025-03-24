<?php
session_start();

if (!isset($_SESSION['stu_Name'])) {
    echo json_encode(['reply' => '未找到登入信息，請重新登錄。']);
    exit;
}

$stuName = $_SESSION['stu_Name'];
$stuId = $_SESSION['stu_Id'];

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "database_project";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("連接失敗: " . $conn->connect_error);
}

$request = json_decode(file_get_contents('php://input'), true);
$userMessage = strtolower($request['message']);

// 發送消息到 Flask 服務
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://localhost:5000/analyze");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['message' => $userMessage]));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

$response = curl_exec($ch);
curl_close($ch);

$nlp_result = json_decode($response, true);

$intent = $nlp_result['intent'];
$entities = $nlp_result['entities'];

$reply = "對不起，我不明白你的問題。";

if ($intent == "course_info" && isset($entities['course_name'])) {
    $courseName = $entities['course_name'];
    
    $stmt = $conn->prepare("SELECT * FROM test WHERE Name LIKE ?");
    $searchTerm = "%$courseName%";
    $stmt->bind_param("s", $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $reply = "課程: " . $row['Name'] . "\n" .
                 "課號: " . $row['Number'] . "\n" .
                 "學分: " . $row['Credit'] . "\n" .
                 "系所: " . $row['Department'] . "\n" .
                 "老師: " . $row['Teacher'] . "\n" .
                 "上課教室和時間: " . $row['Room'] . "\n" .
                 "學程: " . $row['Context'] . "\n" .
                 "全英文: " . ($row['EMI'] == '1' ? '是' : '否');
    } else {
        $reply = "對不起，未找到與 {$courseName} 相關的課程信息。";
    }
}

echo json_encode(['reply' => $reply]);

$conn->close();
?>
