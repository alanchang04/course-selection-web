// function sub() {
// var hideContent = document.getElementById("clickable"+num);
// var closetag = document.getElementById("closetag"+num);
// var clicked = document.getElementById("place"+num);
// var line = document.getElementById("line"+num);
// if (clicked.className == "unclicked") {
//     clicked.className = "clicked";
//     hideContent.className = "content-hide";
//     closetag.className = "close";
//     line.className = "lineClicked";
// }
// else {
//     clicked.className = "unclicked";
//     hideContent.className = "content-show";
//     closetag.className = "closetagHide";
//     line.className = "lineUnclicked";
// }
// }
window.onload = function () {
    loadSchedule();
}
function toggleInputFields() {
    var selectOptions = document.getElementById("selectoptions");
    var newCourseIdInput = document.getElementById("newCourseId");
    var searchContainer = document.querySelector('.search_container');
    if (selectOptions.value === "Edit") {
        // 如果選擇了編輯操作，則顯示新的課程ID輸入框
        newCourseIdInput.style.display = "inline-block";
        searchContainer.style.paddingBottom = '65px';
    } else {
        // 否則隱藏新的課程ID輸入框
        newCourseIdInput.style.display = "none";
        searchContainer.style.paddingBottom = '30px';

    }

    // 根據不同的操作，修改提交按鈕的點擊事件
    var submitButton = document.getElementById("selectrequest");
    if (selectOptions.value === "Delete") {
        submitButton.setAttribute("onclick", "submitDeleteForm()");
    } else if (selectOptions.value === "Edit") {
        submitButton.setAttribute("onclick", "submitEditForm()");
    } else {
        submitButton.setAttribute("onclick", "submitInsertForm()");
    }
}
function submitInsertForm() {
    const courseId = document.getElementById('search').value;
    submitingForm(courseId, 'insert_course.php');
}

function submitDeleteForm() {
    const courseId = document.getElementById('search').value;
    submitingForm(courseId, 'delete_course.php');

}

function submitEditForm() {
    const courseId = document.getElementById('search').value;
    const newCourseId = document.getElementById('newCourseId').value;
    submitingForm(courseId, 'edit_course.php', newCourseId);

}

function submitingForm(courseId, url, newCourseId) {
    const formData = new FormData();
    formData.append('courseId', courseId);
    if (newCourseId) {
        formData.append('newCourseId', newCourseId);
    }

    fetch(url, {
        method: 'POST',
        body: formData
    })
        .then(response => response.text())
        .then(data => {
            const messageContainer = document.getElementById('message-container');
            const message = document.getElementById('message');
            message.innerHTML = data;
            messageContainer.style.display = 'block';
        })
        .catch(error => {
            const messageContainer = document.getElementById('message-container');
            const message = document.getElementById('message');
            message.innerHTML = `發生錯誤：${error}`;
            messageContainer.style.display = 'block';
        });
    loadSchedule();
}

function search() {
    var keywords = document.getElementById("search_bar").value;
    var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("search_results").innerHTML = this.responseText;
        }
    };

    xmlhttp.open("GET", "search.php?keywords=" + keywords, true);
    xmlhttp.send();
}
function loadSchedule() {
    clearSchedule();
    fetch('class_schedule.php')
        .then(response => response.json())
        .then(data => {
            data.forEach(course => {
                let course_info = {
                    ClassID: course.Number,
                    Name: course.Name,
                    Room: "Room Info", // 假設有課室資訊
                    Time: []
                };
                if (course['星期一']) course_info.Time.push("一" + course['星期一']);
                if (course['星期二']) course_info.Time.push("二" + course['星期二']);
                if (course['星期三']) course_info.Time.push("三" + course['星期三']);
                if (course['星期四']) course_info.Time.push("四" + course['星期四']);
                if (course['星期五']) course_info.Time.push("五" + course['星期五']);
                if (course['星期六']) course_info.Time.push("六" + course['星期六']);
                if (course['星期日']) course_info.Time.push("日" + course['星期日']);

                insertClass(course_info, true);
            });
        })
        .catch(error => {
            console.error('Error:', error);
        });
}

function clearSchedule() {
    const schedule = document.getElementById('schedule_content');
    const cells = schedule.getElementsByClassName('schedule_div');
    Array.from(cells).forEach(cell => {
        cell.innerHTML = '';
    });
}
function insertClass(class_info, isSelected, isAuto = "norm") {
    const schedule = document.getElementById('schedule_content');

    for (let i = 0; i < class_info['Time'].length; i++) {
        var timedata = class_info['Time'][i].split('');

        var day_tmp = -1;
        switch (timedata[0]) {
            case "一": day_tmp = 1; break;
            case "二": day_tmp = 2; break;
            case "三": day_tmp = 3; break;
            case "四": day_tmp = 4; break;
            case "五": day_tmp = 5; break;
            case "六": day_tmp = 6; break;
            case "日": day_tmp = 7; break;
        }

        // 解析每個節數
        for (let j = 1; j < timedata.length; j++) {  // 改為從 j = 1 開始遍歷
            var period = timedata[j];

            const cell_index = document.getElementById(day_tmp.toString() + period).children[0];
            if (isSelected) {
                var addedClass = document.createElement('div');
                addedClass.id = class_info['ClassID'] + "_table_" + period;  // 確保每個節數的 ID 唯一
                addedClass.setAttribute('onmouseover', `selectedHover("${class_info['ClassID']}");`);
                addedClass.setAttribute('onclick', `gotoSelected("${class_info['ClassID']}");`);
                addedClass.setAttribute('type', 'button');

                if (class_info["Name"].length > 5) {
                    addedClass.innerHTML = `<span style="margin:auto;">${class_info["Name"].slice(0, 2)}...${class_info["Name"].slice(-2)}<br>${class_info["ClassID"]}</span>`;
                } else {
                    addedClass.innerHTML = `<span style="margin:auto;">${class_info["Name"]}<br>${class_info["ClassID"]}</span>`;
                }

                if (isAuto == "auto") {
                    addedClass.className = "addedclass pending";
                    addedClass.setAttribute('onmouseout', `selectedLeave("${class_info['ClassID']}","pending");`);
                } else {
                    addedClass.className = "addedclass";
                    addedClass.setAttribute('onmouseout', `selectedLeave("${class_info['ClassID']}","norm");`);
                }

                cell_index.appendChild(addedClass);
            } else {
                var deletClass = document.getElementById(class_info['ClassID'] + "_table_" + period);
                if (deletClass != null) {
                    deletClass.parentNode.removeChild(deletClass);
                }
            }
        }
    }
}
