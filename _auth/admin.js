document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('table-select').addEventListener('change', loadTableData);
});

function loadTableData() {
    var selectElement = document.getElementById("table-select");


    var linkContainers = document.querySelectorAll("[id$='-link-container']");
    linkContainers.forEach(function (container) {
        container.style.display = "none";
    });


    var selectedOption = selectElement.value;
    if (selectedOption !== "") {
        var linkContainerId = selectedOption + "-link-container";
        var selectedLinkContainer = document.getElementById(linkContainerId);
        selectedLinkContainer.style.display = "block";
    }

    const table = document.getElementById('table-select').value;
    if (!table) return;

    fetch(`admin_interface.php?table=${table}`)
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                document.getElementById('message').innerText = data.error;
                document.getElementById('message-container').style.display = 'block';
                return;
            }

            const headers = Object.keys(data[0]);
            const dataBody = document.getElementById('data-body');
            if (dataBody) {
                dataBody.innerHTML = '';
            }

            // 生成表頭
            const headerRow = document.createElement('tr');
            headers.forEach(header => {
                const th = document.createElement('th');
                th.innerText = header;
                headerRow.appendChild(th);
            });
            // 添加操作列標題
            const th = document.createElement('th');

            dataBody.appendChild(headerRow);

            // 生成數據行
            data.forEach(row => {
                const tr = document.createElement('tr');
                headers.forEach(header => {
                    const td = document.createElement('td');
                    td.innerText = row[header];
                    tr.appendChild(td);
                });
                const td = document.createElement('td');

                dataBody.appendChild(tr);
            });


        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('message').innerText = '數據加載失敗。';
            document.getElementById('message-container').style.display = 'block';
        });
}



