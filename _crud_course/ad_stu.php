<?php
session_start(); // 啟動會話

if (!isset($_SESSION['stu_Name'])) {
    echo "<p>未找到登入訊息，請重新登錄。</p>";
    exit;
}

$stuName = $_SESSION['stu_Name'];
$stuId = $_SESSION['stu_Id'];
$access = $_SESSION['access'];

// 檢查訪問權限
if ($access == 'visitor') {
    echo "<p>無權訪問此頁面。</p>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>學生管理頁面</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>學生管理頁面</h1>
    <div id="message-container" style="display: none;">
            <div id="message" class="message"></div>
            <div style="text-align: center;">
                <button id="close-message" onclick="hideMessage()">關閉</button>
            </div>
        </div>
 
    <?php
    // 連接資料庫
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "database_project";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("連接失敗: " . $conn->connect_error);
    }

    // 查詢學生資料
    $sql = "SELECT * FROM student";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // 輸出資料
        echo "<table>";
        echo "<tr><th>ID</th><th>姓名</th><th>權限</th></tr>";
        while($row = $result->fetch_assoc()) {
            echo "<tr><td>".$row["stu_Id"]."</td><td>".$row["stu_Name"]."</td><td>".$row["access"]."</td></tr>";
        }
        echo "</table>";
    } else {
        echo "0 結果";
    }
    $conn->close();
    ?>
 <div class="moveblog">
    <select name="move" id="selectoptions" onchange="toggleInputFields()">
        <option>Insert</option>
        <option style="color: red">Delete</option>
        <option style="color: blue">Edit</option>
    </select>
    <!-- Insert 操作 -->
    <div id="insertFields" style="display: block;">
        <input type="search" id="insertId" placeholder="輸入學生ID" />
        <input type="search" id="insertName" placeholder="輸入學生姓名" />
        <input type="search" id="insertAccess" placeholder="輸入權限" />
    </div>
    <!-- Delete 操作 -->
    <div id="deleteFields" style="display: none;">
        <input type="search" id="deleteId" placeholder="輸入學生ID" />
    </div>
    <!-- Edit 操作 -->
    <div id="editFields" style="display: none;">
        <input type="search" id="editId" placeholder="輸入學生ID" />
        <input type="search" id="editName" placeholder="新的學生姓名" />
        <input type="search" id="editAccess" placeholder="新的權限" />
    </div>
    <button id="selectrequest" onclick="submitForm()">提交請求</button>
</div>
<a href="./admin.php" >Go Back</a>

<script>
function toggleInputFields() {
    var selectOptions = document.getElementById("selectoptions");
    var insertFields = document.getElementById("insertFields");
    var deleteFields = document.getElementById("deleteFields");
    var editFields = document.getElementById("editFields");

    if (selectOptions.value === "Insert") {
        insertFields.style.display = "block";
        deleteFields.style.display = "none";
        editFields.style.display = "none";
    } else if (selectOptions.value === "Delete") {
        insertFields.style.display = "none";
        deleteFields.style.display = "block";
        editFields.style.display = "none";
    } else if (selectOptions.value === "Edit") {
        insertFields.style.display = "none";
        deleteFields.style.display = "none";
        editFields.style.display = "block";
    }
}

function submitForm() {
    var selectOptions = document.getElementById("selectoptions");
    var courseId = "";
    var newCourseId = "";
    var url = "";

    if (selectOptions.value === "Insert") {
        courseId = document.getElementById('insertId').value;
        var name = document.getElementById('insertName').value;
        var access = document.getElementById('insertAccess').value;
        url = 'ins_ad_stu.php';
        submitingForm(courseId, url, name, access);
    } else if (selectOptions.value === "Delete") {
        courseId = document.getElementById('deleteId').value;
        url = 'del_ad_stu.php';
        submitingForm(courseId, url);
    } else if (selectOptions.value === "Edit") {
        courseId = document.getElementById('editId').value;
        var newName = document.getElementById('editName').value;
        var newAccess = document.getElementById('editAccess').value;
        url = 'edit_ad_stu.php';
        submitingForm(courseId, url, newName, newAccess);
    }
}
function hideMessage() {
    var messageContainer = document.getElementById("message-container");
    messageContainer.style.display = "none";
}
function submitingForm(courseId, url, name = "", access = "") {
    const formData = new FormData();
    formData.append('courseId', courseId);
    if (name !== "") {
        formData.append('name', name);
    }
    if (access !== "") {
        formData.append('access', access);
    }

    fetch(url, {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        // 將回傳的訊息顯示在頁面上的 message-container 元素中
        const messageContainer = document.getElementById('message-container');
        const message = document.getElementById('message');
        message.innerHTML = data; // 更新訊息
        messageContainer.style.display = 'block';
         // 如果插入成功，重新加載頁面
         if (data.includes("成功插入")) {
            window.location.reload();
        }
    })
    .catch(error => {
        // 處理錯誤訊息
        const messageContainer = document.getElementById('message-container');
        const message = document.getElementById('message');
        message.innerHTML = `發生錯誤：${error}`;
        messageContainer.style.display = 'block';
    });
}
</script>

</body>
</html>
