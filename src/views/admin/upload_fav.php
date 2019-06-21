<?php include 'src/views/partial/sidebar_button.php'; ?>

<div class="card">
    <div class="card-body">

    <?php 

        echo $form;

        if (file_exists('data/fav.png')) {
            echo '<div class="col"><a class="btn btn-danger btn-block mt-2" href="admin/remove-fav" role="button">'.$t->trans('Remove favicon').'</a></div>';
        }

    ?>

    </div>
</div>