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

use Nette\Forms\Form;
use Nette\Utils\Html;
use DocPHT\Core\Translator\T;

class VersionForms extends MakeupForm
{

    public function import()
    {
        $id = $_SESSION['page_id'];
        $aPath = $this->versionModel->getPhpPath($id);

        $form = new Form;
        $form->onRender[] = [$this, 'bootstrap4'];
        
        $form->addGroup(T::trans('Import a Version Archive'));
        
        $form->addUpload('version_zip', T::trans('Version Archive:'))
            ->setRequired(true)
            ->addRule(Form::MIME_TYPE, 'Not an zip file.', ['application/zip', 'application/x-compressed', 'application/x-zip-compressed','multipart/x-zip'])
            ->addRule(Form::MAX_FILE_SIZE, 'Maximum file size is 20 mb.', 20000 * 1024 /* size in Bytes */);
        
        $form->addProtection(T::trans('Security token has expired, please submit the form again'));
        
        $form->addSubmit('submit', T::trans('Import'));
        
        
        $success = '';
        
        if ($form->isSuccess()) {
            $values = $form->getValues();
            $file = $values['version_zip'];
            $file_path = $this->doc->uploadNoUniqid($file,$aPath);	
            
            if ($this->doc->checkImportVersion($file_path,$aPath) === false) {
                (file_exists($file_path)) ? unlink($file_path) : NULL;
                $this->msg->error(T::trans('Version import failed, didn\'t match current page.'),BASE_URL.'page/'.$this->pageModel->getTopic($id).'/'.$this->pageModel->getFilename($id));
                die;
            }
            
            if ($file_path != '') {
                $this->msg->success(T::trans('Version imported successfully.'),BASE_URL.'page/'.$this->pageModel->getTopic($id).'/'.$this->pageModel->getFilename($id));
            } else {
                $this->msg->error(T::trans('Version import failed.'),BASE_URL.'page/'.$this->pageModel->getTopic($id).'/'.$this->pageModel->getFilename($id));
            }
        } 
        
        return $form;
        
    }
    
    public function delete()
    {    
        if (isset($_POST['version']) && isset($_SESSION['page_id'])) {
            ($this->versionModel->deleteVersion($_POST['version'])) 
            ? header('Location:'.$this->pageModel->getTopic($_SESSION['page_id']).'/'.$this->pageModel->getFilename($_SESSION['page_id'])) 
            : $this->msg->error(T::trans('Sorry something didn\'t work!'),BASE_URL.'page/'.$this->pageModel->getTopic($_SESSION['page_id']).'/'.$this->pageModel->getFilename($_SESSION['page_id']));
        }
    }
    
    public function export()
    {    
        if (isset($_POST['version']) && isset($_SESSION['page_id'])) {
            $filename = $_POST['version'];
            if (file_exists($filename)) {
                header('Content-Description: File Transfer');
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename="'.basename($filename).'"');
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . filesize($filename));
                readfile($filename);
                exit;
            }
            $this->msg->error(T::trans('Invalid procedure! File not found.'),BASE_URL.'page/'.$this->pageModel->getTopic($_SESSION['page_id']).'/'.$this->pageModel->getFilename($_SESSION['page_id']));
        } else {
            $this->msg->error(T::trans('Invalid procedure! File not set.'),BASE_URL.'page/'.$this->pageModel->getTopic($_SESSION['page_id']).'/'.$this->pageModel->getFilename($_SESSION['page_id']));
        }
    }
    
    public function restore()
    {
        if (isset($_POST['version']) && isset($_SESSION['page_id'])) {
            $id = $_SESSION['page_id'];
            $versionZip = $_POST['version'];
            $aPath = $this->pageModel->getPhpPath($id);
            $jsonPath = $this->pageModel->getJsonPath($id);
            
            $jsonArray = $this->pageModel->getPageData($id);
            
            foreach ($jsonArray as $fields) {
                if ($fields['key'] == 'image' || $fields['key'] == 'codeFile') { (file_exists('data/' . $fields['v1'])) ? unlink('data/' . $fields['v1']) : NULL; }
            }
        
        
            unlink($aPath);
            unlink($jsonPath);

            $zipData = new \ZipArchive();
        
            if ($zipData->open($versionZip) === TRUE) {
                $zipData->extractTo('.');
                $zipData->close();
                $this->msg->success(T::trans('Version restored successfully.'),BASE_URL.'page/'.$this->pageModel->getTopic($id).'/'.$this->pageModel->getFilename($id));
            } else {
                $this->msg->error(T::trans('Invalid procedure!'),BASE_URL.'page/'.$this->pageModel->getTopic($id).'/'.$this->pageModel->getFilename($id));
            }
        } else {
            $this->msg->error(T::trans('Version data missing!'),BASE_URL.'page/'.$this->pageModel->getTopic($id).'/'.$this->pageModel->getFilename($id));
        }
    }
    
    public function save()
    {
        $id = $_SESSION['page_id'];
        if ($this->versionModel->saveVersion($id)) {
        	$this->msg->success(T::trans('Version saved successfully.'),BASE_URL.'page/'.$this->pageModel->getTopic($id).'/'.$this->pageModel->getFilename($id));
        } else {
            $this->msg->error(T::trans('Invalid procedure!'),BASE_URL.'page/'.$this->pageModel->getTopic($id).'/'.$this->pageModel->getFilename($id));
        }
    }
}