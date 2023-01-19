@extends('app')
@section('content')
<div class="container mt-2">
    <div class="row">
        @if (session('success'))
        <p class="alert alert-success">{{session('success')}}</p>
        
        
        @endif
        @if ($errors->any())
        @foreach ($errors->all() as $err)
        <p class="alert alert-danger">{{$err}}</p>
        @endforeach
        @endif
        
        <div class="row pb-5">
            <div class="col-md-12">Username {{Auth::user()->username}} | wallet  
                @foreach ($columns as $coin)
                   | {{$coin}} : {{$wallet->$coin}} 
                @endforeach
                
            </div>
            
             
        </div> 
        <div class="div mt-2">-----------------------------------------------------</div>
        <div class="card">
            <div class="card-header">
                <h4>
                    Orders Details
                </h4>
            </div>
          
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>user_id</th>
                        <th>asset</th>
                        <th>amount</th>
                        <th>price</th>
                        <th>payment</th>
                        <th>action</th>
                    </tr>

                    @foreach ($orders as $item)
                        @if ($item->status=='completed')
                            @continue
                        @endif
                      <tr>
                        <td>{{$item->user_id}}</td>
                        <td>{{$item->asset}}</td>
                        <td>{{$item->amount}}</td>
                        <td>{{$item->price}}</td>
                        <td>{{$item->payment_fiat}}</td>

                        <td> 
                            @if (Auth::user()->id==$item->user_id)
                                your order
                            @elseif ($item->status=='buy')
                                <a href="{{route('trade.confirm',$item->id)}}" class="btn btn-success"> SELL</a>
                            @elseif ($item->status=='sell')
                                <a href="{{route('trade.confirm',$item->id)}}" class="btn btn-danger"> BUY </a>
                            
                            @endif
                        
                        </td>
                    </tr>    
                    @endforeach
                  
                </table>
            </div>
        </div>
        <div class="div mt-2">-----------------------------------------------------</div>
        <div class="div">Create  order</div>
        <form action="{{route('trade.action')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                
                <div class="col-md-12 mt-3"> Asset 
                    
                 <select class="js-states browser-default select2" name="buy_asset_select">
                        
                    @foreach($columns as $coin)
                        @if($coin=='THB'||$coin=='USD'){
                            @continue
                        }@endif
                        <option value="{{ $coin }}">{{ $coin}}</option>
                    @endforeach
                </select>
            --> With <select class="js-states browser-default select2" name="buy_payment_select">
                        
                        
                    <option value="THB">THB</option>
                    <option value="USD">USD</option>
                
            </select>

                <div class="form-group mt-3">
                    Buy Amount <input type="number" name="buyamount" class="form-control">
                </div>
                <div class="form-group mt-3">
                    Price <input type="number" name="buyprice" class="form-control">
                </div>
                </div>
                
                <div class="col-md-12">
                    <button type="submit" name="action" value="buy" class="mt-3 btn btn-primary">i want to buy</button> 
                </div>


             <div class="div mt-2">-----------------------------------------------------</div>
                <div class="col-md-12 mt-3"> Asset
                    <select class="js-states browser-default select2" name="sell_asset_select">
                        
                        @foreach($columns as $coin)
                            @if($coin=='THB'||$coin=='USD'){
                                @continue
                            }@endif
                            <option value="{{ $coin }}">{{$coin}}</option>
                        @endforeach
                    </select> --> With
                    <select class="js-states browser-default select2" name="sell_payment_select">
                        
                        
                            <option value="THB">THB</option>
                            <option value="USD">USD</option>
                        
                    </select>
                    <div class="form-group mt-3">
                        Sell  Amount <input type="number" name="sellamount" class="form-control">
                    </div>
                    <div class="form-group mt-3">
                        Price <input type="number" name="sellprice" class="form-control" >
                    </div>
               
                </div>

                <div class="col-md-12">
                    <button type="submit" name="action" value="sell" class="mt-3 btn btn-primary">i want to sell</button>
                </div>
            <div class="div mt-2">-----------------------------------------------------</div>
        
            </div> 
            <div class="mt-5">
                <a href="{{route('home') }}" class="btn btn-primary">back</a>
            </div>

        </form>
        
    </div>
</div>

@endsection


