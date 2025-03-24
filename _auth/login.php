<?php
session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log-in</title>
    <link href="login.css" type="text/css" rel="stylesheet" />
    <script src="login.js" type="text/javascript"></script>
</head>

<body>
    <?php
    $db = new PDO("mysql:dbname=database_project", "root", "");
    ?>
    <div class="whole">
        <div class="nav">
            <span class="navTitle">
                <div class="display_but">
                    <button type="button">&#9776;</button>
                </div>
                <a href="./login.php" id="link">Login</a>
            </span>

        </div>

        <div class="logo">LogIn</div>
        <div class="login_container">
            <?php

            if ($_SERVER["REQUEST_METHOD"] == "POST") {

                $user = $_POST["username"];
                $password = $_POST["password"]; ?>

                <form action="" method="post">
                    <div class="selector">
                        <?php if (!empty($user) && !(empty($password))) {
                            $stmt = $db->prepare("SELECT * FROM student WHERE stu_name = :user");
                            $stmt->bindParam(':user', $user);
                            $stmt->execute();
                            $db_info = $stmt->fetch(PDO::FETCH_ASSOC);
                            if ($db_info) {
                                $db_user = $db_info["stu_Name"];
                                $db_password = $db_info["stu_Id"];
                                $db_access = $db_info["access"];
                                if ($db_password == $password) {
                                    $_SESSION['stu_Name'] = $user;
                                    $_SESSION['stu_Id'] = $password;
                                    $_SESSION["access"] = $db_access;
                                    header("Location:index.php");
                                    exit();
                                } else { ?>
                                    <div class="red">Incorrect ID</div><?php
                                                                    }
                                                                } else { ?>
                                <div class="red">User does not exist</div><?php
                                                                        }
                                                                    } else { ?>
                            <div class="red">Incorrect username or ID</div>
                        <?php }
                        ?>
                        <label for="username">Username:</label>
                        <div class="br"></div><input type="text" name="username" class="text"></input>
                        <?php if (empty($user)) { ?>
                            <div class="red">Username cannot be empty</div>
                        <?php   }   ?>
                        <div class="br"></div>
                        <label for="password">Password:</label>
                        <div class="br"></div><input type="password" name="password" class="text"></input>
                        <?php if (empty($password)) {  ?>
                            <div class="red">ID cannot be empty</div>
                        <?php } ?>
                        <div class="br"></div>
                        <input type="submit" value="submit" class="sub_but">
                        <div class="br"></div>
                        <div class="signlink">
                            <span>No account?</span><a href="signup.php" class="signup">Sign up</a>
                        </div>
                    </div>
                </form>
            <?php   } else { ?>
                <form action="" method="post">
                    <div class="selector">
                        <label for="username">Username:</label>
                        <div class="br"></div>
                        <input type="text" name="username" class="text"></input>
                        <div class="br"></div>
                        <label for="password">Your_Student_ID(Without first char):</label>
                        <div class="br"></div>
                        <input type="password" name="password" class="text"></input>
                        <div class="br"></div>
                        <input type="submit" value="submit" class="sub_but">
                        <div class="br"></div>
                        <div class="signlink">
                            <span>No account? </span><a href="signup.php" class="signup">Sign up</a>
                        </div>
                    </div>
                </form>
            <?php  } ?>
        </div>
    </div>

</body>


</html>