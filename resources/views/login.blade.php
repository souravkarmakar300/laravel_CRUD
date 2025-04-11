<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login Page</title>
</head>

<body>
    <div class="container">
        <h1>Login</h1>
        @if (session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif
        @if (session('error'))
        <div class="alert alert-danger" role="alert">
            {{ session('error') }}
        </div>
    @endif
    <form action="{{ route('login.store') }}" method="post">
        @csrf
    
        <input type="text" name="phone_no" placeholder="Enter phone_no" value="{{ old('phone_no') }}"><br>
        @error('phone_no')
            <span style="color:red;">{{ $message }}</span><br>
        @enderror
    
        <input type="password" name="password" placeholder="Password"><br>
        @error('password')
            <span style="color:red;">{{ $message }}</span><br>
        @enderror
    
        @if ($errors->has('error'))
            <span style="color:red;">{{ $errors->first('error') }}</span><br>
        @endif
    
        <input type="submit" value="Login"><br>
        <a href="/">If you are not Login. Please Register </a>
    </form>
    
    </div>

</body>

</html>
