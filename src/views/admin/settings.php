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

<div class="container-fluid">
    <div class="mb-4">
        <button type="button" id="sidebarCollapse" class="btn btn-secondary">
            <i class="fa fa-align-left"></i>
        </button>
    </div>
    <div class="card">
        <div class="card-body">

            <h3 class="mb-4">Settings</h3>
            
            <?php if (isset($_GET['good'])): ?>
               <div class="alert alert-success alert-dismissible">
                    <i class="fa fa-check-circle" aria-hidden="true"></i>
                    <a href="admin" class="close" role="button">&times;</a>
                    <?= $_GET['good'];  ?>
                </div>
            <?php elseif (isset($_GET['bad'])): ?>
                <div class="alert alert-danger alert-dismissible">
                    <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                    <a href="admin" class="close" role="button">&times;</a>
                    <?= $_GET['bad'];  ?>
                </div>
            <?php else: ?>
                <!--  -->
            <?php endif ?>

            <div class="row">

                <div class="col-md-4 grid-margin mb-4">
                    <div class="card bg-docpht d-flex align-items-left">
                        <a href="admin/update-password" class="text-white">
                            <div class="card-body shadow">
                                <div class="d-flex flex-row align-items-left">
                                        <i class="fa fa-lock fa-3x" aria-hidden="true"></i>
                                    <div class="ml-3">
                                        <h6 class="text-white">Change my password</h6>
                                        <p class="mt-2 text-white card-text"><small>Your account</small></p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <?php //if (isset($_SESSION['Active']) && $_SESSION['Username'] == ADMIN): ?>
                <div class="col-md-4 grid-margin mb-4">
                    <div class="card bg-docpht d-flex align-items-left">
                        <a href="admin/remove-user" class="text-white">
                            <div class="card-body shadow">
                                <div class="d-flex flex-row align-items-left">
                                        <i class="fa fa-user-times fa-3x" aria-hidden="true"></i>
                                    <div class="ml-3">
                                        <h6 class="text-white">Remove User</h6>
                                        <p class="mt-2 text-white card-text"><small>User list</small></p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <?php //endif ?>

                <?php //if (isset($_SESSION['Active']) && $_SESSION['Username'] == ADMIN): ?>
                <div class="col-md-4 grid-margin mb-4">
                    <div class="card bg-docpht d-flex align-items-left">
                        <a href="admin/add-user" class="text-white">
                            <div class="card-body shadow">
                                <div class="d-flex flex-row align-items-left">
                                        <i class="fa fa-user-plus fa-3x" aria-hidden="true"></i>
                                    <div class="ml-3">
                                        <h6 class="text-white">Create a user</h6>
                                        <p class="mt-2 text-white card-text"><small>New account</small></p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <?php //endif ?>

                <?php //if (file_exists('data/doc-pht/home.json') && isset($_SESSION['Active']) && $_SESSION['Username'] == ADMIN): ?>
                    <div class="col-md-4 grid-margin mb-4">
                        <div class="card bg-docpht d-flex align-items-left">
                            <a href="admin/create-home" class="text-white">
                                <div class="card-body shadow">
                                    <div class="d-flex flex-row align-items-left">
                                            <i class="fa fa-home fa-3x" aria-hidden="true"></i>
                                        <div class="ml-3">
                                            <h6 class="text-white">Create home page</h6>
                                            <p class="mt-2 text-white card-text"><small>Presentation page</small></p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                <?php //endif ?>

                <div class="col-md-4 grid-margin mb-4">
                    <div class="card bg-docpht d-flex align-items-left">
                        <a href="admin/translations" class="text-white">
                            <div class="card-body shadow">
                                <div class="d-flex flex-row align-items-left">
                                        <i class="fa fa-language fa-3x" aria-hidden="true"></i>
                                    <div class="ml-3">
                                        <h6 class="text-white">Select language</h6>
                                        <p class="mt-2 text-white card-text"><small>Translations</small></p>
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
                                        <h6 class="text-white">Keyboard shortcuts</h6>
                                        <p class="mt-2 text-white card-text"><small>Quick access</small></p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

            </div>

        </div>
    </div>
    <!-- Modal keyboard shortcuts -->
    <div class="modal" id="shortcuts">
            <div class="modal-dialog">
                <div class="modal-content">
                
                    <!-- Modal Header -->
                    <div class="modal-header">
                    <h4 class="modal-title">Available shortcuts</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    
                    <!-- Modal body -->
                    <div class="modal-body">
                    <table class="table table-borderless">
                        <thead>
                        <tr>
                            <th>Combination</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td><code>ctrl+alt+p</code></td>
                            <td>Create new topic</td>
                        </tr>
                        <tr>
                            <td><code>ctrl+alt+s</code></td>
                            <td>Hide or show the sidebar</td>
                        </tr>
                        <tr>
                            <td><code>ctrl+alt+k</code></td>
                            <td>Search</td>
                        </tr>
                        <tr>
                            <td><code>ctrl+alt+z</code></td>
                            <td>Go back</td>
                        </tr>
                        <tr>
                            <td><code>ctrl+alt+enter</code></td>
                            <td>Login</td>
                        </tr>
                        <tr>
                            <td><code>ctrl+alt+o</code></td>
                            <td>Logout</td>
                        </tr>
                        <tr>
                            <td><code>ctrl+alt+a</code></td>
                            <td>Settings</td>
                        </tr>
                        <tr>
                            <td><code>ctrl+alt+e</code></td>
                            <td>Add new item to the page</td>
                        </tr>
                        <tr>
                            <td><code>ctrl+alt+u</code></td>
                            <td>Update the current page</td>
                        </tr>
                        <tr>
                            <td><code>ctrl+alt+d</code></td>
                            <td>Delete the current page</td>
                        </tr>
                        </tbody>
                    </table>
                    </div>
                    
                </div>
            </div>
        </div>
</div>