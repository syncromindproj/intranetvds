<?PHP require 'views/header.php'; ?>
<?php

// TODO Enter your AWS credentials
// Note: these can be set as environment variables (with the same name) or constants.

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
                            <ul id="grupo_filter"></ul>
                            <table id="multimedia_tabla" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Titulo</th>
                                        <th>Url</th>
                                        <th>Docente</th>
                                        <th>Alumno</th>
                                        <th>Grupo</th>
                                        <th>Comentario</th>
                                        <th>Estado</th>
                                        <th>Eliminar</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>

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
<style>
    #grupo_filter{
        display:flex;
        margin:0;
        padding:0;
        margin-bottom: 10px;
        font-size:10px;
    }

    #grupo_filter li{
        list-style:none;
        margin-right: 10px;
        background: #3c8dbc;
        padding: 2px 8px;
        align-items: center;
        display: flex;
    }

    #grupo_filter li a{
        color:#fff;
    }
</style>
<script>
    var multimedia = "";
    $(document).ready(function(){

        var opcion = "";
        var info            = {};
        info["iddocente"]   = $("#txt_idparticipante").val();
        var datos           = JSON.stringify(info);

        multimedia = $('#multimedia_tabla').DataTable( {
		    "ajax": {
                "type": "POST",
                "url": "<?PHP echo constant('URL'); ?>multimediaadmin/ListaMultimedia",
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
                    "data":"titulo",
                    "render":function(url, type, full){
                        var titulo = full["titulo"];
                        if(titulo != "AÚN NO HA PUBLICADO"){
                            return titulo;
                        }else{
                            return '<span style="color:red;">'+ titulo +'</span>'
                        }
                    }
			    },
                {
                    "targets":1,
                    "data":"url",
					"render":function(url, type, full){
                        var link = full["url"];
                        if(link != "AÚN NO HA PUBLICADO"){
                            return "<a onclick='ver_multimedia(this);' data-url='"+ link +"' href='#'>"+ link +"</a>";
                        }else{
                            return '<span style="color:red;">'+ link +'</span>'
                        }
                        
					}
                },
                {
			        "targets": 2,
                    "data":"docente"
                    
                },
                {
			        "targets": 3,
                    "data":"alumno"
                    
                },
                {
			        "targets": 4,
                    "data":"grupo"
                    
                },
                {
			        "targets": 5,
                    "data":"comentario",
                    "render":function(url, type, full){
                        var comentario = full['comentario'];
                        var id = full['idmultimedia'];
                        switch(comentario){
                            case 'AÚN NO HA PUBLICADO':
                                return '<span style="color:red;">'+ comentario +'</span>'
                                break;
                            case "":
                                return "SIN COMENTARIOS";
                                break;
                            default:
                                return '<div style="display:flex;"><audio controls><source src="'+ '<?PHP echo(constant('URL')); ?>' + 'views/uploads/audios/' + comentario +'" type="audio/mpeg">Your browser does not support the audio element.</audio> </div>';
                                break;
                        }
                        
                    }
                    
                },
                {
			        "targets": 6,
                    "data":"aprobado",
                    "render":function(url, type, full){
                        var estado = full['aprobado'];
                        switch(estado){
                            case 'AÚN NO HA PUBLICADO':
                                return '<span style="color:red;">'+ estado +'</span>'
                                break;
                            case '1':
                                return "APROBADO";
                                break;
                            default:
                                return "PENDIENTE";    
                                break;
                        }
                        
                    }
                    
                },
                {
                    "targets":7,
                    "data":"idmultimedia",
                    "render": function(url, type, full){
                        var id = full["idmultimedia"];
                        var idmultimedia = "'" + full["idmultimedia"] + "&" + full["url"] + "'";
                        if(id != "AÚN NO HA PUBLICADO"){
                            //return '<button class="elimina_archivo" onclick="alert_elimina('+ idmultimedia + ');" title="Eliminar material" class="btn btn-danger"><i class="fa fa-trash"></i></button>';
                            return '<button data-id="'+ id +'" data-link="'+ full["url"] +'" onclick="alert_elimina(this);" title="Eliminar material" class="btn btn-danger"><i class="fa fa-trash"></i></button>';
                        }else{
                            return '<span style="color:red;">'+ id +'</span>'
                        }
                        
                    
                    }
                }
			]
			
        } );

        //FILTRO GRUPOS
        $('#grupo_filter').on( 'click', 'a', function () {
            console.log($(this).text());
            //multimedia.columns(4).search($(this).text()).draw();
            regex = '^' + $(this).text() + '$';
            multimedia.columns(4).search(regex, true, false).draw();
        });

        $('#grupo_filter').on('click', 'a.all', function() {
            multimedia
            .search('')
            .columns(4)
            .search('')
            .draw();
        });

        $.ajax({
            type: "POST",
            url: "<?PHP echo constant('URL'); ?>grupo/getGrupos", 
            success: function(result){
                var datos = JSON.parse(result);
                var lista = $("#grupo_filter");
                var html = "";
                html += '<li><a href="#" class="all">TODOS</a></li>';
                for(var x=0;x<datos.data.length;x++){
                    html += '<li><a href="#">' + datos.data[x]['descripcion'] + '</a></li>';
                }
                lista.html(html);
            },
            error:function(result){
                console.log(result);
            }
        });
        //FILTRO GRUPOS


        $("#btn_elimina").click(function(){
            var data = $("#btn_elimina").attr("data-value");
            var id = data.split("&")[0];
            
            $.ajax({
                type: "POST",
                url: "<?PHP echo constant('URL'); ?>multimedia/EliminaS3Object", 
                data:{
                    datos: '{"url": "' + data.split("&")[1] + '"}'
                },
                success: function(result){
                    console.log(result);
                    if(result == "Eliminado S3"){
                        EliminarRegistro(id);
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

    function EliminarRegistro(id)
    {
        $.ajax({
            type: "POST",
            url: "<?PHP echo constant('URL'); ?>multimediaadmin/EliminaMultimedia", 
            data:{
                datos: '{"id": "' + id + '"}'
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

    //function alert_elimina(id, link)
    function alert_elimina(data)
    {
        var id = $(data).attr('data-id');
        var link = $(data).attr('data-link');
        console.log(link);
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
</script>