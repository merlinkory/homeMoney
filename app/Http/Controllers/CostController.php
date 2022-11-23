<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Cost;
class CostController extends Controller
{

    public function index (){
        $costs = Cost::all();

        return response(['code' => 1, 'data'=> $costs->toArray()],200)->header('Content-Type', 'application/json');

    }
    public function store (Request $request){

        if($this->costValidate($request->all())->fails()){
            //TODO: response error
            dd('cost data not valid'); //TODO: remove
        }

        $cost = Cost::create([
            'user_id' => $request->user_id,
            'cost_group_id' => $request->cost_group_id,
            'amount' => $request->amount,
            'currency' => $request->currency,
            'date' => $request->date
        ]);

        dd($cost->toArray());

    }

    public function destroy(int $id){
        $cost = Cost::find($id);

        if($cost){
            $cost->delete();
            return response(['code' => 1, 'message'=> 'cost deleted'],200)->header('Content-Type', 'application/json');
        }

        return response(['code' => 5, 'message'=> 'cost not found'],200)->header('Content-Type', 'application/json');

    }

    public function update(Request $request, int $id){
        $cost = Cost::find($id);

        if($cost){
            $cost->cost_group_id = $request->cost_group_id;
            $cost->amount =  $request->amount;
            $cost->currency = $request->currency;
            $cost->description = $request->description;
            $cost->date = $request->date;
            $cost->save();

            return response(['code' => 1, 'message'=> 'cost updated'],200)->header('Content-Type', 'application/json');
        }

        return response(['code' => 6, 'message'=> 'cost not found'],200)->header('Content-Type', 'application/json');
    }

    protected function costValidate(array $costData){
        return Validator::make($costData,[
            'user_id' => 'required',
            'cost_group_id' => 'required',
            'amount' => 'required',
            'currency' => 'required',
            'date' => 'required'
        ]);
    }
}
