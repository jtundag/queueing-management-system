<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TagsController extends Controller
{
    public function get(Request $request){
        return response()->json([
            'result' => \App\Tag::all(),
        ]);
    }
}
