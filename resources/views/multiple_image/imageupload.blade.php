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
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6">
                <h4>Upload Multiple Images</h4>
                <form action="{{ route('images.store') }}" method="post" id="uploadForm" enctype="multipart/form-data">
                    @csrf
                    <div class="text-info bg-light">
                        @if (Session::has('success'))
                            {{ Session::get('success') }}
                        @endif
                        @if (Session::has('failed'))
                            {{ Session::get('failed') }}
                        @endif
                    </div>
                    <div class="mb-3">
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}"
                            id="name" placeholder="Enter your name">
                        {{-- <div class="invalid-feedback" id="name-error"></div> --}}
                        <span class="text-danger">
                            @error('name')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                    <div class="mb-3">
                        <input type="text" name="quantity" class="form-control" value="{{ old('quantity') }}"
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
                        {{-- <div class="invalid-feedback" id="images-error"></div> --}}
                        {{-- <span class="text-danger">
                            @error('images')
                                {{ $message }}
                            @enderror
                        </span> --}}
                    </div>
                    <button type="submit" class="btn btn-primary">Upload</button>
                </form>
            </div>
            <div class="col-md-6">
                <table id="myTable" class="display">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Quantity</th>
                            <th>Image</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($images as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>
                                    @foreach (json_decode($item->images, true) as $imagess)
                                        <img src="{{ asset('storage/' . $imagess) }}" alt="Image"
                                            style="height: 50px; width: 50px; margin-right: 5px;">
                                    @endforeach
                                </td>
                                <td>
                                    <a href="{{ route('image.edit',$item->id )}}">Edit</a>
                                    <a href="#">Delete</a>
                                </td>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>




        {{-- <table id="myTable" class="display">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Quantity</th>
                    <th>Image</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($images as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>
                            @foreach (json_decode($item->images, true) as $imagess)
                                <img src="{{ asset('storage/' . $imagess) }}" alt="Image"
                                    style="height: 50px; width: 50px; margin-right: 5px;">
                            @endforeach
                        </td>
                @endforeach

            </tbody>
        </table> --}}
    </div>

    <!-- jQuery + Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.19.3/jquery.validate.min.js"></script>
    <!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable();
        });
    </script>
    {{-- <script>
        $(document).ready(function() {
        
            // Preview selected images
            $('#images').on('change', function () {
                $('#preview').html('');
                const files = this.files;
                if (files) {
                    Array.from(files).forEach(file => {
                        const reader = new FileReader();
                        reader.onload = function (e) {
                            $('#preview').append(`
                                <div class="col-md-4 mb-2">
                                    <img src="${e.target.result}" class="img-fluid img-thumbnail" style="height:150px;">
                                </div>
                            `);
                        };
                        reader.readAsDataURL(file);
                    });
                }
            });
        
            // jQuery validation rules
            $('#uploadForm').validate({
                rules: {
                    name: {
                        required: true
                    },
                    quantity: {
                        required: true,
                        number: true
                    },
                    'images[]': {
                        required: true,
                        extension: "jpg|jpeg|png|gif"
                    }
                },
                messages: {
                    name: "Please enter your name",
                    quantity: {
                        required: "Please enter quantity",
                        number: "Only numbers are allowed"
                    },
                    'images[]': {
                        required: "Please upload at least one image",
                        extension: "Only image files (jpg, jpeg, png, gif) are allowed"
                    }
                },
                submitHandler: function(form) {
                    var formData = new FormData(form);
                    
                    $.ajax({
                        url: $(form).attr('action'),
                        method: $(form).attr('method'),
                        data: formData,
                        processData: false,
                        contentType: false,
                        beforeSend: function () {
                            $('button[type=submit]').text('Uploading...').prop('disabled', true);
                        },
                        success: function(response) {
                            if (response.success) {
                                alert(response.message);
                                $('#uploadForm')[0].reset();
                                $('#preview').html('');
                            } else {
                                alert("Something went wrong.");
                            }
                        },
                        error: function(xhr) {
                            const errors = xhr.responseJSON.errors;
                            if (errors) {
                                let messages = '';
                                Object.values(errors).forEach(msg => {
                                    messages += msg + "\n";
                                });
                                alert(messages);
                            }
                        },
                        complete: function () {
                            $('button[type=submit]').text('Upload').prop('disabled', false);
                        }
                    });
                }
            });
        
        });
        </script> --}}

</body>

</html>
