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
                            <ul id="multimedia_filter">
                                <li>
                                    <a href="#" class="all">TODOS</a>
                                </li>
                                <li>
                                    <a href="#">Solar 1</a>
                                </li>
                                <li>
                                    <a href="#">Solar 2</a>
                                </li>
                                <li>
                                    <a href="#">Solar 3</a>
                                </li>
                            </ul>
                            <div id="confirm_mensaje" class="alert alert-success alert-dismissible" style="display:none;">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <h4><i class="icon fa fa-check"></i> Confirmación</h4>
                                <span id="msj_confirmacion"></span>
                            </div>
                            <table id="multimedia_tabla" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Nombres</th>
                                        <th>Apellidos</th>
                                        <th>Correo</th>
                                        <th>Celular</th>
                                        <th>Grupo Solar</th>
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

        <!-- Div Ver Multimedia -->
        <div id="md_ver" class="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-xl" style="width:95%;" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title"><span id="modal_title_fotos">Ver Detalles</span></h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs">
                                <li id="tab_postulante" class="active"><a href="#postulante" data-toggle="tab" aria-expanded="true">Datos del Postulante</a></li>
                                <li id="tab_experiencia"><a href="#experiencia" data-toggle="tab" aria-expanded="false">¿Tiene experiencia coral previa?</a></li>
                                <li id="tab_estudia"><a href="#estudia" data-toggle="tab">¿Estudia o estudió música?</a></li>
                                <li id="tab_apoderado"><a href="#apoderado" data-toggle="tab">Datos del apoderado</a></li>
                                <li id="tab_audio"><a href="#audio" data-toggle="tab">Audio</a></li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="postulante">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <label for="txt_nombres">Nombres</label>
                                            <input type="text" class="form-control" id="txt_nombres" disabled>
                                        </div>
                                        <div class="col-sm-3">
                                            <label for="txt_apellidos">Apellidos</label>
                                            <input type="text" class="form-control" id="txt_apellidos" disabled>
                                        </div>
                                        <div class="col-sm-3">
                                            <label for="txt_nacimiento">Fecha de Nacimiento</label>
                                            <input type="text" class="form-control" id="txt_nacimiento" disabled>
                                        </div>
                                        <div class="col-sm-3">
                                            <label for="txt_edad">Edad</label>
                                            <input type="text" class="form-control" id="txt_edad" disabled>
                                        </div>
                                    </div>
                                    <div class="row" style="padding:20px 0px 0px 0px;">
                                        <div class="col-sm-4">
                                            <label for="txt_correo_postulante">Correo Electrónico</label>
                                            <input type="email" class="form-control" id="txt_correo_postulante" disabled>
                                        </div>
                                        <div class="col-sm-3">
                                            <label for="txt_celular_postulante">Celular</label>
                                            <input type="text" class="form-control" id="txt_celular_postulante" disabled> 
                                        </div>
                                        <div class="col-sm-5">
                                            <label for="sl_gruposolar">Grupo Solar</label>
                                            <input type="text" class="form-control" id="txt_grupo_solar" disabled>
                                        </div>
                                    </div>
                                    <div class="row" style="padding:20px 0px 0px 0px;">
                                        <div class="col-sm-3">
                                            <label for="txt_pais">País</label>
                                            <input type="text" class="form-control" id="txt_pais" disabled>
                                        </div>
                                        <div class="col-sm-3">
                                            <label for="txt_departamento">Departamento</label>
                                            <input type="text" class="form-control" id="txt_departamento" disabled>
                                        </div>
                                        <div class="col-sm-3">
                                            <label for="txt_provincia">Provincia</label>
                                            <input type="text" class="form-control" id="txt_provincia" disabled>
                                        </div>
                                        <div class="col-sm-3">
                                            <label for="txt_distrito">Distrito</label>
                                            <input type="text" class="form-control" id="txt_distrito" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="experiencia">
                                    <div class="row" style="padding:20px 0px 0px 0px;">
                                        <div class="col-sm-4">
                                            <label for="txt_experiencia">¿Tiene experiencia coral previa?</label>
                                            <input type="text" class="form-control" id="txt_experiencia" disabled>
                                        </div>
                                        <div class="col-sm-2">
                                            <label for="txt_cuanto_tiempo">¿Cuánto tiempo?</label>
                                            <input type="text" class="form-control" id="txt_cuanto_tiempo" disabled>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="txt_donde_fue">¿Dónde fue ó es su experiencia coral?</label>
                                            <input type="text" class="form-control" id="txt_donde_fue" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="estudia">
                                    <div class="row" style="padding:20px 0px 0px 0px;">
                                        <div class="col-sm-12">
                                            <label for="txt_estudio">¿Estudia o estudió música, canto o algún instrumento musical de forma particular, academia, escuela o en una Institución?</label>
                                            <input type="text" class="form-control" id="txt_estudio" disabled>
                                        </div>
                                    </div>
                                    <div class="row" style="padding:20px 0px 0px 0px;">
                                        <div class="col-sm-3">
                                            <label for="txt_cuanto_tiempo_instrumento">¿Cuánto tiempo?</label>
                                            <input type="text" class="form-control" id="txt_cuanto_tiempo_instrumento" disabled>
                                        </div>
                                        <div class="col-sm-3">
                                            <label for="txt_donde_estudia">¿Dónde estudia?</label>
                                            <input type="text" class="form-control" id="txt_donde_estudia" disabled>
                                        </div>
                                        <div class="col-sm-3">
                                            <label for="txt_que_instrumento">¿Qué instrumento/canto aprende?</label>
                                            <input type="text" class="form-control" id="txt_que_instrumento" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="apoderado">
                                    <div class="row" style="padding:20px 0px 0px 0px;">
                                        <div class="col-sm-4">
                                            <label for="txt_apoderado">Nombres y Apellidos</label>
                                            <input required="required" type="text" class="form-control" id="txt_apoderado" disabled>
                                        </div>
                                        <div class="col-sm-4">
                                            <label for="txt_cel_apoderado">Celular</label>
                                            <input required="required" type="text" class="form-control" id="txt_cel_apoderado" disabled>
                                        </div>
                                        <div class="col-sm-4">
                                            <label for="txt_mail_apoderado">Correo Electrónico</label>
                                            <input required="required" type="email" class="form-control" id="txt_mail_apoderado" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="audio">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div id="div_audio">
                                                <input type="hidden" id="txt_archivo">
                                                <audio controls id="audio_multimedia">
                                                    <source src="" type="audio/mpeg">
                                                </audio>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" id="btn_aprobar" data-dismiss="modal">Aprobar</button>
                        <button type="button" class="btn btn-danger" id="btn_rechazar" data-dismiss="modal">Rechazar</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div> 
                </div>
            </div>
        </div>
        <!-- End Div Ver Multimedia -->

        <!-- Rechazar Modal -->
        <div class="modal modal-danger fade" id="modal_rechazo">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Rechazar Postulante</h4>
              </div>
              <div class="modal-body">
                <p>¿Está seguro de rechazar al postulante?</p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Cancelar</button>
                <button type="button" id="btn_confirma_rechazo" class="btn btn-outline">Rechazar</button>
              </div>
            </div>
          </div>
        </div>
        <!-- End Rechazar Modal -->

        <!-- Aprobar Modal -->
        <div class="modal modal-success fade" id="modal_aprobar">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Aprobar Postulante</h4>
              </div>
              <div class="modal-body">
                <p>¿Está seguro de aprobar al postulante?</p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Cancelar</button>
                <button type="button" id="btn_confirma_aprobar" class="btn btn-outline">Aprobar</button>
              </div>
            </div>
          </div>
        </div>
        <!-- End Aprobar Modal -->
       
