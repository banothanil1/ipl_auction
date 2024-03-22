<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\validation;
use  App\Models\Buyer;
use App\Models\Player;
use Illuminate\Routing\Events\ResponsePrepared;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\RedirectResponse;
use App\services\playerbid;
class auction_controller extends Controller
{
    public function addplayer(Request $request){
        //dd("ima rkdf");
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'jersy_number' => 'required|integer|unique:players|max:255',
            'place' => 'required|string|max:255',
            'age' => 'required|integer|min:18|max:45',
            'baseprice' => 'required|numeric|min:200000', 
        ],
        [
            'name.required'=>'the name should be properly entered',
            'jersey_number.unique' => 'The jersey number has already been taken.',
            'place'=>'need enter in a way proper way ',
            'age.min' => 'The player must be at least 18 years old.',
            'age.max' => 'The player age must be less or equal then 45',
            'base_price.min'=>'base price should be min 200000 ']
    );
    
        if ($validator->fails()) {
            return response()->json($validator->errors(),400);
        }
    
       $result= Player::create([
            'name' => $request->name,
            'jersy_number' => $request->jersy_number,
            'place' => $request->place,
            'age' => $request->age,
            'baseprice' => $request->baseprice,
        ]);
        
        if(isset($result)){
            return response()->json(["status"=>"player added"],200);
        }

        return response()->json(["status"=>"failed to add player"],400);
    }

    public function addbuyer(Request $request){
        $validator = Validator::make($request->all(), [
            'teamname' => 'required|string|regex:/^[A-Za-z\s.\'-]+$/|max:255',
            'coach_name' => 'required|regex:/^[A-Za-z\s.\'-]+$/|string|max:255',
            'state' => 'required|regex:/^[A-Za-z\s.\'-]+$/|max:255',
            'contact' => 'required|regex:/^\d{10}$/|unique:buyers|min:10|max:10', 
            'networth' => 'required|numeric|min:1500000',
            'password' => 'required|min:8|confirmed', 
            'password_confirmation' =>'required|min:8'
        ],
        [
            'contact.required' => 'The contact must be a valid phone number with max 10 digits.',
            'contact.unique' => 'The contact has already been taken.',
            'contact.max' => 'The contact has to be equal to 10 digits.',
            'contact.min' => 'The contact has to be equal to 10 digits',
            'networth.min' => 'The networth must mroe then equal to 1500000 .',
            'password.confirmed' => 'The password should match confirm password field',
            'password_confirmation'=>'password should be confirmed']
    );
    
        if ($validator->fails()) {
            return response()->json($validator->errors(),400);
        }
    
        $result=Buyer::create([
        'teamname' => $request->teamname,
        'coach_name' => $request->coach_name,
        'state' => $request->state,
        'contact' => $request->contact,
        'networth' => $request->networth,
        'password' =>Hash::make($request->password), 
        ]);

        if(isset($result)){
            return response()->json(["status"=>"buyer added"],200);
        }

        return response()->json(["status"=>"failed to add buyer"],400);
    }
    
    
public function buyerlogin(Request $request) {
    //dd("iam reahing here");
    $validator = Validator::make($request->all(), [
        'name' => 'required|regex:/^[A-Za-z\s.\'-]+$/|max:255',
        'password' => 'required|min:8',
    ],
    [
        'name.required' => 'please enter a proper name',
        'password' => 'invalid passoword or buyer doesnt exist',
    ]);

    if ($validator->fails()) {
        return response()->json(["errro:"=>"you failed to enter proper data"],400);
    }

    $buyer = Buyer::where('coach_name', $request['name'])->first();//finding the buyer name

    if ($buyer && Hash::check($request['password'], $buyer->password)) {
        session()->push('name', $request['name']); // Starting session upon successful login
        session()->push('password', $request['password']);
           playerbid::bidding(session()->get('name'));
    } else {
        return response()->json(['status'=>"your failed to login"],400);
    }

}

public function logout(){
       // dd("iam reaching here")
            if(session()->has('name') && session()->has('password')){
                session()->remove('name');
                session()->remove('password');
                return  response()->json(['status'=>'you are successfully logged out'],200);
            }

           return response()->json(['status'=>'your are allready logged out cannot logout again'],400);
    }

}
