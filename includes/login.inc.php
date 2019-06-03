<?php
if (isset($_POST['login-submit'])) {
    require 'dbh.inc.php';

    $mailuid = $_POST['mailuid'];
    $pwd = $_POST['pwd'];

    // IF USERNAME OR PASSWORD EMPTY
    if (empty($mailuid) || empty($pwd)) {
        header("Location: ../index.php?error=emptyfields");
        exit();

        // IF OK, LOG USER IN
    } else {
        $sql = "SELECT * FROM users WHERE uidUsers=? OR emailUsers=?;";
        $stmt = mysqli_stmt_init($conn);

        // IF THERE IS SOME CONNECTION ERROR WITH DATABASE
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ../index.php?error=sqlerror");
            exit();

            // IF CONNECTION WITH DATABASE IS OK, CHECK USERNAME
        } else {
            mysqli_stmt_bind_param($stmt, 'ss', $mailuid, $mailuid);
            mysqli_stmt_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);

            // IF USER DOES EXIST IN DATABASE
            if ($row = mysqli_fetch_assoc($result)) {
                // COMPARE USERNAME AND PASSWORD THAT USER GAVE
                $pwdCheck = password_verify($pwd, $row['pwdUsers']);

                // IF PASSWORD IS WRONG
                if ($pwdCheck == false) {
                    header("Location: ../index.php?error=wrongpwd");
                    exit();

                    // IF PASSWORD IS CORRECT
                } else if ($pwdCheck == true) {
                    // START SESSION AND LOG USER IN
                    session_start();

                    $_SESSION['userId'] = $row['idUsers'];
                    $_SESSION['userUid'] = $row['uidUsers'];

                    header("Location: ../index.php?login=success");
                    exit();
                }

                // IF USER DOESN'T EXIST IN DATABASE
            } else {
                header("Location: ../index.php?error=nouser");
                exit();
            }
        }
    }
} else {
    header("Location: ../index.php");
    exit();
}