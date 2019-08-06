<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Validator;

class ProductController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data['products'] = Product::with('user', 'category')->orderBy('id', 'desc')->paginate(5);
        return view('admin.products.index', $data);
    }

    public function create()
    {
        $data['categories'] = Product::orderBy('name', 'asc')->get();
        return view('admin.products.create', $data);
    }

    public function store(Request $request)
    {
        $valid = Validator::make($request->all(), [
            'name' => 'required',
            'code' => 'required|unique:products,code',
            'content' => 'required',
            'regular_price' => 'required|numeric|min:0',
            'sale_price' => 'required|numeric|min:0',
            'original_price' => 'required|numeric|min:0',
            'quantity' => 'required|numeric|min:0',
            'image' => 'image|size:2048',
            'category_id' => 'required|exists:categories,id'
        ]);
        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        } else {
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                if (file_exists(public_path('uploads'))) {
                    $folderName = date('Y-m');
                    $fileName = bcrypt($image->getClientOriginalName() . time());
                    if (!file_exists(public_path('uploads/' . $folderName))) {
                        mkdir(public_path('uploads/' . $folderName), 0755);
                    }
                    $image->move(public_path('uploads/' . $folderName), );
                }
            }
            $product = Product::create([
                'name' => $request->input('name'),
                'code' => mb_strtoupper($request->input('code'), 'UTF-8'),
                'content' => $request->input('content'),
                'regular_price' => $request->input('regular_price'),
                'sale_price' => $request->input('sale_price'),
                'original_price' => $request->input('original_price'),
                'quantity' => $request->input('quantity'),
                'user_id' => auth()->id(),
                'category_id' => $request->input('category_id')
            ]);
            return redirect()->route('admin.product.index')->with('message', "Create new product: $product->name success");
        }
    }

    public function show($id)
    {
        $data['product'] = Product::find($id);
        dd($data['product']->tags);
        if ($data['product'] !== null) {
            return view('admin.products.show', $data);
        }
        return redirect()->route('admin.product.index')->with('error', "This product could not be found!");
    }

    public function update(Request $request, $id)
    {
        $valid = Validator::make($request->all(), [
            'name' => 'required|unique:products,name,' . $id,
            'parent' => 'required'
        ]);
        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        } else {
            $product = Product::find($id);
            if ($product !== null) {
                $order = 0;
                if ($request->input('order')) {
                    $order = $request->input('order');
                }
                $product->name = $request->input('name');
                $product->parent = $request->input('parent');
                $product->order = $order;
                $product->save();
                return redirect()->route('admin.product.index')->with('message', "Update info product: $product->name success");
            }
            return redirect()->route('admin.product.index')->with('error', "This product could not be found!");
        }
    }

    public function delete($id)
    {
        $product = Product::find($id);
        if ($product !== null) {
            $product->delete();
            return redirect()->route('admin.product.index')->with('message', "Delete product: $product->name success");
        }
        return redirect()->route('admin.product.index')->with('error', "This product could not be found!");
    }
}
