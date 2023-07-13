<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Province;

class ProvinceController extends BaseController
{

    public function index(){
//        dd("llll");
        $provinces = Province::find('01')->districts;
        return $this->sendResponse($provinces, 'Provinces retrieved successfully');
    }



}
