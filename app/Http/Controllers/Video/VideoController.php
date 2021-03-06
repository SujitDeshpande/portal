<?php

namespace App\Http\Controllers\Video;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as RequestFacade;
use DB;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Skin;

use App\Models\UrgentNotice\UrgentNotice;
use App\Models\Alert\Alert;
use App\Models\StoreInfo;

use App\Models\Video\Video;
use App\Models\Video\Tag;
use App\Models\Video\VideoTag;
use App\Models\Video\Playlist;
use App\Models\Video\PlaylistVideo;


class VideoController extends Controller
{
    private $storeNumber;
    private $storeInfo;
    private $banner;
    private $isComboStore;
    private $skin;
    private $communicationCount;
    private $urgentNoticeCount;
    private $alertCount;

    public function __construct(){
        $this->storeNumber = RequestFacade::segment(1);
        $this->storeInfo = StoreInfo::getStoreInfoByStoreId($this->storeNumber);
        $this->storeBanner = $this->storeInfo->banner_id;
        $this->banner = Banner::find($this->storeBanner);
        $this->isComboStore = $this->storeInfo->is_combo_store;
        $this->skin = Skin::getSkin($this->storeBanner);
        $this->urgentNoticeCount = UrgentNotice::getUrgentNoticeCount($this->storeNumber);
        $this->alertCount = Alert::getActiveAlertCountByStore($this->storeNumber);
        $this->communicationCount = DB::table('communications_target')
            ->where('store_id', $this->storeNumber)
            ->whereNull('is_read')
            ->count();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $featured = Video::getFeaturedVideo();
        $mostViewed = Video::getMostViewedVideos(4);
        $mostLiked = Video::getMostLikedVideos(4);
        $mostRecent = Video::getMostRecentVideos(4);
        $latestPlaylists = Playlist::getLatestPlaylists(3);
        // dd($featured);

        return view('site.video.index')
            ->with('mostLiked', $mostLiked)
            ->with('mostRecent', $mostRecent)
            ->with('mostViewed', $mostViewed)
            ->with('latestPlaylists', $latestPlaylists)
            ->with('featured', $featured)
            ->with('skin', $this->skin)
            ->with('banner', $this->banner)
            ->with('communicationCount', $this->communicationCount)
            ->with('urgentNoticeCount', $this->urgentNoticeCount)
            ->with('isComboStore', $this->isComboStore);
    }

    public function show(Request $request)
    {
        $video = Video::getSingleVideo($request->id);
        $playlists = Video::getPlaylistsThatContainSpecificVideo($request->id);

        return view('site.video.singlevideo')
            ->with('video', $video)
            ->with('playlists', $playlists)
            ->with('skin', $this->skin)
            ->with('banner', $this->banner)
            ->with('communicationCount', $this->communicationCount)
            ->with('urgentNoticeCount', $this->urgentNoticeCount)
            ->with('isComboStore', $this->isComboStore);
    }

    public function allPlaylists()
    {
        $playlists = Playlist::getLatestPlaylists();
        return view('site.video.allPlaylists')
            ->with('playlists', $playlists)
            ->with('skin', $this->skin)
            ->with('banner', $this->banner)
            ->with('communicationCount', $this->communicationCount)
            ->with('urgentNoticeCount', $this->urgentNoticeCount)
            ->with('isComboStore', $this->isComboStore);
    }

    public function showPlaylist(Request $request)
    {
        $videoList = PlaylistVideo::getPlaylistVideos($request->id);
        $playlistMeta = Playlist::getPlaylistMetaData($request->id);

        return view('site.video.playlist')
            ->with('playlistMeta', $playlistMeta)
            ->with('videoList', $videoList)
            ->with('skin', $this->skin)
            ->with('banner', $this->banner)
            ->with('communicationCount', $this->communicationCount)
            ->with('urgentNoticeCount', $this->urgentNoticeCount)
            ->with('isComboStore', $this->isComboStore);
    }

    public function showTag($tag)
    {
        return view('site.video.tag')
            ->with('skin', $this->skin)
            ->with('banner', $this->banner)
            ->with('communicationCount', $this->communicationCount)
            ->with('urgentNoticeCount', $this->urgentNoticeCount)
            ->with('isComboStore', $this->isComboStore);
    }

    public function mostViewed()
    {
        $mostViewed = Video::getMostViewedVideos();
        return view('site.video.popular')
            ->with('skin', $this->skin)
            ->with('banner', $this->banner)
            ->with('communicationCount', $this->communicationCount)
            ->with('urgentNoticeCount', $this->urgentNoticeCount)
            ->with('isComboStore', $this->isComboStore)
            ->with('mostViewed', $mostViewed);
    }
    public function mostRecent()
    {
        $mostRecent = Video::getMostRecentVideos();
        return view('site.video.latest')
            ->with('skin', $this->skin)
            ->with('banner', $this->banner)
            ->with('communicationCount', $this->communicationCount)
            ->with('urgentNoticeCount', $this->urgentNoticeCount)
            ->with('isComboStore', $this->isComboStore)
            ->with('mostRecent', $mostRecent);

    }
    public function mostLiked()
    {
        $mostLiked = Video::getMostLikedVideos();
        return view('site.video.liked')
            ->with('skin', $this->skin)
            ->with('banner', $this->banner)
            ->with('communicationCount', $this->communicationCount)
            ->with('urgentNoticeCount', $this->urgentNoticeCount)
            ->with('isComboStore', $this->isComboStore)
            ->with('mostLiked', $mostLiked);
    }

}
