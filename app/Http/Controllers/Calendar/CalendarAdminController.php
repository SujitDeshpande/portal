<?php

namespace App\Http\Controllers\Calendar;

// use Validator;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Event\Event;
use App\Models\Event\EventType;
use App\Models\Tag\ContentTag;
use App\Models\Tag\Tag;
use App\Models\Banner;
use App\Models\UserBanner;
use App\Models\UserSelectedBanner;


class CalendarAdminController extends Controller
{
    /**
     * Instantiate a new CalendarAdminController instance.
     */
    public function __construct()
    {
        $this->middleware('admin.auth');
        $this->middleware('banner');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = \Auth::user()->id;
        $banner_ids = UserBanner::where('user_id', $user_id)->get()->pluck('banner_id');
        $banners = Banner::whereIn('id', $banner_ids)->get();        
        $banner_id = UserSelectedBanner::where('user_id', \Auth::user()->id)->first()->selected_banner_id;
        $banner  = Banner::find($banner_id);

        // return view('site.calendar.index');
        $events = Event::paginate(15);
        return view('admin.calendar.index')
            ->with('events', $events)
            ->with('banner', $banner)
            ->with('banners', $banners);            
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user_id = \Auth::user()->id;
        $banner_ids = UserBanner::where('user_id', $user_id)->get()->pluck('banner_id');
        $banners = Banner::whereIn('id', $banner_ids)->get();        
        $banner_id = UserSelectedBanner::where('user_id', \Auth::user()->id)->first()->selected_banner_id;
        $banner  = Banner::find($banner_id);

        $event_types_list = EventType::all();
        $tags = Tag::where('banner_id', 1)->lists('name', 'id');
        return view('admin.calendar.create')
            ->with('event_types_list', $event_types_list)
            ->with('tags', $tags)
            ->with('banner', $banner)
            ->with('banners', $banners);     
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Event::storeEvent($request);   
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('admin.calendar.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $event = Event::find($id);
        $event_type = EventType::find($id);
        $event_types_list = EventType::all();
        $banner = UserSelectedBanner::getBanner();
        $tags = Tag::where('banner_id', $banner->id)->lists('name', 'id');
        $tag_ids = ContentTag::where('content_id', $id)->where('content_type', 'event')->get()->pluck('tag_id');
        $selected_tags = Tag::findMany($tag_ids)->pluck('id')->toArray();

        return view('admin.calendar.edit')
            ->with('event', $event)
            ->with('event_type', $event_type)
            ->with('event_types_list', $event_types_list)
            ->with('tags', $tags)
            ->with('selected_tags', $selected_tags);
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

        Event::updateEvent($id, $request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id )
    {
        $event = Event::find($id);
        $event->delete();
    }
}
