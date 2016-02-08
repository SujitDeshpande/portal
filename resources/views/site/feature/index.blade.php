<!DOCTYPE html>
<html>

<head>
    @section('title', 'Feature: ' . $feature->title)
    <link href="/css/plugins/iCheck/custom.css" rel="stylesheet">
    
    @include('site.includes.head')
    <link rel="stylesheet" type="text/css" href="/css/custom/site/feature.css">
    <style>
    #page-wrapper{
        background: linear-gradient(to bottom, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 0) 65%, rgba(0, 0, 0, 1) 100%), url('/images/featured-backgrounds/{{ $feature->background_image }}') no-repeat 0px 50px; 
        background-size: cover;
        overflow: hidden;
    }

    #footer{
        position: fixed;
        bottom: 0px;
    }

    </style>
</head> 

<body class="fixed-navigation">
    <div id="wrapper">
        <nav class="navbar-default navbar-static-side" role="navigation">
            <div class="sidebar-collapse">
              @include('site.includes.sidenav')
            </div>
        </nav>

        <div id="page-wrapper" class="gray-bg clearfix">
            <div class="row border-bottom">
                @include('site.includes.topbar')
            </div>



            <div class="wrapper wrapper-content">

            <h1 style="color: #fff; font-size: 65px; text-transform: uppercase; font-family: GalaxiePolarisCondensed-Bold;text-shadow: 3px 3px 23px rgba(0, 0, 0, 1);padding-bottom: 10px;">{{ $feature->title }}</h1>

                <div class="row">
                    <div class="col-lg-8">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h2>Featured Documents</h2>
                            </div>
                      
                            <div class="ibox-content clearfix">

                            @foreach ($feature_documents as $document)
                                    <?php
                                        $icon ="";
                                        switch($document->original_extension){
                                            case "mp4":
                                                $icon ="fa-film";
                                                break;
                                            case "pdf":
                                                $icon  = "fa-file-pdf-o";
                                                break;
                                            case "xls":
                                            case "xlsx":
                                            case "xlsm":
                                                $icon = "fa-file-excel-o";
                                                break;
                                            case "jpg":
                                            case "png":
                                            case "bmp":
                                            case "gif":
                                            case "psd":
                                                $icon = "fa-file-image-o";
                                                break;
                                            default:
                                                $icon = "fa-file-o";
                                                break;
                                        }
                                    ?>
                                    <div class="feature_documents launchPDFViewer" data-toggle="modal" id="package-document-{{$document->id}}" data-packageDocumentId={{$document->id}} data-file="/viewer/?file=/files/{{$document->filename}}" data-target="#fileviewmodal">
                                        <i class="fa fa-file-pdf-o"></i>  {{$document->original_filename}} 
                                    </div>
                                    
                                        
                                    
                            @endforeach

                            </div>
                        </div>
                        


                        <div class="row">
                            <div class="col-lg-12">
                                <div class="ibox float-e-margins">
                                    <div class="ibox-title">
                                        <h2>Packages</h2>
                                    </div>
                              
                                    <div class="ibox-content clearfix">
                                        <div class="row">
                                            <div class="col-lg-4 package-listing">
                                            @foreach($feature_packages as $package)

                                                <div class="feature_package" id="feature-package-{{$package->id}}" data-packageId = {{$package->id}}>
                                                    <h4><i class="fa fa-gift"></i> {{$package->package_screen_name}} </h4>
                                                    <?php  $package_folder_listing = $package['details']['package_folders']; ?>
                                                    <?php  $package_folder_tree = $package['details']['package_folder_tree']; ?>
                                                    <div class="package-folder-listing hidden" data-packageid= {{$package->id}}>
                                                        
                                                        @foreach ($package_folder_listing as $folder)
                                                            <div class="package_folders" id="package-folder-{{$folder->global_folder_id}}" data-packageFolderId={{$folder->global_folder_id}}>
                                                                <?php $folderstructure = ($package['details']['package_folder_tree'][$folder->global_folder_id]); ?>
                                                                <?php $folder_root = ($package['details']['package_folder_tree'][$folder->global_folder_id][$folder->global_folder_id]); ?>
                                                                <ul class="tree">
                                                                @include('site.feature.folder-structure-partial', ['folderstructure' => $folderstructure, 'folder' =>$folder_root])
                                                                </ul>
                                                            </div>
                                                            
                                                        @endforeach
                                                    </div>
                                                </div>
                                                
                                            @endforeach
                                            </div>

                                            <div class="col-lg-8 package-document-container">


                                                @foreach($feature_packages as $package)
                                                    <?php $package_document_listing = $package['details']['package_documents']; ?>
                                                    
                                                    <div  class="package-document-listing hidden" data-packageid= {{$package->id}} >

                                                        @foreach ($package_document_listing as $document)
                                                        <div class="package_documents launchPDFViewer" data-toggle="modal" id="package-document-{{$document->id}}" data-packageDocumentId={{$document->id}} data-file="/viewer/?file=/files/{{$document->filename}}" data-target="#fileviewmodal"><i class="fa fa-file-pdf-o"></i>  {{$document->original_filename}} </div>
                                                        
                                                           
                                                        @endforeach
                                                    </div>

                                                    <div class="package-folder-document-listing hidden" data-packageid = {{$package->id}}>

                                                    </div>

                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
{{--                         <div class="row">
                            <div class="col-lg-6">
                                <div class="ibox float-e-margins">
                                    <div class="ibox-title">
                                        <h2>Quick Links</h2>
                                    </div>
                              
                                    <div class="ibox-content">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-hover">
                                                <tbody>
                                                <tr>
                                                    
                                                    <td><a data-toggle="tab" href="#contact-1" class="client-link"><i class="fa fa-external-link"></i>  Visit The North Face Website</a></td>
                                                    
                                                </tr>
                                                <tr>
                                                    
                                                    <td><a data-toggle="tab" href="#contact-1" class="client-link"><i class="fa fa-external-link"></i>  Visit the Nike University</a></td>
                                                </tr>
                                                <tr>
                                                    
                                                    <td><a data-toggle="tab" href="#contact-1" class="client-link"><i class="fa fa-file-pdf-o"></i>  OH&amp;S</a></td>
                                                </tr>
                                                <tr>
                                                    
                                                   <td><a data-toggle="tab" href="#contact-1" class="client-link"><i class="fa fa-file-pdf-o"></i>  Store Repairs</a></td>
                                                </tr>
                                                <tr>
                                                    
                                                    <td><a data-toggle="tab" href="#contact-1" class="client-link"><i class="fa fa-external-link"></i>  Corporate Web Portal</a></td>
                                                </tr>
                                                <tr>
                                                    
                                                    <td><a data-toggle="tab" href="#contact-1" class="client-link"><i class="fa fa-calendar"></i>  Week 46 Workload Calendar</a></td>
                                                </tr>



                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>                              
                            </div>

                            <div class="col-lg-6">
                                <div class="ibox float-e-margins">
                                    <div class="ibox-title">
                                        <h2>Latest Communications</h2>
                                    </div>
                              
                                <div class="ibox-content">
                                <div class="feed-activity-list">

                                    <div class="feed-element">
                                        <div>
                                            <small class="pull-right">1m ago</small>
                                            <strong>Get Ready for Hockey Plus</strong>
                                            <div>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum</div>
                                            <small class="text-muted">Today 5:60 pm - 12.06.2014</small>
                                        </div>
                                    </div>

                                    <div class="feed-element">
                                        <div>
                                            <small class="pull-right">2m ago</small>
                                            <strong>Back to School Primer</strong>
                                            <div>There are many variations of passages of Lorem Ipsum available</div>
                                            <small class="text-muted">Today 2:23 pm - 11.06.2014</small>
                                        </div>
                                    </div>

                                    <div class="feed-element">
                                        <div>
                                            <small class="pull-right">5m ago</small>
                                            <strong>Information on New Accessories Fixtures</strong>
                                            <div>Contrary to popular belief, Lorem Ipsum</div>
                                            <small class="text-muted">Today 1:00 pm - 08.06.2014</small>
                                        </div>
                                    </div>

                                    <div class="feed-element">
                                        <div>
                                            <small class="pull-right">5m ago</small>
                                            <strong>Jumpstart Update for March 2016</strong>
                                            <div>The generated Lorem Ipsum is therefore </div>
                                            <small class="text-muted">Yesterday 8:48 pm - 10.06.2014</small>
                                        </div>
                                    </div>




                                </div>
                            </div>
                                </div>                              
                            </div>                            
                        </div> --}}


                      
                    </div>

                    <div class="col-lg-4">

                        <div class="row">

                            <div class="col-lg-12">
                                <div class="ibox float-e-margins">
                                    <div class="ibox-title">
                                        <h2>Latest Updates</h2>
                                    </div>
                                    <div class="ibox-content">

                                        <div>
                                            <div class="feed-activity-list">


                                                @foreach($notifications as $n)

                                                <?php
                                                    $icon ="";
                                                    switch($n->original_extension){
                                                        case "mp4":
                                                            $icon ="fa-film";
                                                            break;
                                                        case "pdf":
                                                            $icon  = "fa-file-pdf-o";
                                                            break;
                                                        case "xls":
                                                        case "xlsx":
                                                        case "xlsm":
                                                            $icon = "fa-file-excel-o";
                                                            break;
                                                        case "jpg":
                                                        case "png":
                                                        case "bmp":
                                                        case "gif":
                                                        case "psd":
                                                            $icon = "fa-file-image-o";
                                                            break;
                                                        default:
                                                            $icon = "fa-file-o";
                                                            break;
                                                    }
                                                ?>
                                                <div class="feed-element">
                                                    <span class="pull-left">
                                                        <h1><i class="fa {{ $icon }}"></i></h1>
                                                    </span>
                                                    <div class="media-body ">
                                                        <small class="pull-right">{{ $n->since }} ago</small>
                                                        <strong><a href="{{ $n->filename }}">{{ $n->title }}</a></strong> was {{ $n->verb }} <strong><a href="{{ $n->global_folder_id }}">{{ $n->folder_name}}</a></strong>. <br>
                                                        <small class="text-muted">{{ $n->prettyDate }}</small>

                                                    </div>
                                                </div>
                                                @endforeach

                                            </div>      

                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>


                </div>
           

                <br class="clearfix" />
            </div>





        </div>
    </div>

    @include('site.includes.footer')       
    @include('site.includes.scripts')
    @include('site.includes.bugreport')
    @include('site.includes.modal')


    <script type="text/javascript" src="/js/vendor/underscore-1.8.3.js"></script>
    <script type="text/javascript" src="/js/custom/site/features/showFeaturePackageDetails.js"></script>
    <script type="text/javascript" src="/js/custom/tree.js"></script>
    <script type="text/javascript" src="/js/vendor/lightbox.min.js"></script>
    <script type="text/javascript" src="/js/custom/site/documents/fileTable.js"></script>
    <script type="text/javascript" src="/js/custom/site/features/showFeaturePackageDetails.js"></script>
    <script type="text/javascript">
        $(".tree").treed({openedClass : 'fa-folder-open', closedClass : 'fa-folder'});
    </script>
</body>
</html> 