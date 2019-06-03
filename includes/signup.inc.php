<?php
if (isset($_POST['signup-submit'])) {
    require 'dbh.inc.php';

    $uid = $_POST['uid'];
    $email = $_POST['email'];
    $pwd = $_POST['pwd'];
    $repwd = $_POST['repwd'];

    // ERROR HANDLING /////////////////////////////////////////////////////////////////////////////

    // IF USER LEAVE ANY EMPTY FIELDS //////////////////////////////////////////////////////////////
    if (empty($uid) || empty($email) || empty($pwd) || empty($repwd)) {
        header("Location: ../signup.php?error=emptyfields&uid=" . $uid . "&email=" . $email);
        exit();

        // IF EMAIL AND USERNAME ARE BOTH INVALID //////////////////////////////////////////////////
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/", $uid)) {
        header("Location: ../signup.php?error=invalidemail&uid");
        exit();

        // IF ONLY EMAIL IS INVALID ////////////////////////////////////////////////////////////
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: ../signup.php?error=invalidemail&uid=" . $uid);
        exit();

        // IF ONLY USERNAME IS INVALID //////////////////////////////////////////////////
    } else if (!preg_match("/^[a-zA-Z0-9]*$/", $uid)) {
        header("Location: ../signup.php?error=invaliduid&email=" . $email);
        exit();

        // IF PASSWORDS WONT MATCH //////////////////////////////////////////////////
    } else if ($pwd !== $repwd) {
        header("Location: ../signup.php?error=passwordcheck&uid=" . $uid . "&email=" . $email);
        exit();

        // CHECK IF USERNAME ALREADY EXISTS IN DATABASE //////////////////////////////////////////////////
    } else {
        $sql = "SELECT uidUsers FROM users WHERE uidUsers=?";
        $stmt = mysqli_stmt_init($conn);

        // IF THERE IS SOME CONNECTION ERROR WITH DATABASE
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ../signup.php?error=sqlerror");
            exit();

            // IF CONNECTED SUCCESSFULLY
        } else {
            mysqli_stmt_bind_param($stmt, "s", $uid);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);

            $resultCheck = mysqli_stmt_num_rows($stmt);

            // IF USERNAME IS ALREADY TAKEN
            if ($resultCheck > 0) {
                header("Location: ../signup.php?error=usertaken&email=" . $email);
                exit();

                // IF USERNAME IS NOT TAKEN
            } else {
                $sql = "INSERT INTO users (uidUsers, emailUsers, pwdUsers) 
                        VALUES (?, ?, ?)";
                $stmt = mysqli_stmt_init($conn);

                // IF THERE IS SOME CONNECTION ERROR WITH DATABASE
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    header("Location: ../signup.php?error=sqlerror");
                    exit();

                    // IF CONNECTED SUCCESSFULLY, INSERT USERNAME INTO DATABASE
                } else {
                    // QUICK PASSWORD HASHING (USE THIS METHOD ALWAYS)
                    $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);

                    mysqli_stmt_bind_param($stmt, "sss", $uid, $email, $hashedPwd);
                    mysqli_stmt_execute($stmt);

                    header("Location: ../signup.php?signup=success");
                    exit();
                }
            }
        }
    }
    // NOT NECESSARY BUT JUST IN CASE CLOSE CONNECTIONS MANUALLY
    mysqli_stmt_close($stmt);
    mysqli_close($conn);

    // IF USER SOMEHOW TRY TO SIGNUP WITHOUT PRESSING SIGNUP BUTTON
} else {
    header("Location: ../signup.php");
    exit();
}