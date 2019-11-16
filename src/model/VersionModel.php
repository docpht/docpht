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

class VersionModel extends PageModel
{

    /**
     * checkVersion
     *
     * @param  string $file
     * @param  string $id
     *
     * @return boolean
     */
    public function checkVersion($file_path, $id)
    {
        $zipData = new \ZipArchive(); 
        if ($zipData->open($file_path) === TRUE) {

            (is_bool($zipData->locateName($this->getPhpPath($id))) === TRUE || is_bool($zipData->locateName($this->getJsonPath($id))) === TRUE) ? $check = FALSE : $check = TRUE; 
            $zipData->close();
            
            if ($check) { return TRUE; } else { return FALSE; }
        } else {
        
        return FALSE;
        
        }
        
    }
    
    /**
     * getVersions
     *
     * @param  string $id
     *
     * @return array boolean
     */
    public function getVersions($id)
    {

        $path = $this->getPhpPath($id);
        if ($path == 'data/doc-pht/home.php') {
            $zippedVersionPath = 'data/doc-pht/';
            $filePattern = '*.zip';
        } else {
        	$zippedVersionPath = 'data/' . substr(pathinfo($path, PATHINFO_DIRNAME ), 6) . '/';
            $filePattern = '*.zip';
        }
    
        $versionList = array();
        foreach (glob($zippedVersionPath . $filePattern) as $file) {
            $addFile = $this->checkVersion($file, $id);
            if($addFile) array_push($versionList, ['path' => $file, 'date' => filemtime($file)]);
        }
        
        return $this->sortVersions($versionList);
    }
        
    /**
     * sortVersions
     *
     * @param  array $array
     * 
     * @return array boolean
     */
    public function sortVersions($array)
    {
    
        if (!empty($array)) {
            $column = array_column($array, 'date');
            array_multisort($column, SORT_DESC, $array);
            
            return $array;
        } else {
            return FALSE;
        }

    }
        
    /**
     * saveVersion
     *
     * @param  array $id
     * 
     * @return array boolean
     */
    public function saveVersion($id)
    {
        $this->doc = new DocBuilder;
        $path = $this->getPhpPath($id);
        if (isset($id)) {
        	$zippedVersionPath = 'data/' . $this->getSlug($id) . '_' . $this->doc->datetimeNow() . '.zip';
        } else {
            die;
        }
        
        $getAssets = $this->getAssets($id);

        if (!empty($getAssets)) {
            $zipData = new \ZipArchive();
            $zipData->open($zippedVersionPath, \ZipArchive::CREATE);
            foreach ($getAssets as $file) {
                $zipData->addFile($file, $file);
            }
            $zipData->close();
            return true;
        } else {
            return false;
        }
    }   

    /**
     * getAssets
     *
     * @param  array $id
     * 
     * @return array boolean
     */
    public function getAssets($id)
    {
        $data = $this->getPageData($id);
        $php = $this->getJsonPath($id);
        $json = $this->getPhpPath($id);
        $assets = [];
        
        foreach ($data as $fields) {
            if ($fields['key'] == 'image' || $fields['key'] == 'codeFile' || $fields['key'] == 'markdownFile') { array_push($assets, 'data/' . $fields['v1']); }
        }
        
        array_push($assets, $php);
        array_push($assets, $json);
        
        if (!empty($assets)) {
            return $assets;
        } else {
            return false;
        }
    }   
    
    /**
     * deleteVersion
     *
     * @param  array $path
     * 
     * @return array boolean
     */
    public function deleteVersion($path)
    {
        if (file_exists($path)) {
            unlink($path);
            return TRUE;
        } else {
            return FALSE;
        }
        
    }
}
    
