<?php

// *** CREATED BY: Jim Kier Mesa

namespace App\Traits;

use Storage;

trait FileHandling
{

    protected function storeFile($directory, $file){
      
        $storeFile = $file->store($directory);

        return $this->takeName($storeFile);
    }

    

    protected function updateFile($directory, $newFile, $oldFile){

        Storage::delete("{$directory}/{$oldFile}");

        return $this->storeFile($directory, $newFile);
    }



    protected function moveUnchangeFile($newDirectory, $oldDirectory, $oldFile){

        if ($newDirectory != $oldDirectory) {

            if ($oldFile != null) {
                
                if(Storage::exists("{$oldDirectory}/{$oldFile}")){

                    Storage::move(
                        "{$oldDirectory}/{$oldFile}",
                        "{$newDirectory}/{$oldFile}"
                    );
                }
            }
        }

        return $oldFile;
    }



    protected function deleteFolder($directory){

        if(Storage::exists($directory)){

        Storage::deleteDirectory($directory);
        
        }
    }


    
    protected function takeName($directory){
        $name = explode("/", $directory);
        $index = sizeof($name) - 1;

        return $name[$index];
    }
}