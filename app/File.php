<?php

namespace App;

use http\Env\Request;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    public function saveFileToModel(Request $request, $model, $path, $filePrefix){
        $file = null;
        if($request->hasFile('image')){
            $file = $request->file('image');
        }
        $filename = uniqid($filePrefix . '_') . '-' . $file->getClientOriginalExtension();
        $path = public_path($path);
        
        $uploaded = $file->move($path, $filename);
        
        if (is_null($model->image)) {
            
            $image= new File();
            
            $image->filename = $uploaded->getFilename();
            $image->image_url = $uploaded->getPathname();
            
            $image->file()->associate($model);
            $image->save();
        }
        else {
            unlink($path . '/' . $model->image->filename);
            $model->image->filename = $uploaded->getFilename();
            $model->image->image_url = $uploaded->getPathname();
            $model->image->update();
        }
    }
    public function file(){
        return $this->morphTo();
    }
}
