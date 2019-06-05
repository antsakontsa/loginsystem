<?php
require 'header.php';
?>

<main>
    <?php
    // IF USER LOG IN
    if (isset($_SESSION['userId'])) {
        // IF USER LOG OUT
    } else {
        echo '<form action="includes/signup.inc.php" method="POST" id="signup-form">
                <input type="text" name="uid" placeholder="Username">
                <input type="text" name="email" placeholder="E-mail">
                <input type="password" name="pwd" placeholder="Password">
                <input type="password" name="repwd" placeholder="Password again">
                <button type="submit" name="signup-submit">Signup</button>
            </form>';

        // DISPLAY ERROR ON PAGE, DEPENDING ON WHICH ERROR USER GETS
        if (isset($_GET['error'])) {
            if ($_GET['error'] == "emptyfields") {
                echo '<p>Fill in all fields!</p>';
            } else if ($_GET['error'] == "invaliduidmail") {
                echo '<p>Invalid username AND e-mail!</p>';
            } else if ($_GET['error'] == "invaliduid") {
                echo '<p>Invalid username!</p>';
            } else if ($_GET['error'] == "invalidemail") {
                echo '<p>Invalid e-mail!</p>';
            } else if ($_GET['error'] == "passwordcheck") {
                echo '<p>Passwords do not match!</p';
            } else if ($_GET['error'] == "usertaken") {
                echo '<p>Username is already taken.</p>';
            }

            // IF USER CREATED SUCCESSFULLY
        } else if (isset($_GET['signup'])) {
            echo '<p>Signup succesful!</p>';
        }
    }
    ?>
</main>

<?php
require 'footer.php';
?>