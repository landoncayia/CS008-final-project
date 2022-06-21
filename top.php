<?php
$phpSelf = htmlentities($_SERVER['PHP_SELF'], ENT_QUOTES, 'UTF-8');

$path_parts = pathinfo($phpSelf);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Picture Studios</title>
        <meta charset="UTF-8">
        <meta name="author" content="Landon Cayia, Lauren Paicopolis, and Natalie Barton">
        <meta name="description" content="Photography Website">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <link rel="stylesheet" href="../style/final.css?version=<?php print time(); ?>" type="text/css" media="screen">
        <link rel="icon" href="../images/photo-camera.ico">
        <style>
            @import url('https://fonts.googleapis.com/css?family=Roboto');
        </style>

<?php

// PATH SETUP

$domain = '//';

$server = htmlentities($_SERVER['SERVER_NAME'], ENT_QUOTES, 'UTF-8');

$domain .= $server;

// INCLUDE LIBRARY FILES

print PHP_EOL . '<!-- include libraries -->' . PHP_EOL;

require_once 'lib/security.php';

include_once 'lib/validation-functions.php';

include_once 'lib/mail-message.php';

print PHP_EOL . '<!-- finished including libraries -->' . PHP_EOL;

if ($path_parts['filename'] == 'about') {
    print '<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
        <script src="../js/jquery.flexslider.js"></script>

        <script type="text/javascript">
            var flexsliderStylesLocation = "../style/flexslider.css";
            $(\'<link rel="stylesheet" type="text/css" href="\' + flexsliderStylesLocation + \'" >\').appendTo("head");
            $(window).load(function() {

                $(\'.flexslider\').flexslider({
                    animation: "fade",
                    slideshowSpeed: 3000,
                    animationSpeed: 1000
                });

            });
        </script>';
}
?>
    </head>

<!-- Body Section -->
<?php
print '<body id="' . $path_parts['filename'] . '">' . PHP_EOL;

include 'nav.php';
print PHP_EOL;

include 'header.php';
print PHP_EOL;

print '<!-- End of top.php -->';
?>

<!-- Main Section -->
<?php print PHP_EOL; ?>