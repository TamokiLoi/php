<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Validator;

class UserController extends Controller
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

    public function index()
    {
        $data['users'] = User::orderBy('id', 'desc')->paginate(5);
        return view('admin.users.index', $data);
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $valid = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required||confirmed'
        ], [
            'name.required' => 'Vui lòng nhập họ và tên', 
            'email.required' => 'Vui lòng nhập email', 
            'email.email' => 'Không đúng định dạng email', 
            'password.required' => 'Vui lòng nhập mật khẩu', 
        ]);
        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        } else {
            $user = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => bcrypt($request->input('name')),
            ]);
            return redirect()->route('admin.user.index')->with('message', "Create new user: $user->name success");
        }
    }

    public function show($id)
    {
        return view('test')->with(compact(['id']));
    }

    public function update(Request $request, $id)
    {
        return 'Update: ' . $id . ', text: ' . $request->input('text');
    }

    public function delete()
    {
        return 'Delete';
    }
}
