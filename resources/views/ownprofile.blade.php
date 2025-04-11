@extends('includes.header_footer')

@section('main')


    <div class="container">
        <div class="row">
                <div class="card col-md-6 mt-5">
                    <h2>Name is => {{Str::upper(Auth::user()->name )}}</h2>
                    <h4>Contact No => {{ Auth::user()->phone_no }}</h4>
                </div>
        </div>
    </div>
    
    @endsection()