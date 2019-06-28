<!DOCTYPE html>
<html>

<head>
    <base href="<?= BASE_URL ?>">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title><?= ucfirst(str_replace('-',' ',$PageTitle)) ?></title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="public/assets/css/bootstrap.min.css" >
    <!-- jQuery-UI CSS -->
    <link rel="stylesheet" href="public/assets/css/jquery-ui.min.css">
    <!-- Custom CSS -->
    <?php
    $cssFile = (!isset($_COOKIE["theme"])) ? 'light' : $_COOKIE["theme"] ;
    echo '<link type="text/css" rel="stylesheet" href="public/assets/css/doc-pht.'.$cssFile.'.css" />';
    ?>
    <link rel="stylesheet" href="public/assets/css/switch.css">
    <link rel="stylesheet" href="public/assets/css/animation.css">
    <!-- Scrollbar Custom CSS -->
    <link rel="stylesheet" href="public/assets/css/scrollbar.min.css">
    <!-- Lightweight, robust, elegant syntax highlighting -->
    <link rel="stylesheet" href="public/assets/css/prism.css">
    <!-- Most popular and easiest to use icon set -->
    <link rel="stylesheet" href="public/assets/css/font-awesome.min.css">
    <!-- Stylesheet fro bootstrap select in form -->
    <link rel="stylesheet" href="public/assets/css/bootstrap-select.min.css">
    <!-- Favicon -->
    <?php
        if (file_exists('data/favicon.png')) {
            echo '<link id="fav" rel="icon" type="image/png" href="data/favicon.png?'.time().'">';
        }
    ?>
    
</head>

<body>

    <div class="wrapper">

    <div class="progress-container">
        <div class="progress-bar" id="scrollindicator"></div>
    </div>

    <?php include 'sidebar.php'; ?>

    <!-- Page Content  -->
    <div id="content">
    <div class="container-fluid">
        
    <?php if($this->msg->display()) : ?>
        <?php echo $this->msg->display(); ?>
    <?php endif; ?>