<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Wallet extends Model
{
    use HasFactory;

    protected $table = 'wallets';
    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'THB',
        'USD',
        'BTC',
        'ETH',
        'XRP',
        'DOGE'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public static function getWallet($id){

        return  Wallet::where('user_id',$id)->first();
        
    }

 
    public static function getTableColumns()
{
    
    $columns = DB::getSchemaBuilder()->getColumnListing('wallets');
    array_splice($columns,0,2);
    array_splice($columns,-2);
    return $columns;

}

}
