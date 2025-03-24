<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>教授評論管理頁面</title>
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
    <h1>教授評論管理頁面</h1>
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

    // 查詢教授評論資料
    $sql = "SELECT * FROM professor";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // 輸出資料
        echo "<table>";
        echo "<tr><th>ID</th><th>sId</th><th>name</th><th>comment</th><th>credit</th></tr>";
        while($row = $result->fetch_assoc()) {
            echo "<tr><td>".$row["Id"]."</td><td>".$row["sId"]."</td><td>".$row["name"]."</td><td>".$row["comment"]."</td><td>".$row["credits"]."</td></tr>";
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
            <input type="search" id="insertId" placeholder="輸入ID" />
            <input type="search" id="insertSid" placeholder="輸入sId" />
            <input type="search" id="insertName" placeholder="輸入姓名" />
            <input type="search" id="insertComment" placeholder="輸入評論" />
            <input type="search" id="insertCredits" placeholder="輸入評分" />
        </div>
        <!-- Delete 操作 -->
        <div id="deleteFields" style="display: none;">
            <input type="search" id="deleteId" placeholder="輸入ID" />
            <input type="search" id="deleteSid" placeholder="輸入sId" />
        </div>
        <!-- Edit 操作 -->
        <div id="editFields" style="display: none;">
            <input type="search" id="editId" placeholder="輸入ID" />
            <input type="search" id="editSid" placeholder="輸入sId" />
            <input type="search" id="editName" placeholder="新的姓名" />
            <input type="search" id="editComment" placeholder="新的評論" />
            <input type="search" id="editCredits" placeholder="新的評分" />
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
        var id = "";
        var sid = "";
        var url = "";

        if (selectOptions.value === "Insert") {
            id = document.getElementById('insertId').value;
            sid = document.getElementById('insertSid').value;
            var name = document.getElementById('insertName').value;
            var comment = document.getElementById('insertComment').value;
            var credits = document.getElementById('insertCredits').value;
            url = 'ins_ad_professor.php';
            submittingForm(id, sid, url, name, comment, credits);
        } else if (selectOptions.value === "Delete") {
            id = document.getElementById('deleteId').value;
            sid = document.getElementById('deleteSid').value;
            url = 'del_ad_professor.php';
            submittingForm(id, sid, url);
        } else if (selectOptions.value === "Edit") {
            id = document.getElementById('editId').value;
            sid = document.getElementById('editSid').value;
            var newName = document.getElementById('editName').value;
            var newComment = document.getElementById('editComment').value;
            var newCredits = document.getElementById('editCredits').value;
            url = 'edit_ad_professor.php';
            submittingForm(id, sid, url, newName, newComment, newCredits);
        }
    }

    function hideMessage() {
        var messageContainer = document.getElementById("message-container");
        messageContainer.style.display = "none";
    }

    function submittingForm(id, sid, url, name = "", comment = "", credits = "") {
        const formData = new FormData();
        formData.append('id', id);
        formData.append('sid', sid);
        if (name !== "") {
            formData.append('name', name);
        }
        if (comment !== "") {
            formData.append('comment', comment);
        }
        if (credits !== "") {
            formData.append('credits', credits);
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
