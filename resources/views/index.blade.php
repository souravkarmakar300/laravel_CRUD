@extends('includes.header_footer')

@section('main')

    <div class="container">
        <a href="/products/create">Add Products</a>
        @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif
        <div class="row">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">Sl No</th>
                        <th scope="col">Name</th>
                        <th scope="col">Description</th>
                        <th scope="col">Image</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($showall as $item)
                        <tr>
                            <th>{{ $item->id }}</th>
                            <td><a href="products/{{$item->id}}/show">{{ $item->name }}</a></td>
                            <td>{{ $item->description }}</td>
                            <td><img src="PublicImage/{{ $item->image }}" class="rounded-circle" width='50'
                                    height='50' alt="image"></td>
                            <td>
                                <a href="products/{{ $item->id }}/edit" class="btn btn-primary btn-sm">Edit</a>
                                <form action="products/{{ $item->id }}/delete" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm mt-1">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @endsection()
