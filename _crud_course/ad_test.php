<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test資料表操作頁面</title>
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
        #data-table-container {
            max-height: 400px;
            overflow-y: auto;
        }
        .list_container {
            padding-top: 10px;
            position: sticky;
            background-color: #ffffffcf;
            backdrop-filter: blur(8px);
        }

        /*標頭整排 課程名稱 時間...等*/
        .list_lead_container {
            display: table-row;
            width: 100%;
            position: sticky;
            height: 50px;
            top: 0px;
            z-index: 1;
            background-color: #ffffffcf;
            backdrop-filter: blur(8px);
        }

        /*單個標頭*/
        #list_head {
            display: flex;
            flex-direction: row;
            text-align: center;
            font-weight: bold;
            align-items: center;
        }
        .course_info {
            display: flex;
            margin-bottom: 10px;
        }

        .course_info span {
            padding: 5px;
            margin-right: 5px;
            font-size: 15px;
        }
    </style>
</head>
<body>
    <h1>Test資料表操作頁面</h1>
    <div id="message-container" style="display: none;">
        <div id="message" class="message"></div>
        <div style="text-align: center;">
            <button id="close-message" onclick="hideMessage()">關閉</button>
        </div>
    </div>
    <div class="search_container">
        <input type="search" id="course_search" placeholder="Search courses">
        <button id="search_button" onclick="searchCourses()">Search</button>
    </div>
    <div id="search_results_container"></div>
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

    // 查詢資料
    $sql = "SELECT * FROM test";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
       // 輸出資料
       echo "<div id='data-table-container'><table>";
       echo "<tr><th>ID</th><th>Change</th><th>Description</th><th>MultipleCompulsory</th><th>Department</th><th>Number</th><th>Grade</th><th>Class</th><th>Name</th><th>Url</th><th>Credit</th><th>YearSemester</th><th>CompulsoryElective</th><th>Restrict</th><th>Select</th><th>Selected</th><th>Remaining</th><th>Teacher</th><th>Room</th><th>星期一</th><th>星期二</th><th>星期三</th><th>星期四</th><th>星期五</th><th>星期六</th><th>星期天</th><th>Context</th><th>Programs</th><th>EMI</th></tr>";
       
       $row_count = 0;
       while($row = $result->fetch_assoc()) {
           echo "<tr><td>".$row["Id"]."</td><td>".$row["Change"]."</td><td>".$row["Description"]."</td><td>".$row["MultipleCompulsory"]."</td><td>".$row["Department"]."</td><td>".$row["Number"]."</td><td>".$row["Grade"]."</td><td>".$row["Class"]."</td><td>".$row["Name"]."</td><td>".$row["Url"]."</td><td>".$row["Credit"]."</td><td>".$row["YearSemester"]."</td><td>".$row["CompulsoryElective"]."</td><td>".$row["Restrict"]."</td><td>".$row["Select"]."</td><td>".$row["Selected"]."</td><td>".$row["Remaining"]."</td><td>".$row["Teacher"]."</td><td>".$row["Room"]."</td><td>".$row["星期一"]."</td><td>".$row["星期二"]."</td><td>".$row["星期三"]."</td><td>".$row["星期四"]."</td><td>".$row["星期五"]."</td><td>".$row["星期六"]."</td><td>".$row["星期天"]."</td><td>".$row["Context"]."</td><td>".$row["Programs"]."</td><td>".$row["EMI"]."</td></tr>";
           $row_count++;

       }
       echo "</table></div>";
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
            <input type="search" id="insertChange" placeholder="輸入Change" />
            <input type="search" id="insertDescription" placeholder="輸入Description" />
            <input type="search" id="insertMultipleCompulsory" placeholder="輸入MultipleCompulsory" />
            <input type="search" id="insertDepartment" placeholder="輸入Department" />
            <input type="search" id="insertNumber" placeholder="輸入Number" />
            <input type="search" id="insertGrade" placeholder="輸入Grade" />
            <input type="search" id="insertClass" placeholder="輸入Class" />
            <input type="search" id="insertName" placeholder="輸入Name" />
            <input type="search" id="insertUrl" placeholder="輸入Url" />
            <input type="search" id="insertCredit" placeholder="輸入Credit" />
            <input type="search" id="insertYearSemester" placeholder="輸入YearSemester" />
            <input type="search" id="insertCompulsoryElective" placeholder="輸入CompulsoryElective" />
            <input type="search" id="insertRestrict" placeholder="輸入Restrict" />
            <input type="search" id="insertSelect" placeholder="輸入Select" />
            <input type="search" id="insertSelected" placeholder="輸入Selected" />
            <input type="search" id="insertRemaining" placeholder="輸入Remaining" />
            <input type="search" id="insertTeacher" placeholder="輸入Teacher" />
            <input type="search" id="insertRoom" placeholder="輸入Room" />
            <input type="search" id="insertMonday" placeholder="輸入星期一" />
            <input type="search" id="insertTuesday" placeholder="輸入星期二" />
            <input type="search" id="insertWednesday" placeholder="輸入星期三" />
            <input type="search" id="insertThursday" placeholder="輸入星期四" />
            <input type="search" id="insertFriday" placeholder="輸入星期五" />
            <input type="search" id="insertSaturday" placeholder="輸入星期六" />
            <input type="search" id="insertSunday" placeholder="輸入星期天" />
            <input type="search" id="insertContext" placeholder="輸入Context" />
            <input type="search" id="insertPrograms" placeholder="輸入Programs" />
            <input type="search" id="insertEMI" placeholder="輸入EMI" />
        </div>
        <!-- Delete 操作 -->
        <div id="deleteFields" style="display: none;">
            <input type="search" id="deleteId" placeholder="輸入ID" />
        </div>
        <!-- Edit 操作 -->
        <div id="editFields" style="display: none;">
            <input type="search" id="editId" placeholder="輸入ID" />
            <input type="search" id="editChange" placeholder="新的Change" />
            <input type="search" id="editDescription" placeholder="新的Description" />
            <input type="search" id="editMultipleCompulsory" placeholder="新的MultipleCompulsory" />
            <input type="search" id="editDepartment" placeholder="新的Department" />
            <input type="search" id="editNumber" placeholder="新的Number" />
            <input type="search" id="editGrade" placeholder="新的Grade" />
            <input type="search" id="editClass" placeholder="新的Class" />
            <input type="search" id="editName" placeholder="新的Name" />
            <input type="search" id="editUrl" placeholder="新的Url" />
            <input type="search" id="editCredit" placeholder="新的Credit" />
            <input type="search" id="editYearSemester" placeholder="新的YearSemester" />
            <input type="search" id="editCompulsoryElective" placeholder="新的CompulsoryElective" />
            <input type="search" id="editRestrict" placeholder="新的Restrict" />
            <input type="search" id="editSelect" placeholder="新的Select" />
            <input type="search" id="editSelected" placeholder="新的Selected" />
            <input type="search" id="editRemaining" placeholder="新的Remaining" />
            <input type="search" id="editTeacher" placeholder="新的Teacher" />
            <input type="search" id="editRoom" placeholder="新的Room" />
            <input type="search" id="editMonday" placeholder="新的星期一" />
            <input type="search" id="editTuesday" placeholder="新的星期二" />
            <input type="search" id="editWednesday" placeholder="新的星期三" />
            <input type="search" id="editThursday" placeholder="新的星期四" />
            <input type="search" id="editFriday" placeholder="新的星期五" />
            <input type="search" id="editSaturday" placeholder="新的星期六" />
            <input type="search" id="editSunday" placeholder="新的星期天" />
            <input type="search" id="editContext" placeholder="新的Context" />
            <input type="search" id="editPrograms" placeholder="新的Programs" />
            <input type="search" id="editEMI" placeholder="新的EMI" />
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
            var change = document.getElementById('insertChange').value;
            var description = document.getElementById('insertDescription').value;
            var multipleCompulsory = document.getElementById('insertMultipleCompulsory').value;
            var department = document.getElementById('insertDepartment').value;
            var number = document.getElementById('insertNumber').value;
            var grade = document.getElementById('insertGrade').value;
            var classField = document.getElementById('insertClass').value;
            var name = document.getElementById('insertName').value;
            var urlField = document.getElementById('insertUrl').value;
            var credit = document.getElementById('insertCredit').value;
            var yearSemester = document.getElementById('insertYearSemester').value;
            var compulsoryElective = document.getElementById('insertCompulsoryElective').value;
            var restrict = document.getElementById('insertRestrict').value;
            var selectField = document.getElementById('insertSelect').value;
            var selected = document.getElementById('insertSelected').value;
            var remaining = document.getElementById('insertRemaining').value;
            var teacher = document.getElementById('insertTeacher').value;
            var room = document.getElementById('insertRoom').value;
            var monday = document.getElementById('insertMonday').value;
            var tuesday = document.getElementById('insertTuesday').value;
            var wednesday = document.getElementById('insertWednesday').value;
            var thursday = document.getElementById('insertThursday').value;
            var friday = document.getElementById('insertFriday').value;
            var saturday = document.getElementById('insertSaturday').value;
            var sunday = document.getElementById('insertSunday').value;
            var context = document.getElementById('insertContext').value;
            var programs = document.getElementById('insertPrograms').value;
            var emi = document.getElementById('insertEMI').value;
            url = 'ins_ad_test.php';
            submitingForm(id, url, change, description, multipleCompulsory, department, number, grade, classField, name, urlField, credit, yearSemester, compulsoryElective, restrict, selectField, selected, remaining, teacher, room, monday, tuesday, wednesday, thursday, friday, saturday, sunday, context, programs, emi);
        } else if (selectOptions.value === "Delete") {
            id = document.getElementById('deleteId').value;
            url = 'del_ad_test.php';
            submitingForm(id, url);
        } else if (selectOptions.value === "Edit") {
            id = document.getElementById('editId').value;
            var change = document.getElementById('editChange').value;
            var description = document.getElementById('editDescription').value;
            var multipleCompulsory = document.getElementById('editMultipleCompulsory').value;
            var department = document.getElementById('editDepartment').value;
            var number = document.getElementById('editNumber').value;
            var grade = document.getElementById('editGrade').value;
            var classField = document.getElementById('editClass').value;
            var name = document.getElementById('editName').value;
            var urlField = document.getElementById('editUrl').value;
            var credit = document.getElementById('editCredit').value;
            var yearSemester = document.getElementById('editYearSemester').value;
            var compulsoryElective = document.getElementById('editCompulsoryElective').value;
            var restrict = document.getElementById('editRestrict').value;
            var selectField = document.getElementById('editSelect').value;
            var selected = document.getElementById('editSelected').value;
            var remaining = document.getElementById('editRemaining').value;
            var teacher = document.getElementById('editTeacher').value;
            var room = document.getElementById('editRoom').value;
            var monday = document.getElementById('editMonday').value;
            var tuesday = document.getElementById('editTuesday').value;
            var wednesday = document.getElementById('editWednesday').value;
            var thursday = document.getElementById('editThursday').value;
            var friday = document.getElementById('editFriday').value;
            var saturday = document.getElementById('editSaturday').value;
            var sunday = document.getElementById('editSunday').value;
            var context = document.getElementById('editContext').value;
            var programs = document.getElementById('editPrograms').value;
            var emi = document.getElementById('editEMI').value;
            url = 'edit_ad_test.php';
            submitingForm(id, url, change, description, multipleCompulsory, department, number, grade, classField, name, urlField, credit, yearSemester, compulsoryElective, restrict, selectField, selected, remaining, teacher, room, monday, tuesday, wednesday, thursday, friday, saturday, sunday, context, programs, emi);
        }
    }

    function hideMessage() {
        var messageContainer = document.getElementById("message-container");
        messageContainer.style.display = "none";
    }

    function submitingForm(id, url, change = "", description = "", multipleCompulsory = "", department = "", number = "", grade = "", classField = "", name = "", urlField = "", credit = "", yearSemester = "", compulsoryElective = "", restrict = "", selectField = "", selected = "", remaining = "", teacher = "", room = "", monday = "", tuesday = "", wednesday = "", thursday = "", friday = "", saturday = "", sunday = "", context = "", programs = "", emi = "") {
        const formData = new FormData();
        formData.append('id', id);
        if (change !== "") formData.append('change', change);
        if (description !== "") formData.append('description', description);
        if (multipleCompulsory !== "") formData.append('multipleCompulsory', multipleCompulsory);
        if (department !== "") formData.append('department', department);
        if (number !== "") formData.append('number', number);
        if (grade !== "") formData.append('grade', grade);
        if (classField !== "") formData.append('class', classField);
        if (name !== "") formData.append('name', name);
        if (urlField !== "") formData.append('url', urlField);
        if (credit !== "") formData.append('credit', credit);
        if (yearSemester !== "") formData.append('yearSemester', yearSemester);
        if (compulsoryElective !== "") formData.append('compulsoryElective', compulsoryElective);
        if (restrict !== "") formData.append('restrict', restrict);
        if (selectField !== "") formData.append('select', selectField);
        if (selected !== "") formData.append('selected', selected);
        if (remaining !== "") formData.append('remaining', remaining);
        if (teacher !== "") formData.append('teacher', teacher);
        if (room !== "") formData.append('room', room);
        if (monday !== "") formData.append('monday', monday);
        if (tuesday !== "") formData.append('tuesday', tuesday);
        if (wednesday !== "") formData.append('wednesday', wednesday);
        if (thursday !== "") formData.append('thursday', thursday);
        if (friday !== "") formData.append('friday', friday);
        if (saturday !== "") formData.append('saturday', saturday);
        if (sunday !== "") formData.append('sunday', sunday);
        if (context !== "") formData.append('context', context);
        if (programs !== "") formData.append('programs', programs);
        if (emi !== "") formData.append('emi', emi);

        fetch(url, {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            const messageContainer = document.getElementById('message-container');
            const message = document.getElementById('message');
            message.innerHTML = data; // 更新訊息
            messageContainer.style.display = 'block';
            if (data.includes("成功")) {
                window.location.reload();
            }
        })
        .catch(error => {
            const messageContainer = document.getElementById('message-container');
            const message = document.getElementById('message');
            message.innerHTML = `發生錯誤：${error}`;
            messageContainer.style.display = 'block';
        });
    }
    function searchCourses() {
        const searchInput = document.getElementById('course_search').value.trim();

        if (searchInput !== '') {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'search_courses.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            xhr.onreadystatechange = function () {
            if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
                const searchResultsContainer = document.getElementById('search_results_container');
                searchResultsContainer.innerHTML = this.responseText;
            }
            };

            xhr.send('search=' + encodeURIComponent(searchInput));
        } else {
            // Clear the search results container if the search input is empty
            const searchResultsContainer = document.getElementById('search_results_container');
            searchResultsContainer.innerHTML = '';
        }
    }

    </script>
</body>
</html>
