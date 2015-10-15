<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Folder;
use App\FolderStructure;
use App\Banner;

class FolderStructureAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $banner_id  = $request->get('banner_id');
        if (isset($banner_id)) {
            $banner = Banner::where('id', $banner_id)->first();
        }
        else {
            $banner = Banner::where('id', 1)->first();
        }  

        $navigation = FolderStructure::getNavigationStructure($banner->id);
        return view('admin.folderstructure-view')->with('navigation', $navigation)
                                                     ->with('banner', $banner);     
                                                
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $folders = Folder::getFolders();
        return view('admin.define-folder-relationship')
            ->with('folders', $folders);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        FolderStructure::createFolderStructure($request);
        //return "Relationship established: '" . $request->get('child') . "' is child of '" . $request->get('parent') . "'.";
        return redirect()->action('FolderStructureAdminController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
