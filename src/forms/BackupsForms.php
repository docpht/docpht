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

class BackupsForms extends MakeupForm
{

    public function import()
    {
        $form = new Form;
        $form->onRender[] = [$this, 'bootstrap4'];
        
        $form->addGroup(T::trans('Import a Backup Archive'));
        
        $form->addUpload('backup_zip', T::trans('Backup Archive:'))
            ->setRequired(true)
            ->addRule(Form::MIME_TYPE, 'Not an zip file.', ['application/zip', 'application/x-compressed', 'application/x-zip-compressed','multipart/x-zip'])
            ->addRule(Form::MAX_FILE_SIZE, 'Maximum file size is 100 mb.', 100000 * 1024 /* size in Bytes */);
        
        $form->addSubmit('submit', T::trans('Add'));
        
        
        $success = '';
        
        if ($form->isSuccess()) {
            $values = $form->getValues();
            $file = $values['backup_zip'];
            $file_path = $this->doc->uploadBackup($file);	
            
            if ($this->backupsModel->checkBackups($file_path) === false) {
                (file_exists($file_path)) ? unlink($file_path) : NULL;
                $this->msg->error(T::trans('Backup import failed, missing data files.'),BASE_URL.'admin/backup');
                die;
            }
            
            if ($file_path != '') {
                $this->msg->success(T::trans('Backup imported successfully.'),BASE_URL.'admin/backup');
            } else {
                $this->msg->error(T::trans('Backup import failed.'),BASE_URL.'admin/backup');
            }
        } 
        
        return $form;
        
    }
    
    public function delete()
    {    
        if (isset($_POST['backup'])) {
            ($this->backupsModel->deleteBackup($_POST['backup'])) 
            ? $this->msg->success(T::trans('Backup removed successfully.'),BASE_URL.'admin/backup')
            : $this->msg->error(T::trans('Sorry something didn\'t work!'),BASE_URL.'admin/backup');
        }
    }
    
    public function export()
    {    
        if (isset($_POST['backup'])) {
            $filename = $_POST['backup'];
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
            $this->msg->error(T::trans('Invalid procedure! File not found.'),BASE_URL.'admin/backup');
        } else {
            $this->msg->error(T::trans('Invalid procedure! File not set.'),BASE_URL.'admin/backup');
        }
    }
    
    public function restore()
    {
        $zipData = new \ZipArchive();
        if (isset($_POST['backup'])) {
            $zip_file = $_POST['backup'];
            if ($zipData->open($zip_file) === TRUE) {
                $files = $this->backupsModel->getZipList($zip_file);
                foreach ($files as $file) { if(file_exists($file))unlink($file); }
                $zipData->extractTo('.');
                $zipData->close();
                $this->msg->success(T::trans('Backup restored successfully.'),BASE_URL.'admin/backup');
            } else {
                $this->msg->error(T::trans('Invalid procedure!'),BASE_URL.'admin/backup');
            }
        } else {
            $this->msg->error(T::trans('Backup data missing!'),BASE_URL.'admin/backup');
        }
    }
    
    
    public function save()
    {
        if ($this->backupsModel->createBackup()) {
			$this->msg->success(T::trans('Backup saved successfully.'),BASE_URL.'admin/backup');
        } else {
			$this->msg->error(T::trans('Sorry something didn\'t work!'),BASE_URL.'admin/backup');
        }
    }
}