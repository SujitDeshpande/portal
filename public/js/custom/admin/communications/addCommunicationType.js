$(document).on('click','.communicationtype-create',function(){
  	
  	var hasError = false;

    var communicationTypeName = $("#communication_type").val();
    var bannerId = localStorage.getItem('admin-banner-id');
    var colour = $("input:radio[name='colour']:checked").val();

    //console.log(communicationTypeName +", "+ bannerId +", "+ colour);

    if(communicationTypeName == '') {
		swal("Oops!", "This we need a name for this communication type.", "error"); 
		hasError = true;
		$(window).scrollTop(0);
	}	

	if(hasError == false) {
		$.ajax({
		    url: '/admin/communicationtypes',
		    type: 'POST',
		    data: { communication_type: communicationTypeName, colour: colour, banner_id: bannerId },
		    success: function(result) {
		        $("#communication_type").val(""); // empty the form
				swal("Nice!", "'" + communicationTypeName +"' has been created", "success");        
		    }
		});
	}
	
    return false;
});