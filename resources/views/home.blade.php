@extends('app')
@section('content')

@auth
    
        <p>Username {{Auth::user()->username}} | 
        Wallet | THB : {{Auth::user()->wallet->THB}} |
        USD : {{Auth::user()->wallet->USD}} |
        BTC : {{Auth::user()->wallet->BTC}} |
        ETH : {{Auth::user()->wallet->ETH}} |
        XRP : {{Auth::user()->wallet->XRP}} |
        DOGE : {{Auth::user()->wallet->DOGE}}
        
        <a href="{{route('password') }}" class="btn btn-primary">change password</a>
        <a href="{{route('logout') }}" class="btn btn-danger">logout</a>
    
    
    
    </p>
    
        <a href="{{route('deposit') }}" class="btn btn-primary">deposit</a>
        <a href="{{route('transfer') }}" class="btn btn-primary">transfer</a>
        <div  class="mt-3">
            
    </div>

    <div class="container mt-5">
        <div class="row">
            <div class=" ">
                <a href="{{route('trade') }}" class="btn btn-primary">BUY-SELL COIN</a>
            </div>
        </div>   
    </div>
    
@endauth

@guest

    <a href="{{route('login') }}" class="btn btn-primary">login</a>
    <a href="{{route('register') }}" class="btn btn-info">register</a>
    
@endguest





@endsection