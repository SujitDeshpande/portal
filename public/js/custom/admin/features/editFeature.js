$("#add-more-files").click(function(){
	$("#document-listing").modal('show');
});

$("#add-more-packages").click(function(){
	$("#package-listing").modal('show');
});



$('body').on('click', '#attach-selected-files', function(){
	$("#files-selected").empty();
	// $("#files-selected").append('<label class="control-label col-sm-2">Files attached</label>');
	$('input[name^="package_files"]').each(function(){
		if($(this).is(":checked")){
			$(".feature-documents-table tbody").append('<tr class="selected-files"> '+
													'<td data-fileid='+ $(this).val() +'><i class="fa fa-file-o"></i> '+ $(this).attr("data-filename") +'</td>'+
													'<td></td>'+
													'<td> <a data-document-id="'+ $(this).val()+'" id="file'+ $(this).val()+'" class="remove-staged-file btn btn-danger btn-sm"><i class="fa fa-trash"></i></a></td>'+
												 '</tr>');
		}
	});
});

$('body').on('click', '#attach-selected-packages', function(){

	console.log('attach selected-packages');
	$("#packages-selected").empty();
	// $("#packages-selected").append('<label class="control-label col-sm-2">Packages Attached</label>');
	$('input[name^="feature_packages"]').each(function(){
		if($(this).is(":checked")){
			$(".feature-packages-table tbody").append( '<tr class="selected-packages"> '+
													'<td data-packageid='+ $(this).val() +'><i class="fa fa-folder-o"></i> '+ $(this).attr("data-packagename") +'</td>'+
													'<td></td>'+
													'<td> <a data-package-id="'+ $(this).val()+'" id="package'+ $(this).val()+'" class="remove-staged-package btn btn-danger btn-sm"><i class="fa fa-trash"></i></a></td>'+
												 '</tr>');		
		}
		
	});
});




$(".remove-file").on('click', function(){
	var document_id = $(this).attr('data-document-id');
	$(this).closest('.feature-files').fadeOut(200);
	$("#files-staged-to-remove").append('<div class="remove_document"  data-documentid='+ document_id +'>')
});

$(".remove-package").on('click', function(){
	var package_id = $(this).attr('data-package-id');
	console.log(package_id);
	$(this).closest('.feature-packages').fadeOut(200);
	
	$("#packages-staged-to-remove").append('<div class="remove_package" data-packageid='+ package_id +'>')
});

$("body").on('click', ".remove-staged-file", function(){
	
	var document_id = $(this).attr('data-document-id');
	$(".feature-files[data-fileid = '" + document_id + "']").remove();
	$(this).closest('.feature-files').fadeOut(200);

});

$("body").on('click', ".remove-staged-package", function(){
	
	var package_id = $(this).attr('data-packageid');
	$(".feature-packages[data-packageid = '" + package_id + "']").remove();
	$(this).closest('feature-packages').fadeOut(200);

});

$('input[id="thumbnail"]').on('change', function(){

	var featureID = $("#featureID").val();
	var thumbnail = $('input[id="thumbnail"]')[0].files[0];
	console.log(featureID);
	var data = new FormData();
	data.append('thumbnail', thumbnail);
	data.append('featureID', featureID);
	console.log(data);
	$.ajax({
		    url: '/admin/feature/thumbnail',
		    type: 'POST',
		    data: data, 
            processData: false,  // tell jQuery not to process the data
            contentType: false,   // tell jQuery not to set contentType
		    success: function(result) {
		        console.log(result);
		        $(".thumbnail-preview img").attr('src', "/images/featured-covers/"+result);
		        // $('#createNewFeatureForm')[0].reset(); // empty the form
				// swal("Nice!", "'" + featureTitle +"' has been created", "success");        
		    }
		}).done(function(response){
			console.log(response);
		});    

});

