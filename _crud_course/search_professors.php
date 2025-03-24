<?php
$conn = new PDO('mysql:dbname=database_project;host=localhost', 'root', '');

if (isset($_POST['search'])) {
    $search = $_POST['search'];

    $sql = "SELECT professor_info.name, professor.comment, professor.credits, professor_info.department_Id, student.stu_Name
            FROM professor_info 
            JOIN professor ON professor_info.name = professor.name 
            JOIN student ON professor.sId = student.stu_Id
            WHERE professor_info.name LIKE :search OR
                  professor_info.pId LIKE :search OR
                  professor_info.gender LIKE :search OR
                  professor_info.department_Id LIKE :search OR
                  professor_info.status LIKE :search OR
                  professor.comment LIKE :search OR
                  professor.credits LIKE :search OR
                  student.stu_Name LIKE :search";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':search', '%' . $search . '%');
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $searchResultsHtml = '<div id="list_content" style="display: block; width: 100%; text-align: center;">';
        $searchResultsHtml .= '<div id="list_head" class="list_lead_container" style="top: 0px">';
        $searchResultsHtml .= '<div class="list_head" style="width:20%;">Name</div>';
        $searchResultsHtml .= '<div class="list_head" style="width:20%;">Comment</div>';
        $searchResultsHtml .= '<div class="list_head" style="width:20%;">Credits</div>';
        $searchResultsHtml .= '<div class="list_head" style="width:20%;">Department ID</div>';
        $searchResultsHtml .= '<div class="list_head" style="width:20%;">Student Name</div>';
        $searchResultsHtml .= '</div>';

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $searchResultsHtml .= '<div class="course_info">';
            $searchResultsHtml .= '<span class="name" style="width: 20%;">' . htmlspecialchars($row["name"]) . '</span>';
            $searchResultsHtml .= '<span class="comment" style="width: 20%;">' . htmlspecialchars($row["comment"]) . '</span>';
            $searchResultsHtml .= '<span class="credits" style="width: 20%;">' . htmlspecialchars($row["credits"]) . '</span>';
            $searchResultsHtml .= '<span class="department_Id" style="width: 20%;">' . htmlspecialchars($row["department_Id"]) . '</span>';
            $searchResultsHtml .= '<span class="stu_Name" style="width: 20%;">' . htmlspecialchars($row["stu_Name"]) . '</span>';
            $searchResultsHtml .= '</div>';
        }

        $searchResultsHtml .= '</div>';

        echo $searchResultsHtml;
    } else {
        echo '<p>No results found</p>';
    }
}
?>
