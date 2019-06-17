<?php 

if (isset($values)) {
    foreach ($values as $value) {
        echo $value;
    }
}
$versions = $this->version->create();

$statusPage = $this->pageModel->getStatusPublished();

if (isset($_SESSION['Active']) && $versions['state'] == 0) {
    echo '<ul class="list-inline text-right mt-4">
            '.$versions['value'].'
            <li class="list-inline-item" data-toggle="tooltip" data-placement="bottom" title="'.$t->trans($statusPage['page']).'">
                <a href="page/publish" id="sk-publish" class="btn '.$statusPage['btn'].' btn-sm" role="button"><i class="fa '.$statusPage['icon'].'" aria-hidden="true"></i></a>
            </li>
            <li class="list-inline-item" data-toggle="tooltip" data-placement="bottom" title="'.$t->trans("Update").'">
                <a href="page/update" id="sk-update" class="btn btn-outline-info btn-sm" role="button"><i class="fa fa-pencil-square" aria-hidden="true"></i></a>
            </li>
            <li class="list-inline-item" data-toggle="tooltip" data-placement="bottom" title="'.$t->trans("Delete").'">
                <button type="button" id="sk-delete" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#confirmDelete">
                    <i class="fa fa-trash" aria-hidden="true"></i>
                </button>
            </li>
        </ul>';
} else if (isset($_SESSION['Active']) && $versions['state'] > 0){
    echo '<ul class="list-inline text-right mt-4">
            <li class="list-inline-item" data-toggle="tooltip" data-placement="bottom" title="'.$t->trans($statusPage['page']).'">
                <a href="page/publish" id="sk-publish" class="btn '.$statusPage['btn'].' btn-sm" role="button"><i class="fa '.$statusPage['icon'].'" aria-hidden="true"></i></a>
            </li>
            <li class="list-inline-item" data-toggle="tooltip" data-placement="bottom" title="'.$t->trans("Update").'">
                <a href="page/update" id="sk-update" class="btn btn-outline-info btn-sm" role="button"><i class="fa fa-pencil-square" aria-hidden="true"></i></a>
            </li>
            <li class="list-inline-item" data-toggle="tooltip" data-placement="bottom" title="'.$t->trans("Delete").'">
                <button type="button" id="sk-delete" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#confirmDelete">
                    <i class="fa fa-trash" aria-hidden="true"></i>
                </button>
            </li>
        </ul>';
    echo $versions['value'];
}

?>
            <!-- Modal confirm delete -->
            <div class="modal" id="confirmDelete">
                <div class="modal-dialog">
                <div class="modal-content shadow">
                
                    <!-- Modal Header -->
                    <div class="modal-header">
                    <h4 class="modal-title"><?= $t->trans('Warning'); ?></h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    
                    <!-- Modal body -->
                    <div class="modal-body">
                    <?= $t->trans('Confirm delete?'); ?>
                    </div>
                    
                    <!-- Modal footer -->
                    <div class="modal-footer">
                    <a href="page/delete" class="btn btn-success" role="button"><?= $t->trans('Yes'); ?></a>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><?= $t->trans('No'); ?></button>
                    </div>
                    
                </div>
                </div>
            </div>