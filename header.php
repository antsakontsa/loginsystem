<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>

<body>
    <header>
        <nav>
            <div>
                <?php
                // IF USER LOG IN
                if (isset($_SESSION['userId'])) {
                    echo '<ul>
                            <li><a href="index.php">Home</a></li>
                            <li><a href="portfolio.php">Portfolio</a></li>
                            <li><a href="aboutme.php">About me</a></li>
                            <li><a href="contact.php">Contact</a></li>
                            
                            <form action="includes/logout.inc.php" method="POST">
                                <button type="submit" name="logout-submit">Logout</button>
                            </form
                        </ul>';

                    // IF USER LOG OUT OR ISN'T LOGGED IN YET
                } else {
                    // DISPLAY LOGIN FORM
                    echo '<form action="includes/login.inc.php" method="POST" id="login-form">
                            <input type="text" name="mailuid" placeholder="Username/E-mail...">
                            <input type="password" name="pwd" placeholder="Password...">
                            <button type="submit" name="login-submit" id="login-submit">Login</button>
                        </form>';
                }
                ?>
            </div>
        </nav>
    </header>