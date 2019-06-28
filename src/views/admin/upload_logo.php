<?php include 'src/views/partial/sidebar_button.php'; ?>

<div class="card fade-in-fwd">
    <div class="card-body">

    <?php 

        echo $logoForm;

        if (file_exists('data/logo.png')) {
            echo '<div class="col"><a class="btn btn-danger btn-block mt-2" href="admin/remove-logo" role="button">'.$t->trans('Remove logo').'</a></div>';
        }

    ?>

    </div>
</div>

<div class="card fade-in-fwd mt-3">
    <div class="card-body">

    <?php 

        echo $favForm;

        if (file_exists('data/favicon.png')) {
            echo '<div class="col"><a class="btn btn-danger btn-block mt-2" href="admin/remove-fav" role="button">'.$t->trans('Remove favicon').'</a></div>';
        }

    ?>

    </div>
</div>