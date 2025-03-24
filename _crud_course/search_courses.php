<?php
$conn = new PDO('mysql:dbname=database_project;host=localhost', 'root', '');

if (isset($_POST['search'])) {
    $search = $_POST['search'];

    $sql = "SELECT Id, Number, Name, Teacher, Room
            FROM test
            WHERE Id LIKE :search OR
                  Number LIKE :search OR
                  Name LIKE :search OR
                  Teacher LIKE :search OR
                  Room LIKE :search";
    
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':search',  $search );
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $searchResultsHtml = '<div id="list_content" style="display: block; width: 100%; text-align: center;">';
        $searchResultsHtml .= '<div id="list_head" class="list_lead_container" style="top: 0px">';
        $searchResultsHtml .= '<div class="list_head" style="width:20%;">Id</div>';
        $searchResultsHtml .= '<div class="list_head" style="width:20%;">Number</div>';
        $searchResultsHtml .= '<div class="list_head" style="width:20%;">Name</div>';
        $searchResultsHtml .= '<div class="list_head" style="width:20%;">Teacher</div>';
        $searchResultsHtml .= '<div class="list_head" style="width:20%;">Room</div>';
        $searchResultsHtml .= '</div>';

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $searchResultsHtml .= '<div class="course_info">';
            $searchResultsHtml .= '<span class="id" style="width: 20%;">' . htmlspecialchars($row["Id"]) . '</span>';
            $searchResultsHtml .= '<span class="number" style="width: 20%;">' . htmlspecialchars($row["Number"]) . '</span>';
            $searchResultsHtml .= '<span class="name" style="width: 20%;">' . htmlspecialchars($row["Name"]) . '</span>';
            $searchResultsHtml .= '<span class="teacher" style="width: 20%;">' . htmlspecialchars($row["Teacher"]) . '</span>';
            $searchResultsHtml .= '<span class="room" style="width: 20%;">' . htmlspecialchars($row["Room"]) . '</span>';
            $searchResultsHtml .= '</div>';
        }

        $searchResultsHtml .= '</div>';

        echo $searchResultsHtml;
    } else {
        echo '<p>No results found</p>';
    }
}
?>
