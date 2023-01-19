<?php 

namespace App\Helpers;

use App\Models\User;

use App\Models\User_log ;
use Illuminate\Support\Facades\Auth;


class LogActivity
{




    public static function createLog($user_id,$type,$asset,$amount,$payment,$price,$destination_wallet)
    {

        
        $log = new User_log([
            'user_id' => $user_id,
            'type' => $type,
            'asset' => $asset,
            'amount'=>$amount,
            'payment'=>$payment,
            'price'=> $price,
            'destination_wallet'=> $destination_wallet,
            'status'=> '',
        ]);
        
        

        $user = User::find($user_id);
        
        $user->userlog()->save($log);
        
        
    	
    }
   
   

}

