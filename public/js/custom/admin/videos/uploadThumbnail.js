// HTML heavily inspired by http://blueimp.github.io/jQuery-File-Upload/ -->
// Get the template HTML and remove it from the doument
var previewNode = document.querySelector("#template");
previewNode.id = "";
var previewTemplate = previewNode.parentNode.innerHTML;
previewNode.parentNode.removeChild(previewNode);


var myDropzone = new Dropzone(document.body, { // Make the whole body a dropzone
    url: "/admin/video/" + $('input[name="video_id"]').val() + "/storethumbnail", // Set the url
    paramName: "document",
    thumbnailWidth: 80,
    thumbnailHeight: 80,
    parallelUploads: 20,
    previewTemplate: previewTemplate,
    addRemoveLinks: false,
    autoQueue: false, // Make sure the files aren't queued until manually added
    previewsContainer: "#previews", // Define the container to display the previews
    clickable: ".fileinput-button", // Define the element that should be used as click trigger to select files.
    accept: function(file, done) {
      // TODO: Image upload validation
      done();
    },
    sending: function(file, xhr, formData) {
       console.log($('#folder-title').attr('data-folderid'));
       console.log($('input[name="video_id"]').val());
      // Pass token. You can use the same method to pass any other values as well such as a id to associate the image with for example.
        formData.append("_token", $('input[name="_token"]').val()); // Laravel expect the token post value to be named _token by default
        formData.append("video_id", $('input[name="video_id"]').val());
        
    },
    init: function () {
      this.on("success", function (file, response) {
        console.log(response)
        });
    } 

});
myDropzone.on("drop", function (e) {
  $("#watermark").hide();
  $('#actions .start').removeClass('disabled');
  $('#actions .cancel').removeClass('disabled');
})


myDropzone.on("addedfile", function (file) {
    // Hookup the start button
      $("#watermark").hide();
      $('#actions .start').removeClass('disabled');
      $('#actions .cancel').removeClass('disabled');
      file.previewElement.querySelector(".start").onclick = function () {
        myDropzone.enqueueFile(file);
      };
});

// Update the total progress bar
myDropzone.on("totaluploadprogress", function (progress) {
  document.querySelector("#total-progress .progress-bar").style.width = progress + "%";
});

myDropzone.on("sending", function (file) {
    // Show the total progress bar when upload starts
    document.querySelector("#total-progress").style.opacity = "1";
    // And disable the start button
    file.previewElement.querySelector(".start").setAttribute("disabled", "disabled");
});

// Hide the total progress bar when nothing's uploading anymore
myDropzone.on("queuecomplete", function (progress) {
    document.querySelector("#total-progress").style.opacity = "0";
    // var upload_package_id = $("#upload_package_id").val();
    // var banner_id = localStorage.getItem('admin-banner-id');
    // var folder_id = $('#folder_id').val();
     var video_id =  $('[name=video_id').val();
    $(".file-row .delete").hide();
//    window.location = '/admin/document/add-meta-data?package=' + upload_package_id + "&banner_id=" + banner_id + "&parent=" + folder_id;
    var videolink = $("<a class='btn btn-primary next-action' href='/admin/video/'><i class='fa fa-check'></i> Back to Videos</a>");
    //$(metadatalink).appendTo("#file-uploader #container");
    //
    $( ".file-actions .btn" ).fadeOut( "slow", function() {
      $( ".file-actions" ).empty();
      $(videolink).appendTo(".file-actions");
    });
    
    
    
});

// Setup the buttons for all transfers
// The "add files" button doesn't need to be setup because the config
// `clickable` has already been specified.
document.querySelector("#actions .start").onclick = function () {
    myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED));
};
document.querySelector("#actions .cancel").onclick = function () {
    myDropzone.removeAllFiles(true);
    $("#watermark").show();
    $('#actions .start').addClass('disabled');
    $('#actions .cancel').addClass('disabled');
};

myDropzone.on('removedfile', function(file) {
  if( $("#previews").has(".file-row").length < 1 ) {
    $("#watermark").show();
    $('#actions .start').addClass('disabled');
    $('#actions .cancel').addClass('disabled');
  }
});