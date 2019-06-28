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

        <?php if (isset($_SESSION['Active'])) : ?>

            <?php $backupsList = $this->backupsModel->getBackups(); ?>
            
                  <div class="card fade-in-fwd bg-light text-dark mb-4 mt-4">
                    <div class="card-body text-center">
                    <p class="card-text"><?= $t->trans("Backup management") ?></p>
                    <form class="d-flex">
                        
                      <div class="input-group mb-2 mr-sm-2 mr-1">
                        <div class="input-group-prepend">
                          <div class="input-group-text"><?= $t->trans("Backup") ?></div>
                        </div>
                        <select id="rbbackup" name="backup" class="custom-select" required>
                        <?php if (!empty($backupsList)) : ?>
                          <option value="" selected disabled><?= $t->trans("Select a backup") ?></option>
                        <?php else : ?>
                          <option value="" selected disabled><?= $t->trans("There are no backups") ?></option>
                        <?php endif ?>
                            <?php if (!empty($backupsList)) : ?>
                                  <?php foreach($backupsList as $backup) : ?>
                                        <option value="<?= $backup['path'] ?>"><?= date(DATAFORMAT, $backup['date']) ?></option>
                                  <?php endforeach; ?>
                            <?php endif ?>
                        </select>
                      </div>
                      <?php if (!empty($backupsList)) : ?>
                        <button type="submit" form="rmb" class="btn btn-primary mb-2 mr-2 text-light" data-toggle="tooltip" data-placement="bottom" title="<?= $t->trans("Restore from backup") ?>">
                          <i class="fa fa-window-restore" aria-hidden="true"></i>
                        </button>
                      <?php endif ?> 
                      
                      </form>

                    <?php if (!empty($backupsList)) : ?>
                      <form id="rmb" action="admin/backup/restore" method="post" class="d-flex">
                      <input type="hidden" id="rmbhidden" name="backup">
                      </form>
                    <?php endif ?>
                    
                      <div class="d-flex justify-content-center">
                          <?php if (!empty($backupsList)) : ?>
                            <form id="db" action="admin/backup/delete" method="post">
                                <input type="hidden" id="dbhidden" name="backup">
                                <button type="submit" form="db" class="btn btn-danger mr-2 text-light" role="button" data-toggle="tooltip" data-placement="bottom" title="<?= $t->trans("Remove backup") ?>" onclick="return confirmationRemoval()">
                                    <i class="fa fa-remove" aria-hidden="true"></i>
                                </button>
                            </form>
                          <?php endif ?>
                            <form id="ib" action="admin/backup/import" method="post">
                                <input type="hidden" id="ibhidden" name="backup">
                                <button type="submit" form="ib" class="btn btn-secondary mb-2 mr-2" data-toggle="tooltip" data-placement="bottom" title="<?= $t->trans("Import a backup") ?>">
                                <i class="fa fa-upload" aria-hidden="true"></i>
                                </button>
                            </form>
                          <?php if (!empty($backupsList)) : ?>
                            <form id="eb" action="admin/backup/export" method="post">
                                <input type="hidden" id="ebhidden" name="backup">
                                <button type="submit" form="eb" class="btn btn-secondary mr-2" data-toggle="tooltip" data-placement="bottom" title="<?= $t->trans("Export a backup") ?>">
                                <i class="fa fa-download" aria-hidden="true"></i>
                                </button>
                            </form>
                          <?php endif ?>
                            <a href="admin/backup/save" class="btn btn-success mb-2 mr-2 text-light" role="button" data-toggle="tooltip" data-placement="bottom" title="<?= $t->trans("Save backup") ?>">
                              <i class="fa fa-floppy-o" aria-hidden="true"></i>
                            </a>
                        </div>
                    </div>
                  </div>

        <?php endif ?> 