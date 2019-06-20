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

class HomePageForm extends MakeupForm
{
    public function set()
    {
        $id = $_SESSION['page_id'];
        $this->homePageModel->set($id);
        header('Location:'.$this->pageModel->getTopic($id).'/'.$this->pageModel->getFilename($id));
        exit;
    }
}
