<?php

namespace App\Http\Controllers;

use App\Helpers\LogActivity;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class UserController extends Controller
{
    // register
    public function register(){
        $data['title'] = 'Register';
        return view('user.register',$data);
    }


    public function register_action(Request $request){

        $request->validate([
            'username' => 'required',
            'password' => 'required',
            'password_confirm' => 'required|same:password'
        ]);

        
        if( User::where('username',$request->username)->exists() ){
            return back()->withErrors(['username' => 'duplicate username ']);
        }
        $user = new User ([ 
            'username' => $request->username,
            'password' => Hash::make($request->password)
        ]);
        $user->save();
    // create wallet 
        $wallet = new Wallet([
            'THB' =>'0',
            'USD' =>'0',
            'BTC' =>'0',
            'ETH' =>'0',
            'XRP' =>'0',
            'DOGE' =>'0',
        ]);
        $user->wallet()->save($wallet);

        return redirect()->route('login')->with('success','Registration success');
        
    }
//////////////////////////////////////////////////////////////////////////////////////////
    // login 

    public function login(){
        $data['title'] = 'Login';
        return view('user.login',$data);
    }

    public function login_action(Request $request){

        $request->validate([
            'username' => 'required',
            'password' => 'required'
            
        ]);
        if(Auth::attempt(['username'=>$request->username,'password'=>$request->password])){
            $request->session()->regenerate();
            return redirect()->intended('/');
        }
        
        
        return back()->withErrors(['password' => 'Wrong username or password!']);
        
    }
//////////////////////////////////////////////////////////////////////////////////////////
    //change password

    public function password(){
        $data['title'] = 'Change Password';
        return view('user.password',$data);
    }

    public function password_action(Request $request){
        
        $request->validate([
            'old_password'=>'required|current_password',
            'new_password'=>'required',
            'new_password_confirm'=>'required|same:new_password',
            
            
        ]);
        $user = User::find(Auth::id());
        $user->password = Hash::make($request->new_password);
        
        $user->save();
        $request->session()->regenerate();
        return back()->with('success','Password change');
        
    }
//////////////////////////////////////////////////////////////////////////////////////////
    //logout
    public function  logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');

    }

///////////////////////////////////////////////////////////////////////////////////////
    // deposit
    // public function get_coin(){
    //     $columns = Schema::getColumnListing('wallets');
    //     array_splice($columns,0,2);
    //     array_splice($columns,-2);
        
    //     return $columns;
    // }

    public function deposit(){
        $data['title'] = 'deposit';
        $columns = Schema::getColumnListing('wallets');
       
        array_splice($columns,0,2);
        array_splice($columns,-2);
         $data['columns'] = $columns;
        return view('user.deposit',$data);
    }

    public function deposit_action(Request $request){
        
        $coin = $request->deposit_select;
        $user =  User::find(Auth::id());
        $balance = $user->wallet->$coin;
        $curr_balance = $balance + $request->amount;
        $user->wallet()->update([
            $coin => $curr_balance
        ]);

       
        return back()->with('success','Deposit complete');
        
    }

///////////////////////////////////////////////////////////////////////////////////////
    // tranfer
    public function transfer(){
        $data['title'] = 'Transfer';
        $columns = Schema::getColumnListing('wallets');
       
        array_splice($columns,0,2);
        array_splice($columns,-2);
        $data['columns'] = $columns;
       
        $wallet = Wallet::where('user_id',Auth::id())->first();
        $data['wallet'] = $wallet;
        
        

        return view('user.transfer',$data);
    }

    public function transfer_action(Request $request){  
       
        
        $coin = $request->transfer_select;
        $user =  User::find(Auth::id());
        $balance = Wallet::getWallet(Auth::id())->$coin;
        
        $userwallet_id = Wallet::where('user_id',Auth::id())->first()->id;
        
        
        if($balance==0){
            return back()->withErrors(['msg' => 'not enough coin ']);
        }
        $request->validate([
            'amount'=>'required|gt:0|lte:'.$balance,
            'wallet_id' => 'required',
               
        ]);
        
        if($request->wallet_id==$userwallet_id){
            return back()->withErrors(['msg' => 'cant transfer to your own wallet  ']);
        };
       
        $curr_balance = $balance - $request->amount;
        $user->wallet()->update([
            $coin => $curr_balance
        ]);

        if( Wallet::where('id',$request->wallet_id)->exists() ){
            
            $towallet = Wallet::where('id',$request->wallet_id)->first();
            $towallet->update([
            $coin => $towallet->$coin + $request->amount
        ]);
        }

        LogActivity::createLog($user->id,'transfer',$coin,$request->amount,'','',$request->wallet_id);
        
       
        return back()->with('success','transfer complete');
        
    }




}
