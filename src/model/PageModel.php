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
 * connect()
 * connectPageData($id)
 * create($topic, $filename)
 * getPagesByTopic($topic)
 * getPublishedPagesByTopic($topic)
 * getUniqTopics()
 * getUniqPublishedTopics()
 * getPhpPath($id)
 * getSlug($id)
 * getJsonPath($id)
 * getAllFromKey($key)
 * getAllFromDataKey($data, $key)
 * getAllPublishedFromKey($key)
 * getAllIndexed()
 * getId($path)
 * getTopic($id)
 * getFilename($id)
 * getPageData($id)
 * putPageData($id, $data)
 * addPageData($id, $array)
 * modifyPageData($id, $index, $array)
 * removePageData($id, $index)
 * insertPageData($id, $index, $before_or_after, $array)
 * remove($id)
 * disconnect($path, $data)
 * findKey($data, $search)
 * hideBySlug($slug)
 * getStatusPublished()
 */
namespace DocPHT\Model;

use DocPHT\Core\Translator\T;

class PageModel
{
    const DB = 'data/pages.json';
    
    
    /**
     * connect
     *
     * 
     * @return array
     */
    public function connect()
    {
		if(!file_exists(self::DB))
		{
		    file_put_contents(self::DB,[]);
		} 
		
		return json_decode(file_get_contents(self::DB),true);
    }
    
    /**
     * connectPageData
     *
     * @param  string $id
     * 
     * @return array
     */
    public function connectPageData($id)
    {
        $path = $this->getJsonPath($id);
        
        if (isset($path)) {
            if (!file_exists(pathinfo($path, PATHINFO_DIRNAME))) {
                mkdir(pathinfo($path, PATHINFO_DIRNAME), 0755, true);
            }
            
            if(!file_exists($path))
            {
                file_put_contents($path,array(
                    
                    ));
            } 
            
            return json_decode(file_get_contents(realpath($path)),true);
        }
    }
    
    /**
     * create
     *
     * @param  string $topic
     * @param  string $filename
     *
     * @return string
     */
    public function create($topic, $filename)
    {
        $data = $this->connect();
        $id = uniqid();
        $topic = strtolower(str_replace(' ', '-', pathinfo($topic, PATHINFO_FILENAME) ));
		$filename = strtolower(str_replace(' ', '-', pathinfo($filename, PATHINFO_FILENAME)));
        $slug = preg_replace('/[^a-z0-9]+/i', '-', trim(strtolower($topic))) .'/'. preg_replace('/[^a-z0-9]+/i', '-', trim(strtolower($filename)));

        if (!is_null($data)) {
            
            $slugs = $this->getAllFromKey('slug');

            if (is_array($slugs)) {
                if(in_array($slug, $slugs))
                {
                    $count = 1;
                    while(in_array(($slug . '-' . ++$count ), $slugs));
                    $slug = $slug . '-' . $count;
                    $filename = $filename . '-' . $count;
                }
            };
        }   
        
		$phpPath = 'pages/'.$slug.'.php';
        $jsonPath = 'data/'.$slug.'.json';
        
        $data[] = array(
            'pages' => [
                    'id' => $id,
                    'slug' => $slug,
                    'topic' => $topic,
                    'filename' => $filename,
                    'phppath' => $phpPath,
                    'jsonpath' => $jsonPath,
                    'published' => 0,
                    'home' => 0
            ]);
            
            
        $this->connectPageData($id);
        $this->disconnect(self::DB, $data);
        
		return $id;
    }

    /**
     * getPagesByTopic
     *
     * @param  string $topic
     *
     * @return array|bool
     */
    public function getPagesByTopic($topic)
    {
        $data = $this->connect();
        if (!is_null($data)) {
            foreach($data as $value){
                if($value['pages']['topic'] === $topic) {
                  $array[] = $value['pages'];  
                }
            } 
            usort($array, function($a, $b) {
                return $a['topic'] <=> $b['topic'];
            });
            return (isset($array)) ? $array : false;
        } else {
            return false;
        }
    }

    /**
     * getPublishedPagesByTopic
     *
     * @param  string $topic
     *
     * @return array|bool
     */
    public function getPublishedPagesByTopic($topic)
    {
        $data = $this->connect();
        if (!is_null($data)) {
            foreach($data as $value){
                if($value['pages']['topic'] == $topic && $value['pages']['published'] == 1) {
                  $array[] = $value['pages'];  
                }
            } 
            usort($array, function($a, $b) {
                return $a['topic'] <=> $b['topic'];
            });
            return (isset($array)) ? $array : false;
        } else {
            return false;
        }
    }

