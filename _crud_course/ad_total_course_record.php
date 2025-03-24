<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>學生所有課程頁面</title>
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
    <h1>學生所有課程頁面</h1>
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

    // 查詢課表資料
    $sql = "SELECT * FROM total_course_record";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // 輸出資料
        echo "<table>";
        echo "<tr><th>ID</th><th>sId</th><th>cId</th><th>totalCredit</th><th>grade</th></tr>";
        while($row = $result->fetch_assoc()) {
            echo "<tr><td>".$row["Id"]."</td><td>".$row["sId"]."</td><td>".$row["cId"]."</td><td>".$row["totalCredit"]."</td><td>".$row["grade"]."</td></tr>";
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
            <input type="search" id="insertStuId" placeholder="輸入學生ID" />
            <input type="search" id="insertCId" placeholder="輸入課程ID" />
            <input type="search" id="insertTotalCredit" placeholder="輸入總學分" />
            <input type="search" id="insertGrade" placeholder="輸入成績" />
        </div>
        <!-- Delete 操作 -->
        <div id="deleteFields" style="display: none;">
            <input type="search" id="deleteId" placeholder="輸入ID" />
            <input type="search" id="deleteStuId" placeholder="輸入學生ID" />
        </div>
        <!-- Edit 操作 -->
        <div id="editFields" style="display: none;">
            <input type="search" id="editId" placeholder="輸入ID" />
            <input type="search" id="editStuId" placeholder="輸入學生ID" />
            <input type="search" id="editCId" placeholder="新的課程ID" />
            <input type="search" id="editTotalCredit" placeholder="新的總學分" />
            <input type="search" id="editGrade" placeholder="新的成績" />
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
        var id = "";
        var url = "";

        if (selectOptions.value === "Insert") {
            id = document.getElementById('insertId').value;
            var stuId = document.getElementById('insertStuId').value;
            var cId = document.getElementById('insertCId').value;
            var totalCredit = document.getElementById('insertTotalCredit').value;
            var grade = document.getElementById('insertGrade').value;
            url = 'ins_ad_total_course.php';
            submitingForm(id, url, stuId, cId, totalCredit, grade);
        } else if (selectOptions.value === "Delete") {
            id = document.getElementById('deleteId').value;
            var stuId = document.getElementById('deleteStuId').value;
            url = 'del_ad_total_course.php';
            submitingForm(id, url, stuId);
        } else if (selectOptions.value === "Edit") {
            id = document.getElementById('editId').value;
            var stuId = document.getElementById('editStuId').value;
            var newCId = document.getElementById('editCId').value;
            var newTotalCredit = document.getElementById('editTotalCredit').value;
            var newGrade = document.getElementById('editGrade').value;
            url = 'edit_ad_total_course.php';
            submitingForm(id, url, stuId, newCId, newTotalCredit, newGrade);
        }
    }

    function hideMessage() {
        var messageContainer = document.getElementById("message-container");
        messageContainer.style.display = "none";
    }

    function submitingForm(id, url, stuId = "", cId = "", totalCredit = "", grade = "") {
        const formData = new FormData();
        formData.append('id', id);
        if (stuId !== "") {
            formData.append('stuId', stuId);
        }
        if (cId !== "") {
            formData.append('cId', cId);
        }
        if (totalCredit !== "") {
            formData.append('totalCredit', totalCredit);
        }
        if (grade !== "") {
            formData.append('grade', grade);
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
