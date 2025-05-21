<link rel="stylesheet" href="./css/jquery-ui.min.css">
<script src="./js/popper.min.js"></script>
<script src="./js/sweetalert2.all.min.js"></script>
<?php 
require '../include/connector/dbconn.php';
include "../include/settings.php"; 

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    try {
        $query = "SELECT * FROM user WHERE username=? AND password=? AND status='1'";
        $stmt = mysqli_prepare($db, $query);
        if (!$stmt) {
            throw new Exception("Failed to prepare statement: " . mysqli_error($db));
        }

        mysqli_stmt_bind_param($stmt, "ss", $username, $password);
        if (!mysqli_stmt_execute($stmt)) {
            throw new Exception("Failed to execute statement: " . mysqli_stmt_error($stmt));
        }

        $results = mysqli_stmt_get_result($stmt);
        if (!$results) {
            throw new Exception("Failed to get result: " . mysqli_stmt_error($stmt));
        }

        if(mysqli_num_rows($results) > 0) {
            $usertype = mysqli_fetch_array($results);
            if($usertype['status'] == "1") {
                switch ($usertype['types']) {
                    case "isAdmin":
                        $_SESSION['admin'] = $usertype['code'];
                        $_SESSION['status'] = "Welcome to $settingName";
                        $_SESSION['status_code'] = "success";
                        header('location: ../tri.admin/adminHome.php');
                        exit();
                        break;
                    case "isJudge":
                        $_SESSION['judge'] = $usertype['code'];
                        $_SESSION['status'] = "Welcome to $settingName";
                        $_SESSION['status_code'] = "success";
                        header('location: ../tri.judge/judgeHome.php');
                        exit();
                        break;
                    case "isSuper";
						$_SESSION['super'] = $usertype['code'];
						$_SESSION['status'] = "Welcome to $settingName";
						$_SESSION['status_code'] = "success";
						header('location: ../tri.super/superBackup.php');
						exit();
						break;
                }
            }
        } else {
            throw new Exception("Wrong Username/Password Combination");
        }
    } catch (Exception $e) {
        // Handle exceptions
        $_SESSION['status'] = $e->getMessage();
        $_SESSION['status_code'] = "error";
        header('location: ../index.php');
        exit();
    }
}
?>
