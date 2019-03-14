<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

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
        $data['users'] = User::paginate(10);
        return view('admin.users.index', $data);
    }

    public function create()
    {
        return 'create';
    }

    public function store(Request $request)
    {
        return 'store ' . $request->input('text');
    }

    public function show($id)
    {
        return view('test')->with(compact(['id']));
    }

    public function update(Request $request, $id)
    {
        return 'update ' . $id . $request;
    }

    public function delete()
    {
        return 'delete';
    }

}
