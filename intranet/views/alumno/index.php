<?PHP require 'views/header.php'; ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Alumnos
        <small>Listado de Alumnos</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Reportes</a></li>
        <li class="active">Reporte de Audiciones 2019</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

    <div id="confirm_grupo" class="alert alert-success alert-dismissible" style="display:none;">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-check"></i> Confirmación</h4>
        <span id="mensaje_confirmacion"></span>
    </div>
       
      <!--------------------------
        | Your Page Content Here |
        -------------------------->
        <div class="row">
            <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                <h3 class="box-title">Audiciones 2019</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="alumnos" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Nombres</th>
                                <th>Apellidos</th>
                                <th>Edad</th>
                                <th>Grupo</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                    </table>
                    
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->

            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

        <!-- Div Asignar -->
        <div id="md_asignar" class="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><span id="modal_title"></span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="frm_asignar" method="POST">
                        <div class="form-row">
                            <div class="col-4">
                                <label for="sl_grupo">Grupo</label>
                                <select class="form-control" id="sl_grupo" name="sl_grupo"></select>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" id="btn_asignar" name="btn_asignar" class="btn btn-primary">Asignar</button>
                </div>
                </form>
                </div>
            </div>
        </div>
        <!-- End Div Asignar -->

        <!-- Div Nuevo Apoderado -->
        <div id="md_nuevoapoderado" class="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title"><span id="modal_title_apoderado"></span></h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="frm_apoderado" method="POST">
                        <div class="row">
                            <div class="col-md-3 form-group">
                                <label for="txt_nombres_apoderado">Nombres</label>
                                <input required type="text" class="form-control" id="txt_nombres_apoderado" name="txt_nombres_apoderado" placeholder="Nombres">
                            </div>
                            
                            <div class="col-md-3">
                                <label for="txt_apellidos_apoderado">Apellidos</label>
                                <input required type="text" class="form-control" id="txt_apellidos_apoderado" name="txt_apellidos_apoderado" placeholder="Apellidos">
                            </div>

                            <div class="col-md-3">
                                <label for="txt_correo_apoderado">Correo</label>
                                <input required type="text" class="form-control" id="txt_correo_apoderado" name="txt_correo_apoderado" placeholder="Correo">
                            </div>

                            <div class="col-md-3">
                                <label for="txt_celular_apoderado">Celular</label>
                                <input required type="text" class="form-control" id="txt_celular_apoderado" name="txt_celular_apoderado" placeholder="Celular">
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" id="btn_enviar_apoderado" data-value="0" name="btn_enviar_apoderado" class="btn btn-primary">Registrar</button>
                </div>
                </form>
                </div>
            </div>
        </div>
        <!-- Fin Nuevo Apoderado -->

        <!-- Div Ver -->
        <div id="md_nuevo" class="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><span id="modal_title"></span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="confirm_apoderado" class="alert alert-success alert-dismissible" style="display:none;">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h4><i class="icon fa fa-check"></i> Confirmación</h4>
                        <span id="mensaje_confirmacion_apoderado"></span>
                    </div>
                    
                    <input type="hidden" id="txt_idparticipante" />
                    <form id="frm_alumno" method="POST">
                        <div class="form-row">
                            <div class="col-12">
                                <div class="nav-tabs-custom">
                                    <ul class="nav nav-tabs">
                                        <li id="tab_datos_generales" class="active"><a href="#datos_generales" data-toggle="tab">Datos Generales</a></li>
                                        <li id="tab_estudios"><a href="#estudios" data-toggle="tab">Estudios</a></li>
                                        <li id="tab_salud"><a href="#salud" data-toggle="tab">Salud</a></li>
                                        <li id="tab_apoderados"><a href="#apoderados" data-toggle="tab">Apoderados</a></li>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="active tab-pane" id="datos_generales">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label for="txt_nombres">Nombres</label>
                                                    <input required type="text" class="form-control" id="txt_nombres" name="txt_nombres" placeholder="Nombres">
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="txt_apellidos">Apellidos</label>
                                                    <input required type="text" class="form-control" id="txt_apellidos" name="txt_apellidos" placeholder="Apellidos">
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="txt_nacimiento">Fecha de Nacimiento</label>
                                                    <input type="text" class="form-control" id="txt_nacimiento" name="txt_nacimiento" placeholder="Nacimiento">
                                                </div>
                                            </div>
                                            <div class="row top-buffer">
                                                <div class="col-md-4">
                                                    <label for="txt_dni">DNI</label>
                                                    <input type="text" class="form-control" id="txt_dni" name="txt_dni" placeholder="DNI">
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="txt_direccion">Direccion</label>
                                                    <input type="text" class="form-control" id="txt_direccion" name="txt_direccion" placeholder="Direccion">
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="txt_distrito">Distrito</label>
                            						<select class="form-control" id="txt_distrito" name="txt_distrito"></select>
                                                </div>
                                            </div>
                                            <div class="row top-buffer">
                                                <div class="col-md-6">
                                                    <label for="txt_celular_alumno">Celular</label>
                                                    <input type="text" class="form-control" id="txt_celular_alumno" name="txt_celular_alumno" placeholder="Celular">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="txt_correo_alumno">Correo</label>
                                                    <input type="text" class="form-control" id="txt_correo_alumno" name="txt_correo_alumno" placeholder="Correo">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="estudios">
                                            <div class="row top-buffer">
                                                <div class="col-md-6">
                                                    <label for="txt_centro_estudios">Centro de estudios</label>
                                                    <input type="text" class="form-control" id="txt_centro_estudios" name="txt_centro_estudios" placeholder="Centro de estudios">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="txt_grado_instruccion">Grado de instrucción</label>
                                                    <input type="text" class="form-control" id="txt_grado_instruccion" name="txt_grado_instruccion" placeholder="Grado de instrucción">
                                                </div>
                                            </div>
                                            <div class="row top-buffer">
                                                <div class="col-md-12">
                                                    <label for="estudia_canto">¿Estudia canto? </label> 
                                                    <label>
                                                        <input type="radio" name="estudia_canto" id="estudia_canto" value="S" >
                                                        Sí
                                                    </label>
                                                    <label>
                                                        <input type="radio" name="estudia_canto" id="estudia_canto" value="N" >
                                                        No
                                                    </label>
                                                    <input type="text" class="form-control" id="txt_centro_instruccion" name="txt_grado_instruccion" placeholder="Centro de instrucción">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="salud">
                                            <div class="row top-buffer">
                                                <div class="col-md-6">
                                                    <label for="txt_seguro_salud">Seguro de salud</label>
                                                    <input type="text" class="form-control" id="txt_seguro_salud" name="txt_seguro_salud" placeholder="Seguro de salud">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="txt_alergias">Alergias</label>
                                                    <input type="text" class="form-control" id="txt_alergias" name="txt_alergias" placeholder="Alergias">
                                                </div>
                                            </div>
                                            <div class="row top-buffer">
                                                <div class="col-md-12" style="margin-top:10px;margin-bottom:10px;">
                                                    <strong>Medicamentos</strong>
                                                </div>
                                            </div>
                                            <div class="row top-buffer">
                                                <div class="col-md-4">
                                                    <label for="txt_dolor_cabeza">Dolor de cabeza</label>
                                                    <input type="text" class="form-control" id="txt_dolor_cabeza" name="txt_dolor_cabeza" placeholder="Dolor de cabeza">
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="txt_fiebre">Fiebre</label>
                                                    <input type="text" class="form-control" id="txt_fiebre" name="txt_fiebre" placeholder="Fiebre">
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="txt_dolor_estomago">Dolor de estomago</label>
                            						<input type="text" class="form-control" id="txt_dolor_estomago" name="txt_dolor_estomago" placeholder="Dolor de estomago">
                                                </div>
                                            </div>
                                            <div class="row top-buffer">
                                                <div class="col-md-12">
                                                    <label for="txt_medicamento_diario">¿Medicamento diario? </label> 
                                                    <label>
                                                        <input type="radio" name="opcion_diario" id="opcion_diario" value="S">
                                                        Sí
                                                    </label>
                                                    <label>
                                                        <input type="radio" name="opcion_diario" id="opcion_diario" value="N">
                                                        No
                                                    </label>
                                                    <textarea class="form-control" id="txt_medicamento_diario" name="txt_medicamento_diario" placeholder="Medicamento diario"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="apoderados">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div id="confirm_delete_apoderado" class="alert alert-success alert-dismissible" style="display:none;">
                                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                                        <h4><i class="icon fa fa-check"></i> Confirmación</h4>
                                                        <span>El registro fue eliminado</span>
                                                    </div>
                            
                                                    <table id="apoderados_table" class="table table-striped table-bordered" style="width:100%">
                                                        <thead>
                                                            <tr>
                                                                <th>Nombres</th>
                                                                <th>Apellidos</th>
                                                                <th>Celular</th>
                                                                <th>Correo</th>
                                                                <th>Opciones</th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" id="btn_enviar" name="btn_enviar" class="btn btn-primary">Registrar</button>
                </div>
                </form>
                </div>
            </div>
        </div>
        <!-- Fin Div Ver -->

         <!-- Delete Modal -->
         <div class="modal modal-danger fade" id="modal_delete">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">¿Eliminar Registro?</h4>
              </div>
              <div class="modal-body">
                <p>Desea eliminar el registo: <span id="sp_grupo"></span></p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Cancelar</button>
                <button type="button" id="btn_elimina" class="btn btn-outline">Eliminar</button>
              </div>
            </div>
          </div>
        </div>
        <!-- End Delete Modal -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


