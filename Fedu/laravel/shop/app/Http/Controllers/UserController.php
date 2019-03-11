<?php

namespace App\Http\Controllers;

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
        return 'Index';
    }

    public function create()
    {
        return 'Create';
    }

    public function store()
    {
        return 'store';
    }

    public function show($id)
    {
        return 'show ' . $id;
    }

    public function update()
    {
        return 'update';
    }

    public function delete()
    {
        return 'delete';
    }

}
