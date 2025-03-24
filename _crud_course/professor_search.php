<?php
// search_professors.php
$conn = new PDO('mysql:dbname=database_project;host=localhost', 'root', '');

if (isset($_POST['search'])) {
    $search = $_POST['search'];

    $sql = "SELECT professor_info.pId, professor_info.name, professor_info.gender, department.dname 
            FROM professor_info 
            JOIN department ON professor_info.department_Id = department.depart_code_number 
            WHERE professor_info.name LIKE :search OR
                    professor_info.pId LIKE :search OR
                    professor_info.gender LIKE :search OR
                    department.dname LIKE :search";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':search', '%' . $search . '%');
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $searchResultsHtml = '<div id="list_content" style="display: block; width: 100%; text-align: center;">';
        $searchResultsHtml .= '<div id="list_head" class="list_lead_container" style="top: 0px">';
        $searchResultsHtml .= '<div class="list_head" style="width:10%;">Id</div>';
        $searchResultsHtml .= '<div class="list_head" style="width:23%;">Name</div>';
        $searchResultsHtml .= '<div class="list_head" style="width:34%;">Gender</div>';
        $searchResultsHtml .= '<div class="list_head" style="width:33%;">Department ID</div>';
        $searchResultsHtml .= '</div>';

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $searchResultsHtml .= '<div class="course_info">';
            $searchResultsHtml .= '<span class="Id" style = "width: 10%;">' . htmlspecialchars($row["pId"]) . '</span>';
            $searchResultsHtml .= '<span class="name" style = "width: 23%;">' . htmlspecialchars($row["name"]) . '</span>';
            $searchResultsHtml .= '<span class="gender" style = "width: 34%;">' . htmlspecialchars($row["gender"]) . '</span>';
            $searchResultsHtml .= '<span class="department_Id" style = "width: 33%;">' . htmlspecialchars($row["dname"]) . '</span>';
            $searchResultsHtml .= '</div>';
        }

        $searchResultsHtml .= '</div>';

        echo $searchResultsHtml;
    } else {
        echo '<p>No results found</p>';
    }
}
