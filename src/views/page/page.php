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


    $pages = $this->pageModel->connect();
    $id = $_SESSION['page_id'];
    $lastPage = count($pages);

    $filertPages = array_filter($pages, function ($var) {
        return ($var['pages']['published'] ===  1);
    });

    $reindexedPages = array_values($filertPages);

    foreach ($reindexedPages as $key => $val) { 
        if ($pages[$key]['pages']['id'] === $id && $key < $lastPage - 1) {
                $next = $reindexedPages[$key + 1]['pages']['slug'];
                $nextPage = $reindexedPages[$key + 1]['pages']['filename'];
        }
        if ($pages[$key]['pages']['id'] === $id && $key > 0) {
                $prev = $reindexedPages[$key - 1]['pages']['slug'];
                $prevPage = $reindexedPages[$key - 1]['pages']['filename'];
        }
    }

?>
            
            <div class="mt-4">
                    <nav aria-label="pagination">
                        <ul class="pagination justify-content-center">
                            <li class="page-item">
                            <?php if (isset($prev) && isset($prevPage)): ?>
                                <a class="page-link text-muted" href="<?= 'page/'.$prev ?>"><i class="fa fa-angle-double-left" aria-hidden="true"></i> <?= $prevPage ?></a>
                            <?php endif; ?>
                            </li>

                            <li class="page-item">
                            <?php if (isset($next) && isset($nextPage)): ?>
                                <a class="page-link text-muted" href="<?= 'page/'.$next ?>"><?= $nextPage ?> <i class="fa fa-angle-double-right" aria-hidden="true"></i></a>
                            <?php endif; ?>
                            </li>
                        </ul>
                    </nav>
            </div>
           

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