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
        $zipData = new ZipArchive(); 
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
     * @return array
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
            return false;
        }

    }
}
    