

let upload_files;
let uploaded_files = "";

// PLupload
function createUploader(event_element="" ,element="", browse_btn="",container="" ,file_list="" , uploader_url=""){

    upload_files = new plupload.Uploader({
        runtimes : 'html5,flash,silverlight,html4',
        browse_button : browse_btn, // For the browse button
        container: document.getElementById(container), // container of the upload button and elements
        chunk_size: '1mb', 
        url : uploader_url,
        max_file_count: 1,
        multi_selection: false,

        //ADD FILE FILTERS HERE
        filters: {
            mime_types: [{title: "Image files", extensions: "avif,gif,jpg,jpeg,jfif,pjpeg,pjp,png"}]
        },

        // Flash settings
        //flash_swf_url :  `${base_url}assets/static/plugins/plupload-master/js/Moxie.swf`,

        // Silverlight settings
        //silverlight_xap_url : `${base_url}assets/static/plugins/plupload-master/js/Moxie.xap`,
        
        init: {
            PostInit: function(res) { // before the upload will state 
                // change events here
                $(document).on(event_element, element , function(e){
                    if(event_element == 'submit'){
                        e.preventDefault();
                    }
                    uploaded_files=""; // reset uploaded files
                    upload_files.start();
                    return false;
                });
            },

            FilesAdded: function(up, files) { // after files has been added
                $('#upload-progress-bar').css('width', '0%');
                $('#upload-progress-container').fadeOut();
                if(upload_files.files?.length > 1)
                {
                    upload_files.removeFile(upload_files.files[0]);
                    upload_files.refresh();// must refresh for flash runtime
                }
                plupload.each(files, function(file) {
                    document.getElementById(file_list).innerHTML = `<div class="file-queue-cont ${file.id}"><p class="added-file-name">${file.name} (${plupload.formatSize(file.size)})</p></div>`;
                });
            },

            BeforeUpload:function(){
                $('#upload-progress-container').fadeIn();
		$('#submit-data-form').attr("disabled", true);
                toastr.info('Processing')
            },

            UploadProgress: function(up, file) { // upload progress
                $('#upload-progress-bar').css('width', file.percent+'%');
            },

            Error: function(up, err) { // if an error will occur
                if(err.code === -601){
                    alert('File Extension is invalid');
                }else{
                    alert('Something went wrong!');
                }
                console.log( err.code );
            },
            
            FileUploaded: function(up, raw_file, server_file){
                // append the saved file from server
                uploaded_files = server_file.response;
            }
        }
    });
    upload_files.init();
}

// remove queued file
$(document).on('click','.remove-file-queue',function(){
    let file_id = $(this).data('queue-id');
    upload_files.removeFile(file_id);
    $('.'+file_id).slideUp();

});


// ADDITIONAL USEFUL TOOLS

// once A has been uploaded "FileUploaded" will trigger
// upload_files.bind('FileUploaded', function(up, file, response) {
//     console.log(response);
// });

// before uploading will start "beforeupload"will trigger
// upload_files.bind('beforeupload', function (event, item) {
//     console.log(item.name);
// });

// after ALL the files has been uploaded UploadComplete will trigger
// upload_files.bind("UploadComplete", function(files) {
//     let file_names = JSON.stringify(uploaded_files);
// });
