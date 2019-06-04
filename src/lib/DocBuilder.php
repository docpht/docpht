<?php declare(strict_types=1);

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

namespace DocPHT\Lib;

class DocBuilder {
    
    /**
     * valuesSwitch
     *
     * @param  resource $values
     * @param  string $file_path
     *
     * @return string
     */
    public function valuesSwitch($values, $file_path)
    {
        if (isset($values['options'])) {
            switch ($values['options']) {
                case 'title':
					$option = $this->title($values['option_content'],$values['option_content']);
                    break;
                case 'description':
					$option = $this->description($values['option_content']);
                    break;
                case 'path':
					$option = $this->pathAdd($values['option_content']);
                    break;
                case 'pathAdd':
					$option = $this->pathAdd($values['option_content']);
                    break;
                case 'codeInline':
					$option = $this->codeInline($values['option_content'],$values['language']);
                    break;
                case 'codeFile':
					$option = $this->codeFile(substr($file_path, 5), $values['language']);
                    break;
                case 'blockquote':
					$option = $this->blockquote($values['option_content']);
                    break;
                case 'image':
					$option = $this->image(substr($file_path, 5), $values['option_content']);
                    break;
                case 'imageURL':
					$option = $this->imageURL($values['option_content'], $values['names']);
                    break;
                case 'linkButton':
					$option = $this->linkButton($values['option_content'], $values['names'], $values['trgs']);
                    break;
                case 'markdown':
					$option = $this->markdown($values['option_content']);
                    break;
                case 'addButton':
                    $option = '$html->addButton(),'."\n";
                    break;
                default:
                    $option = '';
                    break;
            }
        } else { $option = ''; }
        
        return $option;
    }
    
    /**
     * jsonSwitch
     *
     * @param  resource $jsonVals
     *
     * @return string
     */
    public function jsonSwitch($jsonVals)
    {
        if (isset($jsonVals['key'])) {
            switch ($jsonVals['key']) {
                case 'title':
                    $option = $this->title($jsonVals['v1'],$jsonVals['v1']);
                    break;
                case 'description':
                    $option = $this->description($jsonVals['v1']);
                    break;
                case 'pathAdd':
                    $option = $this->pathAdd($jsonVals['v1']);
                    break;
                case 'path':
                    $option = $this->pathAdd($jsonVals['v1']);
                    break;
                case 'codeInline':
                    $option = $this->codeInline($jsonVals['v1'],$jsonVals['v2']);
                    break;
                case 'codeFile':
					$option = $this->codeFile($jsonVals['v1'], $jsonVals['v2']);
                    break;
                case 'blockquote':
                    $option = $this->blockquote($jsonVals['v1']);
                    break;
                case 'image':
					$option = $this->image($jsonVals['v1'], $jsonVals['v2']);
                    break;
                case 'imageURL':
					$option = $this->imageURL($jsonVals['v1'], $jsonVals['v2']);
                    break;
                case 'linkButton':
					$option = $this->linkButton($jsonVals['v1'], $jsonVals['v2'], $jsonVals['v3']);
                    break;
                case 'markdown':
					$option = $this->markdown($jsonVals['v1']);
                    break;
                case 'addButton':
                    $option = '$html->addButton(),'."\n";
                    break;
                    
                default:
                    $option = '';
                    break;
            }
        } else { $option = ''; }
        
        return $option;
    }
    
