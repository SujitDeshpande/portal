<?php

namespace App\Http\Controllers\UrgentNotice;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as RequestFacade; 
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Skin;
use App\Models\Banner;
use App\Models\StoreInfo;
use App\Models\Communication\Communication;
use App\Models\UrgentNotice\UrgentNotice;


class UrgentNoticeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $storeNumber = RequestFacade::segment(1);
        $storeInfo = StoreInfo::getStoreInfoByStoreId($storeNumber);
        $storeBanner = $storeInfo->banner_id;
        $skin = Skin::getSkin($storeBanner);

        $urgentNoticeCount = UrgentNotice::getUrgentNoticeCount($storeNumber);
        $urgentNotices = UrgentNotice::getUrgentNoticesByStore($storeNumber);

        return view('site.urgentnotices.index')
            ->with('skin', $skin)
            ->with('urgentNoticeCount', $urgentNoticeCount)
            ->with('notices', $urgentNotices);      
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($sn, $id)
    {
        $storeNumber = RequestFacade::segment(1);
        $storeInfo = StoreInfo::getStoreInfoByStoreId($storeNumber);
        $storeBanner = $storeInfo->banner_id;

        $skin = Skin::getSkin($storeBanner);

        $communicationCount = Communication::getCommunicationCount($storeNumber); 

        $urgentNoticeCount = UrgentNotice::getUrgentNoticeCount($storeNumber);

        $notice = UrgentNotice::getUrgentNotice($id);

        return view('site.urgentnotices.notice')
            ->with('skin', $skin)
            ->with('notice', $notice)
            ->with('communicationCount', $communicationCount)
            ->with('urgentNoticeCount', $urgentNoticeCount);        
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
        //
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
    }
}
