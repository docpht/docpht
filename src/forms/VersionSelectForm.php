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

namespace DocPHT\Form;

use DocPHT\Core\Translator\T;

class VersionSelectForm extends MakeupForm
{
    public function create()
    {
        if (isset($_SESSION['Active']) && isset($_SESSION['page_id'])) {
            $id = $_SESSION['page_id'];
            
            $versionList = $this->versionModel->getVersions($id);
            
            if (!empty($versionList)) {
                $versionSelect = '
                <div style="margin-top: 100px;">
                  <div class="card bg-light text-dark mb-4 mt-4">
                    <div class="card-body text-center">
                    <p class="card-text">'.T::trans("Version management").'</p>
                    <form id="rv" action="page/restore-version" method="post" class="d-flex">
            
                      <div class="input-group mb-2 mr-sm-2 mr-1">
                        <div class="input-group-prepend">
                          <div class="input-group-text">'.T::trans("Version").'</div>
                        </div>
                        <select id="rvselect" name="version" class="custom-select" required>
                        <option value="" selected disabled>'.T::trans("Select a version").'</option>';
                                  foreach($versionList as $version) {
                                    $versionSelect .= '<option value="' . $version['path'] .'">' . date(DATAFORMAT, $version['date']) . '</option>';
                                  }
                            $versionSelect .= 
                        '</select>
                      </div>
                        <button type="submit" form="rv" class="btn btn-primary mb-2 mr-2 text-light" data-toggle="tooltip" data-placement="bottom" title="'.T::trans("Restore version").'" title="'.T::trans("Restore version").'">
                          <i class="fa fa-window-restore" aria-hidden="true"></i>
                        </button>
                      </form>
                      <div class="d-flex justify-content-center">
                            <form id="dv" action="page/delete-version" method="post">
                                <input type="hidden" id="dvhidden" name="version">
                                <button type="submit" form="dv" class="btn btn-danger mr-2 text-light" role="button" data-toggle="tooltip" data-placement="bottom" title="'.T::trans("Remove version").'" title="'.T::trans("Remove version").'">
                                    <i class="fa fa-remove" aria-hidden="true"></i>
                                </button>
                            </form>
                            <form id="iv" action="page/import-version" method="post">
                                <input type="hidden" id="ivhidden" name="version">
                                <button type="submit" form="iv" class="btn btn-secondary mb-2 mr-2" data-toggle="tooltip" data-placement="bottom" title="'.T::trans("Import a version").'" title="'.T::trans("Import a version").'">
                                <i class="fa fa-upload" aria-hidden="true"></i>
                                </button>
                            </form>
                            <form id="ev" action="page/export-version" method="post">
                                <input type="hidden" id="evhidden" name="version">
                                <button type="submit" form="ev" class="btn btn-secondary mr-2" data-toggle="tooltip" data-placement="bottom" title="'.T::trans("Export a version").'" title="'.T::trans("Export a version").'">
                                <i class="fa fa-download" aria-hidden="true"></i>
                                </button>
                            </form>
                            <a href="page/save-version" class="btn btn-success mb-2 mr-2 text-light" role="button" data-toggle="tooltip" data-placement="bottom" title="'.T::trans("Save version").'" title="'.T::trans("Save version").'">
                              <i class="fa fa-floppy-o" aria-hidden="true"></i>
                            </a>
                        </div>
                    </div>
                  </div>
                </div>';
                
                return ['value' => $versionSelect, 'state' => 2];
            } else {
                $versionSave = '
                  <li class="list-inline-item" data-toggle="tooltip" data-placement="bottom" title="'.T::trans("Save version").'">
                      <a href="page/save-version" class="btn btn-outline-secondary btn-sm" role="button"><i class="fa fa-floppy-o" aria-hidden="true"></i></a>
                  </li>';
                  
                return ['value' => $versionSave, 'state' => 0];    
            }
        
        } else {
            $versionSelect = '';
            
            return ['value' => $versionSelect, 'state' => 1];
        }
    }
}   