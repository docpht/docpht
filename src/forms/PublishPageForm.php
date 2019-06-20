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

        foreach ($pages as $key => $value) {

            if ($value['pages']['id'] === $id) {
                if ($value['pages']['published'] === 0 && $value['pages']['home'] !== 1) {
                    $published = 1;
                } else {
                    $published = 0;
                }
                $pages[$key] = array(
                    'pages' => [
                        'id' => $value['pages']['id'],
                        'slug' => $value['pages']['slug'],
                        'topic' => $value['pages']['topic'],
                        'filename' => $value['pages']['filename'],
                        'phppath' => $value['pages']['phppath'],
                        'jsonpath' => $value['pages']['jsonpath'],
                        'published' => $published,
                        'home' => $value['pages']['home']
                    ]
                );
            }

            $this->pageModel->disconnect('data/pages.json', $pages);
        }
    
        
        header('Location:'.$this->pageModel->getTopic($id).'/'.$this->pageModel->getFilename($id));
        exit;
    }
}
