<?php
session_start(); // 啟動會話

if (!isset($_SESSION['stu_Name'])) {
    echo "<p>未找到登入信息，請重新登錄。</p>";
    exit;
}

$stuName = $_SESSION['stu_Name'];
$stuId = $_SESSION['stu_Id'];
?>
<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./chatbox.css">
    <script src="chatbox.js" type="text/javascript"></script>
    <title>聊天室</title>
</head>
<body>
<div class="header">聊天室</div>
<div class="chat-container" id="chat-container">
    <!-- 範例消息 -->
    <div class="message bot">
        <div class="content">
            你好！<?= $stuName?> 我是一個聊天機器人。
        </div>
    </div>
</div>
<div class="input-container">
    <input type="text" id="userInput" placeholder="輸入消息...">
    <button onclick="sendMessage()">發送</button>
</div>
</body>
</html>