<!-- Main Footer -->
<?PHP require 'views/footer.php'; ?>
<!-- /.main-footer -->

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs/dt-1.10.18/b-1.5.4/b-html5-1.5.4/r-2.2.2/datatables.min.css"/>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs/dt-1.10.18/b-1.5.4/b-html5-1.5.4/r-2.2.2/datatables.min.js"></script>

<script>
	$(document).ready(function() {
        var idalumno = "";
        var apoderados = "";

		var alumnos = $('#alumnos').DataTable( {
		    "ajax": "http://localhost:8080/intranet/alumno/getAlumnos",
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
                    "data": "nombres"
                },            
                {
                    "targets": 1,
                    "data": "apellidos"
                },            
                {
                    "targets": 2,
                    "data": "edad"
                },  
                {
                    "targets": 3,
                    "data": "grupo"
                },    
                {
                    "targets":4,
                    "data":"idparticipante",
                    "render": function(url, type, full){
                        console.log(url);
                        return '<button type="button" onclick="ver_participante('+ full[0] +');" class="btn btn-primary"><i class="fa fa-pencil"></i> Ver</button> <button type="button" onclick="asignar_grupo('+ full[0] +');" class="btn btn-warning"><i class="fa fa-plus-square"></i> Asignar</button>'
                        return false;
                    },
                    "width":"40%"
                }        
			],
			"columns":[
                /*{"data":"idparticipante"},
                {"data":"nombres"},
				{"data":"apellidos"},
				{"data":"edad"},
                {"data":"grupo"},
                {
                    data: null,
                    className: "centerd",
                    defaultContent: '<button class="view btn btn-primary"><i class="fa fa-pencil"></i> Ver</button> <button class="assign btn btn-warning"><i class="fa fa-plus-square"></i> Asignar Grupo</button>'
                }*/
			],
			"dom": 'Bfrtip',
			"buttons": [
				{
					"extend": "pdfHtml5",
					"orientation": "landscape",
					"pageSize": "LEGAL"
				}
			]
		} );

        $("#frm_apoderado").submit(function(event){
            event.preventDefault();
            var nombres         = $("#txt_nombres_apoderado").val();
            var apellidos       = $("#txt_apellidos_apoderado").val();
            var celular         = $("#txt_celular_apoderado").val();
            var correo          = $("#txt_correo_apoderado").val();
            var idpostulante    = $("#txt_idparticipante").val();
            var info = {};
            
            info["nombres"]         = nombres;
            info["apellidos"]       = apellidos;
            info["celular"]         = celular;
            info["correo"]          = correo;
            info["idpostulante"]    = idpostulante;
            //console.log(myJsonString);
            var idapoderado = $("#btn_enviar_apoderado").attr("data-value");
            info["id"]              = idapoderado
            var myJsonString        = JSON.stringify(info);
            if(idapoderado!="0"){
                $.ajax({
                    type: "POST",
                    url: "<?PHP echo constant('URL'); ?>apoderado/ActualizaApoderado", 
                    data:{
                        datos: myJsonString
                    },
                    success: function(result){
                        console.log(result);
                        $('#md_nuevoapoderado').modal('hide');
                        $("#mensaje_confirmacion_apoderado").html("El nuevo apoderado ha sido registrado.");
                        $("#confirm_apoderado").show().delay(2000).fadeOut();
                        ver_participante(idpostulante);
                    },
                    error:function(result){
                        console.log(result);
                    }
                });
            }else{
               $.ajax({
                    type: "POST",
                    url: "<?PHP echo constant('URL'); ?>apoderado/RegistraApoderado", 
                    data:{
                        datos: myJsonString
                    },
                    success: function(result){
                        console.log(result);
                        if(result == '23000'){
                            
                        }else{
                            $('#md_nuevoapoderado').modal('hide');
                            $("#mensaje_confirmacion_apoderado").html("El nuevo apoderado ha sido registrado.");
                            $("#confirm_apoderado").show().delay(2000).fadeOut();
                            ver_participante(idpostulante);
                        }
                    },
                    error:function(result){
                        console.log(result);
                    }
                });
            }
        });
        

        $("#frm_alumno").submit(function(event){
            event.preventDefault();
            idalumno                    = $("#btn_enviar").attr('data-value');
            var txt_nombres             = $("#txt_nombres").val();
            var txt_apellidos           = $("#txt_apellidos").val();
            var txt_nacimiento          = $("#txt_nacimiento").val();
            var txt_dni                 = $("#txt_dni").val();
            var txt_direccion           = $("#txt_direccion").val();
            var txt_distrito            = $("#txt_distrito").val();
            var txt_celular_alumno      = $("#txt_celular_alumno").val();
            var txt_correo_alumno       = $("#txt_correo_alumno").val();
            var txt_centro_estudios     = $("#txt_centro_estudios").val();
            var txt_grado_instruccion   = $("#txt_grado_instruccion").val();
            var estudia_canto           = $("#estudia_canto").val();
            var txt_centro_instruccion  = $("#txt_centro_instruccion").val();
            var txt_seguro_salud        = $("#txt_seguro_salud").val();
            var txt_alergias            = $("#txt_alergias").val();
            var txt_dolor_cabeza        = $("#txt_dolor_cabeza").val();
            var txt_fiebre              = $("#txt_fiebre").val();
            var txt_dolor_estomago      = $("#txt_dolor_estomago").val();
            var opcion_diario           = $("#opcion_diario").val();
            var txt_medicamento_diario  = $("#txt_medicamento_diario").val();

            var info = {};
            info["idalumno"]                = idalumno;
            info["txt_nombres"]             = txt_nombres;
            info["txt_apellidos"]           = txt_apellidos;
            info["txt_nacimiento"]          = txt_nacimiento;
            info["txt_dni"]                 = txt_dni;
            info["txt_direccion"]           = txt_direccion;
            info["txt_distrito"]            = txt_distrito;
            info["txt_celular_alumno"]      = txt_celular_alumno;
            info["txt_correo_alumno"]       = txt_correo_alumno;
            info["txt_centro_estudios"]     = txt_centro_estudios;
            info["txt_grado_instruccion"]   = txt_grado_instruccion;
            info["estudia_canto"]           = estudia_canto;
            info["txt_centro_instruccion"]  = txt_centro_instruccion;
            info["txt_seguro_salud"]        = txt_seguro_salud;
            info["txt_alergias"]            = txt_alergias;
            info["txt_dolor_cabeza"]        = txt_dolor_cabeza;
            info["txt_fiebre"]              = txt_fiebre;
            info["txt_dolor_estomago"]      = txt_dolor_estomago;
            info["opcion_diario"]           = opcion_diario;
            info["txt_medicamento_diario"]  = txt_medicamento_diario;
            var myJsonString = JSON.stringify(info);

            $.ajax({
                type: "POST",
                url: "<?PHP echo constant('URL'); ?>alumno/ActualizaAlumno", 
                data:{
                    datos: myJsonString
                },
                success: function(result){
                    console.log(result);
                    $('#md_nuevo').modal('hide');
                    alumnos.ajax.reload();	
                    $("#mensaje_confirmacion").html("Se ha actualizado la información del alumno.");
                    $("#confirm_grupo").show().delay(2000).fadeOut();
                },
                error:function(result){
                    console.log(result);
                }
            });

        });
        
        
        $("#txt_distrito").append('<option value="" selected="selected">Seleccione un distrito</option>');
        $.ajax({
            type: "GET",
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            url: "<?PHP echo constant('URL'); ?>distritos.json", 
            success: function(result){
                $.each(result, function(i,v){
                    var id = v.id;
                    var value = v.value;
                    $("#txt_distrito").append('<option value="'+id+'">'+ value +'</option>');
                });
            }
        });

        $("#frm_asignar").submit(function(event){
            event.preventDefault();
            var grupo = $("#sl_grupo").val();
            var idalumno = $("#btn_asignar").attr('data-value');

            var info = {};
            info["idgrupo"]         = grupo;
            info["idparticipante"]  = idalumno;
            var myJsonString = JSON.stringify(info);
            console.log(myJsonString);
            
            if(grupo != ""){
                $.ajax({
                    type: "POST",
                    url: "<?PHP echo constant('URL'); ?>alumno/AsignaGrupo", 
                    data:{
                        datos: myJsonString
                    },
                    success: function(result){
                        console.log(result);
                        $('#md_asignar').modal('hide');
                        alumnos.ajax.reload();	
                        $("#mensaje_confirmacion").html("Se ha actualizado la información del alumno.");
                        $("#confirm_grupo").show().delay(2000).fadeOut();
                    },
                    error:function(result){
                        console.log(result);
                    }
                });
            }else{
                alert("Seleccione un grupo");
            }
            
        });
	} );

    function cargaGrupos(){
        $("#sl_grupo").empty();
        $("#sl_grupo").append('<option value="" selected="selected">Seleccione un grupo</option>');
        $.ajax({
            type: "GET",
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            url: "<?PHP echo constant('URL'); ?>grupo/getGrupos", 
            success: function(result){
                $.each(result.data, function(i,v){
                    var idgrupo     = v.idgrupo;
                    var descripcion = v.descripcion;
                    $("#sl_grupo").append('<option value="' + idgrupo +'">'+ descripcion +'</option>');
                });
            }
        });
    }

    function asignar_grupo(id){
        $("#btn_asignar").attr("data-value", id);
        $('#md_asignar').modal();
        $("#modal_title").html("Asignar Grupo");
        $("#btn_enviar").text("Guardar");
        cargaGrupos();
    }

    function ver_participante(id){
        $("#tab_estudios").removeClass("active");
        $("#tab_salud").removeClass("active");
        $("#tab_apoderados").removeClass("active");
        $("#tab_datos_generales").addClass("active");

        $("#estudios").removeClass("active");
        $("#salud").removeClass("active");
        $("#apoderados").removeClass("active");
        $("#datos_generales").addClass("active");
        
        $("#btn_enviar").attr("data-value", id);
        $('#md_nuevo').modal();
        $("#txt_idparticipante").val(id);
        $("#modal_title").html("Actualizar Datos");
        $("#btn_enviar").text("Guardar");
        $.ajax({
            type: "POST",
            url: "<?PHP echo constant('URL'); ?>alumno/VerAlumno", 
            data:{
                datos: '{"idalumno": "' + id + '"}'
            },
            success: function(result){
                var datos = jQuery.parseJSON(result);
                console.log(datos);
                $("#txt_nombres").val(datos.nombres);
                $("#txt_apellidos").val(datos.apellidos);
                $("#txt_nacimiento").val(datos.fecha_nacimiento);
                $("#txt_dni").val(datos.dni);
                $("#txt_distrito").val(datos.distrito);
                $("#txt_direccion").val(datos.direccion);
                $("#txt_celular_alumno").val(datos.celular_postulante);
                $("#txt_correo_alumno").val(datos.correo_postulante);
                $("#txt_centro_estudios").val(datos.centro_estudios);
                $("#txt_grado_instruccion").val(datos.anio_estudios);
                if(datos.estudia_canto == "S"){
                    $('input:radio[name=estudia_canto]:nth(0)').attr('checked',true);
                }
                if(datos.estudia_canto == "N"){
                    $('input:radio[name=estudia_canto]:nth(1)').attr('checked',true);
                }
                $("#txt_centro_instruccion").val(datos.donde_estudia);
                $("#txt_seguro_salud").val(datos.seguro_salud);
                $("#txt_alergias").val(datos.alergias);
                $("#txt_dolor_cabeza").val(datos.dolor_cabeza);
                $("#txt_fiebre").val(datos.fiebre);
                $("#txt_dolor_estomago").val(datos.dolor_estomago);
                if(datos.toma_medicamento_diario == "S"){
                    $('input:radio[name=opcion_diario]:nth(0)').attr('checked',true);
                }
                if(datos.estudia_canto == "N"){
                    $('input:radio[name=opcion_diario]:nth(1)').attr('checked',true);
                }
                $("#txt_medicamento_diario").val(datos.medicamento_diario);
            },
            error:function(result){
                console.log(result);
            }
        });

        apoderados = CrearDatatable(id, "apoderados_table");
    }

    function CrearDatatable(idparent, tabla){
        var info = {};
        info["idparent"]    = idparent;
        var myJsonString    = JSON.stringify(info);
        console.log(tabla);

        var tabla = $('#' + tabla).DataTable( {
            "responsive":true,
            "scrollCollapse": true,
            "searching": true,
            "bDestroy": true,
            "ordering": false,
            "columnDefs":[
                {
                    "targets":0,
                    "data":"nombres",
                    "width":"40%"
                },
                {
                    "targets":1,
                    "data":"apellidos",
                    "width":"40%"
                },
                {
                    "targets":2,
                    "data":"celular",
                    "width":"20%"
                },
                {
                    "targets":3,
                    "data":"correo",
                    "width":"20%"
                },
                {
                    "targets":4,
                    "data":"id_apoderadoalumno",
                    "width":"20%",
                    "render": function(url, type, full){
                        var id = "'" + full[0] + "'";
                        return '<button type="button" onclick="editar_apoderado('+ id +');" title="Editar placa" class="btn btn-primary"><i class="fa fa-pencil"></i></button> <button type="button" onclick="alert_elimina('+ id +');" title="Eliminar placa" class="btn btn-danger"><i class="fa fa-trash"></i></button>';
                        return false;
                    },
                },
            ],
            "ajax": {
                "type": "POST",
                "url": "<?PHP echo constant('URL'); ?>apoderado/GetApoderadosByAlumno",
                "data": {
                    "datos": myJsonString
                }
            },
            "language":{
                "url":"https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            "dom": 'Bfrtip',
            "buttons": [
                {
                    text: 'Nuevo',
                    action: function ( e, dt, node, config ) {
                        opcion = "nuevo";
                        $('#md_nuevoapoderado').modal();
                        $("#txt_nombres_apoderado").val("");
                        $("#txt_apellidos_apoderado").val("");
                        $("#txt_celular_apoderado").val("");
                        $("#txt_correo_apoderado").val("");
                        $("#txt_nombres_apoderado").focus();
                        $('#md_nuevo').modal('hide');
                        
                        $("#modal_title_fotos").html("Agregar Fotos");
                        $("#btn_enviar").text("Guardar");
                        $("#btn_enviar_apoderado").attr("data-value", "0");
                    }
                }
            ]
        } );

        return tabla;
    } 

    function editar_apoderado(id){
        $("#md_nuevo").modal('hide');
        $("#btn_enviar_apoderado").attr("data-value", id);
        $("#md_nuevoapoderado").modal();
        $.ajax({
            type: "POST",
            url: "<?PHP echo constant('URL'); ?>apoderado/GetApoderado", 
            data:{
                datos: '{"id": "' + id + '"}'
            },
            success: function(result){
                var datos = jQuery.parseJSON(result);
                $("#txt_nombres_apoderado").val(datos.nombres);
                $("#txt_apellidos_apoderado").val(datos.apellidos);
                $("#txt_correo_apoderado").val(datos.correo);
                $("#txt_celular_apoderado").val(datos.celular);
                console.log(datos);
            },
            error:function(result){
                console.log(result);
            }
        });
        return false;
    }

    $('#md_nuevoapoderado').on('hidden.bs.modal', function () {
        $("#md_nuevoapoderado").modal('hide');
        $('#md_nuevo').modal();
        $('body').css("padding-right", "0px");
    });

    function alert_elimina(id)
    {
        $("#modal_delete").modal();
        $("#btn_elimina").attr("data-value", id);
    }

    $("#btn_elimina").click(function(){
        var id = $("#btn_elimina").attr("data-value");;
        $.ajax({
            type: "POST",
            url: "<?PHP echo constant('URL'); ?>apoderado/EliminaApoderado", 
            data:{
                datos: '{"id": "' + id + '"}'
            },
            success: function(result){
                console.log(result);
                $('#modal_delete').modal('hide');
                apoderados.ajax.reload();	
                $("#confirm_delete_apoderado").show().delay(2000).fadeOut();
            },
            error:function(result){
                console.log(result);
            }
        });
    });
    
</script>

<!-- Optionally, you can add Slimscroll and FastClick plugins.
     Both of these plugins are recommended to enhance the
     user experience. -->
     </body>
</html>