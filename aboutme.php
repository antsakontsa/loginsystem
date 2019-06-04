<?php
require 'header.php';
?>

<main>
    <?php
    // IF USER LOG IN
    if (isset($_SESSION['userId'])) {
    echo "<p>About me page.</p>";
    }
    ?>
</main>

<?php
require 'footer.php';
?>