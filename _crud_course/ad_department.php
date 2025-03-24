<?php
session_start(); // 啟動會話

?>
<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>系所管理頁面</title>
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
    <h1>系所管理頁面</h1>
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

    // 查詢系所資料
    $sql = "SELECT * FROM department";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // 輸出資料
        echo "<table>";
        echo "<tr><th>depart_code_number</th><th>dname</th></tr>";
        while($row = $result->fetch_assoc()) {
            echo "<tr><td>".$row["depart_code_number"]."</td><td>".$row["dname"]."</td></tr>";
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
            <input type="search" id="insertDepartCode" placeholder="輸入系所代號" />
            <input type="search" id="insertDname" placeholder="輸入系所名稱" />
        </div>
        <!-- Delete 操作 -->
        <div id="deleteFields" style="display: none;">
            <input type="search" id="deleteDepartCode" placeholder="輸入系所代號" />
        </div>
        <!-- Edit 操作 -->
        <div id="editFields" style="display: none;">
            <input type="search" id="editDepartCode" placeholder="輸入系所代號" />
            <input type="search" id="editDname" placeholder="新的系所名稱" />
        </div>
        <button id="selectrequest" onclick="submitForm()">提交請求</button>
    </div>
    <a href="./admin.php">Go Back</a>

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
        var departCode = "";
        var url = "";

        if (selectOptions.value === "Insert") {
            departCode = document.getElementById('insertDepartCode').value;
            var dname = document.getElementById('insertDname').value;
            url = 'ins_ad_department.php';
            submittingForm(departCode, url, dname);
        } else if (selectOptions.value === "Delete") {
            departCode = document.getElementById('deleteDepartCode').value;
            url = 'del_ad_department.php';
            submittingForm(departCode, url);
        } else if (selectOptions.value === "Edit") {
            departCode = document.getElementById('editDepartCode').value;
            var newDname = document.getElementById('editDname').value;
            url = 'edit_ad_department.php';
            submittingForm(departCode, url, newDname);
        }
    }

    function hideMessage() {
        var messageContainer = document.getElementById("message-container");
        messageContainer.style.display = "none";
    }

    function submittingForm(departCode, url, dname = "") {
        const formData = new FormData();
        formData.append('depart_code_number', departCode);
        if (dname !== "") {
            formData.append('dname', dname);
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
            // 如果操作成功，重新加載頁面
            if (data.includes("成功")) {
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
