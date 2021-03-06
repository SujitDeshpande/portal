<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\Document\FolderStructure;
use App\Models\Document\Document;

class ApiController extends Controller
{
    
    public function getNavigation(Request $request)
    {
        $banner_id = $request->get('banner_id');
        if (isset($banner_id)) {
            
        }
        return FolderStructure::getNavigationStructure();

    }

    public function getDocumentsInFolder(Request $request)
    {
        return Document::getDocuments($request);
    }

    public function getDocumentById($fileId)
    {
        return Document::getDocumentById($fileId);  
    }
}
