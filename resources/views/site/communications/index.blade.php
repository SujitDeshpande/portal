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
                <div class="ibox float-e-margins">
                    <div class="ibox-content mailbox-content">
                        <div class="file-manager">
                            {{-- <a class="btn btn-block btn-primary compose-mail" href="mail_compose.html">Compose Mail</a> --}}
                            <div class="space-25"></div>
                            {{-- <h5>Folders</h5> --}}
                            <ul class="folder-list m-b-md" style="padding: 0">
                                <li>
                                    <a href="/{{ Request::segment(1) }}/communication"> <i class="fa fa-inbox "></i> All Messages 
                                    @if($communicationCount > 0)
                                    <span class="label label-inverse pull-right">{{ $communicationCount }}</span> 
                                    @endif
                                    </a>
                                </li>
{{--                                 <li><a href="mailbox.html"> <i class="fa fa-envelope-o"></i> Send Mail</a></li>
                                <li><a href="mailbox.html"> <i class="fa fa-certificate"></i> Important</a></li> --}}
{{--                                 <li><a href="mailbox.html"> <i class="fa fa-file-text-o"></i> Drafts <span class="label label-danger pull-right">2</span></a></li>
                                <li><a href="mailbox.html"> <i class="fa fa-trash-o"></i> Trash</a></li> --}}
                            </ul>
                            <h5>Categories</h5>
                            <ul class="category-list" style="padding: 0">
                            @foreach($communicationTypes as $c)

                                <li><a href="#"> <span class="label label-{{ $c->colour }} pull-right">{{ $c->count }}</span> {{ $c->communication_type }}</a></li>

                            @endforeach
                            </ul>
                                
{{--                            <li><a href="#"> <i class="fa fa-circle text-danger"></i> Documents</a></li>
                                <li><a href="#"> <i class="fa fa-circle text-primary"></i> Social</a></li>
                                <li><a href="#"> <i class="fa fa-circle text-info"></i> Advertising</a></li>
                                <li><a href="#"> <i class="fa fa-circle text-warning"></i> Clients</a></li> --}}
                            

{{--                             <h5 class="tag-title">Labels</h5>
                            <ul class="tag-list" style="padding: 0">
                                <li><a href=""><i class="fa fa-tag"></i> Family</a></li>
                                <li><a href=""><i class="fa fa-tag"></i> Work</a></li>
                                <li><a href=""><i class="fa fa-tag"></i> Home</a></li>
                                <li><a href=""><i class="fa fa-tag"></i> Children</a></li>
                                <li><a href=""><i class="fa fa-tag"></i> Holidays</a></li>
                                <li><a href=""><i class="fa fa-tag"></i> Music</a></li>
                                <li><a href=""><i class="fa fa-tag"></i> Photography</a></li>
                                <li><a href=""><i class="fa fa-tag"></i> Film</a></li>
                            </ul> --}}
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-10 animated fadeInRight">
            <div class="mail-box-header">

