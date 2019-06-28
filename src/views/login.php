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
    <title><?= $t->trans('Login'); ?></title>
</head>
<body>
<div class="login-container text-center">
    <form action="login" method="post" name="Login_Form" class="form-signin">
        <?php 
            if (file_exists('data/logo.png')) {
                echo '<a href="'.BASE_URL.'"><img id="logo" src="data/logo.png?'.time().'" alt="logo" class="img-fluid mb-3"></a>';
            } else {
                echo '<a href="'.BASE_URL.'"><h1>'.TITLE.' <i class="fa fa-code" aria-hidden="true"></i></h3></a>';
            }
        ?>
        <label for="inputUsername" class="sr-only"><?= $t->trans('Username'); ?></label>
        <input name="Username" type="email" id="inputUsername" class="form-control" placeholder="Email" required autofocus>
        <label for="inputPassword" class="sr-only"><?= $t->trans('Password'); ?></label>
        <input name="Password" type="password" id="inputPassword" class="form-control" placeholder="Password" required>
        <div class="checkbox">
            <label class="login-remember">
                <input type="checkbox" value="remember-me"> <?= $t->trans('Remember me'); ?>
            </label>
        </div>
        <button name="Submit" value="Login" class="btn btn-md btn-secondary btn-block" type="submit"><?= $t->trans('Login'); ?></button>
        <a href="<?= BASE_URL ?>lost-password" class="text-muted"><?= $t->trans('I lost my password') ?></a>
    </form>
</div>

<!-- jQuery -->
<script src="public/assets/js/jquery-3.4.1.min.js"></script>
<!-- Bootstrap js -->
<script src="public/assets/js/bootstrap.min.js"></script>
</body>
</html>
