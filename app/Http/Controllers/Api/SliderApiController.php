<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SliderApiResource;
use App\Models\Slider;
use Illuminate\Http\Request;

class SliderApiController extends Controller
{
    public function index()
    {
        $sliders = Slider::latest()->get();
        return SliderApiResource::collection($sliders);
      
    }
}
