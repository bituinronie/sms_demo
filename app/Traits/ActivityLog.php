<?php

// *** CREATED BY: Jim Kier Mesa

namespace App\Traits;

use Arr, Str;

trait ActivityLog
{
    protected function activityCauseTo($model, $getForeign = [], $only = []){

        $keyName = array_keys($model->toArray());

        for ($i=0; $i < count($keyName); $i++) {

            if ($this->activityCauseToShowOnly($keyName[$i], $only)) {

                $data[$i] = [Str::upper(Str::replace('_', ' ', $keyName[$i])) => $model[$keyName[$i]]];
            }
        }

        if (Arr::accessible($getForeign)) {

            foreach (collect($getForeign) as $foreignKey => $foreignKeyData) {

                foreach ($foreignKeyData as $foreignValue) {

                    if ($model->$foreignKey) {

                        $foreign[Str::upper($foreignKey)][Str::upper(Str::replace('_', ' ',$foreignValue))] = $model->$foreignKey->$foreignValue;

                    }else{

                        $foreign[$foreignKey] = null;
                    }
                }
            }
        }

        return Arr::collapse([Arr::collapse($data ?? []), $foreign ?? []]);
    }
    
    
    protected function activityChangedOnly($original, $updated, $getForeign = [], $file = [], $ignored = []){

        foreach ($original->getFillable() as $key) {

            if ($original->$key != $updated->$key) {

                if ($this->activityIgnored($key, $ignored)) {

                    if ($this->activityFile($key, $file)) {
                        
                        $oldFileArr[Str::upper(Str::replace('_', ' ', $key))] = $original->$key == null ? 'NO FILE' : 'REMOVED THE OLD FILE';
                        $newFileArr[Str::upper(Str::replace('_', ' ', $key))] = $updated->$key  == null ? 'NO FILE' : 'UPLOADED A NEW FILE';

                    }else {

                        $oldArr[Str::upper(Str::replace('_', ' ', $key))] = $original->$key;
                        $newArr[Str::upper(Str::replace('_', ' ', $key))] = $updated->$key;

                    }
                }

                if (Arr::accessible($getForeign)) {

                    foreach (collect($getForeign) as $foreignKey => $foreignKeyData) {

                        foreach ($foreignKeyData as $foreignValue) {
    
                            if (($original->$foreignKey ?? null) != ($updated->$foreignKey ?? null)) {
    
                                $oldForeignArr[Str::upper(Str::replace('_', ' ', $foreignKey))][Str::upper(Str::replace('_', ' ', $foreignValue))]
                                = $original->$foreignKey->$foreignValue ?? null;

                                $newForeignArr[Str::upper(Str::replace('_', ' ', $foreignKey))][Str::upper(Str::replace('_', ' ', $foreignValue))]
                                = $updated->$foreignKey->$foreignValue ?? null;

                            }
                        }
                    }
                }
                
            }
            
        }
        
        return [
            'old' => Arr::collapse([$oldArr ?? [], $oldFileArr ?? [], $oldForeignArr ?? []]),
            'new' => Arr::collapse([$newArr ?? [], $newFileArr ?? [], $newForeignArr ?? []])
        ];

    }


    private function activityIgnored($keyName, $ignored){

        foreach ($ignored as $ignoredCtr => $ignoredKeyName) {

            if ($keyName == $ignoredKeyName) {

                return false;
            }
        }

        return true;
    }


    private function activityFile($keyName, $file){

        foreach ($file as $fileCtr => $fileKeyName) {

            if ($keyName == $fileKeyName) {

                return true;
            }
        }

        return false;
    }

    private function activityCauseToShowOnly($keyName, $only){

		foreach ($only as $onlyCtr => $onlyKeyName) {

            if ($keyName == $onlyKeyName) {

                return true;
            }
        }

        return false;
	}

}