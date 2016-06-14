<!DOCTYPE html>
<html>

<head>
    @section('title', 'Calendar')
    @include('site.includes.head')
    <link rel="stylesheet" type="text/css" href="/css/custom/site/event.css">
</head>	

<body class="fixed-navigation">
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

       <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-10">
                <h2>Workload Calendar</h2>
{{--                 <ol class="breadcrumb">
                    <li><a href="/">Home</a></li>
                    <li><a href="/document">Documents</a></li>
                </ol> --}}
            </div>
            <div class="col-lg-2">

            </div>
        </div>


                    <div class="tabs-container wrapper wrapper-content animated fadeInRight">
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#tab-1" aria-expanded="true">Calendar View</a></li>
                            <li class=""><a data-toggle="tab" href="#tab-2" aria-expanded="false">Event List</a></li>
                        </ul>
                        <div class="tab-content">
                            <div id="tab-1" class="tab-pane active">
                                <div class="panel-body">

                                    <div class="ibox-content">
                                        <div id="calendar"></div>                        
                                    </div>

                                </div>
                            </div>
                            <div id="tab-2" class="tab-pane">
                                <div class="panel-body">
                                  
                                  <div class="ibox-content inspinia-timeline" style="display: block;">

                                        @foreach($events as $event)
                                        <div class="timeline-item">
                                            <div class="row">
                                                <div class="col-xs-4 date">
                                                    <i class="fa fa-calendar"></i>
                                                    {!! $event->prettyDateStart !!} 
                                                    <br>
                                                    <small class="text-navy">
                                                    @if( strtotime($event->start) < strtotime(date("y-m-d H:i:s")) )
                                                        {!! $event->since !!} ago
                                                    @else 
                                                        in {!! $event->since !!} 
                                                    @endif
                                                    
                                                    </small>
                                                </div>
                                                <div class="col-xs-8 content">
                                                    <span class="label label-primary">{!! $event->event_type_name !!}</span>
                                                    <p class="m-b-xs"><strong>{!! $event->title !!}</strong></p>
                                                    <p>{!! $event->description !!}</p>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach

                                    </div> 

                                </div>
                            </div>
                        </div>


                    </div>


{{--
         <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox float-e-margins">
                
                            <div class="ibox-content">
                                <div id="calendar"></div>                        
                            </div>
                        </div>
                        
                    </div>
                </div>
         </div>
--}}


    @include('site.includes.footer')       
    @include('site.includes.scripts')

    <script type="text/javascript" src="/js/plugins/fullcalendar/moment.min.js"></script>
    <script type="text/javascript" src="/js/plugins/fullcalendar/fullcalendar.min.js"></script>
    
    <script type="text/javascript">
    $(function() { // document ready

        var date = new Date();
        var d = date.getDate();
        var m = date.getMonth() + 1;
        var y = date.getFullYear();
        var today = y + "-" + m + "-" + d;

        $('#calendar').fullCalendar({
            eventStartEditable: false,
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay,list'
            },
            defaultDate: today,
            editable: true,
            eventDurationEditable: false,
            eventLimit: true, // allow "more" link when too many events
            eventClick:  function(event, jsEvent, view) {
                console.log(event.start);
                $('#modalTitle').html("<span class='event-title pull-left'>" + event.title +"</span>");
                $('#modalTitle').append("<span class='event-span pull-right'>" + event.prettyStart+ " to " + event.prettyEnd + "</span>");
                $('#modalBody').html(event.description);
                $('#fullCalModal').modal();
            },
            events: [
                @foreach($events as $event)
                {
                title: "{!! $event->title !!}",
                start: "{!! $event->start !!}",
                end: "{!! $event->end !!}",
                description : '{!! $event->description !!}',
                prettyStart : "{!! $event->prettyDateStart !!}",
                prettyEnd : "{!! $event->prettyDateEnd !!}",
                },
                @endforeach
            ]
        });
    });
    </script>

    @include('site.includes.modal')

</body>
</html>                