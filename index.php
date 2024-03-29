<?php include 'file-functions.php';$url_base = 'http://localhost:8888/LightFile/'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>LightFile</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="font-awesome.min.css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:400,700&display=swap" rel="stylesheet">
  <style type="text/css">
    body{
      font-family: 'Nunito', sans-serif;
      color: #000;
    }
    button{
      color: #000;
    }
    .modal {
        display: none;
        position: fixed;
        top: 0;
        right: 0;
        width: 100%;
        height: 100%;
        z-index: 1050;
        overflow-x: hidden;
        overflow-y: auto;
    }
    .modal-overlay {
        position: fixed;
        top: 0;
        right: 0;
        background: rgba(20, 26, 38, .5);
        width: 100%;
        height: 100%;
        z-index: 1040;
    }
    .modal-content {
        width: 50%;
        min-height: 400px;
        background: #fff;
        z-index: 1;
        position: relative;
        margin: 40px auto;
        top: 0;
        padding: 30px;
        z-index: 1060;
    }
    .modal_open .modal-content{
        opacity: 0;
        animation-name: bounceIn;
        animation-duration: 450ms;
        animation-timing-function: linear;
        animation-fill-mode: forwards;
    }
    .modal-close {
        position: absolute;
        font-size: 40px;
        color: #fff;
        right: -55px;
        top: -30px;
        cursor: pointer;
        text-decoration: none;
    }


    /* ANIMATIONS */
    @keyframes bounceIn{
      0%{
        opacity: 0;
        transform: scale(0.3) translate3d(0,0,0);
      }
      50%{
        opacity: 0.9;
        transform: scale(1.1);
      }
      80%{
        opacity: 1;
        transform: scale(0.89);
      }
      100%{
        opacity: 1;
        transform: scale(1) translate3d(0,0,0);
      }
    }

.lf_header {
    position: relative;
}
.lf_header_left {
    width: 30%;
    display: inline-block;
}

.lf_header_right {
    width: 67%;
    display: inline-block;
    text-align: right;
}
.lf_button {
    position: relative;
    height: 40px;
    cursor: pointer;
    border-width: 1px;
    border-style: solid;
    border-color: rgb(236, 239, 241);
    border-radius: 4px;
    padding: 10px;
    -webkit-appearance: none;
    background: #fff;
}
.lf_button:hover {
     box-shadow: rgba(57, 90, 100, 0.1) 0px 2px 9px 0px;
}
.lf_folders{
  border-bottom: 1px solid rgb(236, 239, 241);
  display: block;
  font-size: 0;
  padding-bottom: 20px;
}
.lf_folder {
    display: inline-block;
    align-items: center;
    height: 40px;
    cursor: pointer;
    border-width: 1px;
    border-style: solid;
    border-color: rgb(236, 239, 241);
    border-radius: 4px;
    margin: 5px;
    width: calc(33.33% - 15px);
}
.lf_folder:hover{
    box-shadow: rgba(57, 90, 100, 0.1) 0px 2px 9px 0px;
}
.lf_folder_icon {
    width: 25px;
    line-height: 40px;
    font-size: 14px;
    text-align: center;
}
.lf_folder_name {
    width: calc(100% - 25px);
    display: inline-block;
    font-size: 15px;
}

.lf_files{
  display: block;
  font-size: 0;
}
.lf_file {
    display: inline-block;
    align-items: center;
    cursor: pointer;
    border-width: 1px;
    border-style: solid;
    border-color: rgb(236, 239, 241);
    border-radius: 4px;
    margin: 5px;
    width: calc(33.33% - 15px);
    transition: all .3s;
}
.lf_file:hover{
    box-shadow: rgba(57, 90, 100, 0.3) 0px 2px 9px 0px;
}
.lf_file_selected{
  background-color: #d4d9dd;
  box-shadow: rgba(57, 90, 100, 0.6) 0px 2px 9px 0px !important;
}
.lf_file_preview {
    padding-top: 50%;
    background-color: #ccc;
    background-size: cover;
    background-position: center;
}
.lf_file_icon {
    width: 25px;
    line-height: 40px;
    font-size: 14px;
    text-align: center;
}
.lf_file_name {
    width: calc(100% - 25px);
    display: inline-block;
    font-size: 15px;
}
.lf_button.finish_selection.lf_file_selected {
    background: #d4d9dd;
}

/*UP*/
.dragdrop {
    height: 100%;
    width: 100%;
    margin: 0 auto;
    display: none;
}
.dragdrop.drag-on .upload-area{
    background: #ccc;
}
.upload-area{
    width: 70%;
    height: 300px;
    border: 2px solid lightgray;
    border-radius: 3px;
    margin: 0 auto;
    margin-top: 100px;
    text-align: center;
    overflow: auto;
}

.upload-area:hover{
    cursor: pointer;
}

.upload-area h1 {
    text-align: center;
    font-weight: normal;
    font-family: sans-serif;
    line-height: 45px;
    color: darkslategray;
    margin: 0;
    padding: 65px 0 0 0;
}