    /**
     * valuesToArray
     *
     * @param  array $values
     * @param  string $file_path
     * @param  array $self
     *
     * @return array
     */
    public function valuesToArray($values, $file_path, $self = [])
    {
        if (isset($values['options'])) {
            switch ($values['options']) {
                case 'title':
                    $option = ['key' => $values['options'], 'v1' => $values['option_content'], 'v2' => '', 'v3' => '', 'v4' => ''];
                    break;
                case 'description':
                    $option = ['key' => $values['options'], 'v1' => $values['option_content'], 'v2' => '', 'v3' => '', 'v4' => ''];
                    break;
                case 'pathAdd':
                    $option = ['key' => $values['options'], 'v1' => $values['option_content'], 'v2' => '', 'v3' => '', 'v4' => ''];
                    break;
                case 'codeInline':
                    $option = ['key' => $values['options'], 'v1' => $values['option_content'], 'v2' => $values['language'], 'v3' => '', 'v4' => ''];
                    break;
                case 'codeFile':
                    $option = ['key' => $values['options'], 'v1' => substr($file_path, 5), 'v2' => $values['language'], 'v3' => '', 'v4' => ''];
                    break;
                case 'blockquote':
                    $option = ['key' => $values['options'], 'v1' => $values['option_content'], 'v2' => '', 'v3' => '', 'v4' => ''];
                    break;
                case 'image':
                    $option = ['key' => $values['options'], 'v1' => substr($file_path, 5), 'v2' => $values['option_content'], 'v3' => '', 'v4' => ''];
                    break;
                case 'imageURL':
					$option = ['key' => $values['options'], 'v1' => $values['option_content'], 'v2' => $values['names'], 'v3' => '', 'v4' => ''];
                    break;
                case 'linkButton':
					$option = ['key' => $values['options'], 'v1' => $values['option_content'], 'v2' => $values['names'], 'v3' => $values['trgs'], 'v4' => ''];
                    break;
                case 'markdown':
					$option = ['key' => $values['options'], 'v1' => $values['option_content'], 'v2' => '', 'v3' => '', 'v4' => ''];
                    break;
                case 'addButton':
                    $option = ['key' => 'addButton', 'v1' => '', 'v2' => '', 'v3' => '', 'v4' => ''];
                    break;
                default:
                    $option = $self;
                    break;
            }
        }
        
        return $option;
    }  
    
    /**
     * removeOldFile
     *
     * @param  string $key1
     * @param  string $key2
     * @param  string $path
     *
     */
    public function removeOldFile($key1, $key2, $path)
    {
        ($key1 == 'image' && $key2 != 'image') ? (file_exists($path) ? unlink($path) : NULL) : NULL;
        ($key1 == 'codeFile' && $key2 != 'codeFile') ? (file_exists($path) ? unlink($path) : NULL) : NULL;
    }
    
    /**
     * buildPhpPage
     *
     * @param  string $id
     *
     */
    public function buildPhpPage($id)
    {
        $db = new DocData;
        $data = $db->getPageData($id);
        $path = $db->getPhpPath($id);
        $anchors = [];
        $values = [];
        
		foreach ($data as $vals) {
		    $vals = $vals;
            $values[] = $this->jsonSwitch($vals);
    			if ($vals['key'] == "title") {
    			    $anchors[] = "'".$vals['v1']."'";
    			}
		}
			
        $file = "<?php\n\n"
                ."require_once 'lib/DocPHT.php';\n\n"
                .'$_SESSION'."['update_path'] = '".$path."';\n\n"
                .'$html = new DocPHT(['.implode(',',$anchors)."]);\n"
                .'$values'." = [\n".implode('', $values).'$html->addButton(),'."\n"."];";
        
        if (!file_exists(pathinfo($path, PATHINFO_DIRNAME))) {
            mkdir(pathinfo($path, PATHINFO_DIRNAME), 0755, true);
            file_put_contents($path, $file);
        } else {
            file_put_contents($path, $file);
        }

    }
    
    /**
     * startsWith
     *
     * @param  mixed $haystack
     * @param  mixed $needle
     *
     * @return bool
     */
    public function startsWith($haystack, $needle)
    {
         $length = strlen($needle);
         return (substr($haystack, 0, $length) === $needle);
    }    
    
    /**
     * upload
     *
     * @param  string $file
     * @param  string $aPath
     *
     * @return resource
     */
    public function upload($file, $aPath)
    {
        if (isset($file) && $file->isOk()) {
            $file_contents = $file->getContents();
            $file_name = $file->getName();
            $file_path = 'data' . substr(pathinfo($aPath, PATHINFO_DIRNAME ), 3) . '/' . uniqid() . '_' . $file_name;
            file_put_contents($file_path, $file_contents);
            return $file_path;
        } else {
            return '';
        }
        
    }

   /**
    * datetimeNow
    *
    * @return string
    */
   public static function datetimeNow() 
   {
      $timeZone = new DateTimeZone(TIMEZONE);
      $datetime = new DateTime();
      $datetime->setTimezone($timeZone);
      return $datetime->format(DATAFORMAT);
    }
    
