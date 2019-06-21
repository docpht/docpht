<?php include 'src/views/partial/sidebar_button.php'; ?>

<div class="card">
    <div class="card-body">

    <?php 

        echo $form;

        if (file_exists('data/logo.png')) {
            echo '<div class="col"><a class="btn btn-danger btn-block mt-2" href="admin/remove-logo" role="button">'.$t->trans('Remove logo').'</a></div>';
        }

    ?>

    </div>
</div>