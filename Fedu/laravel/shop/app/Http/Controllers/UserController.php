<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
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
        ]);
        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        } else {
            $user = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => bcrypt($request->input('password')),
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
                return redirect()->route('admin.user.index')->with('message', "Update info user: $user->name success");
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
