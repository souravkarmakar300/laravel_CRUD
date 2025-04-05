@extends('includes.header_footer')

@section('main')


    <div class="container">
        <div class="row">
                <div class="card col-md-6 mt-5">
                    <h2>User Name is => {{Str::upper($product->name)}}</h2>
                    <h4>User Description is => {{$product->description}}</h4>
                    <img src="{{asset('PublicImage/'.$product->image)}}" width='200' height='200' alt="image">
                </div>
        </div>
    </div>
    
    @endsection()