</div>

<!-- Main Footer -->
<?PHP require 'views/footer.php'; ?>
<!-- /.main-footer -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs/dt-1.10.18/b-1.5.4/b-html5-1.5.4/r-2.2.2/datatables.min.css"/>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs/dt-1.10.18/b-1.5.4/b-html5-1.5.4/r-2.2.2/datatables.min.js"></script>
<script src="https://nightly.datatables.net/select/js/dataTables.select.js?_=9a6592f8d74f8f520ff7b22342fa1183"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
<style>
    #multimedia_filter{
        display:flex;
        margin:0;
        padding:0;
        margin-bottom: 10px;
        font-size:10px;
    }

    #multimedia_filter li{
        list-style:none;
        margin-right: 10px;
        background: #3c8dbc;
        padding: 2px 8px;
        align-items: center;
        display: flex;
    }

    #multimedia_filter li a{
        color:#fff;
    }
</style>
<script>
    function getDetalles(id){
        var info    = {};
        info["id"]  = id;
        var datos   = JSON.stringify(info);

        $.ajax({
            url: "<?PHP echo constant('URL'); ?>preinscripcion/GetPersonaById",
            data:{
                "datos": datos
            },
            success:function(result){
                var datos = JSON.parse(result);
                datos = datos.data[0];
                $("#txt_nombres").val(datos['nombres_postulante']);
                $("#txt_apellidos").val(datos['apellidos_postulante']);
                $("#txt_nacimiento").val(datos['fecha_nacimiento']);
                $("#txt_edad").val(datos['edad']);
                $("#txt_correo_postulante").val(datos['correo_postulante']);
                $("#txt_celular_postulante").val(datos['celular_postulante']);
                $("#txt_grupo_solar").val(datos['grupo_solar']);
                $("#txt_pais").val(datos['pais']);
                $("#txt_departamento").val(datos['departamento']);
                $("#txt_provincia").val(datos['provincia']);
                $("#txt_distrito").val(datos['distrito']);

                $("#txt_experiencia").val(datos['experiencia']);
                $("#txt_cuanto_tiempo").val(datos['cuanto_tiempo']);
                $("#txt_donde_fue").val(datos['donde_fue']);

                $("#txt_estudio").val(datos['estudio_musica']);
                $("#txt_cuanto_tiempo_instrumento").val(datos['tiempo_instrumento']);
                $("#txt_donde_estudia").val(datos['donde_estudia']);
                $("#txt_que_instrumento").val(datos['que_instrumento']);

                $("#txt_apoderado").val(datos['nombres_apoderado']);
                $("#txt_cel_apoderado").val(datos['celular_apoderado']);
                $("#txt_mail_apoderado").val(datos['mail_apoderado']);

                $("#txt_archivo").val(datos['archivo']);
                
                if(datos['aprobado'] != '0'){
                    $("#btn_aprobar").attr("disabled", "disabled");
                    $("#btn_rechazar").attr("disabled", "disabled");
                }else{
                    $("#btn_aprobar").removeAttr("disabled");
                    $("#btn_rechazar").removeAttr("disabled");
                }
            }
        });
    }

    function ver_multimedia(data){
        var id = data;
        $('#md_ver').modal();
        
        $("#tab_postulante").addClass("active");
        $("#tab_experiencia").removeClass("active");
        $("#tab_estudia").removeClass("active");
        $("#tab_apoderado").removeClass("active");
        $("#tab_audio").removeClass("active");

        $("#postulante").addClass("active");
        $("#experiencia").removeClass("active");
        $("#estudia").removeClass("active");
        $("#apoderado").removeClass("active");
        $("#audio").removeClass("active");

        $("#btn_aprobar").attr("data-id", id);
        $("#btn_rechazar").attr("data-id", id);
        getDetalles(id);
    }

    var multimedia = "";
    $(document).ready(function(){
        $("#btn_aprobar").click(function(){
            var id = $("#btn_aprobar").attr("data-id");
            $("#modal_aprobar").modal();
            $("#btn_confirma_aprobar").attr("data-id", id);
            return false;
        });

        $("#btn_rechazar").click(function(){
            var id = $("#btn_rechazar").attr("data-id");
            $("#modal_rechazo").modal();
            $("#btn_confirma_rechazo").attr("data-id", id);
            return false;
        });

        $("#btn_confirma_rechazo").click(function(){
            var id = $("#btn_confirma_rechazo").attr("data-id");
            var info    = {};
            info["id"]  = id;
            var datos   = JSON.stringify(info);

            $.ajax({
                url: "<?PHP echo constant('URL'); ?>preinscripcion/RechazarPostulante",
                data:{
                    "datos": datos
                },
                success:function(result){
                    var datos = JSON.parse(result);
                    $('#md_ver').modal('hide');
                    $('#modal_rechazo').modal('hide');
                    multimedia.ajax.reload();	
                    $("#confirm_mensaje").show().delay(2000).fadeOut();
                    $("#msj_confirmacion").html(datos.message);
                }
            });
        });

        $("#btn_confirma_aprobar").click(function(){
            var id = $("#btn_confirma_aprobar").attr("data-id");
            var info    = {};
            info["id"]  = id;
            var datos   = JSON.stringify(info);

            $.ajax({
                url: "<?PHP echo constant('URL'); ?>preinscripcion/AprobarPostulante",
                data:{
                    "datos": datos
                },
                success:function(result){
                    var datos = JSON.parse(result);
                    $('#md_ver').modal('hide');
                    $('#modal_aprobar').modal('hide');
                    multimedia.ajax.reload();	
                    $("#confirm_mensaje").show().delay(2000).fadeOut();
                    $("#msj_confirmacion").html(datos.message);
                }
            });
        });

        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            var target = $(e.target).attr("href") // activated tab
            if(target == "#audio"){
                var info = {};
                info["key"]      = $("#txt_archivo").val();
                var datos = JSON.stringify(info);
                $.ajax({
                    type: "POST",
                    url: "<?PHP echo constant('URL'); ?>multimedia/S3GetObject", 
                    data:{
                        datos: datos
                    },
                    success: function(result){
                        var datos = JSON.parse(result);
                        switch(datos.extension){
                            case "mp3" || "MP3":
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
        });

        multimedia = $('#multimedia_tabla').DataTable( {
		    "ajax": {
                "type": "POST",
                "url": "<?PHP echo constant('URL'); ?>preinscripcion/ListaPersonas",
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
                    "data":"nombres_postulante"
                    
			    },
                {
			        "targets": 1,
                    "data":"apellidos_postulante"
                    
			    },
                {
			        "targets": 2,
                    "data":"correo_postulante"
                    
			    },
                {
			        "targets": 3,
                    "data":"celular_postulante"
                    
			    },
                {
			        "targets": 4,
                    "data":"grupo_solar"
                    
			    },
                {
			        "targets": 5,
                    "render":function(url, type, full){
                        var aprobado = full["aprobado"];
                        switch(aprobado){
                            case '0':
                                return 'PENDIENTE';
                                break;
                            case '1':
                                return 'APROBADO';
                                break;
                            case '2':
                                return 'NO APROBADO';
                                break;
                        }
                        
					}
			    },
                {
                    "targets":6,
                    "data":"id",
					"render":function(url, type, full){
                        var id = full["id"];
                        return '<button onclick="ver_multimedia('+ id + ');" title="Ver detalles" class="btn btn-primary"><i class="fa fa-search"></i> Ver detalles</button>';
					}
                }
                
			]
        } );

        //FILTRO GRUPOS
        $('#multimedia_filter').on( 'click', 'a', function () {
            console.log($(this).text());
            regex = '^' + $(this).text() + '$';
            multimedia.columns(4).search(regex, true, false).draw();
        });

        $('#multimedia_filter').on('click', 'a.all', function() {
            multimedia
            .search('')
            .columns(4)
            .search('')
            .draw();
        });

        $('#md_ver').on('hidden.bs.modal', function (e) {
            $("#audio_multimedia").attr("src", "");
        });
    });


    
</script>