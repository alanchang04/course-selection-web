<?php
session_start(); // 啟動會話

if (!isset($_SESSION['stu_Name'])) {
    echo "<p>未找到登入信息，請重新登錄。</p>";
    exit;
}

$stuName = $_SESSION['stu_Name'];
$stuId = $_SESSION['stu_Id'];
$access = $_SESSION['access'];

// 檢查訪問權限
if ($access !== 'admin') {
    echo "<p>無權訪問此頁面。</p>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理者介面</title>
    <link rel="stylesheet" href="admin.css">
    <script src="admin.js" type="text/javascript"></script>
</head>
<body>
    <h1>管理者介面</h1>
    <div id="message-container" style="display: none;">
        <p id="message"></p>
    </div>

    <div>
        <h2>選擇資料表</h2>
        <select id="table-select" onchange="loadTableData()">
            <option value="">-- 選擇資料表 --</option>
            <option value="student">學生</option>
            <option value="professor">教授</option>
            <option value="test">總課表</option>
            <option value="total_course_record">總課程記錄</option>
            <option value="class_schedule">課程表</option>
            <option value="department">系所</option>
            <option value="professor_info">教授資訊</option>
            <!-- <option value="graduate_progress">畢業進度</option> -->
        </select>
    </div>

    <div>
        <h2>資料</h2>
        <div id="data-container" style="max-height: 300px; overflow-y: auto;">
            <table id="data-table">
                <tbody id="data-body">
                    <!-- 動態生成表頭和數據行 -->
                </tbody>
            </table>
        </div>
    </div>

    <div id="student-link-container" style="display: none;">
        <a href="ad_stu.php">student管理頁面</a>
    </div>


    <div id="professor-link-container" style="display: none;">
        <a href="ad_prof.php">professor管理頁面</a>
    </div>


    <div id="class_schedule-link-container" style="display: none;">
        <a href="ad_schedule.php">class_schedule管理頁面</a>
    </div>

    <div id="test-link-container" style="display: none;">
        <a href="ad_test.php">test管理頁面</a>
    </div>

    <div id="total_course_record-link-container" style="display: none;">
        <a href="ad_total_course_record.php">total_course_record管理頁面</a>
    </div>

    <div id="department-link-container" style="display: none;">
        <a href="ad_department.php">department管理頁面</a>
    </div>

    <div id="professor_info-link-container" style="display: none;">
        <a href="ad_professor_info.php">professor_info管理頁面</a>
    </div>
</body>
</html>
