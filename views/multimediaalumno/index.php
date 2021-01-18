<?PHP require 'views/header.php'; ?>
<?php

// TODO Enter your bucket and region details (see details below)
$s3FormDetails = getS3Details(constant('AWS_BUCKET'), constant('AWS_REGION'));

/**
 * Get all the necessary details to directly upload a private file to S3
 * asynchronously with JavaScript using the Signature V4.
 *
 * @param string $s3Bucket your bucket's name on s3.
 * @param string $region   the bucket's location/region, see here for details: http://amzn.to/1FtPG6r
 * @param string $acl      the visibility/permissions of your file, see details: http://amzn.to/18s9Gv7
 *
 * @return array ['url', 'inputs'] the forms url to s3 and any inputs the form will need.
 */
function getS3Details($s3Bucket, $region, $acl = 'private') {

    // Options and Settings
    $awsKey = (!empty(getenv('AWS_ACCESS_KEY')) ? getenv('AWS_ACCESS_KEY') : AWS_ACCESS_KEY);
    $awsSecret = (!empty(getenv('AWS_SECRET')) ? getenv('AWS_SECRET') : AWS_SECRET);
    
    $algorithm = "AWS4-HMAC-SHA256";
    $service = "s3";
    $date = gmdate("Ymd\THis\Z");
    $shortDate = gmdate("Ymd");
    $requestType = "aws4_request";
    $expires = "86400"; // 24 Hours
    $successStatus = "201";
    $url = "//{$s3Bucket}.{$service}-{$region}.amazonaws.com";
    

    // Step 1: Generate the Scope
    $scope = [
        $awsKey,
        $shortDate,
        $region,
        $service,
        $requestType
    ];
    $credentials = implode('/', $scope);

    // Step 2: Making a Base64 Policy
    $policy = [
        'expiration' => gmdate('Y-m-d\TG:i:s\Z', strtotime('+6 hours')),
        'conditions' => [
            ['bucket' => $s3Bucket],
            ['acl' => $acl],
            ['starts-with', '$key', ''],
            ['starts-with', '$Content-Type', ''],
            ['starts-with', '$Content-Length', ''],
            ['success_action_status' => $successStatus],
            ['x-amz-credential' => $credentials],
            ['x-amz-algorithm' => $algorithm],
            ['x-amz-date' => $date],
            ['x-amz-expires' => $expires],
        ]
    ];
    $base64Policy = base64_encode(json_encode($policy));

    // Step 3: Signing your Request (Making a Signature)
    $dateKey = hash_hmac('sha256', $shortDate, 'AWS4' . $awsSecret, true);
    $dateRegionKey = hash_hmac('sha256', $region, $dateKey, true);
    $dateRegionServiceKey = hash_hmac('sha256', $service, $dateRegionKey, true);
    $signingKey = hash_hmac('sha256', $requestType, $dateRegionServiceKey, true);

    $signature = hash_hmac('sha256', $base64Policy, $signingKey);

    // Step 4: Build form inputs
    // This is the data that will get sent with the form to S3
    $inputs = [
        'Content-Type' => '',
        'Content-Length' => '',
        'acl' => $acl,
        'success_action_status' => $successStatus,
        'policy' => $base64Policy,
        'X-amz-credential' => $credentials,
        'X-amz-algorithm' => $algorithm,
        'X-amz-date' => $date,
        'X-amz-expires' => $expires,
        'X-amz-signature' => $signature
    ];

    return compact('url', 'inputs');
}

