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
    <link rel="stylesheet" href="public/assets/css/doc-pht.css">
    <!-- Scrollbar Custom CSS -->
    <link rel="stylesheet" href="public/assets/css/scrollbar.min.css">
    <!-- Lightweight, robust, elegant syntax highlighting -->
    <link rel="stylesheet" href="public/assets/css/prism.css">
    <!-- Most popular and easiest to use icon set -->
    <link rel="stylesheet" href="public/assets/css/font-awesome.min.css">
    <!-- Stylesheet fro bootstrap select in form -->
    <link rel="stylesheet" href="public/assets/css/bootstrap-select.min.css">

</head>

<body>

    <div class="wrapper">

    <?php include 'sidebar.php'; ?>

    <!-- Page Content  -->
    <div id="content">
    
    <?php if($this->error->getMessage()) : ?>
    <div class="container">
        <div class="alert alert-info alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <?php echo $this->error->getMessage(); ?>
        </div>
    </div>
    <?php endif; ?>