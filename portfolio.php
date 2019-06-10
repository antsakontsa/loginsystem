<?php
require 'header.php';
?>

<main>
    <?php
    // IF USER LOG IN
    if (isset($_SESSION['userId'])) {
        echo "<p class='white'>You cant see this text if you are not logged in!</p>";
    }
    ?>
</main>

<?php
require 'footer.php';
?>