?>
 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                <?PHP echo $this->title ; ?>
                <small><?PHP echo $this->subtitle ; ?></small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="panel"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Listado de Archivos</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content container-fluid">
            <!--------------------------
            | Your Page Content Here |
            -------------------------->
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">
                        <h3 class="box-title"><?PHP echo $this->subtitle ; ?></h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div id="confirm_data" class="alert alert-success alert-dismissible" style="display:none;">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <h4><i class="icon fa fa-check"></i> Confirmación</h4>
                                <span id="mensaje_confirmacion"></span>
                            </div>

                            <table id="multimedia_tabla" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Titulo</th>
                                        <th>Url</th>
                                        <th>Comentario</th>
                                        <th>Estado</th>
                                        <th>Opciones</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Div Nuevo Multimedia -->
        <div id="md_nuevo" class="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title"><span id="modal_title_fotos">Registro Multimedia</span></h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        
                    <form action="<?php echo $s3FormDetails['url']; ?>"
                                    method="POST"
                                    id="form_upload"
                                    enctype="multipart/form-data"
                                    class="direct-upload">

                        <div class="row" style="margin-top:20px;">
                            <div class="col-md-12">
                                <label for="txt_titulo">Titulo</label>
                                <input required type="text" class="form-control" id="txt_titulo" >
                            </div>
                        </div>
                        <div class="row" style="margin-top:20px;">
                            <div class="col-md-12">
                                <label for="txt_descripcion">Descripción</label>
                                <textarea class="form-control" id="txt_descripcion" required ></textarea>
                                <input type="text" style="display:none;" id="txt_archivo_s3"  />
                            </div>
                        </div>
                        <div class="row" style="margin-top:20px;">
                            <div class="col-md-12">
                                <label for="sl_registro">Registro vocal</label>
                                <select id="sl_registro" class="form-control" required></select>
                            </div>
                        </div>
                        <div class="row" style="margin-top:20px;">
                            <div class="col-md-12">
                                <!--input required type="file" id="archivo" name="archivo" />
                                <div id="progress"></div-->
                                 <!-- Direct Upload to S3 Form -->
                                
                                    <?php foreach ($s3FormDetails['inputs'] as $name => $value) { ?>
                                        <input type="hidden" name="<?php echo $name; ?>" value="<?php echo $value; ?>">
                                    <?php } ?>

                                    <!-- Key is the file's name on S3 and will be filled in with JS -->
                                    <input type="hidden" name="key" value="">
                                    <input type="file" name="file">

                                    <!-- Progress Bars to show upload completion percentage -->
                                    <div class="progress-bar-area"></div>

                                
                            </div>
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" disabled="disabled" id="btn_enviar" name="btn_enviar" class="btn btn-primary">Registrar</button>
                    </div> 
                    </form>  
                </div>
            </div>
        </div>
        <!-- End Div Nuevo Multimedia -->

        <!-- Div Ver Multimedia -->
        <div id="md_ver" class="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title"><span id="modal_title_fotos">Ver Multimedia</span></h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="row">
                            <div class="col-md-12">
                                <img class="img-responsive" id="img_multimedia" />
                                <div id="div_vid" class="embed-responsive embed-responsive-16by9" style="display:none;">
                                    <video id="vid_multimedia" controls >
                                        <source src="" type="video/quicktime">
                                    </video>
                                </div>
                                <div id="div_audio" style="display:none;">
                                    <audio controls id="audio_multimedia">
                                        <source src="" type="audio/mpeg">
                                    </audio>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div> 
                </div>
            </div>
        </div>
        <!-- End Div Ver Multimedia -->

        <!-- Delete Modal -->
        <div class="modal modal-danger fade" id="modal-delete">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">¿Eliminar Registro?</h4>
              </div>
              <div class="modal-body">
                <p><span id="sp_grupo"></span></p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Cancelar</button>
                <button type="button" id="btn_elimina" data-value="" class="btn btn-outline">Eliminar</button>
              </div>
            </div>
          </div>
        </div>
        <!-- End Delete Modal -->

       
</div>

