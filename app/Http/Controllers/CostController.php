<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Cost;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CostController extends Controller
{

    public function index (Request $request){

        $cb = new Carbon(); // Carbon init
        $date = $cb->subDays(14);

        $costs = DB::table('costs')
            ->join('cost_groups','costs.cost_group_id', 'cost_groups.id')
            ->select('costs.*', 'cost_groups.name')
            ->where('costs.user_id','=',Auth::id())
            ->where('costs.date','>', $date)
            ->orderBy('costs.date', 'asc')
            ->get();

        $output = [];
        foreach ($costs as $cost){
            $costDate = Carbon::create($cost->date)->toDateString();
            if(!isset($output[$costDate]['total']))$output[$costDate]['total'] = [];
            $output[$costDate]['costs'][] = [
                'id' => $cost->id,
                'name' => $cost->name,
                'amount' => $cost->amount * 1,
                'currency' => $cost->currency,
                'description' => $cost->description
            ];
            if(!isset($output[$costDate]['total'][$cost->currency])) $output[$costDate]['total'][$cost->currency] = 0;
            $output[$costDate]['total'][$cost->currency] += $cost->amount;
        }

        return response(['code' => 1, 'data'=> $output],200)->header('Content-Type', 'application/json');

    }
    public function store (Request $request){

        if($this->costValidate($request->all())->fails()){
            //TODO: response error
            dd('cost data not valid'); //TODO: remove
        }

        $cost = Cost::create([
            'user_id' => Auth::id(),
            'cost_group_id' => $request->cost_group_id,
            'amount' => $request->amount,
            'currency' => $request->currency,
            'description' => $request->description,
            'date' => $request->date
        ]);

        return response(['code' => 1, 'data'=> $cost],200)->header('Content-Type', 'application/json');

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

    public function report(Request $request){

        $year = $request->year;
        $month = $request->month;

        $costs = DB::table('costs')
            ->join('cost_groups','costs.cost_group_id', 'cost_groups.id')
            ->select('costs.*', 'cost_groups.name')
            ->where('costs.user_id',Auth::id())
            ->whereYear('costs.date', $year)
            ->whereMonth('costs.date', $month)
            ->get();

        $output = [];

        foreach ($costs as $cost){
            if(!isset($output[$cost->currency]['groups'][$cost->name]))
                $output[$cost->currency]['groups'][$cost->name] = 0;
            $output[$cost->currency]['groups'][$cost->name] += $cost->amount;
            if(!isset($output[$cost->currency]['total']))
                $output[$cost->currency]['total'] = 0;
            $output[$cost->currency]['total'] += $cost->amount;
        }

        return response(['code' => 1, 'data'=> $output],200)->header('Content-Type', 'application/json');
    }

    protected function costValidate(array $costData){
        return Validator::make($costData,[
            'cost_group_id' => 'required',
            'amount' => 'required',
            'currency' => 'required',
            'date' => 'required'
        ]);
    }
}
