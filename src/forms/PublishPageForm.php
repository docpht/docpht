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

class PublishPageForm extends MakeupForm
{
    public function publish()
    {
        $id = $_SESSION['page_id'];
        $pages = $this->pageModel->connect();

        foreach ($pages as $val) {
            if ($val['pages']['id'] === $id) {

                if ($val['pages']['published'] === 0) {
                    $val['pages']['published'] = $val['pages']['published'] + 1;
                } else {
                    $val['pages']['published'] = $val['pages']['published'] - 1;
                }
            } 
            
            $path = $this->pageModel->getPhpPath($id);
            $this->pageModel->disconnect('data/pages.json', [$val]);
        }
        
        header('Location:'.$this->pageModel->getTopic($id).'/'.$this->pageModel->getFilename($id));
        exit;
    }
}
