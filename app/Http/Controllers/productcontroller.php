<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use App\Models\products;

class productcontroller extends Controller
{
    public function index()
    {
        $showall = Products::all();
        return view('index', compact('showall'));
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
        $product = Products::findOrFail($id);
        return view('edit', compact('product'));
    }

    public function update(Request $request){

        // dd($request->all());
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'image' => 'nullable|mimes:png,jpg,pdf,jpeg|max:2048',
        ]);

        $product = Products::find($request->id);

        // Process Image Upload
        if(isset($request->image)){
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('PublicImage'), $imageName);
            
            if(!empty($product->image)){
                unlink(public_path('PublicImage/'.$product->image));
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

    public function show($id){
        
        $product = Products::find($id);

        return view('show', compact('product'));
    }

    public function destroy($id)
    {
        $product = Products::findOrFail($id);
        $product->delete();
        return redirect()->back()->withSuccess('Product deleted successfully.');
    }


}
