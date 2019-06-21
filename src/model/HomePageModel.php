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

class HomePageModel extends PageModel
{

    /**
     * get
     *
     *
     * @return string|bool
     */
    public function get()
    {
        $data = $this->connect();
        if (!is_null($data)) {
            foreach($data as $value){
                if($value['pages']['home'] == 1) {
                  $path = $value['pages']['phppath'];  
                  break;
                }
            } 
            return (isset($path)) ? $path : false;
        } else {
            return false;
        }
    }
    
    /**
     * set
     *
     *
     * @return string|bool
     */
    public function set($id)
    {
        $data = $this->connect();

        foreach ($data as $key => $value) {
            if ($value['pages']['id'] === $id) {
                if($value['pages']['home'] === 0) {
                    $home = 1;
                    $published = 0;
                } else {
                    $home = 0;
                    $published = $value['pages']['published'];
                }
            } else {
                $home = 0;
                $published = $value['pages']['published'];
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
                        'home' => $home
                ]
            );
        }

        $this->disconnect(PageModel::DB, $pages);

    }
    
    /**
     * getStatus
     *
     * @return array
     */
    public function getStatus($id)
    {
        $pages = $this->connect();
        foreach ($pages as $value) {
            
            if ($value['pages']['id'] === $id) {
                $home = $value['pages']['home'];
            }
        }

        if ($home === 1) {
            $array = [
                'page' => 'Unset as homepage',
                'btn' => 'btn-warning',
                'icon' => 'fa-home',
                'set' => false
            ];
        } else {
            $array = [
                'page' => 'Set as homepage',
                'btn' => 'btn-outline-warning',
                'icon' => 'fa-home',
                'set' => true
            ];
        }

        return $array;
    }
    
    
}
