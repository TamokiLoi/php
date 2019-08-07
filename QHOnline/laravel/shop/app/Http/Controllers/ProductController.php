<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Validator;
use App\Category;
use Intervention\Image\Facades\Image;
use App\ImageStore\Facades\Tool;

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
        $data['products'] = Product::with('user')->orderBy('id', 'desc')->paginate(4);
        return view('admin.products.index', $data);
    }

    public function create()
    {
        $data['categories'] = Category::orderBy('name', 'asc')->get();
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
            'image' => 'image|max:2048',
            'category_id' => 'required|exists:categories,id',
        ], [
            // required
            'name.required' => 'Vui lòng nhập Tên sản phẩm',
            'code.required' => 'Vui lòng nhập Mã sản phẩm',
            'content.required' => 'Vui lòng nhập nội dung cho sản phẩm',
            'regular_price.required' => 'Vui lòng nhập giá thị trường',
            'sale_price.required' => 'Vui lòng nhập giá bán',
            'original_price.required' => 'Vui lòng nhập giá gốc',
            'quantity.required' => 'Vui lòng nhập số lượng',
            'category_id.required' => 'Vui lòng chọn chuyên mục',
            // numeric
            'regular_price.numeric' => 'Vui lòng nhập số theo đúng định dạng',
            'sale_price.numeric' => 'Vui lòng nhập số theo đúng định dạng',
            'original_price.numeric' => 'Vui lòng nhập số theo đúng định dạng',
            // min
            'regular_price.min' => 'Vui lòng nhập số nhỏ nhất cho phép là :min',
            'sale_price.min' => 'Vui lòng nhập số nhỏ nhất cho phép là :min',
            'original_price.min' => 'Vui lòng nhập số nhỏ nhất cho phép là :min',
            'quantity.min' => 'Vui lòng nhập số nhỏ nhất cho phép là :min',
            // unique
            'code.unique' => 'Mã sản phẩm đã được sử dụng, vui lòng nhập mã khác.',
            // exists
            'parent.exists' => 'ID Chuyên mục không hợp lệ',
            // image
            'image.image' => 'Không đúng định dạng hình ảnh cho phép (jpg, png...)',
            'image.max' => 'Dung lượng ảnh vượt quá giới hạn cho phép là :max',
        ]);
        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        } else {
            $imageName = '';
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                if (file_exists(public_path('uploads'))) {
                    // arrangement folder by date
                    $folderName = date('Y-m');

                    // encode
                    $fileNameWithTimestamp = md5($image->getClientOriginalName() . time());

                    // fileName
                    $fileName = $fileNameWithTimestamp . '.' . $image->getClientOriginalExtension();

                    // fileNameThumbnail
                    $fileNameThumbnail = $fileNameWithTimestamp . '_thumb' . '.' . $image->getClientOriginalExtension();

                    // check exists folder and create new folder
                    if (!file_exists(public_path("uploads/$folderName"))) {
                        mkdir(public_path("uploads/$folderName"), 0755);
                    }

                    // get imageName to save in SQL
                    $imageName = "$folderName/$fileName";

                    // move image to folder Uploads with fileName
                    $image->move(public_path("uploads/$folderName"), $fileName);

                    // save image thumbnail
                    Image::make(public_path("uploads/$folderName/$fileName"))
                        ->resize(100, 75)
                        ->save(public_path("uploads/$folderName/$fileNameThumbnail"));
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
                'image' => $imageName,
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
