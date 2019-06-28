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
use DocPHT\Model\PageModel;

class BackupsForms extends MakeupForm
{

    public function restoreOptions()
    {
        if (isset($_POST['backup'])){ 
            $tmp = 'temp/o1o1'; //because post data goes bye bye after submit, should solve for this later
            file_put_contents($tmp,$_POST['backup']);
        }
        
        $form = new Form;
        $form->onRender[] = [$this, 'bootstrap4'];
        
        $form->addGroup(T::trans('Restore from backup'));
        
        $options = [
            'crestore' => T::trans('Clear current pages and restore from backup'),
            'mrestore' => T::trans('Merge pages from backup with current pages'),
            'urestore' => T::trans('Restore users from backup'),
            ];
        
        $form->addRadioList('restore_option', T::trans('Restore options:'), $options)
        	->setRequired(true);
        	
        $form->addSubmit('submit', T::trans('Restore'));
        
        
        $success = '';
        
        if ($form->isSuccess()) {
            $values = $form->getValues();
            $option = $values['restore_option'];
            $backup = file_get_contents('temp/o1o1'); //because post data goes bye bye after submit, should solve for this later
            unlink('temp/o1o1');
            
            switch ($option) {
                case 'crestore':
                    $procedure = $this->clearRestore($backup);
                    break;
                case 'mrestore':
                    $procedure = $this->restoreMerge($backup);
                    break;
                case 'urestore':
                    $procedure = $this->restoreUsers($backup);
                    break;
                case 'default':
                    break;
                
            }
            
            if ($procedure) {
                $this->msg->success(T::trans('Restored successfully.'),BASE_URL.'admin/backup');
            } else {
                $this->msg->error(T::trans('Invalid procedure!'),BASE_URL.'admin/backup');
            }

        } 
        return $form;
        
    }

    public function import()
    {
        $form = new Form;
        $form->onRender[] = [$this, 'bootstrap4'];
        
        $form->addGroup(T::trans('Import a Backup Archive'));
        
        $form->addUpload('backup_zip', T::trans('Backup Archive:'))
            ->setRequired(true)
            ->addRule(Form::MIME_TYPE, 'Not an zip file.', ['application/zip', 'application/x-compressed', 'application/x-zip-compressed','multipart/x-zip'])
            ->addRule(Form::MAX_FILE_SIZE, 'Maximum file size is 100 mb.', 100000 * 1024 /* size in Bytes */);
        
        $form->addSubmit('submit', T::trans('Import'));
        
        
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
    
    public function filter($files)
    {
        $exclude = 'data/users.json';
        $key = array_search($exclude, $files);
        unset($files[$key]);
        return $files;
    }
    
    public function restoreMerge($zip_file)
    {
        $zipData = new \ZipArchive();
        if (!empty($zip_file)) {
            if ($zipData->open($zip_file) === TRUE) {
                $oldIds = $this->pageModel->getAllFromKey('id');
                $new = json_decode(file_get_contents("zip://".$zip_file."#data/pages.json"),true);
                $newIds = $this->pageModel->getAllFromDataKey($new, 'id');
                
                foreach($newIds as $id) {
                    $this->pageModel->remove($id);
                }
                
                $join = array_merge($this->pageModel->connect(), $new); 

                $files = $this->filter($this->backupsModel->getZipList($zip_file));
                foreach ($files as $file) { if(file_exists($file))unlink($file); } 
                for($i = 0; $i < $zipData->numFiles; $i++) {
                    $filename = $zipData->getNameIndex($i);
                    $zipData->extractTo('.', $filename);
                }            
                $zipData->close();
                $this->pageModel->disconnect(PageModel::DB, $join);
                
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    
    public function clearRestore($zip_file)
    {
        $zipData = new \ZipArchive();
        if (!empty($zip_file)) {
            if ($zipData->open($zip_file) === TRUE) {
                $this->recursiveRemoveDirectory('data');
                $this->recursiveRemoveDirectory('pages');
                $files = $this->filter($this->backupsModel->getZipList($zip_file));
                for($i = 0; $i < $zipData->numFiles; $i++) {
                    $filename = $zipData->getNameIndex($i);
                    $zipData->extractTo('.', $filename);
                }  
                $zipData->close();
                
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    
    public function restoreUsers($zip_file)
    {
        $zipData = new \ZipArchive();
        if (!empty($zip_file)) {
            if ($zipData->open($zip_file) === TRUE) {
                if(file_exists('data/users.json'))unlink('data/users.json');
                $zipData->extractTo('.', 'data/users.json');
                $zipData->close();
                
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    
    
    function recursiveRemoveDirectory($directory)
    {
        foreach(glob("{$directory}/*") as $file)
        {
            if(is_dir($file)) { 
                $this->recursiveRemoveDirectory($file);
            } else {
                if(strpos($file, 'data/DocPHT_Backup_') === false && strpos($file, 'data/users.json') === false)unlink($file);
            }
        }
        if($directory !== 'data' && $directory !== 'pages')rmdir($directory);
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