@extends('app')
@section('content')
    <div class="row">
        <div class="col-md-6">
            @if (session('success'))
             <p class="alert alert-success">{{session('success')}}</p>
                
            @endif
            @if ($errors->any())
            @foreach ($errors->all() as $err)
            <p class="alert alert-danger">{{$err}}</p>
            @endforeach
                
            @endif
            <form action="{{route('login.action')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <strong>username</strong>
                            <input type="text" name="username" class="form-control">
                           
                          
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <strong>password</strong>
                            <input type="password" name="password" class="form-control">
                           
                        </div>
                    </div>
                  
                    <div class="col-md-12"><button type="submit" class="mt-3 btn btn-primary">Login</button></div>
                    <div>
                        <a href="{{route('home') }}" class="btn btn-primary">back</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection