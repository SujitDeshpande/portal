<!DOCTYPE html>
<html>

<head>
    @section('title', 'Urgent Notice')
    @include('site.includes.head')
    <meta name="csrf-token" content="{!! csrf_token() !!}"/> 
</head>	

<body class="fixed-navigation">

    <input type="hidden" id="communication_id" name="communication_id" value="{{ $notice->id }}">
    <input type="hidden" id="store_id" name="store_id" value="{{ Request::segment(1) }}">

    <div id="wrapper">
    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="sidebar-collapse">
          @include('site.includes.sidenav')
        </div>
    </nav>

    <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
            @include('site.includes.topbar')
        </div>



<div class="wrapper wrapper-content">
        <div class="row">


		<div class="col-lg-12 animated fadeInRight">
            <div class="mail-box-header">
            	 <a href="../"><i class="fa fa-chevron-left"></i> Back</a>
                <h1>
                    {{ $notice->title }}
                     <span class="pull-right font-normal" style="font-size: 16px;">{{ $notice->prettyDate }} <small style="font-weight: normal;padding-left: 10px;">({{ $notice->since }} ago)</small></span>
                </h1>
               
            </div>
                <div class="mail-box">


                <div class="mail-body">
                    {!! $notice->description !!}
                </div>


                @if($notice->attachment_type_id == 1) {{-- folders --}}
                <div class="mail-attachment">
                    <h3>
                        <span><i class="fa fa-paperclip"></i> {{ count($attached_folders) }} attachments</span>
                    </h3>
                    @foreach($attached_folders as $folder)

                            <div class="file-box">
                                <div class="file">
                                    <a href="/{{ Request::segment(1) }}/document#!/{{ $folder->global_folder_id }}">

                                        <div class="icon">
                                            <i class="fa fa-folder-open"></i>
                                        </div>

                                        <div class="file-name">
                                            <div style="font-size: 16px; padding-bottom: 10px;"> {{ $folder->name }}</div>
                                            
                                            <small class="clearfix"><span class="text-muted pull-left">{{ $folder->prettyDate }}</span> <span class="text-muted pull-right">{{ $folder->since }} ago</span></small>
                                        </div>
                                    </a>
                                </div>

                            </div>                    
                    
                    @endforeach
                    <div class="clearfix"></div>
                </div>
                @endif

                @if($notice->attachment_type_id == 2) {{-- files --}}

                   <div class="mail-attachment">
                        <h3>
                            <span><i class="fa fa-paperclip"></i> {{ count($attached_documents) }} attachments</span>
                        </h3>

                        <div class="attachment">

                        	@foreach($attached_documents as $doc)
                       	    
                                <div class="file-box">
                                    <div class="file">
                                        {!! $doc->anchor_only !!}

    										<div class="icon">
                                                {!! $doc->icon !!}
                                            </div>


                                            <div class="file-name">
                                                <div style="font-size: 16px; padding-bottom: 10px;"> {{ $doc->title }}</div>
                                                
                                                <small class="clearfix"><span class="text-muted pull-left">{{ $doc->prettyDate }}</span> <span class="text-muted pull-right">{{ $doc->since }} ago</span></small>

                                            </div>
                                        </a>
                                        
                                    </div>

                                </div>

                            @endforeach

        
                            <div class="clearfix"></div>
                        </div>
					</div>

                @endif 


            </div>            

                
        
</div>



    @include('site.includes.footer')       

    <script type="text/javascript" src="/js/plugins/fullcalendar/moment.min.js"></script>
    
    @include('site.includes.scripts')
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });  
  
    </script>
<!--     <script type="text/javascript" src="/js/custom/site/communications/markAsRead.js"></script> -->

 

    @include('site.includes.bugreport')
	@include('site.includes.modal')
</body>
</html> 