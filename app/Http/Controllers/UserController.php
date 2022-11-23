<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function store(Request $request){

        if($this->userValidate($request->all())->fails()){
            return response(['code' => 2, 'message'=> 'user data invalid'],200)->header('Content-Type', 'application/json');
        }

        if(User::where('email',$request->email)->exists()){
            return response(['code' => 3, 'message'=> 'user exists'],200)->header('Content-Type', 'application/json');
        }

        $user = User::create([
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        if($user){
            return response(['code' => 1, 'message'=> 'user created'],200)->header('Content-Type', 'application/json');
        }else{
            return response(['code' => 4, 'message'=> 'user not created'],200)->header('Content-Type', 'application/json');
        }
    }

    public function createToken(Request $request){

        if($this->userValidate($request->all())->fails()){
            return response(['code' => 2, 'message'=> 'user data invalid'],200)->header('Content-Type', 'application/json');
        }

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            //TODO: response error
        }

        return $user->createToken($request->token_name,['finance'])->plainTextToken;
    }

    public function login(Request $request){
        if($this->userValidate($request->all())->fails()){
            return response(['code' => 2, 'message'=> 'user data invalid'],200)->header('Content-Type', 'application/json');
        }

        if(Auth::check()){
            return redirect('/clientarea');
        }

        $user = User::where('email',$request->email)->first();


        if (! $user || ! Hash::check($request->password, $user->password)) {
            return redirect('/')->withErrors([
                'email' => 'auth fail'
            ]);
        }

        auth()->login($user, true);

        return redirect('/clientarea');
    }

    public function logout() {
        Auth::logout();
        return redirect('/');
    }

    protected function userValidate(array $userData){
        return Validator::make($userData,[
            'email' => ['required','email'],
            'password' => ['required']
        ]);
    }


}
