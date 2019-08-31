<?php

/**
 * This file is part of the DocPHT project.
 * 
 * @author Valentino Pesce
 * @copyright (c) Valentino Pesce <valentino@iltuobrand.it>
 * @copyright (c) Craig Crosby <creecros@gmail.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

?>

<!DOCTYPE html>
<html>
<head>
    <base href="<?= BASE_URL ?>">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link rel="stylesheet" href="public/assets/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="public/assets/css/bootstrap.min.css">
    <?php
    $cssFile = (!isset($_COOKIE["theme"])) ? 'light' : $_COOKIE["theme"] ;
    echo '<link type="text/css" rel="stylesheet" href="public/assets/css/doc-pht.'.$cssFile.'.css" />';
    ?>
    <link rel="stylesheet" href="public/assets/css/switch.css">
    <!-- Favicon -->
    <?php
        if (file_exists('data/favicon.png')) {
            echo '<link id="fav" rel="icon" type="image/png" href="data/favicon.png?'.time().'">';
        }
    ?>
    <title><?= ucfirst(str_replace('-',' ',$PageTitle)) ?></title>
</head>
<body>
