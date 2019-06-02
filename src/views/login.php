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
    <link rel="stylesheet" type="text/css" href="public/assets/css/doc-pht.css">
    <title>Log in</title>
</head>
<body>
<div class="login-container">
    <form action="login" method="post" name="Login_Form" class="form-signin">
        <a href="<?= BASE_URL ?>"><h1 class="form-signin-heading">DocPHT <i class="fa fa-code" aria-hidden="true"></i></h1></a>
        <label for="inputUsername" class="sr-only">Username</label>
        <input name="Username" type="username" id="inputUsername" class="form-control" placeholder="Username" required autofocus>
        <label for="inputPassword" class="sr-only">Password</label>
        <input name="Password" type="password" id="inputPassword" class="form-control" placeholder="Password" required>
        <div class="checkbox">
            <label class="login-remember">
                <input type="checkbox" value="remember-me"> Remember me
            </label>
        </div>
        <button name="Submit" value="Login" class="btn btn-md btn-secondary btn-block" type="submit">Log in</button>
    </form>
</div>

<!-- jQuery -->
<script src="public/assets/js/jquery-3.4.1.min.js"></script>
<!-- Bootstrap js -->
<script src="public/assets/js/bootstrap.min.js"></script>
</body>
</html>
