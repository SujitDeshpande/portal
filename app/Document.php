<?php

namespace App;


use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use App\Week;
use App\Folder;
use App\FileFolder;
use Carbon\Carbon;


class Document extends Model
{
    protected $table = 'documents';
    protected $fillable = array('upload_package_id', 'original_filename','original_extension', 'filename', 'title', 'description', 'start', 'end', 'banner_id');

    public static function getDocuments($folder_id, $isWeek, $forApi=null)
    {

        if (isset($folder_id)) {
            

            $response = [];
            if($isWeek == "true"){

                $response["type"] = "week"; 
                
                $global_folder_id = \DB::table('folder_ids')->where('folder_id', $folder_id )
                                                            ->where('folder_type', 'week')
                                                            ->first()->id;
                
                $folder = Week::where('id', $folder_id)->first();
                
                $response["folder"] = [];
                array_push($response["folder"], $folder);
            }
            else{

                $response["type"] = "folder";

                $global_folder_id = \DB::table('folder_ids')->where('folder_id', $folder_id )
                                                            ->where('folder_type', 'folder')
                                                            ->first()->id;

                $folder = Folder::where('id', $folder_id)->first();    
                
                $response["folder"] = [];
                array_push($response["folder"], $folder);
            }
            
            if ($forApi) {
                $files = \DB::table('file_folder')
                            ->join('documents', 'file_folder.document_id', '=', 'documents.id')
                            ->where('file_folder.folder_id', '=', $global_folder_id)
                            ->where('documents.start', '<=', Carbon::now() )
                            ->select('documents.*')
                            ->get();  
            }
            else{
                $files = \DB::table('file_folder')
                            ->join('documents', 'file_folder.document_id', '=', 'documents.id')
                            ->where('file_folder.folder_id', '=', $global_folder_id)
                            ->select('documents.*')
                            ->get();            
            }
            $response["files"] = [];
            if (count($files) > 0) {
                 $response["files"] =  $files;
            }
            else{
                $response["files"] = null;
            }
            return $response;
            
        }
        return [];
    } 

    public static function storeDocument($request)
    {
        
        $metadata = Document::getDocumentMetaData($request->file('document'));       

        $directory = public_path() . '/files';
        $uniqueHash = sha1(time() . time());
        $filename  = $metadata["modifiedName"] . "_" . $uniqueHash . "." . $metadata["originalExtension"];

        $upload_success = $request->file('document')->move($directory, $filename); //move and rename file        

        if ($upload_success) {
            $documentdetails = array(
                'original_filename' => $metadata["originalName"],
                'filename'          => $filename,
                'original_extension'=> $metadata["originalExtension"],
                'upload_package_id' => $request->get('upload_package_id'),
                'title'             => "no title",
                'description'       => "no description",
                'banner_id'         => intval($request->get('banner_id'))
            );

            $document = Document::create($documentdetails);
            $document->save();
            $lastInsertedId= $document->id;

            $isWeekFolder = $request->get('isWeekFolder');
            $folder_type = "folder"; 
            if ($isWeekFolder == "true") {
                $folder_type = "week";
            }
            

            $folder_id = $request->get('folder_id');
            $global_folder_id = \DB::table('folder_ids')->where('folder_id', $folder_id)
                                                        ->where('folder_type', $folder_type)
                                                        ->first()->id;

            $documentfolderdetails = array(
                'document_id' => $lastInsertedId,
                'folder_id' => $global_folder_id
            );
           
            $documentfolder = FileFolder::create($documentfolderdetails);
            $documentfolder->save();
        }
    }

    public static function getDocumentMetaData($file)
    {
        
        $extension = $file->getClientOriginalExtension();
        $originalName = $file->getClientOriginalName();
        $modifiedName = str_replace(" ", "_", $originalName);
        $modifiedName = str_replace(".", "_", $modifiedName);

        $response = [];
        $response["originalName"] = $originalName;
        $response["modifiedName"] = $modifiedName;
        $response["originalExtension"] = $extension;

        return $response;
    }

    public static function getDocumentById($id)
    {
        $document =  Document::where('id', $id)->first();
        if ($document) {
            return $document;
        }
        return [];
    }

    public static function deleteDocument($id)
    {
        
        FileFolder::where('document_id', $id)->delete();
        $document = Document::find($id);
        unlink(public_path('files/'.$document->filename));
        $document->delete();
        return;
    }

    public static function updateMetaData(Request $request, $id=null)
    {
        
        if (!isset($id)) {
            $id = $request->get('file_id');
        }
        
        $title = $request->get('title');
        $description = $request->get('description');
        $start = $request->get('start');
        $end = $request->get('end');

        $metadata = array(
            'title'       => $title,
            'description' => $description,
            'start'       => $start,
            'end'         => $end
        );

        $document = Document::find($id);
        $document->update($metadata);

    }

    public static function getRecentDocuments($banner_id, $days)
    {
        $fromDate =  Carbon::today()->subDays($days);
        $documents = Document::where('start', '>=', $fromDate)
                            ->where('banner_id', $banner_id)    
                            ->orderBy('start','desc')
                            ->get();

        foreach ($documents as $document) {
            
            $global_folder_id = FileFolder::where('document_id',$document->id)->first()->folder_id;

            $global_folder_details =  \DB::table('folder_ids')->where('id', $global_folder_id)->first();
            $folder_id = $global_folder_details->folder_id;
            $folder_type = $global_folder_details->folder_type;


            if ($folder_type == 'folder') {
                $folder_details = Folder::where('id', $folder_id)->get();
            }
            else{
                $folder_details  = Week::where('id', $folder_id)->get();
            }

            $document["folder_details"] = $folder_details;
            unset($folder_id);
            unset($folder_details);

        }
        return $documents;
    }

    public static function getArchivedDocuments($folder_id)
    {
        $folder = Folder::find($folder_id);
        $archivedDocuments = [];
        if($folder->has_weeks == 1) {
            $weeksInFolder = Week::where('parent_id', $folder_id)->get();
            $counter = 0;
            foreach ($weeksInFolder as $weekInFolder) {
                $weekFolderId = $weekInFolder->id;
                $global_folder_id = \DB::table('folder_ids')->where('folder_id', $weekFolderId)
                                                            ->where('folder_type', 'week')
                                                            ->first()->id;
                $docs = FileFolder::where('folder_id', $global_folder_id)->get();
                if(count($docs)>0) {
                    $archivedDocuments[$counter]["folder"] = $weekInFolder;
                    $archivedDocuments[$counter]["number_of_documents"] = count($docs);
                    // $archivedDocuments[$counter]["docs"] = $docs;
                    $archivedDocuments[$counter]["doc_ids"] = [];
                    foreach ($docs as $doc) {
                        // $doc_details = Document::where('id', $doc->document_id)->first();
                        array_push($archivedDocuments[$counter]["doc_ids"], $doc->document_id);
                        unset($doc_details);
                    }
                    
                    $counter++;    
                }
                
            }
            return $archivedDocuments;
        }     
        
        
        else{
            $global_folder_id = \DB::table('folder_ids')->where('folder_id', $folder_id)
                                                            ->where('folder_type', 'folder')
                                                            ->first()->id;
            $docs = FileFolder::where('folder_id', $global_folder_id)->get();
            $archivedDocuments[0]["folder"] = $folder;
            $archivedDocuments[0]["number_of_documents"] = count($docs);
            $archivedDocuments[0]["docs"] = $docs;
            return $archivedDocuments;

        }
    }
}
