<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Str;

class CategoryController extends Controller
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
        $data['categories'] = Category::orderBy('id', 'desc')->paginate(5);
        return view('admin.categories.index', $data);
    }

    public function create()
    {
        $data['categories'] = Category::where([
            ['parent', '=', 0],
            ['id', '<>', 1],
        ])->get();
        return view('admin.categories.create', $data);
    }

    public function store(Request $request)
    {
        $valid = Validator::make($request->all(), [
            'name' => 'required|unique:categories,name',
            'parent' => 'required'
        ]);

        $valid->sometimes('parent', 'exists:categories,id', function($input) {
            return $input->parent !== "0";
        });
        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        } else {
            $order = 0;
            if ($request->input('order')) {
                $order = $request->input('order');
            }
            $category = Category::create([
                'name' => $request->input('name'),
                'slug' => Str::slug($request->input('name')),
                'parent' => $request->input('parent'),
                'order' => $order
            ]);
            return redirect()->route('admin.category.index')->with('message', "Create new category: $category->name success");
        }
    }

    public function show($id)
    {
        $data['category'] = Category::find($id);
        $data['categories'] = Category::where([
            ['parent','=', 0],
            ['id','<>', 1],
        ])->get();
        if ($data['category'] !== null) {
            return view('admin.categories.show', $data);
        }
        return redirect()->route('admin.category.index')->with('error', "This category could not be found!");
    }

    public function update(Request $request, $id)
    {
        $valid = Validator::make($request->all(), [
            'name' => 'required|unique:categories,name,' . $id,
            'parent' => 'required'
        ]);
        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        } else {
            $category = Category::find($id);
            if ($category !== null) {
                $order = 0;
                if ($request->input('order')) {
                    $order = $request->input('order');
                }
                $category->name = $request->input('name');
                $category->parent = $request->input('parent');
                $category->order = $order;
                $category->save();
                return redirect()->route('admin.category.index')->with('message', "Update info category: $category->name success");
            }
            return redirect()->route('admin.category.index')->with('error', "This category could not be found!");
        }
    }

    public function delete($id)
    {
        $category = Category::find($id);
        if ($category !== null) {
            $category->delete();
            return redirect()->route('admin.category.index')->with('message', "Delete category: $category->name success");
        }
        return redirect()->route('admin.category.index')->with('error', "This category could not be found!");
    }

}