    /**
     * uploadNoUniqid
     *
     * @param  string $file
     * @param  string $aPath
     *
     * @return resource
     */
    public function uploadNoUniqid($file, $aPath)
    {
        if (isset($file) && $file->isOk()) {
            $file_contents = $file->getContents();
            $file_name = $file->getName();
            $file_path = 'data' . substr(pathinfo($aPath, PATHINFO_DIRNAME ), 3) . '/' . $file_name;
            file_put_contents($file_path, $file_contents);
            return $file_path;
        } else {
            return '';
        }
        
    }
    
    /**
     * checkImportVersion
     *
     * @param  string $file
     * @param  string $aPath
     *
     * @return boolean
     */
    public function checkImportVersion($file_path, $aPath)
    {
        $zipData = new ZipArchive(); 
        if ($zipData->open($file_path) === TRUE) {

            $check = is_bool($zipData->locateName($aPath)); 
            $zipData->close();
            
            if ($check) { return false; } else { return true; }
        } else {
        
        return false;
        
        }
        
    }
    
    /**
     * title
     *
     * @param  string $val
     * @param  string $anch
     *
     * @return string
     */
    public function title($val,$anch)
    {
       $out = '$html->title'."('{$val}','{$anch}'), \n";
       return $out; 
    }
    
    /**
     * description
     *
     * @param  string $val
     *
     * @return string
     */
    public function description($val)
    {
       $val = htmlspecialchars((string) $val, ENT_QUOTES, 'UTF-8');
       $out = '$html->description'."('{$val}'), \n";
       return $out; 
    }
    
    /**
     * path
     *
     * @param  string $val
     * @param  string $ext
     *
     * @return string
     */
    public function path($val,$ext)
    {
       $out = '$html->path'."('pages/{$val}.{$ext}'), \n";
       return $out; 
    }

    /**
     * pathHome
     *
     * @param  string $val
     * @param  string $ext
     *
     * @return string
     */
    public function pathHome($val,$ext)
    {
       $out = '$html->path'."('data/{$val}.{$ext}'), \n";
       return $out; 
    }
    
    /**
     * pathAdd
     *
     * @param  string $val
     *
     * @return string
     */
    public function pathAdd($val)
    {
       $out = '$html->path'."('{$val}'), \n";
       return $out; 
    }
    
    /**
     * codeInline
     *
     * @param  string $val
     * @param  string $lan
     *
     * @return string
     */
    public function codeInline($val,$lan)
    {
       $val = addcslashes($val,"\'");
       $out = '$html->codeInline'."('{$lan}','{$val}'), \n";
       return $out; 
    }
    
    /**
     * codeFile
     *
     * @param  string $src
     * @param  string $lan
     *
     * @return resource
     */
    public function codeFile($src,$lan)
    {
       $src = addcslashes($src,"\'");
       $out = '$html->codeFile'."('{$lan}','{$src}'), \n";
       return $out; 
    }
    
    /**
     * blockquote
     *
     * @param  string $val
     *
     * @return string
     */
    public function blockquote($val)
    {
       $val = htmlspecialchars((string) $val, ENT_QUOTES,'UTF-8');
       $out = '$html->blockquote'."('{$val}'), \n";
       return $out; 
    }
    
    /**
     * image
     *
     * @param  string $src
     * @param  string $val
     *
     * @return resource
     */
    public function image($src,$val)
    {
       $out = '$html->image'."('{$src}','{$val}'), \n";
       return $out; 
    }
    
    /**
     * imageURL
     *
     * @param  string $src
     * @param  string $val
     *
     * @return resource
     */
    public function imageURL($src,$val)
    {
       $out = '$html->imageURL'."('{$src}','{$val}'), \n";
       return $out; 
    }
    
    /**
     * markdown
     *
     * @param  string $val
     *
     * @return resource
     */
    public function markdown($val)
    {
       $val = addcslashes($val,"\'");
       $out = '$html->markdown'."('{$val}'), \n";
       return $out; 
    }
    
    /**
     * linkButton
     *
     * @param  string $src
     * @param  string $val
     * @param  string $trg
     *
     * @return string
     */
    public function linkButton($src,$val,$trg)
    {
       $out = '$html->linkButton'."('{$src}','{$val}','{$trg}'), \n";
       return $out;
    }
}