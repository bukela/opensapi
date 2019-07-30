<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\File as FileModel;
use Illuminate\Support\Facades\File;

class FileController extends Controller
{
    public function image_destroy($id) {

        $file = FileModel::findOrFail($id);
        // dd($file);
        File::delete(public_path('uploads/galleries/').$file->filename);
        $file->delete();

        return response(['message' => 'file deleted']);

    }
}