    /**
     * getUniqTopics
     * 
     * @return array|bool
     */
    public function getUniqTopics()
    {
        $data = $this->connect();
        $array = $this->getAllFromKey('topic');
        if (is_array($array) && !is_null($array)) {
            $array = array_unique($array);
            sort($array);
            return (isset($array)) ? $array : false;
        } else {
            return false;
        } 
    }

    /**
     * getUniqPublishedTopics
     * 
     * @return array|bool
     */
    public function getUniqPublishedTopics()
    {
        $data = $this->connect();
        $array = $this->getAllPublishedFromKey('topic');
        if (is_array($array) && !is_null($array)) {
            $array = array_unique($array);
            sort($array);
            return (isset($array)) ? $array : false;
        } else {
            return false;
        } 
    }
    
    /**
     * getPhpPath
     *
     * @param  string $id
     *
     * @return string
     */
    public function getPhpPath($id)
    {
        $data = $this->connect();
        $key = $this->findKey($data, $id);

        return $data[$key]['pages']['phppath'];
    }
    
    /**
     * getSlug
     *
     * @param  string $id
     *
     * @return string
     */
    public function getSlug($id)
    {
        $data = $this->connect();
        $key = $this->findKey($data, $id);

        return $data[$key]['pages']['slug'];
    }
    
    /**
     * getJsonPath
     *
     * @param  string $id
     *
     * @return string
     */
    public function getJsonPath($id)
    {
        $data = $this->connect();
        $key = $this->findKey($data, $id);
        
        if (isset($data[$key])) {
            return $data[$key]['pages']['jsonpath'];
        }
    }    
    
    /**
     * getAllFromKey
     * 
     * @param string $key
     * 
     * @return array|bool
     */
    public function getAllFromKey($key)
    {
        $data = $this->connect();
        if (!is_null($data) && !empty($data)) {
            foreach($data as $value){
                $array[] = $value['pages'][$key];
            } 
            return $array;
        } else {
            return false;
        }
    }   
    
    /**
     * getAllFromDataKey
     * 
     * @param array $data
     * @param string $key
     * 
     * @return array|bool
     */
    public function getAllFromDataKey($data, $key)
    {
        if (!is_null($data) && !empty($data)) {
            foreach($data as $value){
                $array[] = $value['pages'][$key];
            } 
            return $array;
        } else {
            return false;
        }
    }   
    
    /**
     * getAllPublishedFromKey
     * 
     * @param string $key
     * 
     * @return array|bool
     */
    public function getAllPublishedFromKey($key)
    {
        $data = $this->connect();
        if (!is_null($data) && !empty($data)) {
            foreach($data as $value){
                if($value['pages']['published'] == 1) $array[] = $value['pages'][$key];
            } 
            return (isset($array)) ? $array : false;
        } else {
            return false;
        }
    }
    
    /**
     * getAllIndexed
     * 
     * 
     * @return array|bool
     */
    public function getAllIndexed()
    {
        $data = $this->connect();
        if (!is_null($data)) {
            foreach($data as $value){
                foreach ($value as $value) {
                    $array[] =  $value;
            }
        }

            return $array;
        } else {
            return false;
        }
    }
    
    /**
     * getId
     *
     * @param  string $path
     *
     * @return string
     */
    public function getId($path)
    {
        $data = $this->connect();
        $key = array_search($path, array_column($data, 'phppath'));
        
        return $data[$key]['pages']['id'];
    }
    
    /**
     * getTopic
     *
     * @param  string $id
     *
     * @return string
     */
    public function getTopic($id)
    {
        $data = $this->connect();
        $key = $this->findKey($data, $id);
        
        return $data[$key]['pages']['topic'];
    }
    
    /**
     * getFilename
     *
     * @param  string $id
     *
     * @return string
     */
    public function getFilename($id)
    {
        $data = $this->connect();
        $key = $this->findKey($data, $id);
        
        return $data[$key]['pages']['filename'];
    }
    
    /**
     * getPageData
     *
     * @param  string $id
     *
     * @return array
     */
    public function getPageData($id)
    {
        $data = $this->connectPageData($id);

        return $data;
    }
    
