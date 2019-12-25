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

use DocPHT\Model\PageModel;
use DocPHT\Core\Translator\T;
use Instant\Core\Helper\TextHelper;
use Plasticbrain\FlashMessages\FlashMessages;

class DocBuilder 
{
    
    protected $pageModel;
    protected $msg;

	public function __construct()
	{
        $this->pageModel = new PageModel();
        $this->msg = new FlashMessages();
	}
    /**
     * jsonSwitch
     *
     * @param array $jsonVals
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
                case 'markdownFile':
					$option = $this->markdownFile($jsonVals['v1']);
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
    public function valuesToArray($values, $file_path = null, $self = [])
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
                case 'markdownFile':
					$option = ['key' => $values['options'], 'v1' => substr($file_path, 5), 'v2' => '', 'v3' => '', 'v4' => ''];
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
        ($key1 == 'markdownFile' && $key2 != 'markdownFile') ? (file_exists($path) ? unlink($path) : NULL) : NULL;
    }
    
    /**
     * buildPhpPage
     *
     * @param  string $id
     *
     */
    public function buildPhpPage($id)
    {
        $data = $this->pageModel->getPageData($id);
        $path = $this->pageModel->getPhpPath($id);
        $anchors = [];
        $values = [];
        
		foreach ($data as $vals) {
		    $vals = $vals;
            $values[] = $this->jsonSwitch($vals);
    			if ($vals['key'] == "title") {
    			    $anchors[] = "'".TextHelper::e($vals['v1'])."'";
    			}
		}
			
        $file = "<?php\n\n"
                ."use DocPHT\Lib\DocPHT;\n\n"
                .'$_SESSION'."['page_id'] = '".$id."';\n\n"
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
    * datetimeNow
    *
    * @return string
    */
    public static function datetimeNow() 
    {
      $timeZone = new \DateTimeZone(TIMEZONE);
      $datetime = new \DateTime();
      $datetime->setTimezone($timeZone);
      return $datetime->format(DATAFORMAT);
    }

    /**
     * setFolderPermissions
     * 
     * @param  string $needle
     *
     * @return void
     */
    public function setFolderPermissions($folder)
    {
        $dirpath = $folder;
        $dirperm = 0755;
        $fileperm = 0644; 
        chmod ($dirpath, $dirperm);
        $glob = glob($dirpath."/*");
        foreach($glob as $ch)
        {
            $ch = (is_dir($ch)) ? chmod ($ch, $dirperm) : chmod ($ch, $fileperm);
        }
    }
    
    /**
     * upload
     *
     * @param  string $file
     * @param  string $path
     *
     * @return resource
     */
    public function upload($file, $path)
    {
        if (isset($file) && $file->isOk()) {
            $file_contents = $file->getContents();
            $file_name = $file->getName();
            $this->setFolderPermissions('data');
            $file_path = 'data/' . substr(pathinfo($path, PATHINFO_DIRNAME ), 6) . '/' . uniqid() . '_' . $file_name;
            file_put_contents($file_path, $file_contents);
            return $file_path;
        } else {
            return '';
        }
        
    }

    
    /**
     * uploadNoUniqid
     *
     * @param  string $file
     * @param  string $path
     *
     * @return resource
     */
    public function uploadNoUniqid($file, $path)
    {
        if (isset($file) && $file->isOk()) {
            $file_contents = $file->getContents();
            $file_name = $file->getName();
            $this->setFolderPermissions('data');
            $file_path = 'data/' . substr(pathinfo($path, PATHINFO_DIRNAME ), 6) . '/' . $file_name;
            file_put_contents($file_path, $file_contents);
            return $file_path;
        } else {
            return '';
        }
        
    }

    /**
     * uploadLogoDocPHT
     *
     * @param  string $file
     *
     * @return resource
     */
    public function uploadLogoDocPHT($file)
    {
        if (isset($file) && $file->isOk()) {
            $file_contents = $file->getContents();
            $this->setFolderPermissions('data');
            $file_path = 'data/logo.png';
            file_put_contents($file_path, $file_contents);
            return $file_path;
        } else {
            return '';
        }
        
    }

    /**
     * uploadFavDocPHT
     *
     * @param  string $file
     *
     * @return resource
     */
    public function uploadFavDocPHT($file)
    {
        if (isset($file) && $file->isOk()) {
            $file_contents = $file->getContents();
            $this->setFolderPermissions('data');
            $file_path = 'data/favicon.png';
            file_put_contents($file_path, $file_contents);
            return $file_path;
        } else {
            return '';
        }
        
    }
    
    /**
     * uploadBackup
     *
     * @param  string $file
     *
     * @return resource
     */
    public function uploadBackup($file)
    {
        if (isset($file) && $file->isOk()) {
            $file_contents = $file->getContents();
            $file_name = $file->getName();
            $this->setFolderPermissions('data');
            $file_path = 'data/' . $file_name;
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
     * @param  string $path
     *
     * @return bool
     */
    public function checkImportVersion($file_path, $path)
    {
        $zipData = new \ZipArchive(); 
        if ($zipData->open($file_path) === TRUE) {

            $check = is_bool($zipData->locateName($path)); 
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
    	$val = TextHelper::e($val);
        $anch = TextHelper::e($anch);
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
        $val = TextHelper::e($val);
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
        $val = TextHelper::e($val);
        $ext = TextHelper::e($ext);
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
        $val = TextHelper::e($val);
        $ext = TextHelper::e($ext);
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
        $val = TextHelper::e($val);
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
        if (!empty($src)) {
            $src = addcslashes($src,"\'");
            $out = '$html->codeFile'."('{$lan}','{$src}'), \n";
            return $out;
        } else {
            $this->msg->error(T::trans('No files added for uploading'),$_SERVER['HTTP_REFERER']);
        }
        
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
        $val = TextHelper::e($val);
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
        $val = TextHelper::e($val);
        $src = TextHelper::e($src);
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
        $val = TextHelper::e($val);
        $src = TextHelper::e($src);
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
     * markdownFile
     *
     * @param  string $src
     *
     * @return resource
     */
    public function markdownFile($src)
    {
        if (!empty($src)) {
            $src = addcslashes($src,"\'");
            $out = '$html->markdownFile'."('{$src}'), \n";
            return $out;
        } else {
            $this->msg->error(T::trans('No files added for uploading'),$_SERVER['HTTP_REFERER']);
        }
        
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
        $val = TextHelper::e($val);
        $src = TextHelper::e($src);
        $out = '$html->linkButton'."('{$src}','{$val}','{$trg}'), \n";
        return $out;
    }
    
    /**
     * getOptions
     *
     * @return array
     */
    public function getOptions()
    {
        return [
        'title' => T::trans('Add title'),
        'description' => T::trans('Add description'),
    	'pathAdd'  => T::trans('Add path'),
    	'codeInline' => T::trans('Add code inline'),
    	'codeFile' => T::trans('Add code from file'),
    	'blockquote' => T::trans('Add blockquote'),
    	'image' => T::trans('Add image from file'),
    	'imageURL' => T::trans('Add image from url'),
    	'markdown' => T::trans('Add markdown'),
    	'markdownFile' => T::trans('Add markdown from file'),
    	'linkButton' => T::trans('Add link button')
    	];
    }


    /**
     * listCodeLanguages
     *
     * @return array
     */
    public function listCodeLanguages()
    {
        $json = '
        {
            "Markup":"markup",
            "HTML":"html",
            "CSS":"css",
            "C-like":"clike",
            "JavaScript":"javascript",
            "ABAP":"abap",
            "Augmented Backusâ€“Naur form":"abnf",
            "ActionScript":"actionscript",
            "Ada":"ada",
            "Apache Configuration":"apacheconf",
            "APL":"apl",
            "AppleScript":"applescript",
            "Arduino":"arduino",
            "ARFF":"arff",
            "AsciiDoc":"asciidoc",
            "6502 Assembly":"asm6502",
            "ASP.NET (C#)":"aspnet",
            "AutoHotkey":"autohotkey",
            "AutoIt":"autoit",
            "Bash":"shell",
            "BASIC":"basic",
            "Batch":"batch",
            "Bison":"bison",
            "Backusâ€“Naur form":"bnf",
            "Brainfuck":"brainfuck",
            "Bro":"bro",
            "C":"c",
            "C#":"csharp",
            "C++":"cpp",
            "CIL":"cil",
            "CoffeeScript":"coffeescript",
            "CMake":"cmake",
            "Clojure":"clojure",
            "Crystal":"crystal",
            "Content-Security-Policy":"csp",
            "CSS Extras":"css-extras",
            "D":"d",
            "Dart":"dart",
            "Diff":"diff",
            "Django/Jinja2":"django",
            "Docker":"docker",
            "Extended Backusâ€“Naur form":"ebnf",
            "Eiffel":"eiffel",
            "EJS":"ejs",
            "Elixir":"elixir",
            "Elm":"elm",
            "ERB":"erb",
            "Erlang":"erlang",
            "F#":"fsharp",
            "Flow":"flow",
            "Fortran":"fortran",
            "G-code":"gcode",
            "GEDCOM":"gedcom",
            "Gherkin":"gherkin",
            "Git":"git",
            "GLSL":"glsl",
            "GameMaker Language":"gml",
            "Go":"go",
            "GraphQL":"graphql",
            "Groovy":"groovy",
            "Haml":"haml",
            "Handlebars":"handlebars",
            "Haskell":"haskell",
            "Haxe":"haxe",
            "HCL":"hcl",
            "HTTP":"http",
            "HTTP Public-Key-Pins":"hpkp",
            "HTTP Strict-Transport-Security":"hsts",
            "IchigoJam":"ichigojam",
            "Icon":"icon",
            "Inform 7":"inform7",
            "Ini":"ini",
            "Io":"io",
            "J":"j",
            "Java":"java",
            "JavaDoc":"javadoc",
            "JavaDoc-like":"javadoclike",
            "Java stack trace":"javastacktrace",
            "Jolie":"jolie",
            "JSDoc":"jsdoc",
            "JS Extras":"js-extras",
            "JSON":"json",
            "JSONP":"jsonp",
            "JSON5":"json5",
            "Julia":"julia",
            "Keyman":"keyman",
            "Kotlin":"kotlin",
            "LaTeX":"latex",
            "Less":"less",
            "Liquid":"liquid",
            "Lisp":"lisp",
            "LiveScript":"livescript",
            "LOLCODE":"lolcode",
            "Lua":"lua",
            "Makefile":"makefile",
            "Markdown":"markdown",
            "Markup templating":"markup-templating",
            "MATLAB":"matlab",
            "MEL":"mel",
            "Mizar":"mizar",
            "Monkey":"monkey",
            "N1QL":"n1ql",
            "N4JS":"n4js",
            "Nand To Tetris HDL":"nand2tetris-hdl",
            "NASM":"nasm",
            "nginx":"nginx",
            "Nim":"nim",
            "Nix":"nix",
            "NSIS":"nsis",
            "Objective-C":"objectivec",
            "OCaml":"ocaml",
            "OpenCL":"opencl",
            "Oz":"oz",
            "PARI/GP":"parigp",
            "Parser":"parser",
            "Pascal":"pascal",
            "Perl":"perl",
            "PHP":"php",
            "PHPDoc":"phpdoc",
            "PHP Extras":"php-extras",
            "PL/SQL":"plsql",
            "PowerShell":"powershell",
            "Processing":"processing",
            "Prolog":"prolog",
            ".properties":"properties",
            "Protocol Buffers":"protobuf",
            "Pug":"pug",
            "Puppet":"puppet",
            "Pure":"pure",
            "Python":"python",
            "Q (kdb+ database)":"q",
            "Qore":"qore",
            "R":"r",
            "React JSX":"jsx",
            "React TSX":"tsx",
            "Ren\"py":"renpy",
            "Reason":"reason",
            "Regex":"regex",
            "reST (reStructuredText)":"rest",
            "Rip":"rip",
            "Roboconf":"roboconf",
            "Ruby":"ruby",
            "Rust":"rust",
            "SAS":"sas",
            "Sass (Sass)":"sass",
            "Sass (Scss)":"scss",
            "Scala":"scala",
            "Scheme":"scheme",
            "Smalltalk":"smalltalk",
            "Smarty":"smarty",
            "SQL":"sql",
            "Soy (Closure Template)":"soy",
            "Stylus":"stylus",
            "Swift":"swift",
            "TAP":"tap",
            "Tcl":"tcl",
            "Textile":"textile",
            "TOML":"toml",
            "Template Toolkit 2":"tt2",
            "Twig":"twig",
            "TypeScript":"typescript",
            "T4 Text Templates (C#)":"t4-cs",
            "T4 Text Templates (VB)":"t4-vb",
            "T4 templating":"t4-templating",
            "Vala":"vala",
            "VB.Net":"vbnet",
            "Velocity":"velocity",
            "Verilog":"verilog",
            "VHDL":"vhdl",
            "vim":"vim",
            "Visual Basic":"visual-basic",
            "WebAssembly":"wasm",
            "Wiki markup":"wiki",
            "Xeora":"xeora",
            "Xojo (REALbasic)":"xojo",
            "XQuery":"xquery",
            "YAML":"yaml"
            }
        ';

        return json_decode($json, true);
    }
}
