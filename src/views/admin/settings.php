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


    <?php include 'src/views/partial/sidebar_button.php'; ?>

    <?php $admin = $this->adminModel->checkUserIsAdmin($_SESSION['Username']); ?>

    <div class="card fade-in-fwd">
        <div class="card-body">

            <h3 class="mb-4"><?= $t->trans('Settings') ?></h3>

            <div class="row">

                <div class="col-md-4 grid-margin mb-4">
                    <div class="card bg-docpht d-flex align-items-left">
                        <a href="admin/update-password" class="text-white">
                            <div class="card-body shadow">
                                <div class="d-flex flex-row align-items-left">
                                        <i class="fa fa-lock fa-3x" aria-hidden="true"></i>
                                    <div class="ml-3">
                                        <h6 class="text-white"><?= $t->trans('Change my password'); ?></h6>
                                        <p class="mt-2 text-white card-text"><small><?= $t->trans('Your account'); ?></small></p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-md-4 grid-margin mb-4">
                    <div class="card bg-docpht d-flex align-items-left">
                        <a href="admin/update-email" class="text-white">
                            <div class="card-body shadow">
                                <div class="d-flex flex-row align-items-left">
                                        <i class="fa fa-envelope fa-3x" aria-hidden="true"></i>
                                    <div class="ml-3">
                                        <h6 class="text-white"><?= $t->trans('Update email'); ?></h6>
                                        <p class="mt-2 text-white card-text"><small><?= $t->trans('Your account'); ?></small></p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <?php if (isset($_SESSION['Active']) && $admin == true): ?>
                <div class="col-md-4 grid-margin mb-4">
                    <div class="card bg-docpht d-flex align-items-left">
                        <a href="admin/remove-user" class="text-white">
                            <div class="card-body shadow">
                                <div class="d-flex flex-row align-items-left">
                                        <i class="fa fa-user-times fa-3x" aria-hidden="true"></i>
                                    <div class="ml-3">
                                        <h6 class="text-white"><?= $t->trans('Remove User'); ?></h6>
                                        <p class="mt-2 text-white card-text"><small><?= $t->trans('User list'); ?></small></p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <?php endif ?>

                <?php if (isset($_SESSION['Active']) && $admin == true): ?>
                <div class="col-md-4 grid-margin mb-4">
                    <div class="card bg-docpht d-flex align-items-left">
                        <a href="admin/add-user" class="text-white">
                            <div class="card-body shadow">
                                <div class="d-flex flex-row align-items-left">
                                        <i class="fa fa-user-plus fa-3x" aria-hidden="true"></i>
                                    <div class="ml-3">
                                        <h6 class="text-white"><?= $t->trans('Create a user'); ?></h6>
                                        <p class="mt-2 text-white card-text"><small><?= $t->trans('New account'); ?></small></p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <?php endif ?>

                <?php if (file_exists('data/doc-pht/home.json') && isset($_SESSION['Active']) && $admin == true): ?>
                    <div class="col-md-4 grid-margin mb-4">
                        <div class="card bg-docpht d-flex align-items-left">
                            <a href="admin/create-home" class="text-white">
                                <div class="card-body shadow">
                                    <div class="d-flex flex-row align-items-left">
                                            <i class="fa fa-home fa-3x" aria-hidden="true"></i>
                                        <div class="ml-3">
                                            <h6 class="text-white"><?= $t->trans('Create home page'); ?></h6>
                                            <p class="mt-2 text-white card-text"><small><?= $t->trans('Presentation page'); ?></small></p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                <?php endif ?>

                <div class="col-md-4 grid-margin mb-4">
                    <div class="card bg-docpht d-flex align-items-left">
                        <a href="admin/translations" class="text-white">
                            <div class="card-body shadow">
                                <div class="d-flex flex-row align-items-left">
                                        <i class="fa fa-language fa-3x" aria-hidden="true"></i>
                                    <div class="ml-3">
                                        <h6 class="text-white"><?= $t->trans('Select language'); ?></h6>
                                        <p class="mt-2 text-white card-text"><small><?= $t->trans('Translations'); ?></small></p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-md-4 grid-margin mb-4">
                    <div class="card bg-docpht d-flex align-items-left">
                        <a href="admin" class="text-white" data-toggle="modal" data-target="#shortcuts">
                            <div class="card-body shadow">
                                <div class="d-flex flex-row align-items-left">
                                        <i class="fa fa-bolt fa-3x" aria-hidden="true"></i>
                                    <div class="ml-3">
                                        <h6 class="text-white"><?= $t->trans('Keyboard shortcuts'); ?></h6>
                                        <p class="mt-2 text-white card-text"><small><?= $t->trans('Quick access'); ?></small></p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <?php if (isset($_SESSION['Active']) && $admin == true): ?>
                <div class="col-md-4 grid-margin mb-4">
                    <div class="card bg-docpht d-flex align-items-left">
                        <a href="admin/backup" class="text-white">
                            <div class="card-body shadow">
                                <div class="d-flex flex-row align-items-left">
                                        <i class="fa fa-database fa-3x" aria-hidden="true"></i>
                                    <div class="ml-3">
                                        <h6 class="text-white"><?= $t->trans('Backups'); ?></h6>
                                        <p class="mt-2 text-white card-text"><small><?= $t->trans('Backup management'); ?></small></p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <?php endif ?>

                <?php if (isset($_SESSION['Active']) && $admin == true): ?>
                <div class="col-md-4 grid-margin mb-4">
                    <div class="card bg-docpht d-flex align-items-left">
                        <a href="admin/upload-logo" class="text-white">
                            <div class="card-body shadow">
                                <div class="d-flex flex-row align-items-left">
                                        <i class="fa fa-picture-o fa-3x" aria-hidden="true"></i>
                                    <div class="ml-3">
                                        <h6 class="text-white"><?= $t->trans('Customization'); ?></h6>
                                        <p class="mt-2 text-white card-text"><small><?= $t->trans('Logo & favicon'); ?></small></p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <?php endif ?>

                <?php if (isset($_SESSION['Active']) && $admin == true): ?>
                <div class="col-md-4 grid-margin mb-4">
                    <div class="card bg-docpht d-flex align-items-left">
                        <a href="admin/lastlogins" class="text-white">
                            <div class="card-body shadow">
                                <div class="d-flex flex-row align-items-left">
                                        <i class="fa fa-sign-in fa-3x" aria-hidden="true"></i>
                                    <div class="ml-3">
                                        <h6 class="text-white"><?= $t->trans('Last logins'); ?></h6>
                                        <p class="mt-2 text-white card-text"><small><?= $t->trans('Log'); ?></small></p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <?php endif ?>
                
            </div>
            <?php if (isset($_SESSION['Active']) && $admin == true && $newAppVersion === true): ?>
                <div class="text-center">
                    <a class="btn btn-outline-success" href="https://github.com/docpht/docpht/releases/latest" target="_blank" role="button"><?= $t->trans('New version of <b>DocPHT</b> available'); ?> <i class="fa fa-download" aria-hidden="true"></i></a>
                </div>
            <?php endif ?>
        </div>
    </div>
    <!-- Modal keyboard shortcuts -->
    <div class="modal" id="shortcuts">
            <div class="modal-dialog">
                <div class="modal-content shadow">
                
                    <!-- Modal Header -->
                    <div class="modal-header">
                    <h4 class="modal-title"><?= $t->trans('Available shortcuts'); ?></h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    
                    <!-- Modal body -->
                    <div class="modal-body">
                    <table class="table table-borderless">
                        <thead>
                        <tr>
                            <th><?= $t->trans('Combination'); ?></th>
                            <th><?= $t->trans('Action'); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td><span class="badge badge-secondary">ctrl+alt+p</span></td>
                            <td><?= $t->trans('Create new topic'); ?></td>
                        </tr>
                        <tr>
                            <td><span class="badge badge-secondary">ctrl+alt+s</span></td>
                            <td><?= $t->trans('Hide or show the sidebar'); ?></td>
                        </tr>
                        <tr>
                            <td><span class="badge badge-secondary">ctrl+alt+k</span></td>
                            <td><?= $t->trans('Search'); ?></td>
                        </tr>
                        <tr>
                            <td><span class="badge badge-secondary">ctrl+alt+z</span></td>
                            <td><?= $t->trans('Go back'); ?></td>
                        </tr>
                        <tr>
                            <td><span class="badge badge-secondary">ctrl+alt+enter</span></td>
                            <td><?= $t->trans('Login'); ?></td>
                        </tr>
                        <tr>
                            <td><span class="badge badge-secondary">ctrl+alt+o</span></td>
                            <td><?= $t->trans('Logout'); ?></td>
                        </tr>
                        <tr>
                            <td><span class="badge badge-secondary">ctrl+alt+a</span></td>
                            <td><?= $t->trans('Settings'); ?></td>
                        </tr>
                        <tr>
                            <td><span class="badge badge-secondary">ctrl+alt+e</span></td>
                            <td><?= $t->trans('Add new item to the page'); ?></td>
                        </tr>
                        <tr>
                            <td><span class="badge badge-secondary">ctrl+alt+u</span></td>
                            <td><?= $t->trans('Update the current page'); ?></td>
                        </tr>
                        <tr>
                            <td><span class="badge badge-secondary">ctrl+alt+d</span></td>
                            <td><?= $t->trans('Delete the current page'); ?></td>
                        </tr>
                        </tbody>
                    </table>
                    </div>
                    
                </div>
            </div>
        </div>