    /**
     * putPageData
     *
     * @param  string $id
     * @param  array $data
     *
     * @return int|bool
     */
    public function putPageData($id, $data)
    {
        $path = $this->getJsonPath($id);

        return file_put_contents($path, json_encode($data));
    }
    
    /**
     * addPageData
     *
     * @param  string $id
     * @param  array $array
     *
     * @return int|bool
     */
    public function addPageData($id, $array)
    {
        $data = $this->getPageData($id);
        $data[] = array(
            'key' => $array['key'],
            'v1' => $array['v1'],
            'v2' => $array['v2'],
            'v3' => $array['v3'],
            'v4' => $array['v4']
            );
            
        return $this->putPageData($id, $data);
    }
    
    /**
     * modifyPageData
     *
     * @param  string $id
     * @param  integer $index
     * @param  array $array
     *
     * @return int|bool
     */
    public function modifyPageData($id, $index, $array)
    {
        $data = $this->getPageData($id);
        $data[$index] = array(
            'key' => $array['key'],
            'v1' => $array['v1'],
            'v2' => $array['v2'],
            'v3' => $array['v3'],
            'v4' => $array['v4']
            );
            
        return $this->putPageData($id, $data);
    }
    
    /**
     * removePageData
     *
     * @param  string $id
     * @param  integer $index
     *
     * @return int|bool
     */
    public function removePageData($id, $index)
    {
        $data = $this->getPageData($id);
        array_splice($data, $index, 1);

            
        return $this->putPageData($id, $data);
    }
    
    /**
     * insertPageData
     *
     * @param  string $id
     * @param  integer $index
     * @param  string $before_or_after
     * @param  array $array
     *
     * @return int|bool
     */
    public function insertPageData($id, $index, $before_or_after, $array)
    {
        $data = $this->getPageData($id);
        
        array_splice($data, ($before_or_after == 'b') ? (int)$index : (int)$index + 1, 0, array([
            'key' => $array['key'],
            'v1' => $array['v1'],
            'v2' => $array['v2'],
            'v3' => $array['v3'],
            'v4' => $array['v4']
            ]));

        return $this->putPageData($id, $data);
    }
    
    
    /**
     * remove
     *
     * @param  string $id
     *
     * @return int|bool
     */
    public function remove($id)
    {
        $data = $this->connect();
        $key = $this->findKey($data, $id);
        
        if ($key !== false) {
        array_splice($data, $key, 1);
        }
        
        return $this->disconnect(self::DB, $data);
    }
    
    /**
     * disconnect
     *
     * @param  string $path
     * @param  array $data
     *
     * @return int|bool
     */
    public function disconnect($path, $data)
    {
        return file_put_contents($path, json_encode($data));
    }
    
    /**
     * findKey
     *
     * @param  string $id
     *
     * @return int|bool
     */
    public function findKey($data, $search)
    {
        $x = 0;
        if (isset($data)) {
            foreach ($data as $array) {
                if ($array['pages']['id'] == $search) $key = $x;
                $x++;
            }
            
            return isset($key) ? $key : false;
        }
    }

    /**
     * hideBySlug
     *
     * @param  string $slug
     *
     * @return string
     */
    public function hideBySlug($slug)
    {
        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') {
            $protocol  = "https://";
        } else {
            $protocol  = "http://";
        }
        
        if (isset($slug)) {
            return $protocol.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'] !== BASE_URL.$slug;
        }
    }
    
    /**
     * getStatusPublished
     *
     * @return array
     */
    public function getStatusPublished()
    {
        $pages = $this->connect();
        $id = $_SESSION['page_id'];
        foreach ($pages as $value) {
            if ($value['pages']['id'] === $id) {
                $published = $value['pages']['published'];
            }
        }

        if ($published === 1) {
            $statusPage = [
                'page' => 'Published',
                'btn' => 'btn-success',
                'icon' => 'fa-toggle-on'
            ];
        } else {
            $statusPage = [
                'page' => 'Draft',
                'btn' => 'btn-outline-danger',
                'icon' => 'fa-toggle-off blink',
                'alert' => '<div class="alert alert-danger text-center" role="alert">'.T::trans('This page is unpublished').'</div>'
            ];
        }

        return $statusPage;
    }
}