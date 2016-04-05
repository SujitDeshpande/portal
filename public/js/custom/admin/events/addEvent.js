$(document).ready(function(){
	$("#allStores").click();	
	console.log("1");

});
$("#allStores").change(function(){

	if ($("#allStores").is(":checked")) {

		$("#storeSelect option").each(function(index){			
			$(this).attr('selected', 'selected');
		});
		$("#storeSelect").chosen();
		
	}
	else if ($("#allStores").not(":checked")) {
		$("#storeSelect option").each(function(){
			$(this).removeAttr('selected');
		});
		$("#storeSelect").chosen();
		
	}
});

$(document).on('click','.event-create',function(){
  	
  	var hasError = false;

  	var eventBanner = $("#banner").val(); 
	var eventTitle = $("#title").val(); 
    var eventType = $("#event_type").val();
    var eventDescription = CKEDITOR.instances['description'].getData();
    var eventStart = $("#start").val();
    var eventEnd = $("#end").val();
    var tags = $('#tags').val();
    var target_stores  = $("#storeSelect").val();
    var allStores  = $("allStores:checked").val();

    console.log("tags" + tags);
    if(eventTitle == '') {
		swal("Oops!", "This event needs a title.", "error"); 
		hasError = true;
		$(window).scrollTop(0);
		return false;
	}	

	if(eventType == ''){
		swal("Oops!", "Event type missing", "error"); 
		hasError = true;
		$(window).scrollTop(0);
		return false;
	}

    if(eventStart == '' || eventEnd == '') {
		swal("Oops!", "This event needs a start and end date.", "error"); 
		hasError = true;
		$(window).scrollTop(0);
		return false;
	}	
	if( target_stores == null && typeof allStores === 'undefined' ) {
		swal("Oops!", "Target stores not selected.", "error"); 
		hasError = true;
		$(window).scrollTop(0);
		return false;
	}


    if(hasError == false) {

		$.ajax({
		    url: '/admin/calendar',
		    type: 'POST',
		    data: {
		    	banner: eventBanner,
		  		title: eventTitle,
		  		description: eventDescription,
		    	event_type: eventType,
		    	start: eventStart,
		    	end: eventEnd,
		    	target_stores : target_stores,
		    },
		    success: function(result) {
		        console.log(result);
		        $('#createNewEventForm')[0].reset(); // empty the form
		        CKEDITOR.instances['description'].setData('');
		        $('#datepicker').find('input').datepicker('setDate', null);
		        $("#allStores").click();
				swal("Nice!", "'" + eventTitle +"' has been created", "success");        
		    }
		});    	
    }


    return false;
});