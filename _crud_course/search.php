<?php
// Establish database connection
$conn = new PDO('mysql:dbname=database_project;host=localhost', 'root', '');

// Get keywords from the GET request
$keywords = "%{$_GET['keywords']}%"; // Surround keywords with '%' for a partial match

// Query to search for courses based on keywords in any column
$sql = "SELECT * FROM test WHERE Description LIKE :keywords 
        OR Department LIKE :keywords 
        OR Number LIKE :keywords 
        OR Grade LIKE :keywords 
        OR Class LIKE :keywords 
        OR Name LIKE :keywords 
        OR Credit LIKE :keywords 
        OR YearSemester LIKE :keywords 
        OR CompulsoryElective LIKE :keywords 
        OR Teacher LIKE :keywords 
        OR Room LIKE :keywords 
        OR 星期一 LIKE :keywords 
        OR 星期二 LIKE :keywords 
        OR 星期三 LIKE :keywords 
        OR 星期四 LIKE :keywords 
        OR 星期五 LIKE :keywords 
        OR 星期六 LIKE :keywords 
        OR 星期天 LIKE :keywords 
        OR Context LIKE :keywords 
        OR Programs LIKE :keywords";

// Prepare the SQL query
$stmt = $conn->prepare($sql);

// Bind the keyword parameter
$stmt->bindParam(':keywords', $keywords, PDO::PARAM_STR);

// Execute the query
$stmt->execute();

// Check if there are any results
if ($stmt->rowCount() > 0) {
    // Display search results
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // Output each result as desired
        $weekdays = array(
            1 => "星期一",
            2 => "星期二",
            3 => "星期三",
            4 => "星期四",
            5 => "星期五",
            6 => "星期六",
            7 => "星期天"
        );

        // 尋找該課程在哪些星期有課
        $days_with_classes = array();
        for ($day = 1; $day <= 7; $day++) {
            $section = $row[$weekdays[$day]];
            if (!is_null($section)) {
                // Only keep non-null sections
                if (is_numeric($section)) {
                    $days_with_classes[] = "{$weekdays[$day]} {$section}";
                }
            }
        }

        // If there are days with classes, output the course information
        if (!empty($days_with_classes)) {
            $time_display = implode(", ", $days_with_classes);
?>
            <div class="course_info">
                <span style="width:11%"><?= $row["Number"] ?></span>
                <span class='course-name'><?= $row["Name"] ?></span>
                <span class='time'><?= $time_display ?></span>
                <span class='class'><?= $row["Class"] ?></span>
                <span class='department'><?= $row["Department"] ?></span>
                <span class='compulsory-elective'><?= $row["CompulsoryElective"] ?></span>
                <span class='credit'><?= $row["Credit"] ?></span>
                <span class='teacher'><?= $row["Teacher"] ?></span>
                <span class='programs'><?= $row["Programs"] ?></span>
                <span class='emi'><?= $row["EMI"] ?></span>
            </div>
<?php
        }
    }
} else {
    // No results found
    echo "No courses found.";
}
?>