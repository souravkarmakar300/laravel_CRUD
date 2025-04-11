<?php

namespace App\Http\Controllers;

use App\Models\ProductLogin;
use Illuminate\Http\Request;
use App\Models\products;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;

class productcontroller extends Controller
{
    public function register()
    {
        return view('register');
    }

    public function register_store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone_no' => 'required|unique:product_logins|digits:10',
            'password' => 'required|string|min:5',
        ]);

        $create = ProductLogin::create([
            'name' => $request->name,
            'phone_no' => $request->phone_no,
            'password' => Hash::make($request->password),
        ]);

        return redirect('/')->withSuccess('Registration successful. Please login.');
    }

    public function Show_login()
    {
        return view('login');
    }

    public function login_store(Request $request)
    {

        $reqData = $request->validate([
            'phone_no' => 'required|digits:10',
            'password' => 'required|string|min:5',
        ]);

        $credentials = [
            'phone_no' => $reqData['phone_no'],
            'password' => $reqData['password']
        ];
        // $userName = ProductLogin::where('phone_no', $reqData['phone_no'])->first();
        // dd($userName);

        if (auth('web')->attempt($credentials)) {
            return redirect('/index')->withSuccess('Login successfully');
        } else {
            return redirect()->back()->withErrors(['error' => 'Invalid credentials']);
        }
        // }

    }

    public function ownprofile($id){

        // if(Gate::allows('profile_view', $id)){

        // }else{
            
        // }
        $user = Auth::user();
        // dd($user);
        return view('ownprofile', compact('user'));
    }

    public function index()
    {

        // Gate::authorize('isAdmin');

        // $showall = Products::all();
        // return view('index', compact('showall'));

        if(Gate::allows('isAdmin')){
            $showall = Products::all();
            return view('index', compact('showall'));
        } else{
            $showall = Products::all();
            return view('index', compact('showall'));
        }

        // $showall = Products::all();
        // return view('index', compact('showall'));
    }

    public function create()
    {
        return view('create');
    }

    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'image' => 'required|mimes:png,jpg,pdf,jpeg|max:2048',
        ]);

        // Process Image Upload
        $imageName = time() . '.' . $request->image->extension();
        $request->image->move(public_path('PublicImage'), $imageName);

        // dd($request->image);
        // Save product
        $product = new Products(); // Ensure the model name is correct
        $product->name = $request->name;
        $product->description = $request->description;
        $product->image = $imageName;
        $product->save();
        return redirect()->back()->withSuccess('Product created successfully.');
    }

    public function edit($id)
    {
        // $id = Crypt::decrypt($id); // decrypt ID
        $product = Products::findOrFail($id);
        return view('edit', compact('product'));
    }

    public function update(Request $request)
    {

        // dd($request->all());
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'image' => 'nullable|mimes:png,jpg,pdf,jpeg|max:2048',
        ]);

        $product = Products::find($request->id);

        // Process Image Upload
        if (isset($request->image)) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('PublicImage'), $imageName);

            if (!empty($product->image)) {
                unlink(public_path('PublicImage/' . $product->image));
            }
            $product->image = $imageName;
        }
        // dd($imageName);

        //   dd($request->name);
        // Save product
        $product->name = $request->name;
        $product->description = $request->description;
        $product->save();

        return redirect()->back()->withSuccess('Product Updated successfully !!!');
    }

    public function show($id)
    {


        // $encrypted = 'eyJpdiI6Ik01MjBMeThsQk1NNzlHUFlSVWlueEE9PSIsInZhbHVlIjoiNlFFRG51ditSQVNVU2FOOHVrU3ZMUT09IiwibWFjIjoiN2JjNmYwYzNlMzVhODk0YWEyNjkyMmY4YTM3ZmMxY2U3ZDMzNDllMWNlNTMzM2Q4ZWY0YTNjNGE1ZDY4MGU4NCIsInRhZyI6IiJ9';

        // $enc = 'eyJpdiI6IjNBazdURDBxc1hzVG5pSEczUCt3QWc9PSIsInZhbHVlIjoiZ25ERkpSTXAzSzJNanRhR3l6SUF1UT09IiwibWFjIjoiMzAxMDMxYjIxMWM3MzJhZmE0OTUyMjE4Nzc0ODg0YjhkMThjYTIzY2MzZjBlNGM2NmQ5ZWVlMzg5MDY1YjRlMCIsInRhZyI6IiJ9';

        // if($encrypted == $enc){
        //     dd('yes');
        // }else{
        //     dd('no');
        // }
        
        // $decrypted = Crypt::decrypt($encrypted);
        //  dd($decrypted);         


        // $id = Crypt::decrypt($id); // decrypt ID

        $product = Products::findOrFail($id);

        return view('show', compact('product'));
    }

    public function destroy($id)
    {
        $product = Products::findOrFail($id);
        $product->delete();
        return redirect()->back()->withSuccess('Product deleted successfully.');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login')->withSuccess('Logout successfully');
    }
}
