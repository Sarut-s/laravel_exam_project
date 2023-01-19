@extends('app')
@section('content')
<div class="container mt-2">
    <div class="row">
        @if (session('success'))
        <p class="alert alert-success">{{session('success')}}</p>
        @elseif(session('fail'))   
        <p class="alert alert-danger">{{session('fail')}}</p>
        @endif
        @if ($errors->any())
        @foreach ($errors->all() as $err)
        <p class="alert alert-danger">{{$err}}</p>
        @endforeach
        @endif

        <div class="col-md-12 mb-5"> wallet  
            @foreach ($columns as $coin)
               | {{$coin}} : {{$wallet->$coin}} 
            @endforeach
            
        </div>
        <form action="{{route('trade.confirmaction') }}" method="POST" enctype="multipart/form-data">
            @csrf 
            @method('PUT')
            <div class="row">
                <div class="col-md-12 mb-2">
                    <div class="form-group">
                        <strong>user_id</strong>
                        <input type="text" name="userid" value="{{$orders->user_id}}" disabled  class="form-control">
                        <input name="id" type="hidden" value="{{$orders->id}}">
                        <input name="action" type="hidden" value="{{$orders->status}}">

                    </div>
                </div>
                <div class="col-md-12 mb-2">
                    <div class="form-group">
                        <strong>asset</strong>
                        <input type="text" name="asset" value="{{$orders->asset}}" disabled  class="form-control">
                        
                    </div>
                </div>
                <div class="col-md-12 mb-2">
                    <div class="form-group">
                        <strong>price</strong>
                        <input type="text" name="price" value="{{$orders->price}}" disabled  class="form-control">
                        
                    </div>
                </div>
                <div class="col-md-12 mb-2">
                    <div class="form-group">
                        <strong>amount</strong>
                        <input type="text" name="amount" value="{{$orders->amount}}" disabled  class="form-control">
                        
                    </div>
                </div>
                <div class="col-md-12 mb-2">
                    <div class="form-group">
                        <strong>payment</strong>
                        <input type="text" name="payment" value="{{$orders->payment_fiat}}" disabled  class="form-control">
                        
                    </div>
                </div>
                <div class="col-md-12 mb-2">
                    <div class="form-group">
                        @if ($orders->status=='buy')
                            <strong>sell {{$orders->asset}} amount</strong>
                            <input type="number" name="amount_sell"  class="form-control">
                        @else
                            <strong>buy {{$orders->asset}} amount</strong>
                            <input type="number" name="amount_buy"  class="form-control">
                        @endif

                        
                       
                    </div>
                </div>
                <div class="col-md-12"><button type="submit" class="mt-3 btn btn-primary">submit</button></div>
            </div>
        </form>
        <div class="mt-5">
            <a href="{{route('trade') }}" class="btn btn-primary">back</a>
        </div>
    </div>
    
</div>

@endsection