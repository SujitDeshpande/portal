<html>
<head>
	<title></title>
       <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
       <link rel="stylesheet" type="text/css" href="/css/font-awesome.min.css">
       <style type="text/css">
       	.folder-name{
			display:inline-block;
			color:#222222;
			font-size: 14px;
			font: Helvetica ;
			text-transform: capitalize;	
			line-height: 25px;
		}

       </style>
</head>
<body>
	<!-- navbar begins -->
	<nav class="navbar navbar-default">
	  <div class="container-fluid">
	    <div class="navbar-header">
	    	<a class="navbar-brand">
		    	@if(isset($banner))
		    	<span>{{$banner->name}}</span> 
		    	@endif
	    	</a>
	    	
	    </div>
	    
		<ul class="nav navbar-nav">
			<li class="dropdown">
	          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Banner <span class="caret"></span></a>
	          <ul class="dropdown-menu">
	            <li><a href="/admin/folderstructure?banner_id=1">Sportchek</a></li>
	            <li><a href="/admin/folderstructure?banner_id=2">Atmosphere</a></li>
	          </ul>
	        </li>
	    </ul>
	    
	    <ul class="nav navbar-nav navbar-right">
        	<li><a href="/admin/folder/create?banner_id={{$banner->id}}">Add New Category</a></li>
    	</ul>
	    </div>
	  
	</nav>
	<!-- navbar ends-->
	<div class="col-md-10 col-md-offset-1">
		<div class="row">
			<div class="col-md-4" >
				<h3>Document Categories</h3>	
			</div>
			
		</div>
		<div class="row">
			<div >
				{!! csrf_field() !!}

				@foreach ($navigation as $nav) 
					
					@if ( $nav["is_child"] == 0)
						
						@include('admin.folderstructure-partial', ['navigation' =>$navigation, 'currentnode' => $nav, 'banner' => $banner])
						
					@endif


				@endforeach
			</div>
		</div>
	</div>
</body>
<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script type="text/javascript">


	$("body").on("click", ".deleteFolder", function(e) {
		e.preventDefault();
		if (confirm('Are you sure you want to delete this folder?')) {
		    console.log($(this).attr('data-folderId'))
		    $(this).closest('div').fadeOut(500)
			$.ajax({
			    url: '/admin/folder/'+ $(this).attr('data-folderId'),
			    type: 'DELETE',
			    data : {	
			    			_token : $('[name=_token').val()
					   }

			})
			.done(function(data){
				console.log(data)
			});
		}
	})  


</script>
</html>



