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
        top: -55px;;
        cursor: pointer;
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
}
.lf_file:hover{
    box-shadow: rgba(57, 90, 100, 0.1) 0px 2px 9px 0px;
}
.lf_file_preview {
    padding-top: 50%;
    background-color: #ccc;
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
/*
.lf_folder {
    display: inline-flex;
    -webkit-box-align: center;
    align-items: center;
    height: 40px;
    justify-content: space-evenly;
    cursor: pointer;
    border-width: 1px;
    border-style: solid;
    border-color: rgb(236, 239, 241);
    border-image: initial;
    border-radius: 4px;
    margin: 5px;
    width: calc(33.33% - 15px);
}
*/
  </style>
</head>
<body>
<div class="modal" id="modal">
  <div class="modal-overlay"></div>
  <div class="modal-content">
    <a href="#" class="modal-close">X</a>
    <div class="lf_header">
      <div class="lf_header_left">
        <h2 class="lf_title">Archivos</h2>
      </div>
      <div class="lf_header_right">
          <button type="button" class="lf_button"><i class="fa fa-cloud-upload" aria-hidden="true"></i> Subir archivo</button>
          <button type="button" class="lf_button"><i class="fa fa-folder-open-o" aria-hidden="true"></i> Crear carpeta</button>
      </div>
    </div>
    <hr>
    <div id="lf_holder">
      <h4 class="lf_title">Carpetas</h4>
      <div class="lf_folders"> 
        <div class="lf_folder"><i class="lf_folder_icon fa fa-folder-o" aria-hidden="true"></i><span class="lf_folder_name">Ejemplo</span></div>
        <div class="lf_folder"><i class="lf_folder_icon fa fa-folder-o" aria-hidden="true"></i><span class="lf_folder_name">Ejemplo</span></div>
        <div class="lf_folder"><i class="lf_folder_icon fa fa-folder-o" aria-hidden="true"></i><span class="lf_folder_name">Ejemplo</span></div>
        <div class="lf_folder"><i class="lf_folder_icon fa fa-folder-o" aria-hidden="true"></i><span class="lf_folder_name">Ejemplo</span></div>
        <div class="lf_folder"><i class="lf_folder_icon fa fa-folder-o" aria-hidden="true"></i><span class="lf_folder_name">Ejemplo</span></div>
        <div class="lf_folder"><i class="lf_folder_icon fa fa-folder-o" aria-hidden="true"></i><span class="lf_folder_name">Ejemplo</span></div>
        <div class="lf_folder"><i class="lf_folder_icon fa fa-folder-o" aria-hidden="true"></i><span class="lf_folder_name">Ejemplo</span></div>
      </div>
      <h4 class="lf_title">Archivos</h4>
      <div class="lf_files"> 
        <div class="lf_file">
          <div class="lf_file_preview file_type"></div>
          <div class="lf_file_name_holder">
            <i class="lf_file_icon fa fa-file-o" aria-hidden="true"></i><span class="lf_file_name">Ejemplo</span>
          </div>
      </div>
    </div>
  </div>
</div>
<script src="jquery.min.js"></script>
<script>
  // jQuery Plugins
(function ( $ ) {
  // MediaCore Modal
  $.fn.modal = function(param = 'open') {
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
      return this;
  };
}( jQuery ));

jQuery(document).ready(function($){
  $('#modal').modal();
  $('.open_modal').click(function(e){
    e.preventDefault()
    $($(this).attr('href')).modal();
  })
})
</script>
</body>
</html>