<?php

namespace App\Http\Controllers;

use App\Models\Cost;
use Illuminate\Http\Request;
use App\Models\CostGroup;

class CostGroupController extends Controller
{
    public function index(int $user_id){
        $costGroups = CostGroup::where('user_id',$user_id)->get();

        if($costGroups){
            return response(['code' => 1, 'data'=> $costGroups],200)->header('Content-Type', 'application/json');
        }

        return response(['code' => 7, 'message'=> 'can not get cost groups'],200)->header('Content-Type', 'application/json');
    }
}
