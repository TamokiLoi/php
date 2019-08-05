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
            'password' => 'required|confirmed'
        ], [
            'name.required' => 'Vui lòng nhập Họ và Tên', 
            'email.required' => 'Vui lòng nhập Email', 
            'email.email' => 'Không đúng định dạng Email', 
            'email.unique' => 'Email đã được sử dụng, vui lòng nhập Email khác.', 
            'password.required' => 'Vui lòng nhập Mật khẩu'
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
        $data['user'] = User::find($id);
        if ($data['user'] !== null) {
            return view('admin.users.show', $data);
        }
        return redirect()->route('admin.user.index')->with('error', "This user could not be found!");
    }

    public function update(Request $request, $id)
    {
        $valid = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'confirmed'
        ], [
            'name.required' => 'Vui lòng nhập Họ và Tên', 
            'email.required' => 'Vui lòng nhập Email', 
            'email.email' => 'Không đúng định dạng Email', 
            'email.unique' => 'Email đã được sử dụng, vui lòng nhập Email khác.', 
        ]);
        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        } else {
            $user = User::find($id);
            if ($user !== null) {
                $user->name = $request->input('name');
                $user->email = $request->input('email');
                if ($request->input('password')) {
                    $user->password = bcrypt($request->input('password'));
                }
                $user->save();
                return redirect()->route('admin.user.index')->with('message', "Update infor user: $user->name success");
            }
            return redirect()->route('admin.user.index')->with('error', "This user could not be found!");
        }
    }

    public function delete($id)
    {
        $user = User::find($id);
        if ($user !== null) {
            $user->delete();
            return redirect()->route('admin.user.index')->with('message', "Delete user: $user->name success");
        }
        return redirect()->route('admin.user.index')->with('error', "This user could not be found!");
    }
}
