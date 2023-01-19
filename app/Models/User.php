<?php

namespace App\Models;

use App\Models\User_log;
use App\Models\Orders;
use App\Models\Wallet;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    protected $table = 'users';
    protected $primaryKey = 'id';

    protected $fillable = ['username','password'];

    public function wallet(){

        return $this->hasOne(Wallet::class,'user_id','id');
        
    }

    public function order() {
        return $this->hasMany(Orders::class, 'user_id','id');
    }

    public function userlog() {
        return $this->hasMany(User_log::class, 'user_id','id');
    }
    

}
