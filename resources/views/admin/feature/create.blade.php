<!DOCTYPE html>
<html>

<head>
    @section('title', 'Features')
    @include('admin.includes.head')

	<meta name="csrf-token" content="{!! csrf_token() !!}"/>
</head>

<body class="fixed-navigation">
    <div id="wrapper">
	    <nav class="navbar-default navbar-static-side" role="navigation">
	        <div class="sidebar-collapse">
	          @include('admin.includes.sidenav')
	        </div>
	    </nav>

	<div id="page-wrapper" class="gray-bg" >
		<div class="row border-bottom">
			@include('admin.includes.topbar')
        </div>

		<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Features</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="/admin">Home</a>
                        </li>
                        <li>
                            <a href="/admin/feature">Features</a>
                        </li>
                        <li class="active">
                            <strong>Create a New Feature</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
		</div>

		<div class="wrapper wrapper-content  animated fadeInRight">
		            <div class="row">
		                <div class="col-lg-12">
		                    <div class="ibox">
		                        <div class="ibox-title">
		                            <h5>Create a New Feature</h5>

		                            <div class="ibox-tools">

		                                {{-- <a href="/admin/feature/create" class="btn btn-primary btn"><i class="fa fa-plus"></i> Create New Feature</a> --}}
		                            </div>
		                        </div>
		                        <div class="ibox-content">



		                            <div class="table-responsive">





		                            </div>
		                        </div>

		                    </div>
		                </div>
		            </div>


		        </div>

				@include('site.includes.footer')

			    @include('admin.includes.scripts')

				<script type="text/javascript">
					$.ajaxSetup({
				        headers: {
				            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				        }
					});

				</script>


				<script type="text/javascript" src="/js/custom/admin/global/bannerSelector.js"></script>

				@include('site.includes.bugreport')



			</body>
			</html>