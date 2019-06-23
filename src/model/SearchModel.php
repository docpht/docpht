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
 *
 *
 */
namespace DocPHT\Model;

use DocPHT\Lib\DocBuilder;
use DocPHT\Model\PageModel;

class SearchModel extends PageModel
{
    public function feed()
    {
        $data = $this->getAllIndexed();
        $array = [];
        if($data !== false){
            foreach ($data as $value) {
                if(!empty($value['id'])) {
                    (!empty($value['topic'])) ? array_push($array, $this->add($value['id'], $value['topic'])) : $array;
                    (!empty($value['topic'])) ? array_push($array, $this->add($value['id'], $value['filename'])) : $array;
                }
                foreach($this->getPageData($value['id']) as $page) {
                    (!empty($page['v1'])) ? array_push($array,$this->add($value['id'], $page['v1'])) : $array;
                    (!empty($page['v2'])) ? array_push($array,$this->add($value['id'], $page['v2'])) : $array;
                    (!empty($page['v3'])) ? array_push($array,$this->add($value['id'], $page['v3'])) : $array;
                    (!empty($page['v4'])) ? array_push($array,$this->add($value['id'], $page['v4'])) : $array;
                    if($page['key'] === 'codeFile' || $page['key'] === 'markdownFile') {
                        (!empty($page['v1'])) ? array_push($array, $this->add($value['id'], file_get_contents('data/'.$page['v1']))) : $array;
                    }
                }
            }
        }
        $this->disconnect('data/search.json',$array);
    }
    
    public function add($id, $content)
    {
        return [
                    'id' => $id,
                    'content' => $content
                ];
    }
}