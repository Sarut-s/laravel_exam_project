<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Orders extends Model
{
    use HasFactory;

    protected $table = 'orders';
    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'user_wallet_id',
        'payment_fiat',
        'asset',
        'amount',
        'price',
        'status'
        
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public static function getOrder($id) {
        return  Orders::where('id',$id)->first();
    }
}
