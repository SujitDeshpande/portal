<!DOCTYPE html>
<html>

<head>
    @section('title', 'Communications')
    <link href="/css/plugins/iCheck/custom.css" rel="stylesheet">
    @include('site.includes.head')
    
</head>	

<body class="fixed-navigation">
    <div id="wrapper">
    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="sidebar-collapse">
          @include('site.includes.sidenav');
        </div>
    </nav>

    <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
            @include('site.includes.topbar')
        </div>


<div class="wrapper wrapper-content">
        <div class="row">
            <div class="col-lg-2">

            @include('site.communications.commsidebar')

            </div>
            <div class="col-lg-10 animated fadeInRight">
            <div class="mail-box-header">
                <div class="row">
                    <div class="col-md-8">
                        <h2>
                            @if($title == "")
                                All Messages <small>({{ $communicationCount }} unread)</small>
                            @else
                                {{ $title }}
                            @endif
                        </h2>
                    </div>
                    <div class="col-md-2 col-md-offset-2">
                        <form class="form-inline" >
                            <div tyle="float:right">
                                <label>Archives</label>
                                
                                    <div class="switch">
                                        <div class="onoffswitch">
                                            @if($archives)
                                            <input type="checkbox" checked="" class="onoffswitch-checkbox" id="archives" name="archives">
                                            @else
                                            <input type="checkbox" class="onoffswitch-checkbox" id="archives" name="archives">
                                            @endif
                                            <label class="onoffswitch-label" for="archives">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                    </div>
                               
                            </div>
                        </form>
                    </div>
                </div>

            </div>
                <div class="mail-box">


                <table class="table table-hover table-mail">
                <tbody>

                @foreach($communications as $communication)
                <?php $tr_class="" ?>
                @if( $communication->is_read == 1)
                    <?php $tr_class = "read";?>
                @else
                    <?php $tr_class = "unread"; ?>
                @endif

                @if($communication->archived)
                    <?php $tr_class .= " archived";?>
                @endif
                <tr class= "{{ $tr_class }}" >
                    <td class="check-mail">
                        <i class="fa fa-envelope-o"></i>
                    </td>

                    @if( $communication->communication_type_id == "1")
                        <td class="mail-subject">
                            @if($communication->has_attachments == true)
                                <i class="fa fa-paperclip"></i>
                            @endif
                            <a href="communication/show/{{ $communication->id }}">{{ $communication->subject }}</a>
                        </td>
                    @else
                        <td class="mail-subject">
                            @if($communication->has_attachments == true)
                                <i class="fa fa-paperclip"></i>
                            @endif
                            <a href="communication/show/{{ $communication->id }}">{{ $communication->subject }}</a> <span class="label label-sm label-{!! $communication->label_colour !!}">{!! $communication->label_name !!}</span></td>
                    @endif
                    
                    <td class="mail-preview"><a href="communication/show/{{ $communication->id }}">{!! $communication->trunc !!}</a></td>
                    <td class=""><!-- <i class="fa fa-paperclip"></i> --></td>
                    <td class="text-right mail-date">{{ $communication->prettyDate }} <small style="font-weight: normal;padding-left: 10px;">({{ $communication->since }} ago)</small></td>
                </tr>                

                @endforeach
                 
                </tbody>
                </table>


                </div>
            </div>
        </div>
        </div>



    @include('site.includes.footer')       

    <script type="text/javascript" src="/js/plugins/fullcalendar/moment.min.js"></script>
    @include('site.includes.scripts')
    <script src="/js/custom/site/getArchivedContent.js"></script>
    <script src="/js/plugins/iCheck/icheck.min.js"></script>
 
	<script>
        $(document).ready(function(){
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });
        });
    </script>

    @include('site.includes.modal')

</body>
</html> 