#file{
    display: none;
}

  </style>
</head>
<body>
<div class="post" style="background-size: cover;height: 100px;width: 100px">
  
</div>
<input type="text" id="post" value="">
<button type="button" class="test_btn">Abrir Media</button>
<div class="modal" id="media">
  <div class="modal-overlay"></div>
  <div class="modal-content">
    <a href="#" class="modal-close">X</a>
    <div class="dragdrop" >
      <form id="drag_drop_upload">
        <input type="hidden" name="do" value="upload">
        <input type="text" name="folder" id="folder" value="media">
        <input type="file" name="file" id="file">

        <!-- Drag and Drop container-->
        <div class="upload-area"  id="uploadfile">
            <h1 class="text_drag">Drag and Drop file here<br/>Or<br/>Click to select file</h1>
        </div>
      </form>
    </div>
    <div class="lf_header">
      <div class="lf_header_left">
        <h2 class="lf_title">Archivos</h2>
      </div>
      <div class="lf_header_right">
          <button type="button" class="lf_button upload_file"><i class="fa fa-cloud-upload" aria-hidden="true"></i> <span class="toggle_upload_text">Subir archivo</span></button>
          <button type="button" class="lf_button"><i class="fa fa-folder-open-o" aria-hidden="true"></i> Crear carpeta</button>
      </div>
    </div>
    <hr>
    Ruta:  <a href="media" class="route_handler">/Inicio</a>  
    <span class="lf_route_position">
   
    </span>
    <hr>
    <div id="lf_holder">
      <h4 class="lf_title">Carpetas</h4>
      <div class="lf_folders">
        <?php
          $file = ".";
          //$a = scandir($dir,1);
          //print_r($a);
          if (is_dir($file)) {
              $directory = $file;
              $result = [];
              //$files = array_diff(scandir($directory), ['.','..']);
              $files = array_diff(preg_grep('/^([^.])/', scandir($directory)), ['.','..']);
              foreach ($files as $entry) if (!is_entry_ignored($entry, $allow_show_folders, $hidden_extensions)) {
              $i = $directory . '/' . $entry;
              $stat = stat($i);
                    $result[] = [
                                'mtime' => $stat['mtime'],
                                'mtype' => mime_content_type($i),
                                'size' => $stat['size'],
                                'name' => basename($i),
                                //'path' => preg_replace('@^\./@', '', $i),
                                'path' => $entry,
                                'url' => $url_base.$i,
                                'urlenc' => urlencode($i),
                                'is_dir' => is_dir($i),
                                'is_deleteable' => $allow_delete && ((!is_dir($i) && is_writable($directory)) ||
                                                                               (is_dir($i) && is_writable($directory) && is_recursively_deleteable($i))),
                                'is_readable' => is_readable($i),
                                'is_writable' => is_writable($i),
                                'is_executable' => is_executable($i),
                    ];
                }
            } else {
              echo ("Not a Directory");
            }
            foreach ($result as $key => $lf_item) {
                if ($lf_item['is_dir']) {
                  echo '<div class="lf_folder" data-path="'.$lf_item['path'].'" data-folfer="'.$lf_item['urlenc'].'">
                          <i class="lf_folder_icon fa fa-folder-o" aria-hidden="true"></i><span class="lf_folder_name">'.$lf_item['name'].'</span>
                        </div>';
                }
            }
        ?>
      </div>
      <h4 class="lf_title">Archivos</h4>
      <div class="lf_files">
        <?php
          foreach ($result as $key => $lf_item) {
                if (!$lf_item['is_dir']) {
                    $mime_images = array('image/png','image/jpeg','image/jpeg','image/jpeg','image/gif','image/bmp','image/vnd.microsoft.icon','image/tiff','image/tiff','image/svg+xml','svgz' => 'image/svg+xml');
         
                    if(in_array($lf_item['mtype'],$mime_images)) {
                      echo '
                            <div class="lf_file" data-path="'.$lf_item['path'].'" data-fileurl="'.$lf_item['url'].'">
                                <div class="lf_file_preview file_type" style="background-image: url('.$lf_item['url'].');"></div>
                                <div class="lf_file_name_holder">
                                  <i class="lf_file_icon fa fa-file-o" aria-hidden="true"></i><span class="lf_file_name">'.$lf_item['name'].'</span>
                                </div>
                            </div>';
                    }else{
                      echo '
                        <div class="lf_file" data-path="'.$lf_item['path'].'" data-fileurl="'.$lf_item['url'].'">
                            <div class="lf_file_name_holder">
                              <i class="lf_file_icon fa fa-file-o" aria-hidden="true"></i><span class="lf_file_name">'.$lf_item['name'].'</span>
                            </div>
                        </div>';
                    }
                }
            }
        ?>
    </div>
  </div>
  <div class="lf_header">
      <div class="lf_header_left">
        <h2 class="lf_title"></h2>
      </div>
      <div class="lf_header_right">
          <button type="button" class="lf_button finish_selection"><i class="fa fa-check" aria-hidden="true"></i> Usar este archivo</button>
      </div>
  </div>
