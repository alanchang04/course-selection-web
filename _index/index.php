<?php
session_start(); // 啟動會話

if (!isset($_SESSION['stu_Name'])) {
    echo "<p>未找到登入信息，請重新登錄。</p>";
    exit;
}

$stuName = $_SESSION['stu_Name'];
$stuId = $_SESSION['stu_Id'];
?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="./index.css">
    <script src="index.js" type="text/javascript"></script>
    <script src="search.js" type="text/javascript"></script>
    <meta charset="UTF-8">
    <title>選課助手(資管版)</title>
</head>

<body>
    <?php
    $conn = new PDO('mysql:dbname=database_project;host=localhost', 'root', '');


    $sql = "SELECT * FROM test";
    $result = $conn->query($sql);
    ?>
    <div id="message-container" style="display: none;">
        <div id="message" class="message"></div>
        <div style="text-align: center;">
            <button id="close-message" onclick="hideMessage()">關閉</button>
        </div>
    </div>
    <script>
        function hideMessage() {
            var messageContainer = document.getElementById("message-container");
            messageContainer.style.display = "none";
        }
    </script>
    <div class="App_container" id="App_container" style="max-height: 100vh; width: 100vw; overflow: auto;">
        <div class="container-fluid" style=" display: table; width: 100vw; height: 100vh;">
            <div class="row">
                <!--左半邊的課表-->
                <div class="col-lg">
                    <div class="left">
                        <table class="schedule_content" id="schedule_content">
                            <tbody>
                                <tr class="schedule_tr">
                                    <td class="schedule_th" style="width: 7%;">節\日</th>
                                    <td class="schedule_th">星期一</th>
                                    <td class="schedule_th">星期二</th>
                                    <td class="schedule_th">星期三</th>
                                    <td class="schedule_th">星期四</th>
                                    <td class="schedule_th">星期五</th>
                                    <td class="schedule_th">星期六</th>
                                    <td class="schedule_th">星期日</th>
                                </tr>
                                <tr class="schedule_tr">
                                    <td class="schedule_th">A<br>7:00-7:50</th>
                                    <td id="1A" class="schedule_th">
                                        <div class="schedule_div"></div>
                                    </td>
                                    <td id="2A" class="schedule_th">
                                        <div class="schedule_div"></div>
                                    </td>
                                    <td id="3A" class="schedule_th">
                                        <div class="schedule_div"></div>
                                    </td>
                                    <td id="4A" class="schedule_th">
                                        <div class="schedule_div"></div>
                                    </td>
                                    <td id="5A" class="schedule_th">
                                        <div class="schedule_div"></div>
                                    </td>
                                    <td id="6A" class="schedule_th">
                                        <div class="schedule_div"></div>
                                    </td>
                                    <td id="7A" class="schedule_th">
                                        <div class="schedule_div"></div>
                                    </td>
                                </tr>
                                <tr class="schedule_tr">
                                    <td class="schedule_th">1<br>8:10-9:00</th>
                                    <td id="11" class="schedule_th">
                                        <div class="schedule_div"></div>
                                    </td>
                                    <td id="21" class="schedule_th">
                                        <div class="schedule_div"></div>
                                    </td>
                                    <td id="31" class="schedule_th">
                                        <div class="schedule_div"></div>
                                    </td>
                                    <td id="41" class="schedule_th">
                                        <div class="schedule_div"></div>
                                    </td>
                                    <td id="51" class="schedule_th">
                                        <div class="schedule_div"></div>
                                    </td>
                                    <td id="61" class="schedule_th">
                                        <div class="schedule_div"></div>
                                    </td>
                                    <td id="71" class="schedule_th">
                                        <div class="schedule_div"></div>
                                    </td>
                                </tr>
                                <tr class="schedule_tr">
                                    <td class="schedule_th">2<br>9:10-10:00</th>
                                    <td id="12" class="schedule_th">
                                        <div class="schedule_div"></div>
                                    </td>
                                    <td id="22" class="schedule_th">
                                        <div class="schedule_div"></div>
                                    </td>
                                    <td id="32" class="schedule_th">
                                        <div class="schedule_div"></div>
                                    </td>
                                    <td id="42" class="schedule_th">
                                        <div class="schedule_div"></div>
                                    </td>
                                    <td id="52" class="schedule_th">
                                        <div class="schedule_div"></div>
                                    </td>
                                    <td id="62" class="schedule_th">
                                        <div class="schedule_div"></div>
                                    </td>
                                    <td id="72" class="schedule_th">
                                        <div class="schedule_div"></div>
                                    </td>
                                </tr>
                                <tr class="schedule_tr">
                                    <td class="schedule_th">3<br>10:10-11:00</th>
                                    <td id="13" class="schedule_th">
                                        <div class="schedule_div"></div>
                                    </td>
                                    <td id="23" class="schedule_th">
                                        <div class="schedule_div"></div>
                                    </td>
                                    <td id="33" class="schedule_th">
                                        <div class="schedule_div"></div>
                                    </td>
                                    <td id="43" class="schedule_th">
                                        <div class="schedule_div"></div>
                                    </td>
                                    <td id="53" class="schedule_th">
                                        <div class="schedule_div"></div>
                                    </td>
                                    <td id="63" class="schedule_th">
                                        <div class="schedule_div"></div>
                                    </td>
                                    <td id="73" class="schedule_th">
                                        <div class="schedule_div"></div>
                                    </td>
                                </tr>
                                <tr class="schedule_tr">
                                    <td class="schedule_th">4<br>11:10-12:00</th>
                                    <td id="14" class="schedule_th">
                                        <div class="schedule_div"></div>
                                    </td>
                                    <td id="24" class="schedule_th">
                                        <div class="schedule_div"></div>
                                    </td>
                                    <td id="34" class="schedule_th">
                                        <div class="schedule_div"></div>
                                    </td>
                                    <td id="44" class="schedule_th">
                                        <div class="schedule_div"></div>
                                    </td>
                                    <td id="54" class="schedule_th">
                                        <div class="schedule_div"></div>
                                    </td>
                                    <td id="64" class="schedule_th">
                                        <div class="schedule_div"></div>
                                    </td>
                                    <td id="74" class="schedule_th">
                                        <div class="schedule_div"></div>
                                    </td>
                                </tr>
                                <tr class="schedule_tr">
                                    <td class="schedule_th">B<br>12:10-13:00</th>
                                    <td id="1B" class="schedule_th">
                                        <div class="schedule_div"></div>
                                    </td>
                                    <td id="2B" class="schedule_th">
                                        <div class="schedule_div"></div>
                                    </td>
                                    <td id="3B" class="schedule_th">
                                        <div class="schedule_div"></div>
                                    </td>
                                    <td id="4B" class="schedule_th">
                                        <div class="schedule_div"></div>
                                    </td>
                                    <td id="5B" class="schedule_th">
                                        <div class="schedule_div"></div>
                                    </td>
                                    <td id="6B" class="schedule_th">
                                        <div class="schedule_div"></div>
                                    </td>
                                    <td id="7B" class="schedule_th">
                                        <div class="schedule_div"></div>
                                    </td>
                                </tr>
                                <tr class="schedule_tr">
                                    <td class="schedule_th">5<br>13:10-14:00</th>
                                    <td id="15" class="schedule_th">
                                        <div class="schedule_div"></div>
                                    </td>
                                    <td id="25" class="schedule_th">
                                        <div class="schedule_div"></div>
                                    </td>
                                    <td id="35" class="schedule_th">
                                        <div class="schedule_div"></div>
                                    </td>
                                    <td id="45" class="schedule_th">
                                        <div class="schedule_div"></div>
                                    </td>
                                    <td id="55" class="schedule_th">
                                        <div class="schedule_div"></div>
                                    </td>
                                    <td id="65" class="schedule_th">
                                        <div class="schedule_div"></div>
                                    </td>
                                    <td id="75" class="schedule_th">
                                        <div class="schedule_div"></div>
                                    </td>
                                </tr>
                                <tr class="schedule_tr">
                                    <td class="schedule_th">6<br>14:10-15:00</th>
                                    <td id="16" class="schedule_th">
                                        <div class="schedule_div"></div>
                                    </td>
                                    <td id="26" class="schedule_th">
                                        <div class="schedule_div"></div>
                                    </td>
                                    <td id="36" class="schedule_th">
                                        <div class="schedule_div"></div>
                                    </td>
                                    <td id="46" class="schedule_th">
                                        <div class="schedule_div"></div>
                                    </td>
                                    <td id="56" class="schedule_th">
                                        <div class="schedule_div"></div>
                                    </td>
                                    <td id="66" class="schedule_th">
                                        <div class="schedule_div"></div>
                                    </td>
                                    <td id="76" class="schedule_th">
                                        <div class="schedule_div"></div>
                                    </td>
                                </tr>
                                <tr class="schedule_tr">
                                    <td class="schedule_th">7<br>15:10-16:00</th>
                                    <td id="17" class="schedule_th">
                                        <div class="schedule_div"></div>
                                    </td>
                                    <td id="27" class="schedule_th">
                                        <div class="schedule_div"></div>
                                    </td>
                                    <td id="37" class="schedule_th">
                                        <div class="schedule_div"></div>
                                    </td>
                                    <td id="47" class="schedule_th">
                                        <div class="schedule_div"></div>
                                    </td>
                                    <td id="57" class="schedule_th">
                                        <div class="schedule_div"></div>
                                    </td>
                                    <td id="67" class="schedule_th">
                                        <div class="schedule_div"></div>
                                    </td>
                                    <td id="77" class="schedule_th">
                                        <div class="schedule_div"></div>
                                    </td>
                                </tr>
                                <tr class="schedule_tr">
                                    <td class="schedule_th">8<br>16:10-17:00</th>
                                    <td id="18" class="schedule_th">
                                        <div class="schedule_div"></div>
                                    </td>
                                    <td id="28" class="schedule_th">
                                        <div class="schedule_div"></div>
                                    </td>
                                    <td id="38" class="schedule_th">
                                        <div class="schedule_div"></div>
                                    </td>
                                    <td id="48" class="schedule_th">
                                        <div class="schedule_div"></div>
                                    </td>
                                    <td id="58" class="schedule_th">
                                        <div class="schedule_div"></div>
                                    </td>
                                    <td id="68" class="schedule_th">
                                        <div class="schedule_div"></div>
                                    </td>
                                    <td id="78" class="schedule_th">
                                        <div class="schedule_div"></div>
                                    </td>
                                </tr>
                                <tr class="schedule_tr">
                                    <td class="schedule_th">9<br>17:10-18:00</th>
                                    <td id="19" class="schedule_th">
                                        <div class="schedule_div"></div>
                                    </td>
                                    <td id="29" class="schedule_th">
                                        <div class="schedule_div"></div>
                                    </td>
                                    <td id="39" class="schedule_th">
                                        <div class="schedule_div"></div>
                                    </td>
                                    <td id="49" class="schedule_th">
                                        <div class="schedule_div"></div>
                                    </td>
                                    <td id="59" class="schedule_th">
                                        <div class="schedule_div"></div>
                                    </td>
                                    <td id="69" class="schedule_th">
                                        <div class="schedule_div"></div>
                                    </td>
                                    <td id="79" class="schedule_th">
                                        <div class="schedule_div"></div>
                                    </td>
                                </tr>
                                <tr class="schedule_tr">
                                    <td class="schedule_th">C<br>18:20-19:10</th>
                                    <td id="1C" class="schedule_th">
                                        <div class="schedule_div"></div>
                                    </td>
                                    <td id="2C" class="schedule_th">
                                        <div class="schedule_div"></div>
                                    </td>
                                    <td id="3C" class="schedule_th">
                                        <div class="schedule_div"></div>
                                    </td>
                                    <td id="4C" class="schedule_th">
                                        <div class="schedule_div"></div>
                                    </td>
                                    <td id="5C" class="schedule_th">
                                        <div class="schedule_div"></div>
                                    </td>
                                    <td id="6C" class="schedule_th">
                                        <div class="schedule_div"></div>
                                    </td>
                                    <td id="7C" class="schedule_th">
                                        <div class="schedule_div"></div>
                                    </td>
                                </tr>
                                <tr class="schedule_tr">
                                    <td class="schedule_th">D<br>19:15-20:05</th>
                                    <td id="1D" class="schedule_th">
                                        <div class="schedule_div"></div>
                                    </td>
                                    <td id="2D" class="schedule_th">
                                        <div class="schedule_div"></div>
                                    </td>
                                    <td id="3D" class="schedule_th">
                                        <div class="schedule_div"></div>
                                    </td>
                                    <td id="4D" class="schedule_th">
                                        <div class="schedule_div"></div>
                                    </td>
                                    <td id="5D" class="schedule_th">
                                        <div class="schedule_div"></div>
                                    </td>
                                    <td id="6D" class="schedule_th">
                                        <div class="schedule_div"></div>
                                    </td>
                                    <td id="7D" class="schedule_th">
                                        <div class="schedule_div"></div>
                                    </td>
                                </tr>
                                <tr class="schedule_tr">
                                    <td class="schedule_th">E<br>20:10-21:00</th>
                                    <td id="1E" class="schedule_th">
                                        <div class="schedule_div"></div>
                                    </td>
                                    <td id="2E" class="schedule_th">
                                        <div class="schedule_div"></div>
                                    </td>
                                    <td id="3E" class="schedule_th">
                                        <div class="schedule_div"></div>
                                    </td>
                                    <td id="4E" class="schedule_th">
                                        <div class="schedule_div"></div>
                                    </td>
                                    <td id="5E" class="schedule_th">
                                        <div class="schedule_div"></div>
                                    </td>
                                    <td id="6E" class="schedule_th">
                                        <div class="schedule_div"></div>
                                    </td>
                                    <td id="7E" class="schedule_th">
                                        <div class="schedule_div"></div>
                                    </td>
                                </tr>
                                <tr class="schedule_tr">
                                    <td class="schedule_th">F<br>21:05-21:55</th>
                                    <td id="1F" class="schedule_th">
                                        <div class="schedule_div"></div>
                                    </td>
                                    <td id="2F" class="schedule_th">
                                        <div class="schedule_div"></div>
                                    </td>
                                    <td id="3F" class="schedule_th">
                                        <div class="schedule_div"></div>
                                    </td>
                                    <td id="4F" class="schedule_th">
                                        <div class="schedule_div"></div>
                                    </td>
                                    <td id="5F" class="schedule_th">
                                        <div class="schedule_div"></div>
                                    </td>
                                    <td id="6F" class="schedule_th">
                                        <div class="schedule_div"></div>
                                    </td>
                                    <td id="7F" class="schedule_th">
                                        <div class="schedule_div"></div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <button class="sub_but" onclick="loadSchedule()">按此按鈕以顯示課表/刷新課表
                    </div>
                    <!-- 這是分隔線中間那條灰色線 -->
                    <div style="display: flex; align-items: center; height: 100%; transform: translateX(700%);">
                        <div class="schedule_line"></div>
                    </div>
                </div>


                <!--右邊的選課程-->
                <div class="col-lg" style="height: 100vh; display: block;padding: 12px;">
                    <div class="function_container" style="height: 100%; overflow:auto;">
                        <nav class="nav" id="nav-tab" style="margin: 0px 0px 0px 0px; position: sticky; top: 0px; z-index: 999; background-color: #fff; padding: 5px; margin: 0px;">
                            <div class="nav nav-tabs" id="nav-tab" role="tablist" style="width: 100%;">
                                <div class="nav-item nav-link" id="nav-all_classes-tab" data-toggle="tab" href="#nav-all_classes" role="tab" aria-controls="nav-all_classes" aria-selected="false">
                                    <div class="title">
                                        <span>Hi! <?= $stuName ?></span>
                                        <a href="./logout.php" class="link0">LogOut</a>
                                        <b>中山大學排課系統</b>
                                        <a href="./index2.php" class="link1">Professor comments</a>
                                        <a href="./index3.php" class="link1">已修畢課程</a>
                                    </div>
                                </div>
                            </div>
                        </nav>

                        <div class="tab-content" id="nav-tabContent">

                            <div class="search_container" style="position: sticky; top: 0px; z-index: 999;">
                                <div style="text-align: center; margin: 10px 28px 10px 28px;">
                                    <div class="form-outline" style="display: flex; width: 95%;">
                                        <!-- <div class="dropdown_show" style="display: inline-block; border-radius: 100px; width: 30%; padding-left: 20px">
                                                <a class="btn btn-secondary dropdown-toggle class_set_sel" href="#" role="button" id="class_set_sel" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <snap id="class_set_now_sel"></snap>
                                                </a>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink" id="class_set_menu"></div>
                                            </div> -->
                                        <input type="search" id="search_bar" class="form-control" onkeyup="search()" style="display: inline-block; border-radius: 100px; width: 100%; padding-left: 5%; padding-right: 5%;" placeholder="綜合搜尋...&nbsp;(例如：四 或 課程種類(如博雅) 或課程名稱 )" aria-label="Search">
                                        <br />
                                    </div>
                                </div>
                                <div class="moveblog">
                                    <select name="move" id="selectoptions" onchange="toggleInputFields()">
                                        <option>Insert</option>
                                        <option style="color: red">Delete</option>
                                        <option style="color: blue">Edit</option>
                                    </select>
                                    <input type="search" id="search" placeholder="輸入課程ID" />
                                    <input type="search" id="newCourseId" placeholder="新的課程ID" style="display: none;" />
                                    <button id="selectrequest" onclick="submitInsertForm()">Submit Request</button>
                                </div>
                            </div>



                            <div class="list_container" style="width: 100%; height: 100%; min-height: 200px;">
                                <div id="list_content" style="display: block; width: 100%; text-align: center;">
                                    <div id="list_head" class="list_lead_container" style="top: 0px">
                                        <div class="list_head" style="width:11%;">課程ID</div>
                                        <div class="list_head" style="width:16%;">課程名稱</div>
                                        <div class="list_head" style="width:6%;">時間</div>
                                        <div class="list_head" style="width:5%;">班級</div>
                                        <div class="list_head" style="width:15%;">上課系所</div>
                                        <div class="list_head" style="width:4%;">必選</div>
                                        <div class="list_head" style="width:4%;">學分</div>
                                        <div class="list_head" style="width:13%;">授課教師</div>
                                        <div class="list_head" style="width:18%;">所屬學程</div>
                                        <div class="list_head" style="width:4%;">英文授課</div>
                                    </div>
                                    <!--class="class_row"以下*N-->
                                    <div id="search_results">
                                        <div id="initial">
                                            <?php
                                            $sql = "SELECT * FROM test";
                                            $stmt = $conn->query($sql);

                                            if ($stmt->rowCount() > 0) {
                                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
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
                                                            // 只保留有數值的節數
                                                            if (is_numeric($section)) {
                                                                $days_with_classes[] = "{$weekdays[$day]} {$section}";
                                                            }
                                                        }
                                                    }

                                                    // 如果有星期有課，則輸出該課程的資訊
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
                                                            <span class='emi' style = "width: 4%;"><?= $row["EMI"] ?></span>
                                                        </div>
                                            <?php
                                                    }
                                                }
                                            } else {
                                                echo "0 結果";
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
</body>

</html>