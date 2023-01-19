<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User_log extends Model
{
    use HasFactory;

    protected $table = 'user_log';
    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'type',
        'asset',
        'amount',
        'payment',
        'price',
        'destination_wallet',
        'status',
       
        
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
    
}