<!-- Main Footer -->
<?PHP require 'views/footer.php'; ?>
<!-- /.main-footer -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs/dt-1.10.18/b-1.5.4/b-html5-1.5.4/r-2.2.2/datatables.min.css"/>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs/dt-1.10.18/b-1.5.4/b-html5-1.5.4/r-2.2.2/datatables.min.js"></script>
<script src="https://nightly.datatables.net/select/js/dataTables.select.js?_=9a6592f8d74f8f520ff7b22342fa1183"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
<!-- Load the FileUpload Plugin (more info @ https://github.com/blueimp/jQuery-File-Upload) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/blueimp-file-upload/9.5.7/jquery.fileupload.js"></script>

<script>
    var multimedia = "";
    $(document).ready(function(){

        // Assigned to variable for later use.
        var form = $('.direct-upload');
        var filesUploaded = [];

        // Place any uploads within the descending folders
        // so ['test1', 'test2'] would become /test1/test2/filename
        var folders = [];

        form.fileupload({
            url: form.attr('action'),
            type: form.attr('method'),
            datatype: 'xml',
            add: function (event, data) {
                // Show warning message if your leaving the page during an upload.
                window.onbeforeunload = function () {
                    return 'You have unsaved changes.';
                };

                // Give the file which is being uploaded it's current content-type (It doesn't retain it otherwise)
                // and give it a unique name (so it won't overwrite anything already on s3).
                var file = data.files[0];
                var filename = Date.now() + '.' + file.name.split('.').pop();
                form.find('input[name="Content-Type"]').val(file.type);
                form.find('input[name="Content-Length"]').val(file.size);
                form.find('input[name="key"]').val((folders.length ? folders.join('/') + '/' : '') + filename);

                // Actually submit to form to S3.
                data.submit();

                // Show the progress bar
                // Uses the file size as a unique identifier
                var bar = $('<div class="progress" data-mod="'+file.size+'"><div class="bar"></div></div>');
                $('.progress-bar-area').append(bar);
                bar.slideDown('fast');
            },
            progress: function (e, data) {
                // This is what makes everything really cool, thanks to that callback
                // you can now update the progress bar based on the upload progress.
                var percent = Math.round((data.loaded / data.total) * 100);
                $('.progress[data-mod="'+data.files[0].size+'"] .bar').css('width', percent + '%').html(percent+'%');
            },
            fail: function (e, data) {
                // Remove the 'unsaved changes' message.
                window.onbeforeunload = null;
                $('.progress[data-mod="'+data.files[0].size+'"] .bar').css('width', '100%').addClass('red').html('');
            },
            done: function (event, data) {
                window.onbeforeunload = null;

                // Upload Complete, show information about the upload in a textarea
                // from here you can do what you want as the file is on S3
                // e.g. save reference to your server using another ajax call or log it, etc.
                var original = data.files[0];
                var s3Result = data.result.documentElement.children;
                
                $("#txt_archivo_s3").val(s3Result[2].innerHTML);
                $("#btn_enviar").removeAttr("disabled");
                
                //console.log(s3Result);
                filesUploaded.push({
                    "original_name": original.name,
                    "s3_name": s3Result[2].innerHTML,
                    "size": original.size,
                    "url": s3Result[0].innerHTML
                });
                $('#uploaded').html(JSON.stringify(filesUploaded, null, 2));
            }
        });



        var opcion = "";
        var info            = {};
        info["idalumno"]    = $("#txt_idparticipante").val();
        var datos           = JSON.stringify(info);

        multimedia = $('#multimedia_tabla').DataTable( {
		    "ajax": {
                "type": "POST",
                "url": "<?PHP echo constant('URL'); ?>multimediaalumno/ListaMultimedia",
                "data": {
                    "datos": datos
                }
            },
			"responsive":true,
			"scrollX":        false,
			"scrollCollapse": true,
			"fixedColumns":   {
				"leftColumns": 2
			},
			"language":{
				"url":"https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
			},
			"columnDefs":[
			    {
			        "targets": 0,
                    "data":"titulo"
                    
			    },
                {
                    "targets":1,
                    "data":"url",
					"render":function(url, type, full){
                        var link = full["url"];
                        return "<a onclick='ver_multimedia(this);' data-url='"+ link +"' href='#'>"+ link +"</a>";
					}
                },
                {
                    "targets":2,
                    "data":"comentario",
                    "render":function(url, type, full){
                        var comentario = full['comentario'];
                        var id = full['idmultimedia'];
                        if(comentario == ""){
                            return "SIN COMENTARIO";
                        }else{
                            return '<audio controls><source src="'+ '<?PHP echo(constant('URL')); ?>' + 'views/uploads/audios/' + comentario +'" type="audio/mpeg">Your browser does not support the audio element.</audio>';
                        }
                    }
					
                },
                {
                    "targets":3,
                    "data":"aprobado",
                    "render":function(url, type, full){
                        var aprobado = full['aprobado'];
                        if(aprobado == "0"){
                            return "PENDIENTE";
                        }else{
                            return 'APROBADO';
                        }
                    }
					
                },
                {
                    "targets":4,
                    "data":"idmultimedia",
                    "render": function(url, type, full){
                        var idmultimedia = "'" + full["idmultimedia"] + "&" + full["url"] + "'";
                        return '<button onclick="alert_elimina('+ idmultimedia + ');" title="Eliminar material" class="btn btn-danger"><i class="fa fa-trash"></i></button>';
                    
                    }
                }
                
			],
			"dom": 'Bfrtip',
			"buttons": [
				{
                    text: 'Nuevo',
					action: function ( e, dt, node, config ) {
                        opcion = "nuevo";
                        $('#md_nuevo').modal();
                        cargaRegistros();
                        $("#btn_enviar").text("Guardar");
                        $("#txt_titulo").val("");
                        $("#txt_descripcion").val("");
                        $("#sl_grupo").focus();
                        $(".progress-bar-area").html("");
                        $("#txt_archivo_s3").val("");
					} 
                }
			]
        } );

        $("#btn_elimina").click(function(){
            var data = $("#btn_elimina").attr("data-value");
            var id = data.split("&")[0];
            var idalumno = $("#txt_idparticipante").val();
            
            $.ajax({
                type: "POST",
                url: "<?PHP echo constant('URL'); ?>multimedia/EliminaS3Object", 
                data:{
                    datos: '{"url": "' + data.split("&")[1] + '"}'
                },
                success: function(result){
                    console.log(result);
                    if(result == "Eliminado S3"){
                        EliminarRegistro(id, idalumno);
                    }
                    //$('#modal-delete').modal('hide');
                    //multimedia.ajax.reload();	
                    //$("#mensaje_confirmacion").html(result);
                    //$("#confirm_grupo").show().delay(2000).fadeOut();
                },
                error:function(result){
                    console.log(result);
                }
            });

        });
        
    });

    $("#form_upload").submit(function(e) {
        e.preventDefault();
        var form = new FormData($("#form_upload")[0]);
        var alumno = $("#txt_idparticipante").val();
        var titulo = $("#txt_titulo").val();
        var descripcion = $("#txt_descripcion").val();
        var archivo = $("#txt_archivo_s3").val();
        var idregistro = $("#sl_registro").val();
        console.log("1", idregistro);
        if(archivo != ""){
            GuardarMultimedia(alumno, titulo, descripcion, archivo, idregistro);
        }
        
    });

    function cargaRegistros(){
        $("#sl_registro").empty();
        $("#sl_registro").append('<option value="" selected="selected">Seleccione un registro vocal</option>');
        $.ajax({
            type: "GET",
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            url: "<?PHP echo constant('URL'); ?>multimediaalumno/getRegistros", 
            success: function(result){
                $.each(result.data, function(i,v){
                    var idregistro  = v.id_registro;
                    var descripcion = v.descripcion;
                    $("#sl_registro").append('<option value="' + idregistro +'">'+ descripcion +'</option>');
                });
            }
        });
    }

    function GuardarMultimedia(alumno, titulo, descripcion, url, idregistro){
        console.log("2", idregistro);
        var info = {};
        info["idalumno"]    = alumno;
        info["titulo"]      = titulo;
        info["descripcion"] = descripcion;
        info["url"]         = url;
        info["idregistro"]  = idregistro;
        var datos = JSON.stringify(info);
        console.log("3", datos);
        $.ajax({
            type: "POST",
            url: "<?PHP echo constant('URL'); ?>multimediaalumno/GuardarMultimedia", 
            data:{
                datos: datos
            },
            success: function(result){
                console.log(result);
                $("#md_nuevo").modal('hide');
                multimedia.ajax.reload();
                
                //Enviar Notificaciones
                var info_correos = {};
                info_correos["idparticipante"] = $("#txt_idparticipante").val();
                var data_correos = JSON.stringify(info_correos);
                
                $.ajax({
                    type: "POST",
                    url: "<?PHP echo constant('URL'); ?>multimediaalumno/EnviarNotificaciones", 
                    async:false,
                    data:{
                        datos: data_correos
                    },
                    success: function(result){
                        console.log(result);
                    },
                    error:function(result){
                        console.log(result);
                    }
                });
            },
            error: function(result){
                console.log(result);
            }
        });
    }

    function EliminarRegistro(id, idalumno)
    {
        $.ajax({
            type: "POST",
            url: "<?PHP echo constant('URL'); ?>multimediaalumno/EliminaMultimedia", 
            data:{
                datos: '{"id": "' + id + '", "idalumno": "'+ idalumno +'"}'
            },
            success: function(result){
                console.log(result);
                $('#modal-delete').modal('hide');
                multimedia.ajax.reload();	
                $("#mensaje_confirmacion").html(result);
                //$("#confirm_grupo").show().delay(2000).fadeOut();
            },
            error:function(result){
                console.log(result);
            }
        });
    }

    function alert_elimina(id, link)
    {
        $('#modal-delete').modal();
        $('#sp_grupo').html("Deseas eliminar el material: " + id + "?");
        $("#btn_elimina").attr("data-value", id);
    }

    function ver_multimedia(data){
        var key = $(data).data('url')
        $('#md_ver').modal();

        var info = {};
        info["key"]      = key;
        var datos = JSON.stringify(info);
        $.ajax({
            type: "POST",
            url: "<?PHP echo constant('URL'); ?>multimediaalumno/S3GetObject", 
            data:{
                datos: datos
            },
            success: function(result){
                var datos = JSON.parse(result);
                console.log(datos.extension);
                switch(datos.extension){
                    case "jpg":
                        $("#div_vid").css("display", "none");
                        $("#div_audio").css("display", "none");
                        
                        $("#img_multimedia").css("display", "block");
                        $("#img_multimedia").attr("src", datos.url);
                        break;

                    case "mp4" || "MP4":
                        $("#img_multimedia").css("display", "none");
                        $("#div_audio").css("display", "none");
                        
                        $("#div_vid").css("display", "block");
                        $("#vid_multimedia").attr("src", datos.url);
                        break;

                    case "mpeg" || "MPEG":
                        $("#img_multimedia").css("display", "none");
                        $("#div_audio").css("display", "none");
                        
                        $("#div_vid").css("display", "block");
                        $("#vid_multimedia").attr("src", datos.url);
                        break;

                    case "mpg" || "MPG":
                        $("#img_multimedia").css("display", "none");
                        $("#div_audio").css("display", "none");
                        
                        $("#div_vid").css("display", "block");
                        $("#vid_multimedia").attr("src", datos.url);
                        break;

                    case "MOV":
                        $("#img_multimedia").css("display", "none");
                        $("#div_audio").css("display", "none");
                        
                        $("#div_vid").css("display", "block");
                        $("#vid_multimedia").attr("src", datos.url);
                        break;

                    case "mov":
                        $("#img_multimedia").css("display", "none");
                        $("#div_audio").css("display", "none");
                        
                        $("#div_vid").css("display", "block");
                        $("#vid_multimedia").attr("src", datos.url);
                        break;
                
                    case "mp3" || "MP3":
                        $("#img_multimedia").css("display", "none");
                        $("#div_vid").css("display", "none");
                        
                        $("#div_audio").css("display", "block");
                        $("#audio_multimedia").attr("src", datos.url);
                        break;

                    case "m4a" || "M4A":
                        $("#img_multimedia").css("display", "none");
                        $("#div_vid").css("display", "none");
                        
                        $("#div_audio").css("display", "block");
                        $("#audio_multimedia").attr("src", datos.url);
                        break;

                    case "m4v" || "M4V":
                        $("#img_multimedia").css("display", "none");
                        $("#div_vid").css("display", "none");
                        
                        $("#div_audio").css("display", "block");
                        $("#audio_multimedia").attr("src", datos.url);
                        break;
                }
                
            },
            error: function(result){
                console.log(result);
            }
        });
        
    }
    

    $('#md_ver').on('hidden.bs.modal', function (e) {
        $("#img_multimedia").attr("src", "");
    });

    $('#md_nuevo').on('hidden.bs.modal', function (e) {
        $("#btn_enviar").attr("disabled", "disabled");
    });
</script>