$('input[id="background"]').on('change', function(){

	var featureID = $("#featureID").val();
	var background = $('input[id="background"]')[0].files[0];
	var data = new FormData();
	data.append('background', background);
	data.append('featureID', featureID);

	$.ajax({
		    url: '/admin/feature/background',
		    type: 'POST',
		    data: data, 
            processData: false,  // tell jQuery not to process the data
            contentType: false,   // tell jQuery not to set contentType
		    success: function(result) {
		        console.log(result);
		        $(".background-preview img").attr('src', "/images/featured-backgrounds/"+result);
		        // $('#createNewFeatureForm')[0].reset(); // empty the form
				// swal("Nice!", "'" + featureTitle +"' has been created", "success");        
		    }
		}).done(function(response){
			console.log(response);
		});    

});

$('input[name="latest_updates_option"]').change( function(){
	if($('input[name=latest_updates_option]').is(':checked')){
		$('input[name="update_frequency"]').prop('disabled', true).val("");
		$(this).next('input[name="update_frequency"]').prop('disabled', false);
	}
});

$(document).on('click','.feature-update',function(){
  	
 
  	var hasError = false;
 	var featureID = $("#featureID").val();
 	
	var featureTitle = $("#feature_title").val();
	var featureTileLabel = $("#tile_label").val();
	var featureStart = $("#start").val();
	var featureEnd = $("#end").val();
	var thumbnail = $('input[id="thumbnail"]')[0].files[0];
	var background = $('input[id="background"]')[0].files[0];
	var remove_document = [];
	var remove_package   = [];
	var feature_files = [];
	var feature_packages = [];
	var update_type = $('input:radio[name =  "latest_updates_option"]:checked').val();
	var update_frequency =  $('input:radio[name ="latest_updates_option"]:checked').next('input[name="update_frequency"]').val();
	console.log('latest updates : ' + update_type);
	console.log('latest update freq : ' + update_frequency);


	$(".remove_document").each(function(){
		remove_document.push($(this).attr('data-documentid'));
	});
	$(".remove_package").each(function(){
		remove_package.push($(this).attr('data-packageid'));
	});
	
	$(".selected-files").each(function(){
		feature_files.push($(this).find('td:first').attr('data-fileid'));
	});
	$(".selected-packages").each(function(){
		feature_packages.push($(this).find('td:first').attr('data-packageid'));
	});
 

    if(featureTitle == '') {
		swal("Oops!", "This feature needs a name.", "error"); 
		hasError = true;
		$(window).scrollTop(0);
		return false;
	}
	if(featureStart == '' || featureEnd == '') {
		swal("Oops!", "Start and end dates cannot be empty", "error"); 
		hasError = true;
		$(window).scrollTop(0);
		return false;
	}
	if(update_frequency == '') {
		swal("Oops!", "Notification window size cannot be empty", "error"); 
		hasError = true;
		$(window).scrollTop(0);
		return false;	
	}

     if(hasError == false) {
     	var dataObj = {};
     	console.log(typeof(dataObj));
     	$.extend(dataObj, {title: featureTitle});
     	$.extend(dataObj, {tileLabel: featureTileLabel});
     	$.extend(dataObj, {start: featureStart});
     	$.extend(dataObj, {end: featureEnd});
     	$.extend(dataObj, {feature_files:  feature_files});
     	$.extend(dataObj, {feature_packages:  feature_packages});
     	$.extend(dataObj, {remove_document: remove_document});
     	$.extend(dataObj, {remove_package: remove_package});
     	$.extend(dataObj, {update_type : update_type});
     	$.extend(dataObj, {update_frequency : update_frequency});
     	

     	var data = JSON.stringify(dataObj);
     	console.log(dataObj);
     	console.log(data);

		$.ajax({
		    url: '/admin/feature/' + featureID ,
		    type: 'PATCH',
		    data: data,
		    contentType: 'application/json',
		    processData : false,
		    success: function(data) {
		        
		        console.log(data); 
				swal("Nice!", "'" + featureTitle +"' has been updated", "success");

		    }
		}).done(function(response){
			console.log(response);
		});    	
    }


    return false;
});