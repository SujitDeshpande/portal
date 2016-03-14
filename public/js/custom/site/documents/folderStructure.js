
$("body").on("click", ".folder", function(e){
	
	console.log(e);
	console.log(this.id);
	e.stopPropagation();
	var id = e.target.id;

	if(id){
		getFolderDocuments(e.target.id);
	} else {
		getFolderDocuments(this.id);
	}

	
	
});

var getFolderDocuments = function(id){
	
	var folder_id = id;
	// var archives = $("#archives:checked").val();
	var archives = false;
	var url = '/folder/' + folder_id ;
	if(archives == true) {
		url = '/folder/' + folder_id +"?archives=true";
	}
	$.ajax(
		{
			url : url
		}
	)
	.done(function(data){
		console.log(data);
		fillTable(data);
		setDeepLink(data);
		fillBreadCrumbs(data);
	});
}

var checkDeepLink = function(){
	if(window.location.hash){
		folderId = window.location.hash.substr(3);
		$("li#" + folderId).click();
		//getFolderDocuments(folderId);
	}
}
var setDeepLink = function(data){
	var id = window.location.hash;
	console.log(id);
	console.log(window.location.pathname);
	location.href = window.location.pathname + "#!/" + data.folder.global_folder_id;
}
	





