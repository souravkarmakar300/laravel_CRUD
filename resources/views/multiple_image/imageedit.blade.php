<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Upload Multiple Images (AJAX)</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
</head>

<body>

    <div class="container pt-5">
        <div class="row">
            <div class="col-md-6">
                <h4>Edit Upload Multiple Images</h4>
                <form action="{{ route('image.update', $imageData->id) }}" method="POST" id="uploadForm" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="text-info bg-light">
                        @if (Session::has('success'))
                            {{ Session::get('success') }}
                        @endif
                        @if (Session::has('failed'))
                            {{ Session::get('failed') }}
                        @endif
                    </div>
                    <div class="mb-3">
                        <input type="text" name="name" class="form-control" value="{{ $imageData->name }}"
                            id="name" placeholder="Enter your name">
                        {{-- <div class="invalid-feedback" id="name-error"></div> --}}
                        <span class="text-danger">
                            @error('name')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                    <div class="mb-3">
                        <input type="text" name="quantity" class="form-control" value="{{ $imageData->quantity }}"
                            id="quantity" placeholder="Enter quantity">
                        {{-- <div class="invalid-feedback" id="quantity-error"></div> --}}
                        <span class="text-danger">
                            @error('quantity')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                    <div class="mb-3">
                        <input type="file" name="images[]" multiple accept="image/*" class="form-control"
                            id="images">
                                @foreach (json_decode($imageData->images, true) as $imagess)
                                <div class="folat-image-preview" style="display: inline-block; margin-right: 5px;">
                                    <img src="{{ asset('storage/' . $imagess) }}" alt="Image"
                                        style="height: 50px; width: 50px; margin-right: 5px;">
                                </div>
                            @endforeach
                    </div>
                    <button type="submit" class="btn btn-primary">Upload</button>
                </form>
            </div>
        </div>
    </div>


</body>

</html>
