<?php
    session_start();
    if(!$_SESSION['logged_in']){
        header("Location: login.php");
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Ossteq Phils.</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="assets/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="assets/css/icheck-bootstrap.min.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="assets/css/toastr.min.css">
  <!-- PLuploader -->
  <link rel="stylesheet" href="assets/css/PLupload.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="assets/css/adminlte.min.css">
  
</head>
<body class="hold-transition register-page">

    <div class="card" style="display:none; width:60%" id="database-view">
        <div class="card-body">
            <div id="view-processing-cont" style="text-align:center">
                <div class="spinner-border" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
            <h3 id="db-title" class="d-block text-center"></h3>
            <p id="db-body" class="d-block text-center"></p>

            <div id="img-container">
                <!-- img container -->
            </div>

            <div class="mt-1  table-responsive p-0">
                <!-- table container -->
                <table class="table table-striped" id="cat-table">
                    <thead>
                        <tr>
                            <th>_id</th>
                            <th>user</th>
                            <th>text</th>
                            <th>type</th>
                            <th>createdAt</th>
                            <th>updatedAt</th>
                        </tr>
                    </thead>
                    <tbody id="cat-data-container">
                        
                    </tbody>
                </table>
            </div>

            <button type="button" class="btn btn-block btn-success mt-1" id="view-form-btn">
                <i class="fab fa-wpforms"></i>
                Back to Form
            </button>
        </div>
    </div>

    <div class="register-box">        
        <div class="card" id="form-view">
            <div class="card-body register-card-body">
                <p class="login-box-msg">Submit new data</p>

                <form id="data-form">
                    <div class="form-group">
                        <label for="txtbox">Text Box (<span id="char-count"></span> Characters)</label>
                        <textarea class="form-control" id="txtbox" rows="3" name="textbox"></textarea>
                    </div>
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title"><i>Radio Button</i></h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <div class="icheck-success d-block">
                                    <input type="radio" id="opt-hi" name="radio" value="Hi">
                                    <label for="opt-hi">
                                    Hi
                                    </label>
                                </div>

                                <div class="icheck-success d-block">
                                    <input type="radio" id="opt-hello" name="radio" value="Hello">
                                    <label for="opt-hello">
                                    Hello
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card card-success mt-3">
                        <div class="card-header">
                            <h3 class="card-title"><i>Check Box</i></h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <div class="icheck-success d-block">
                                    <input type="checkbox" id="world" name="check-world" value="World!"/>
                                    <label for="world">
                                        World!
                                    </label>
                                </div>

                                <div class="icheck-success d-block">
                                    <input type="checkbox" id="web" name="check-web" value="Web!"/>
                                    <label for="web">
                                        Web!
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="card card-success mt-3">
                        <div class="card-header">
                            <h3 class="card-title">Attach Image</h3>
                        </div>
                        <div class="card-body pt-1">
                            <div id="upload-progress-container" class="progress progress-xs mb-1" style="display:none">
                                <div id="upload-progress-bar" class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
                            </div>
                            <div id="file-upload">
                                <div class="form-group">
                                    <!-- upload functionality -->
                                        <div id="file-list"></div>
                                        <div id="uploader-container">
                                            <button type="button" class="btn btn-primary" id="attach-files">Select Image</button>
                                        </div>
                                    <!-- /. upload functionality -->
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="mt-3 text-center">
                            <button type="submit" id="submit-data-form" class="btn btn-inline btn-success">
                                <i class="fa fa-paper-plane mr-2"></i>
                                Submit
                            </button>

                            <button type="button" class="btn btn-inline btn-primary" id="view-database-btn">
                                <i class="fa fa-eye mr-2"></i>
                                View Database
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div><!-- /.card -->
    </div>

    <script>
        const base_url = 'http://ec2-34-219-132-200.us-west-2.compute.amazonaws.com:8080/';
    </script>
    <!-- jQuery -->
    <script src="assets/js/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <!-- Toastr -->
    <script src="assets/js/toastr.min.js"></script>
    <!-- PLuploader -->
    <script src="assets/js/plupload.full.min.js"></script>
    <!-- PLuploader Functions -->
    <script src="assets/js/plupload_function.js"></script>
    <!-- AdminLTE App -->
    <script src="assets/js/adminlte.min.js"></script>
    <script>
        $(function(){
            
            //toastr options
            toastr.options = {
                "positionClass": "toast-top-center",
                "onclick": null,
                "fadeIn": 300,
                "fadeOut": 1000,
                "timeOut": 5000,
                "extendedTimeOut": 1000
            }

            //util functions
            const limit_char_txtbox = 100;
            update_txtbox(limit_char_txtbox);
            function update_txtbox(remaining){
                $('#char-count').html(remaining);
            }

            

            $(document).on('input','#txtbox',function(e){
                const char_length = $(this).val().length;
                const char_values = $(this).val();
                const remaining_char = limit_char_txtbox - char_length
                
                if(remaining_char>=0){
                    update_txtbox(limit_char_txtbox - char_length);
                }else{
                    $(this).val(char_values.slice(0, 100))
                }
            });
        
            
            $(document).on('click','#view-database-btn',function(){
                $('#form-view').slideUp('slow',function(){
                    $('#database-view').slideDown();
                });
                $('#db-title').html('');
                $('#db-body').html('');
                $('#img-container').html('');
                $('#img-container').css({'height':'0px', 'width':'0px'});


                //calling the endpoints using ajax
                const call_endpoint =  (method,endpoint,data={}) => {
                    var params = typeof data == 'string' ? data : Object.keys(data).map(
                        function(k){ return (k) + '=' + (data[k]) }
                    ).join('&');
                    return new Promise((resolve,reject)=>{
                        let xhttp = new XMLHttpRequest();
                        xhttp.onreadystatechange = ()=>{
                            if(xhttp.readyState == 4){
                                if(xhttp.status == 200){
                                    resolve(xhttp.responseText);
                                }else{
                                    reject(`An error occured in ${endpoint}`);
                                }   
                            }
                        }
                        
                        
                        xhttp.open(method,endpoint);
                        if(data)
                            xhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
                        xhttp.send(params??'');
                        
                    });
                }

                const ajax_data = {'id':localStorage.getItem('id')};
                const cat_data = {'count' : 1}
                const call_ajax = call_endpoint( 'POST','ajax.php?method=view',ajax_data);
                const call_cat = call_endpoint( 'GET',`https://cat-fact.herokuapp.com/facts/random?amount=${cat_data.count}`);

                $('#view-processing-cont').slideDown();
                Promise.all([call_ajax,call_cat]).then(values=>{
                    try{
                        const ajax_values = JSON.parse(values[0]);
                        const cat_values = JSON.parse(values[1]);
                        
                        $('#view-processing-cont').slideDown(function(){
                            const construct_body = (ajax_values.dbuser0_checkbox.split(',').map(word=>ajax_values.dbuser0_radio + ' ' +word));
                            if(ajax_values.dbuser0_filename){
                                $('#img-container').css({'height':'300px', 'width':'50%' , 'margin': 'auto'})
                                $('#img-container').html(`<img src="assets/form-files/${ajax_values.dbuser0_filename}" alt="${ajax_values.dbuser0_filename}" style="width:100%; height:100%"/>`);
                            }else{
                                $('#img-container').css({'height':'0px', 'width':'0px'})
                                $('#img-container').html('');
                            }

                            $('#db-title').html(ajax_values.dbuser0_text);
                            $('#db-body').html(construct_body.map(body=> '<p>'+body+'</p>' ));


                            //third party api data
                            const construct_cat = cat_values.length? 
                                cat_values?.map((cat_row)=>
                                `
                                    <tr>
                                        <td>${cat_row._id}</td>
                                        <td>${cat_row.user}</td>
                                        <td>${cat_row.text}</td>
                                        <td>${cat_row.type}</td>
                                        <td>${cat_row.createdAt}</td>
                                        <td>${cat_row.updatedAt}</td>
                                    </tr>
                                `)
                                : 
                                `
                                    <td>${cat_values._id}</td>
                                    <td>${cat_values.user}</td>
                                    <td>${cat_values.text}</td>
                                    <td>${cat_values.type}</td>
                                    <td>${cat_values.createdAt}</td>
                                    <td>${cat_values.updatedAt}</td>
                                `;

                            $('#cat-data-container').html(construct_cat)
                            $('#view-processing-cont').slideUp();
                        });
                        
                    }catch(err){
                        toastr.error('An error has occured. Please refresh the page and try again');
                    }
                   
                    
                }).catch(err =>{
                    console.log(err);
                    toastr.error('An error has occured accessing data. Please refresh the page and try again');
                });

            })

            $(document).on('click','#view-form-btn',function(){
                $('#database-view').slideUp('slow',function(){
                    $('#form-view').slideDown();
                });

            })

            createUploader("submit" ,"#data-form", "attach-files", "uploader-container" ,"file-list" , "ajax.php?method=file_upload");
            // after ALL the files has been uploaded UploadComplete will trigger
            upload_files.bind("UploadComplete", function(files) {
                if(uploaded_files !== ""){
                    $('#file-list').html('Upload Complete. <br/><b> Select another image. <b>');
                }
                const formdata = new FormData($('#data-form')[0]);
                formdata.append('file',uploaded_files)
                //submitting data
                $.ajax({
                    url:'ajax.php?method=insert',
                    type: 'post',
                    data: formdata,
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    cache: false,
                    success:(response)=>{
                        if(response){
                            localStorage.setItem('id',response);
                            toastr.success('Form submitted successfully!')
                        }else{
                            toastr.error('An error has occured');
                        }
                        $('#submit-data-form').attr("disabled", false);
                    },
                    error:(err)=>{
                        console.log(err);
                        toastr.error(err.responseText);
                        $('#submit-data-form').attr("disabled", false);
                    }
                })
            });

        })
    </script>
</body>
</html>
