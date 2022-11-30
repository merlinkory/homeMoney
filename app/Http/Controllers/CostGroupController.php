<?php

namespace App\Http\Controllers;

use App\Models\Cost;
use Illuminate\Http\Request;
use App\Models\CostGroup;
use Illuminate\Support\Facades\Auth;

class CostGroupController extends Controller
{
    public function index(){
        $costGroups = CostGroup::where('user_id',Auth::id())->get();

        if($costGroups){
            return response(['code' => 1, 'data'=> $costGroups],200)->header('Content-Type', 'application/json');
        }

        return response(['code' => 7, 'message'=> 'can not get cost groups'],200)->header('Content-Type', 'application/json');
    }

    public function store(Request $request){

        $costGroup = CostGroup::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
        ]);

        return response(['code' => 1, 'data'=> $costGroup],200)->header('Content-Type', 'application/json');
    }

    public function destory(int $id){

        $costGroup = CostGroup::find($id);

        if($costGroup){
            $costGroup->delete();
            return response(['code' => 1, 'message'=> 'cost group deleted'],200)->header('Content-Type', 'application/json');
        }

        return response(['code' => 7, 'message'=> 'cost group not found'],200)->header('Content-Type', 'application/json');
    }
}
