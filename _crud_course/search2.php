<?php
$conn = new PDO('mysql:dbname=database_project;host=localhost', 'root', '');

function searchProfessorsAndTest($searchTerm) {
    global $conn;
    $sql = "SELECT professor_info.name, test.Number, test.Name 
            FROM professor_info 
            INNER JOIN test ON professor_info.name = test.Teacher
            WHERE professor_info.name LIKE :searchTerm";
    $stmt = $conn->prepare($sql);
    $searchTerm = "%$searchTerm%";
    $stmt->bindParam(':searchTerm', $searchTerm);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $searchTerm = $_POST['searchTerm'];
    $results = searchProfessorsAndTest($searchTerm);
    echo '<div id="list_head" class="list_lead_container" style="top: 0px">';
    echo '<div class="list_head" style="width:33%;">教授姓名</div>';
    echo '<div class="list_head" style="width:33%;">課程代號</div>';
    echo '<div class="list_head" style="width: 33%;">課程名稱</div>';
    echo '</div>';
    if (!empty($results)) {
        foreach ($results as $row) {
            echo "<div class='course_info'>";
            echo "<span class='name' style = 'width: 33%;'>" . htmlspecialchars($row['name']) . "</span>";
            echo "<span class='column1' style = 'width: 33%;'>" . htmlspecialchars($row['Number']) . "</span>";
            echo "<span class='column2' style = 'width: 33%;'>" . htmlspecialchars($row['Name']) . "</span>";
            echo "</div>";
        }
    } else {
        echo "<p>No results found.</p>";
    }
}