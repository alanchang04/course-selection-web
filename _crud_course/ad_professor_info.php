<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>教授資訊頁面</title>
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
    <h1>教授資訊頁面</h1>
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

    // 查詢教授資料
    $sql = "SELECT * FROM professor_info";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // 輸出資料
        echo "<table>";
        echo "<tr><th>pId</th><th>gender</th><th>department_Id</th><th>status</th><th>name</th></tr>";
        while($row = $result->fetch_assoc()) {
            echo "<tr><td>".$row["pId"]."</td><td>".$row["gender"]."</td><td>".$row["department_Id"]."</td><td>".$row["status"]."</td><td>".$row["name"]."</td></tr>";
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
            <input type="search" id="insertPId" placeholder="輸入教授ID" />
            <input type="search" id="insertGender" placeholder="輸入性別" />
            <input type="search" id="insertDepartmentId" placeholder="輸入系所ID" />
            <input type="search" id="insertStatus" placeholder="輸入狀態" />
            <input type="search" id="insertName" placeholder="輸入姓名" />
        </div>
        <!-- Delete 操作 -->
        <div id="deleteFields" style="display: none;">
            <input type="search" id="deletePId" placeholder="輸入教授ID" />
        </div>
        <!-- Edit 操作 -->
        <div id="editFields" style="display: none;">
            <input type="search" id="editPId" placeholder="輸入教授ID" />
            <input type="search" id="editGender" placeholder="輸入新的性別" />
            <input type="search" id="editDepartmentId" placeholder="輸入新的系所ID" />
            <input type="search" id="editStatus" placeholder="輸入新的狀態" />
            <input type="search" id="editName" placeholder="輸入新的姓名" />
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
        var pId = "";
        var url = "";

        if (selectOptions.value === "Insert") {
            pId = document.getElementById('insertPId').value;
            var gender = document.getElementById('insertGender').value;
            var departmentId = document.getElementById('insertDepartmentId').value;
            var status = document.getElementById('insertStatus').value;
            var name = document.getElementById('insertName').value;
            url = 'ins_ad_professor_info.php';
            submittingForm(pId, url, gender, departmentId, status, name);
        } else if (selectOptions.value === "Delete") {
            pId = document.getElementById('deletePId').value;
            url = 'del_ad_professor_info.php';
            submittingForm(pId, url);
        } else if (selectOptions.value === "Edit") {
            pId = document.getElementById('editPId').value;
            var newGender = document.getElementById('editGender').value;
            var newDepartmentId = document.getElementById('editDepartmentId').value;
            var newStatus = document.getElementById('editStatus').value;
            var newName = document.getElementById('editName').value;
            url = 'edit_ad_professor_info.php';
            submittingForm(pId, url, newGender, newDepartmentId, newStatus, newName);
        }
    }

    function hideMessage() {
        var messageContainer = document.getElementById("message-container");
        messageContainer.style.display = "none";
    }

    function submittingForm(pId, url, gender = "", departmentId = "", status = "", name = "") {
        const formData = new FormData();
        formData.append('pId', pId);
        if (gender !== "") {
            formData.append('gender', gender);
        }
        if (departmentId !== "") {
            formData.append('department_Id', departmentId);
        }
        if (status !== "") {
            formData.append('status', status);
        }
        if (name !== "") {
            formData.append('name', name);
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
