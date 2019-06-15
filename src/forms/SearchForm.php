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

class SearchForm 
{
    public function create()
    {
        $searchthis = '';

        if(!empty($_POST['search'])) {
            $searchthis = strtolower(trim($_POST["search"]));

        $jsonFile = new \RecursiveDirectoryIterator("data");
        $jsonFile = new \RecursiveCallbackFilterIterator($jsonFile, [$this, 'filter'] );

            foreach(new \RecursiveIteratorIterator($jsonFile) as $file) {
                $filetypes = ["json"];
                $filetype = pathinfo($file, PATHINFO_EXTENSION);
                if (in_array(strtolower($filetype), $filetypes)) {

                    $string = file_get_contents($file); 
                    $jsonIterator = new \RecursiveIteratorIterator(
                    new \RecursiveArrayIterator(json_decode($string, TRUE)),
                    \RecursiveIteratorIterator::SELF_FIRST);
                    
                    foreach($jsonIterator as $value)  {

                        if (!is_array($value)) 
                        if(!empty($searchthis) && preg_match("#($searchthis)#", strtolower($value)))  {
                    
                            $path = explode('/', $file);
                            $topic = $path[1];
                            $page = $path[2];
                            $page = pathinfo($page, PATHINFO_FILENAME); 
                    
                            similar_text($searchthis, $value, $perc);
                    
                            if (strlen($value) > 500)
                            $value = substr($value, 0, 100) . '...';
                            return '<div class="result-preview">
                                    <a href="page/'.$topic.'/'.$page.'">
                                    <h3 class="result-title">
                                        '.ucfirst(str_replace('-',' ', $topic)).' '.str_replace('-',' ',$page).'
                                    </h3>
                                    <p class="result-subtitle">
                                        '.$value.'
                                    </p>
                                    <small class="badge badge-success">similarity: '.round($perc, 1).'%</small>
                                    </a>
                                </div>
                                <hr>';
                            break;
                        }
                    } 
                }
            }

        } else {
            header('location:'.BASE_URL);
            exit;
        } 
    }

    public function filter($file)
    {
        $exclude = ['doc-pht','pages.json'];
        return ! in_array($file->getFilename(), $exclude);
    }
}
