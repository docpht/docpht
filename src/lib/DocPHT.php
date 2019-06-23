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

use ParsedownCheckbox;
use Emojione\Client;
use Emojione\Ruleset;
use DocPHT\Core\Translator\T;

class DocPHT {

    /**
     * __construct
     *
     * @param  array $anchorLinks
     *
     * @return string
     */
    public function __construct(array $anchorLinks = null)
    {
        return $this->anchorLinks($anchorLinks);
    }

    /**
     * title
     *
     * @param  string $title
     * @param  string $anchorLinkID
     *
     * @return string
     */
    public function title(string $title, string $anchorLinkID = null)
    {
       $client = new Client(new Ruleset());
       $title = $client->shortnameToUnicode($title);
       if (isset($anchorLinkID)) {
        return '<tr>'. ((isset($_SESSION['Active'])) ? '<td class="handle"><i class="fa fa-arrows-v sort"></i></td>' : '') . '<td><h2 class="mt-3 mb-3" id="'.$anchorLinkID.'">'.$title.' '.$this->insertBeforeButton().$this->removeButton().$this->modifyButton().$this->insertAfterButton().'</h2></td></tr>';
       } 
       return '<tr>'. ((isset($_SESSION['Active'])) ? '<td class="handle"><i class="fa fa-arrows-v sort"></i></td>' : '') . '<td><h2 class="mt-3 mb-3">'.$title.' '.$this->insertBeforeButton().$this->removeButton().$this->modifyButton().$this->insertAfterButton().' </h2></td></tr>';
    }

    
    /**
     * anchorLinks
     *
     * @param  array $anchorLinks
     *
     * @return string
     */
    public function anchorLinks(array $anchorLinks = null)
    {
        $client = new Client(new Ruleset());
        
        if (isset($anchorLinks)) {
            echo '<nav class="navbar navbar-expand-lg navbar-light bg-light">
                    <div class="container-fluid">

                        <button type="button" id="sidebarCollapse" class="btn btn-secondary">
                            <i class="fa fa-align-left"></i>
                        </button>
                        <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <i class="fa fa-align-justify"></i>
                        </button>

                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="nav navbar-nav ml-auto">
                            '; foreach ($anchorLinks as $value) {
                                $title = $client->shortnameToImage(ucfirst(str_replace('-',' ',$value)));
                                echo '<li class="nav-item">
                                            <a class="nav-link" href="'.$_SERVER['REQUEST_URI'].'#'.$value.'">'.$title.'</a>
                                      </li>';
                            };
                    echo '</ul></div>
                    </div>
                </nav>
                <div class="table-responsive"><table class="sortable" width="100%"><tbody>';
        } else {
            echo '<nav class="navbar navbar-expand-lg navbar-light bg-light">
                    <div class="container-fluid">

                        <button type="button" id="sidebarCollapse" class="btn btn-secondary">
                            <i class="fa fa-align-left"></i>
                        </button>
                        <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <i class="fa fa-align-justify"></i>
                        </button>
                        
                    </div>
                </nav>
                <div class="table-responsive"><table class="sortable" width="100%"><tbody>';
        }
    }

    /**
     * description
     *
     * @param  string $description
     *
     * @return string
     */
    public function description(string $description)
    {
       $client = new Client(new Ruleset());
       $description = $client->shortnameToUnicode(nl2br($description));
       return '<tr>'. ((isset($_SESSION['Active'])) ? '<td class="handle"><i class="fa fa-arrows-v sort"></i></td>' : '') . '<td><p>'.$description.' '.$this->insertBeforeButton().$this->removeButton().$this->modifyButton().$this->insertAfterButton().'</p></td></tr>';
    }

    /**
     * blockquote
     *
     * @param  string $blockquote
     *
     * @return string
     */
    public function blockquote(string $blockquote)
    {
       $client = new Client(new Ruleset());
       $blockquote = $client->shortnameToUnicode(nl2br($blockquote));
       return '<tr>'. ((isset($_SESSION['Active'])) ? '<td class="handle"><i class="fa fa-arrows-v sort"></i></td>' : '') . '<td><blockquote>'.$blockquote.' '.$this->insertBeforeButton().$this->removeButton().$this->modifyButton().$this->insertAfterButton().'</blockquote></td></tr>';
    }

    /**
     * codeInline
     *
     * @param  string $language
     * @param  string $snippet
     *
     * @return string
     */
    public function codeInline(string $language, string $snippet)
    {   
        return '<tr>'. ((isset($_SESSION['Active'])) ? '<td class="handle"><i class="fa fa-arrows-v sort"></i></td>' : '') . '<td><pre>
                    <code class="language-'.$language.'">
                        <script type="prism-'.$language.'">
                            '.$snippet.'
                        </script>
                    </code>
                </pre>'.$this->insertBeforeButton().$this->removeButton().$this->modifyButton().$this->insertAfterButton().'</td></tr>';
    }

    /**
     * codeFile
     *
     * @param  string $language
     * @param  string $filePath
     *
     * @return string
     */
    public function codeFile(string $language, string $filePath)
    {   
        return '<tr>'. ((isset($_SESSION['Active'])) ? '<td class="handle"><i class="fa fa-arrows-v sort"></i></td>' : '') . '<td><pre>
                    <code class="language-'.$language.'">
                        <script type="prism-'.$language.'">
                            '.file_get_contents('data/'.$filePath).'
                        </script>
                    </code>
                </pre>'.$this->insertBeforeButton().$this->removeButton().$this->modifyButton().$this->insertAfterButton().'</td></tr>';
    }

    /**
     * path
     *
     * @param  string $path
     *
     * @return string
     */
    public function path(string $path)
    {
       return '<tr>'. ((isset($_SESSION['Active'])) ? '<td class="handle"><i class="fa fa-arrows-v sort"></i></td>' : '') . '<td><p class="urlcode">'.$path.' '.$this->insertBeforeButton().$this->removeButton().$this->modifyButton().$this->insertAfterButton().'</p></td></tr>';  
    }


    /**
     * image
     *
     * @param  string $src
     * @param  string $title
     *
     * @return string
     */
    public function image(string $src, string $title)
    {
        return '<tr>'. ((isset($_SESSION['Active'])) ? '<td class="handle"><i class="fa fa-arrows-v sort"></i></td>' : '') . '<td><img src="data/'.$src.'" class="img-fluid mb-3" alt="'.$title.'">'.$this->insertBeforeButton().$this->removeButton().$this->modifyButton().$this->insertAfterButton().'</td></tr>';
    }
    
    /**
     * imageURL
     *
     * @param  string $src
     * @param  string $title
     *
     * @return string
     */
    public function imageURL(string $src, string $title)
    {
        return '<tr>'. ((isset($_SESSION['Active'])) ? '<td class="handle"><i class="fa fa-arrows-v sort"></i></td>' : '') . '<td><img src="'.$src.'" class="img-fluid mb-3" alt="'.$title.'">'.$this->insertBeforeButton().$this->removeButton().$this->modifyButton().$this->insertAfterButton().'</td></tr>';
    }


    /**
     * linkButton
     *
     * @param  string $url
     * @param  string $title
     * @param  boolean $target
     *
     * @return string
     */
    public function linkButton(string $url, string $title, $target = false)
    {
        $client = new Client(new Ruleset());
        $title = $client->shortnameToUnicode($title);
        $setTarget = ($target) ? 'target="_blank"' : '' ;
        return '<tr>'. ((isset($_SESSION['Active'])) ? '<td class="handle"><i class="fa fa-arrows-v sort"></i></td>' : '') . '<td><span class="spinner-grow spinner-grow-sm text-secondary"></span><a href="'.$url.'" '.$setTarget.' class="link" role="button">'.$title.'</a>'.$this->insertBeforeButton().$this->removeButton().$this->modifyButton().$this->insertAfterButton().'</td></tr>';
    }

    /**
     * markdown
     *
     * @param  string $text
     *
     * @return string
     */
    public function markdown(string $text)
    {
        $Parsedown = new ParsedownCheckbox();
        $client = new Client(new Ruleset());
        $markdown = '<tr>'. ((isset($_SESSION['Active'])) ? '<td class="handle"><i class="fa fa-arrows-v sort"></i></td>' : '') . '<td class="markdown-col">';
        $markdown .= $Parsedown->text($client->shortnameToUnicode($text));
        $markdown .= $this->insertBeforeButton().$this->removeButton().$this->modifyButton().$this->insertAfterButton().'</td></tr>';
        return $markdown;
    }

    /**
     * markdownFile
     *
     * @param  string $filePath
     *
     * @return string
     */
    public function markdownFile(string $filePath)
    {   
        $Parsedown = new ParsedownCheckbox();
        $client = new Client(new Ruleset());
        $markdown = '<tr>'. ((isset($_SESSION['Active'])) ? '<td class="handle"><i class="fa fa-arrows-v sort"></i></td>' : '') . '<td class="markdown-col">';
        $markdown .= $Parsedown->text($client->shortnameToUnicode(file_get_contents('data/'.$filePath)));
        $markdown .= $this->insertBeforeButton().$this->removeButton().$this->modifyButton().$this->insertAfterButton().'</td></tr>';
        return $markdown;
    }

    /**
     * addButton
     *
     *
     * @return string
     */
    public function addButton()
    {
        if (isset($_SESSION['Active'])) {
            return '<tr><td class="handle-disabled"></td><td><ul class="list-inline text-left mt-4">
                    <li class="list-inline-item" data-toggle="tooltip" data-placement="bottom" title="'.T::trans('Add').'">
                        <a href="page/add-section" id="sk-add" class="btn btn-outline-success btn-sm" role="button">
                            <i class="fa fa-plus-square" aria-hidden="true"></i>
                        </a>
                    </li>
                </ul></td></tr></tbody></table></div>';
        } else {
            return '</tbody></table></div>';
        }
    }

    /**
     * removeButton
     *
     *
     * @return string
     */
    public function removeButton()
    {
        if (isset($_SESSION['Active'])) {
        return '<span class="text-right remove-button">
                    <a onmouseover="setIndexRemove(this)" href="page/remove" onclick="return confirmationRemoval()" class="anchorjs-link btn btn-danger btn-sm text-right" data-toggle="tooltip" data-placement="bottom" title="'.T::trans('Remove').'" role="button">
                        <i class="fa fa-minus-square" aria-hidden="true" style="vertical-align: middle;"></i>
                    </a>
                </span>';
        } else {
            return '';
        }
    }
    
    /**
     * modifyButton
     *
     *
     * @return string
     */
    public function modifyButton()
    {
        if (isset($_SESSION['Active'])) {
        return '<span class="text-right modify-button">
                    <a onmouseover="setIndexModify(this)" href="page/modify" class="anchorjs-link btn btn-info btn-sm text-right" data-toggle="tooltip" data-placement="bottom" title="'.T::trans('Modify').'" role="button">
                        <i class="fa fa-pencil-square" aria-hidden="true" style="vertical-align: middle;"></i>
                    </a>
                </span>';
        } else {
            return '';
        }
    }
    
    /**
     * insertBeforeButton
     *
     *
     * @return string
     */
    public function insertBeforeButton()
    {
        if (isset($_SESSION['Active'])) {
        return '<span class="text-right modify-button">
                    <a onmouseover="setIndexInsertB(this)" href="page/insert" class="anchorjs-link btn btn-success btn-sm text-right" data-toggle="tooltip" data-placement="bottom" title="'.T::trans('Insert Before').'" role="button">
                        <i class="fa fa-arrow-circle-up" aria-hidden="true" style="vertical-align: middle;"></i>
                    </a>
                </span>';
        } else {
            return '';
        }
    }
    
    /**
     * InsertAfterButton
     *
     *
     * @return string
     */
    public function InsertAfterButton()
    {
        if (isset($_SESSION['Active'])) {
        return '<span class="text-right modify-button">
                    <a onmouseover="setIndexInsertA(this)" href="page/insert" class="anchorjs-link btn btn-success btn-sm text-right" data-toggle="tooltip" data-placement="bottom" title="'.T::trans('Insert After').'" role="button">
                        <i class="fa fa-arrow-circle-down" aria-hidden="true" style="vertical-align: middle;"></i>
                    </a>
                </span>';
        } else {
            return '';
        }
    }    


}