<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FileController extends BaseController
{
    public function store(Request $request){
        $paths = array();
        if (!$request->hasFile('images')){
            return $this->sendError('upload_file_not_found',[], 400);
        }
        $images = $request->images;
        foreach ($images as $image){
            $paths[] = Str::substr($image->store('public/images'), 7);
        }
        return $this->sendResponse($paths, 'Upload images successfully');
    }
}
