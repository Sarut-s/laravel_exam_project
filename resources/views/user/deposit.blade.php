@extends('app')
@section('content')
<div class="container mt2">
    <div class="row">
        @if (session('success'))
        <p class="alert alert-success">{{session('success')}}</p>
           
        @endif
        @if ($errors->any())
        @foreach ($errors->all() as $err)
        <p class="alert alert-danger">{{$err}}</p>
        @endforeach
        @endif
        <form action="{{route('deposit.action')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-12"> Select Coin
                    <select class="js-states browser-default select2" name="deposit_select">
                        
                        @foreach($columns as $coin)
                            <option value="{{ $coin }}">{{ $coin}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        Amount <input type="number" name="amount" class="form-control">
                        
                    </div>
                </div>
                <div class="col-md-12"><button type="submit" class="mt-3 btn btn-primary">submit</button></div>
            </div> 
            <div>
                <a href="{{route('home') }}" class="btn btn-primary">back</a>
            </div>

        </form>
    </div>
</div>

@endsection