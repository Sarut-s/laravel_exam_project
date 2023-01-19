<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Orders;
use App\Models\Wallet;
use App\Helpers\LogActivity;
use Illuminate\Http\Request;
use Faker\Provider\ar_EG\Payment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TradeController extends Controller
{
    //
    public function trade(){

        $data['title'] = 'Trade';
        $data['columns'] = Wallet::getTableColumns();
        $data['wallet']  = Wallet::where('user_id',Auth::id())->first();
        $data['orders'] = Orders::all();
        
        return view('trade.trade',$data);


    }

    public function trade_action(Request $request){  
        
        $asset = $request->action.'_asset_select';
        $payment = $request->action.'_payment_select';
        $amount = $request->action.'amount';
        $price = $request->action.'price';
        $wallet = Wallet::getWallet(Auth::id());
        
        $payment = $request->$payment;
        $asset = $request->$asset;
        
        switch ($request->input('action')) {

            case 'buy':
                
                $total = $request->$price * $request->$amount;
                
                $request->validate([
                    $amount => 'required',
                    $price  =>  'required',
                ]);

                if($wallet->$payment<$total){
                    
                    return back()->withErrors(['msg' => 'not enough '.$payment]);
                };

                $wallet->update([
                    $payment => $wallet->$payment - $total,              
                ]);
                
                break;
    
            case 'sell':
                
                
                
                $request->validate([
                    $amount => 'required',
                    $price  =>  'required',
                ]);

                if($wallet->$asset<$request->$amount){
                    return back()->withErrors(['msg' => 'not enough '.$asset]);
                };

                $wallet->update([
                    $asset => $wallet->$asset - $request->$amount,              
                ]);

                break;

                dd('d');
  
        }

        $wallet = Wallet::getWallet(Auth::id());
        
            $order = new Orders([
                'user_id'  => $wallet->user_id,
                'user_wallet_id'=> $wallet->id,
                'payment_fiat'=>$payment,
                'asset' => $asset,
                'amount'=>$request->$amount,
                'price'=> $request->$price,
                'status'=> $request->action

            ]);
        $user = User::find(Auth::id());
        $user->order()->save($order);
        

        
        
       
        return back()->with('success','placeorder completed');
        
    }


    public function confirm($id){

        $order = Orders::getOrder($id);
       
        $data['title'] = 'Order confirm';
        $data['columns'] = Wallet::getTableColumns();
        $data['wallet']  = Wallet::where('user_id',Auth::id())->first();
        $data['orders'] = $order;
        
        return view('trade.confirm',$data);


    }


    public function confirm_action(Request $request)
    {   

        
        
        $id = $request->id;
        $order = Orders::getOrder($id);
        $seller_id = $order->user_id;
        $user_id = Auth::id();
      
        $wallet = Wallet::getWallet(Auth::id());
        $seller_wallet = Wallet::getWallet($seller_id);
        $Order_asset = $order->asset;
        $payment = $order->payment_fiat;
        
        switch ($request->input('action')) {
            case 'buy':
                
               
                if($wallet->$Order_asset<$request->amount_sell){
                    return back()->with('fail','not enough '. $Order_asset.' coin');
                }

                $request->validate([
                    'amount_sell' => 'required|gt:0|lte:'.$order->amount,
                ]);
                
                $total = $order->price * $request->amount_sell;
                
                
                
                if ($request->amount_sell==$order->amount) {
                    $order->update([
                       'status' => 'completed'
                    ]);
                }
                else {
                    $order->update([
                        'amount' => $order->amount - $request->amount_sell
                     ]);
                }
                $wallet->update([
                    
                    $Order_asset => $wallet->$Order_asset - $request->amount_sell,
                    $payment => $wallet->$payment + $total,
                ]);

                $seller_wallet->update([
                    $Order_asset => $seller_wallet->$Order_asset + $request->amount_sell,
                ]);

                LogActivity::createLog($user_id,'sell',$Order_asset,$request->amount_sell,$payment,$total,$seller_wallet->id);
                

                break;
                

    
            case 'sell':
                

            

                $request->validate([
                    'amount_buy' => 'required|gt:0|lte:'.$order->amount,
                ]);
                
                $total = $order->price * $request->amount_buy;
                
                
                if($wallet->$payment<$total){
                    return back()->with('fail','insufficient funds');
                };

                if ($request->amount_buy==$order->amount) {
                    $order->update([
                       'status' => 'completed'
                    ]);
                }
                else {
                    $order->update([
                        'amount' => $order->amount - $request->amount_buy
                     ]);
                }
                
                $wallet->update([
                    $payment => $wallet->$payment - $total,  
                    $Order_asset => $wallet->$Order_asset + $request->amount_buy,
                ]);

                $seller_wallet->update([
                    $payment => $seller_wallet->$payment + $total,
                ]);
                LogActivity::createLog($user_id,'buy',$Order_asset,$request->amount_buy,$payment,$total,$seller_wallet->id);
                

                break;
  
        }
         
        return redirect('trade')->with('success','order completed');

        
    }
}
