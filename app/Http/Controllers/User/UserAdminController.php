<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Banner;
use App\Models\UserGroup;
use App\Models\UserBanner;


class UserAdminController extends Controller
{
    /**
     * Instantiate a new UserAdminController instance.
     */
    public function __construct()
    {        
        $this->middleware('admin.auth');
        $this->middleware('superadmin.auth');
        $this->middleware('banner');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $user = User::getAdminUsers();
        return $user;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $banners = Banner::lists('name', 'id');

        $groups = UserGroup::lists('name', 'id');
        
        return view('superadmin.user.create')->with('banners', $banners)
                                        ->with('groups', $groups);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = User::createAdminUser($request);
        return ($user);
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
        $user = User::find($id);
        $banners = Banner::lists('name', 'id');
        $selected_banner_ids = UserBanner::where('user_id', $id)->get()->pluck('banner_id');
        $selected_banners = Banner::findMany($selected_banner_ids)->pluck('id')->toArray();

        $groups = UserGroup::lists('name', 'id');
        
        return view('superadmin.user.edit')->with('user', $user)
                                            ->with('banners', $banners)
                                            ->with('selected_banners', $selected_banners)
                                            ->with('groups', $groups);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {  
        User::updateAdminUser($id, $request);    
        return ($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::where('id', $id)->delete();
        return;
    }
}