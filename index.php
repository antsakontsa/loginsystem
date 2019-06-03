<?php
require 'header.php';
?>

<main>
    <?php
    // IF USER LOG IN
    if (isset($_SESSION['userId'])) {
        echo "<p>You are logged in.</p>";
    
    // IF USER LOG OUT
    } else {
        echo "<p>You are not logged in.</p>";
    }
    ?>
</main>

<?php
require 'footer.php';
?>