{{--                 <form method="get" action="index.html" class="pull-right mail-search">
                    <div class="input-group">
                        <input type="text" class="form-control input-sm" name="search" placeholder="Search email">
                        <div class="input-group-btn">
                            <button type="submit" class="btn btn-sm btn-primary">
                                Search
                            </button>
                        </div>
                    </div>
                </form> --}}
                <h2>
                    All Messages <small>({{ count($communications) }} unread)</small>
                </h2>

            </div>
                <div class="mail-box">


                <table class="table table-hover table-mail">
                <tbody>

                @foreach($communications as $communication)
                
                @if( $communication->is_read == 1)
                <tr class="read">
                @else
                <tr class="unread">
                @endif

                    <td class="check-mail">
                        <div class="icheckbox_square-green" style="position: relative;"><input type="checkbox" class="i-checks" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);"></ins></div>
                    </td>
                    <td class="mail-subject"><a href="communication/show/{{ $communication->id }}">{{ $communication->subject }}</a></td>
                    <td class="mail-subject"><a href="communication/show/{{ $communication->id }}">{!! $communication->trunc !!}</a></td>
                    <td class=""><i class="fa fa-paperclip"></i></td>
                    <td class="text-right mail-date">{{ $communication->send_at }}</td>
                </tr>                

                @endforeach
                 
                {{-- <tr class="unread">
                    <td class="check-mail">
                        <div class="icheckbox_square-green" style="position: relative;"><input type="checkbox" class="i-checks" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);"></ins></div>
                    </td>
                    <td class="mail-ontact"><a href="mail_detail.html">Anna Smith</a></td>
                    <td class="mail-subject"><a href="mail_detail.html">Lorem ipsum dolor noretek imit set.</a></td>
                    <td class=""><i class="fa fa-paperclip"></i></td>
                    <td class="text-right mail-date">6.10 AM</td>
                </tr>
                <tr class="unread">
                    <td class="check-mail">
                        <div class="icheckbox_square-green checked" style="position: relative;"><input type="checkbox" class="i-checks" checked="" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);"></ins></div>
                    </td>
                    <td class="mail-ontact"><a href="mail_detail.html">Jack Nowak</a></td>
                    <td class="mail-subject"><a href="mail_detail.html">Aldus PageMaker including versions of Lorem Ipsum.</a></td>
                    <td class=""></td>
                    <td class="text-right mail-date">8.22 PM</td>
                </tr>
                <tr class="read">
                    <td class="check-mail">
                        <div class="icheckbox_square-green" style="position: relative;"><input type="checkbox" class="i-checks" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);"></ins></div>
                    </td>
                    <td class="mail-ontact"><a href="mail_detail.html">Facebook</a> <span class="label label-warning pull-right">Clients</span> </td>
                    <td class="mail-subject"><a href="mail_detail.html">Many desktop publishing packages and web page editors.</a></td>
                    <td class=""></td>
                    <td class="text-right mail-date">Jan 16</td>
                </tr>
                <tr class="read">
                    <td class="check-mail">
                        <div class="icheckbox_square-green" style="position: relative;"><input type="checkbox" class="i-checks" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);"></ins></div>
                    </td>
                    <td class="mail-ontact"><a href="mail_detail.html">Mailchip</a></td>
                    <td class="mail-subject"><a href="mail_detail.html">There are many variations of passages of Lorem Ipsum.</a></td>
                    <td class=""></td>
                    <td class="text-right mail-date">Mar 22</td>
                </tr>
                <tr class="read">
                    <td class="check-mail">
                        <div class="icheckbox_square-green" style="position: relative;"><input type="checkbox" class="i-checks" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);"></ins></div>
                    </td>
                    <td class="mail-ontact"><a href="mail_detail.html">Alex T.</a> <span class="label label-danger pull-right">Documents</span></td>
                    <td class="mail-subject"><a href="mail_detail.html">Lorem ipsum dolor noretek imit set.</a></td>
                    <td class=""><i class="fa fa-paperclip"></i></td>
                    <td class="text-right mail-date">December 22</td>
                </tr>
                <tr class="read">
                    <td class="check-mail">
                        <div class="icheckbox_square-green" style="position: relative;"><input type="checkbox" class="i-checks" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);"></ins></div>
                    </td>
                    <td class="mail-ontact"><a href="mail_detail.html">Monica Ryther</a></td>
                    <td class="mail-subject"><a href="mail_detail.html">The standard chunk of Lorem Ipsum used.</a></td>
                    <td class=""></td>
                    <td class="text-right mail-date">Jun 12</td>
                </tr>
                <tr class="read">
                    <td class="check-mail">
                        <div class="icheckbox_square-green" style="position: relative;"><input type="checkbox" class="i-checks" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);"></ins></div>
                    </td>
                    <td class="mail-ontact"><a href="mail_detail.html">Sandra Derick</a></td>
                    <td class="mail-subject"><a href="mail_detail.html">Contrary to popular belief.</a></td>
                    <td class=""></td>
                    <td class="text-right mail-date">May 28</td>
                </tr>
                <tr class="read">
                    <td class="check-mail">
                        <div class="icheckbox_square-green" style="position: relative;"><input type="checkbox" class="i-checks" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);"></ins></div>
                    </td>
                    <td class="mail-ontact"><a href="mail_detail.html">Patrick Pertners</a> <span class="label label-info pull-right">Adv</span></td>
                    <td class="mail-subject"><a href="mail_detail.html">If you are going to use a passage of Lorem </a></td>
                    <td class=""></td>
                    <td class="text-right mail-date">May 28</td>
                </tr>
                <tr class="read">
                    <td class="check-mail">
                        <div class="icheckbox_square-green" style="position: relative;"><input type="checkbox" class="i-checks" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);"></ins></div>
                    </td>
                    <td class="mail-ontact"><a href="mail_detail.html">Michael Fox</a></td>
                    <td class="mail-subject"><a href="mail_detail.html">Humour, or non-characteristic words etc.</a></td>
                    <td class=""></td>
                    <td class="text-right mail-date">Dec 9</td>
                </tr>
                <tr class="read">
                    <td class="check-mail">
                        <div class="icheckbox_square-green" style="position: relative;"><input type="checkbox" class="i-checks" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);"></ins></div>
                    </td>
                    <td class="mail-ontact"><a href="mail_detail.html">Damien Ritz</a></td>
                    <td class="mail-subject"><a href="mail_detail.html">Oor Lorem Ipsum is that it has a more-or-less normal.</a></td>
                    <td class=""></td>
                    <td class="text-right mail-date">Jun 11</td>
                </tr>
                <tr class="read">
                    <td class="check-mail">
                        <div class="icheckbox_square-green" style="position: relative;"><input type="checkbox" class="i-checks" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);"></ins></div>
                    </td>
                    <td class="mail-ontact"><a href="mail_detail.html">Anna Smith</a></td>
                    <td class="mail-subject"><a href="mail_detail.html">Lorem ipsum dolor noretek imit set.</a></td>
                    <td class=""><i class="fa fa-paperclip"></i></td>
                    <td class="text-right mail-date">6.10 AM</td>
                </tr>
                <tr class="read">
                    <td class="check-mail">
                        <div class="icheckbox_square-green" style="position: relative;"><input type="checkbox" class="i-checks" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);"></ins></div>
                    </td>
                    <td class="mail-ontact"><a href="mail_detail.html">Jack Nowak</a></td>
                    <td class="mail-subject"><a href="mail_detail.html">Aldus PageMaker including versions of Lorem Ipsum.</a></td>
                    <td class=""></td>
                    <td class="text-right mail-date">8.22 PM</td>
                </tr>
                <tr class="read">
                    <td class="check-mail">
                        <div class="icheckbox_square-green" style="position: relative;"><input type="checkbox" class="i-checks" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);"></ins></div>
                    </td>
                    <td class="mail-ontact"><a href="mail_detail.html">Mailchip</a></td>
                    <td class="mail-subject"><a href="mail_detail.html">There are many variations of passages of Lorem Ipsum.</a></td>
                    <td class=""></td>
                    <td class="text-right mail-date">Mar 22</td>
                </tr>
                <tr class="read">
                    <td class="check-mail">
                        <div class="icheckbox_square-green" style="position: relative;"><input type="checkbox" class="i-checks" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);"></ins></div>
                    </td>
                    <td class="mail-ontact"><a href="mail_detail.html">Alex T.</a> <span class="label label-warning pull-right">Clients</span></td>
                    <td class="mail-subject"><a href="mail_detail.html">Lorem ipsum dolor noretek imit set.</a></td>
                    <td class=""><i class="fa fa-paperclip"></i></td>
                    <td class="text-right mail-date">December 22</td>
                </tr>
                <tr class="read">
                    <td class="check-mail">
                        <div class="icheckbox_square-green" style="position: relative;"><input type="checkbox" class="i-checks" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);"></ins></div>
                    </td>
                    <td class="mail-ontact"><a href="mail_detail.html">Monica Ryther</a></td>
                    <td class="mail-subject"><a href="mail_detail.html">The standard chunk of Lorem Ipsum used.</a></td>
                    <td class=""></td>
                    <td class="text-right mail-date">Jun 12</td>
                </tr>
                <tr class="read">
                    <td class="check-mail">
                        <div class="icheckbox_square-green" style="position: relative;"><input type="checkbox" class="i-checks" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);"></ins></div>
                    </td>
                    <td class="mail-ontact"><a href="mail_detail.html">Sandra Derick</a></td>
                    <td class="mail-subject"><a href="mail_detail.html">Contrary to popular belief.</a></td>
                    <td class=""></td>
                    <td class="text-right mail-date">May 28</td>
                </tr>
                <tr class="read">
                    <td class="check-mail">
                        <div class="icheckbox_square-green" style="position: relative;"><input type="checkbox" class="i-checks" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);"></ins></div>
                    </td>
                    <td class="mail-ontact"><a href="mail_detail.html">Patrick Pertners</a> </td>
                    <td class="mail-subject"><a href="mail_detail.html">If you are going to use a passage of Lorem </a></td>
                    <td class=""></td>
                    <td class="text-right mail-date">May 28</td>
                </tr>
                <tr class="read">
                    <td class="check-mail">
                        <div class="icheckbox_square-green" style="position: relative;"><input type="checkbox" class="i-checks" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);"></ins></div>
                    </td>
                    <td class="mail-ontact"><a href="mail_detail.html">Michael Fox</a></td>
                    <td class="mail-subject"><a href="mail_detail.html">Humour, or non-characteristic words etc.</a></td>
                    <td class=""></td>
                    <td class="text-right mail-date">Dec 9</td>
                </tr>
                <tr class="read">
                    <td class="check-mail">
                        <div class="icheckbox_square-green" style="position: relative;"><input type="checkbox" class="i-checks" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);"></ins></div>
                    </td>
                    <td class="mail-ontact"><a href="mail_detail.html">Damien Ritz</a></td>
                    <td class="mail-subject"><a href="mail_detail.html">Oor Lorem Ipsum is that it has a more-or-less normal.</a></td>
                    <td class=""></td>
                    <td class="text-right mail-date">Jun 11</td>
                </tr> --}}
                </tbody>
                </table>


                </div>
            </div>
        </div>
        </div>



    @include('site.includes.footer')       

    <script type="text/javascript" src="/js/plugins/fullcalendar/moment.min.js"></script>
  
    @include('site.includes.scripts')
    <script src="/js/plugins/iCheck/icheck.min.js"></script>
 
	<script>
        $(document).ready(function(){
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });
        });
    </script>

    @include('site.includes.bugreport')

</body>
</html> 