<?php

namespace App\Http\Controllers\Backend;

use App\Attachment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use App\ImageStore\Facades\Tool;
use App\Category;
use App\Product;
use App\Tag;
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
        // check valid
        $valid = Validator::make($request->all(), [
            'name' => 'required',
            'code' => 'required|unique:products,code',
            'content' => 'required',
            'regular_price' => 'required|numeric|min:0',
            'sale_price' => 'required|numeric|min:0',
            'original_price' => 'required|numeric|min:0',
            'quantity' => 'required|numeric|min:0',
            'image' => 'image|max:2048',
            'images.*' => 'image|max:2048',
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
            'quantity.numeric' => 'Vui lòng nhập số theo đúng định dạng',
            // min
            'regular_price.min' => 'Vui lòng nhập số nhỏ nhất cho phép là :min',
            'sale_price.min' => 'Vui lòng nhập số nhỏ nhất cho phép là :min',
            'original_price.min' => 'Vui lòng nhập số nhỏ nhất cho phép là :min',
            'quantity.min' => 'Vui lòng nhập số nhỏ nhất cho phép là :min',
            // unique
            'code.unique' => 'Mã sản phẩm đã được sử dụng, vui lòng nhập mã khác.',
            // exists
            'category_id.exists' => 'ID Chuyên mục không hợp lệ',
            // image
            'image.image' => 'Không đúng định dạng hình ảnh cho phép (jpg, png...)',
            'images.*.image' => 'Không đúng định dạng hình ảnh cho phép (jpg, png...)',
            // size
            'image.max' => 'Dung lượng ảnh vượt quá giới hạn cho phép là :max',
            'images.*.max' => 'Dung lượng ảnh vượt quá giới hạn cho phép là :max',
        ]);
        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        } else {
            // dd($request->all());
            // add images
            $imageName = null;
            if ($request->hasFile('image')) {
                $imageName = $this->saveImage($request->file('image'));
            }

            // add attributes
            $attributes = '';
            if (
                $request->has('attributes') && is_array($request->input('attributes'))
                && count($request->input('attributes')) > 0
            ) {
                $attributes = $request->input('attributes');
                foreach ($attributes as $key => $attribute) {
                    if (!isset($attribute['name'])) {
                        unset($attributes[$key]);
                        continue;
                    }
                    if (!isset($attribute['value'])) {
                        unset($attributes[$key]);
                        continue;
                    }
                }
                $attributes = json_encode($attributes);
            }

            // add product
            $product = Product::create([
                'name' => $request->input('name'),
                'code' => mb_strtoupper($request->input('code'), 'UTF-8'),
                'content' => $request->input('content'),
                'regular_price' => $request->input('regular_price'),
                'sale_price' => $request->input('sale_price'),
                'original_price' => $request->input('original_price'),
                'quantity' => $request->input('quantity'),
                'image' => $imageName,
                'attributes' => $attributes,
                'user_id' => auth()->id(),
                'category_id' => $request->input('category_id')
            ]);

            // add library images
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $file) {
                    Attachment::create([
                        'type' => 'images',
                        'mime' => $file->getMimeType(),
                        'path' => $this->saveImage($file),
                        'product_id' => $product->id
                    ]);
                }
            }

            // add tags
            if ($request->has('tags') && is_array($request->input('tags')) && count($request->input('tags')) > 0) {
                $tags = $request->input('tags');
                $tagsID = [];
                foreach ($tags as $tag) {
                    // firstOrCreate: check exsist and add new
                    $tag = Tag::firstOrCreate([
                        'name' => str_slug($tag)
                    ], [
                        'name' => str_slug($tag),
                        'slug' => str_slug($tag)
                    ]);
                    $tagsID[] = $tag->id;
                }
                $product->tags()->sync($tagsID);
            }

            return redirect()->route('admin.product.index')->with('message', "Create new product: $product->name success");
        }
    }

    public function show($id)
    {
        $data['product'] = Product::find($id);
        $data['categories'] = Category::orderBy('name', 'asc')->get();
        if ($data['product'] !== null) {
            return view('admin.products.show', $data);
        }
        return redirect()->route('admin.product.index')->with('error', "This product could not be found!");
    }

    public function update(Request $request, $id)
    {

        // check valid
        $valid = Validator::make($request->all(), [
            'name' => 'required',
            'code' => 'required|unique:products,code, ' . $id,
            'content' => 'required',
            'regular_price' => 'required|numeric|min:0',
            'sale_price' => 'required|numeric|min:0',
            'original_price' => 'required|numeric|min:0',
            'quantity' => 'required|numeric|min:0',
            'image' => 'image|max:2048',
            'images.*' => 'image|max:2048',
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
            'quantity.numeric' => 'Vui lòng nhập số theo đúng định dạng',
            // min
            'regular_price.min' => 'Vui lòng nhập số nhỏ nhất cho phép là :min',
            'sale_price.min' => 'Vui lòng nhập số nhỏ nhất cho phép là :min',
            'original_price.min' => 'Vui lòng nhập số nhỏ nhất cho phép là :min',
            'quantity.min' => 'Vui lòng nhập số nhỏ nhất cho phép là :min',
            // unique
            'code.unique' => 'Mã sản phẩm đã được sử dụng, vui lòng nhập mã khác.',
            // exists
            'category_id.exists' => 'ID Chuyên mục không hợp lệ',
            // image
            'image.image' => 'Không đúng định dạng hình ảnh cho phép (jpg, png...)',
            'images.*.image' => 'Không đúng định dạng hình ảnh cho phép (jpg, png...)',
            // size
            'image.max' => 'Dung lượng ảnh vượt quá giới hạn cho phép là :max',
            'images.*.max' => 'Dung lượng ảnh vượt quá giới hạn cho phép là :max',
        ]);
        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        } else {
            $product = Product::find($id);
            if ($product !== null) {

                // update images
                $imageName = $product->image;
                if ($request->hasFile('image')) {
                    // delete old-image
                    $this->deleteImage($product->image);

                    // save new image
                    $imageName = $this->saveImage($request->file('image'));
                }

                // update library images
                if ($request->hasFile('images')) {
                    // delete all-old-image-thumbnail
                    foreach ($product->attachments as $file) {
                        $this->deleteImage($file->path);
                        $file->delete();
                    }

                    // save new list images
                    foreach ($request->file('images') as $file) {
                        Attachment::create([
                            'type' => 'images',
                            'mime' => $file->getMimeType(),
                            'path' => $this->saveImage($file),
                            'product_id' => $product->id
                        ]);
                    }
                }

                // update attributes
                $attributes = '';
                if (
                    $request->has('attributes') && is_array($request->input('attributes'))
                    && count($request->input('attributes')) > 0
                ) {
                    $attributes = $request->input('attributes');
                    foreach ($attributes as $key => $attribute) {
                        if (!isset($attribute['name'])) {
                            unset($attributes[$key]);
                            continue;
                        }
                        if (!isset($attribute['value'])) {
                            unset($attributes[$key]);
                            continue;
                        }
                    }
                    $attributes = json_encode($attributes);
                }

                // update product
                $product->name = $request->input('name');
                $product->code = mb_strtoupper($request->input('code'), 'UTF-8');
                $product->content = $request->input('content');
                $product->regular_price = $request->input('regular_price');
                $product->sale_price = $request->input('sale_price');
                $product->original_price = $request->input('original_price');
                $product->quantity = $request->input('quantity');
                $product->image = $imageName;
                $product->attributes = $attributes;
                $product->user_id = auth()->id();
                $product->category_id = $request->input('category_id');
                $product->save();

                // update tags
                if ($request->has('tags') && is_array($request->input('tags')) && count($request->input('tags')) > 0) {
                    $tags = $request->input('tags');
                    $tagsID = [];
                    foreach ($tags as $tag) {
                        $tag = Tag::firstOrCreate([
                            'name' => str_slug($tag)
                        ], [
                            'name' => str_slug($tag),
                            'slug' => str_slug($tag)
                        ]);
                        $tagsID[] = $tag->id;
                    }
                    $product->tags()->sync($tagsID);
                }
                return redirect()->route('admin.product.index')->with('message', "Update info product: $product->name success");
            }
            return redirect()->route('admin.product.index')->with('error', "This product could not be found!");
        }
    }

    public function delete($id)
    {
        $product = Product::find($id);
        if ($product !== null) {
            // delete image
            $this->deleteImage($product->image);
            // delete all-image-thumbnail
            if (count($product->attachments) > 0) {
                foreach ($product->attachments as $file) {
                    $this->deleteImage($file->path);
                    $file->delete();
                }
            }
            $product->delete();
            return redirect()->route('admin.product.index')->with('message', "Delete product: $product->name success");
        }
        return redirect()->route('admin.product.index')->with('error', "This product could not be found!");
    }

    // function save Image
    public function saveImage($image)
    {
        if (!empty($image) && file_exists(public_path('uploads'))) {
            // arrangement folder by date
            $folderName = date('Y-m');

            // encode
            $fileNameWithTimestamp = md5($image->getClientOriginalName() . time());

            // fileName
            $fileName = $fileNameWithTimestamp . '.' . $image->getClientOriginalExtension();

            // check exists folder and create new folder
            if (!file_exists(public_path("uploads/$folderName"))) {
                mkdir(public_path("uploads/$folderName"), 0755);
            }

            // get imageName to save in SQL
            $imageName = "$folderName/$fileName";

            // move image to folder Uploads with fileName
            $image->move(public_path("uploads/$folderName"), $fileName);

            // create image by layout ratio
            $createImage = function ($suffix = '_thumb', $width = 250, $height = 170) use ($folderName,  $fileName, $fileNameWithTimestamp, $image) {
                // fileNameThumbnail
                $fileNameThumbnail = $fileNameWithTimestamp . $suffix . '.' . $image->getClientOriginalExtension();

                // save image thumbnail or ratio
                Image::make(public_path("uploads/$folderName/$fileName"))
                    ->resize($width, $height)
                    ->save(public_path("uploads/$folderName/$fileNameThumbnail"))
                    ->destroy();
            };
            $createImage();
            $createImage('_900x530', 900, 530);
            $createImage('_900x300', 900, 300);
            $createImage('_600x170', 600, 170);
            $createImage('_80x80', 80, 80);
        }
        return $imageName;
    }

    // function delete old-image
    public function deleteImage($path)
    {
        if (!is_dir(public_path('uploads/' . $path)) && file_exists(public_path('uploads/' . $path))) {
            unlink(public_path('uploads/' . $path));
            $deleteAllImages = function ($sizeArr) use ($path) {
                foreach ($sizeArr as $size) {
                    if (
                        !is_dir(public_path('uploads/' . get_thumbnail($path, $size))) &&
                        file_exists(public_path('uploads/' . get_thumbnail($path, $size)))
                    ) {
                        unlink(public_path('uploads/' . get_thumbnail($path, $size)));
                    }
                }
            };
            // delete list image thumbnail
            $deleteAllImages(['_thumb', '_900x530', '_900x300', '_600x170', '_80x80']);
        }
    }
}