</div>
</div>

<script src="jquery.min.js"></script>
<script>
  // jQuery Plugins
(function ( $ ) {
  $.fn.lightfile = function(ajaxurl = "", param = 'open', target = null) {
      //this.css( "color", "green" );
      if (param == 'open') {
        this.fadeIn().addClass('modal_open')
      }else{
        this.fadeOut().removeClass('modal_open')
      }
      $('.modal-overlay').click(function(){
        $('.modal').fadeOut().removeClass('modal_open')
      })
      $('.modal-close').click(function(e){
        e.preventDefault()
        $(this).closest('.modal').fadeOut().removeClass('modal_open')
      })
      
      $(document).on('click','.lf_folder', function(e){
          console.log('change folder to: '+$(this).data('folfer'))
          var path = $(this).data('path'), folder = $(this).data('folfer');
          $.get(ajaxurl+"?do=list&file="+folder, function(data, status){
              $('#folder').val(folder)
              $('.lf_route_position').hide().html('<a href="'+folder+'" class="route_handler">/'+path+'</a>  ').fadeIn()
              $('#lf_holder').hide().html(data).fadeIn()
          });
      })
      $(document).on('click','.route_handler', function(e){
        e.preventDefault()
          $('#folder').val($(this).attr('href'))
          $.get(ajaxurl+"?do=list&file="+$(this).attr('href'), function(data, status){
              $('.lf_route_position').hide().html('').fadeIn()
              $('#lf_holder').hide().html(data).fadeIn()
          });
      })
      $(document).on('click','.lf_file', function(e){
        e.preventDefault()
        $('.lf_file').removeClass('lf_file_selected')
        $(this).addClass('lf_file_selected')
        $('.finish_selection').addClass('lf_file_selected').attr('data-url',$(this).data('fileurl'))
      })

      /////// DRAG DROP START
      //$.post(ajaxurl,{'do':'upload'}, function(data, status){
      //    console.log('upload '+data)
      //});

          // preventing page from redirecting
          $("html").on("dragover", function(e) {
              e.preventDefault();
              e.stopPropagation();
              $("h1").text("Drag here");
          });

          $("html").on("drop", function(e) { e.preventDefault(); e.stopPropagation(); });

          // Drag enter
          $('.upload-area').on('dragenter', function (e) {
              e.stopPropagation();
              e.preventDefault();
              $("h1").text("Drop");
          });

          // Drag over
          $('.upload-area').on('dragover', function (e) {
              e.stopPropagation();
              e.preventDefault();
              $("h1").text("Drop");
          });

          // Drop
          $('.upload-area').on('drop', function (e) {
              e.stopPropagation();
              e.preventDefault();

              $("h1").text("Upload");

              //var file = e.originalEvent.dataTransfer.files;
              //var fd = new FormData();

              //fd.append('file', file[0]);

              uploadData();
          });

          // Open file selector on div click
          $("#uploadfile").click(function(){
              $("#file").click();
          });

          // file selected
          $("#file").change(function(){
             // var fd = new FormData();

              //var files = $('#file')[0].files[0];

              //fd.append('file',files);

              uploadData();
          })

      // Sending AJAX request and upload file
      function uploadData(formdata){

         /* $.ajax({
              url: 'upload.php',
              type: 'post',
              data: formdata,
              contentType: false,
              processData: false,
              dataType: 'json',
              success: function(response){
                  addThumbnail(response);
              }
          });*/
          $("#drag_drop_upload").submit(function(e) {
              e.preventDefault();    
              var formData = new FormData(this);

              $.ajax({
                  url: ajaxurl,
                  type: 'POST',
                  data: formData,
                  success: function (data) {
                      console.log(data)
                  },
                  cache: false,
                  contentType: false,
                  processData: false
              });
          });
      }

      /////// DRAG DROP END

      this.find('.finish_selection').click(function(){
        for(var i in target) {
         // console.log(target[i]);
          if (i == 'bg') {
            $(target[i]).css('background-image','url('+$(this).attr('data-url')+')')
          }
          if (i == 'val') {
            $(target[i]).val($(this).attr('data-url'))
          }
          if (i == 'event') {
              $( document ).trigger( target[i], [$(this).attr('data-url')] );
          }
        }
        $(this).closest('.modal').fadeOut().removeClass('modal_open')
        
      })
      
      return this;
  };
}( jQuery ));

jQuery(document).ready(function($){
  //$('.test_btn').click(function(e){
    /* first param open te file manager, second param are method to use the url of file selected
        example:
        bg    -> put as background image the url of file selected
        val   -> change value of input
        event -> fire a custom event and pass the url as argument
    */
    $('#media').lightfile('http://localhost:8888/LightFile/file-functions.php','open', {'bg':'.post','val':'#post','event':'media_selected'});
    //example of return the url as argument
    $( document ).on( "media_selected", function( event, arg ) {
          console.log( arg );
    });
    $('.upload_file').click(function(e){
        $('.dragdrop').slideToggle()
    })
  //})
})
</script>
</body>
</html>