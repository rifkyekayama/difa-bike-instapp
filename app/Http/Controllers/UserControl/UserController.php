<?php

namespace App\Http\Controllers\UserControl;

use Illuminate\Http\Request;
use App\Http\Requests\UserControl\UserStore;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\UserControl\User;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $users = User::all();
        return view('pages.UserControl.index', compact('users'))->withTitle('User Control');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('pages.UserControl.create')->withTitle('Create User Control');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserStore $request)
    {
        //
        $user = new User;
        $user->name = $request->get('name');
        $user->email = $request->get('email');
        $user->password = bcrypt($request->get('password'));
        $user->save();

        flash('User berhasil disimpan.');

        return redirect()->route('user-control.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $user = User::find(decrypt($id));
        return view('pages.UserControl.edit', compact('user'))->withTitle('Edit User');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserStore $request, $id)
    {
        //
        $user = User::find(decrypt($id));
        $user->name = $request->get('name');
        $user->email = $request->get('email');
        $user->password = bcrypt($request->get('password'));
        $user->update();

        flash('User berhasil diubah.');

        return redirect()->route('user-control.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $user = User::find(decrypt($id));
        $user->delete();

        $users = User::all();
        return view('pages.UserControl._table-user', compact('users'));
    }
}
