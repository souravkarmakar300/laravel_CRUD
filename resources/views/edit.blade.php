@extends('includes.header_footer')

@section('main')


         <h2>Update Products</h2>
         @if (session('success'))
         <div class="alert alert-success" role="alert">
             {{ session('success') }}
         </div>
     @endif     
      <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card p-2">
                    <div class="card-header text-center fs-3">{{ Str::upper($product->name) }}</div>
                    <form action="/products/{{ $product->id }}/update" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" value="{{$product->name}}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" class="form-control">{{ old('description', $product->description) }}</textarea>
                        </div>
                        
                        <div class="form-group">
                            <label for="image">Image</label>
                            <input type="file" name="image" id="image" class="form-control">
                            <img src="{{ asset('PublicImage/' . $product->image) }}" width="100" height="100" alt="image">
                        </div>
                        <button class="btn btn-primary btn-sm mt-2" type="submit">Update</button>
                    </form>
                </div>
            </div>
        </div>
      </div>
    
      @endsection()