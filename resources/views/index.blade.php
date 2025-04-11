@extends('includes.header_footer')

@section('main')
    <div class="container">

        @if (Gate::allows('isAdmin'))
        <h1 class="text-center">
            Welcome 
            <a href="{{ route('ownprofile', Auth::id()) }}">
                {{ strtoupper(Auth::user()->name) }}
            </a>
        </h1>
        
        @elseif (Gate::allows('isUser'))
        <h1 class="text-center">
            Welcome 
            <a href="{{ route('ownprofile', Auth::id()) }}">
                {{ strtoupper(Auth::user()->name) }}
            </a>
        </h1>
        
        @endif
        <a href="/products/create">Add Products</a>

        {{-- Alert Message --}}
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

                        {{-- View for ADMIN Using Gate --}}
                        @can('isAdmin')
                            <th scope="col">Description</th>
                        @endcan

                        <th scope="col">Image</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($showall as $item)
                        <tr>
                            <th>{{ $item->id }}</th>
                            {{-- <td><a href="products/{{ encrypt($item->id) }}/show">{{ $item->name }}</a></td> --}}
                            <td><a href="products/{{ $item->id }}/show">{{ $item->name }}</a></td>

                            {{-- View for ADMIN --}}
                            {{-- @if (Gate::allows('isAdmin'))
                                <td>{{ $item->description }}</td>
                            @endif --}}

                            {{-- View for ADMIN Using Gate --}}
                            @can('isAdmin')
                                <td>{{ $item->description }}</td>
                            @endcan

                            <td><img src="PublicImage/{{ $item->image }}" class="rounded-circle" width='50'
                                    height='50' alt="image"></td>
                            <td>

                                {{-- View for ADMIN Using Gate --}}
                                @can('isAdmin')
                                {{-- <a href="products/{{ encrypt($item->id) }}/edit" class="btn btn-primary btn-sm">Edit</a> --}}
                                <a href="products/{{ $item->id }}/edit" class="btn btn-primary btn-sm">Edit</a>
                                @endcan

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
