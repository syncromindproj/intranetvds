<?PHP require 'views/header.php'; ?>
<link href='<?PHP echo constant('URL'); ?>views/public/css/bootstrap-datepicker.min.css' rel='stylesheet' />  <!-- Content Wrapper. Contains page content -->
<link href='<?PHP echo constant('URL'); ?>views/public/css/bootstrap-datetimepicker.min.css' rel='stylesheet' />  <!-- Content Wrapper. Contains page content -->

 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                <?PHP echo $this->title ; ?>
                <small><?PHP echo $this->subtitle ; ?></small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="#">Intranet</a></li>
                <li class="active">Listado de Hijos</li>
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
                                <span id="mensaje_confirmacion_data"></span>
                            </div>

                            <table id="hijos_tabla" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Nombres</th>
                                        <th>Apellidos</th>
                                        <th>Opciones</th>
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
                <p>Desea eliminar la placa: <span id="sp_grupo"></span></p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Cancelar</button>
                <button type="button" id="btn_elimina" data-value="" class="btn btn-outline">Eliminar</button>
              </div>
            </div>
          </div>
        </div>
        <!-- End Delete Modal -->


        <!-- Div Ver -->
        <div id="md_nuevo" class="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title"><span id="modal_title_nuevo"></span></h3>
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
                                                    <input type="text" disabled class="form-control" id="txt_dni" name="txt_dni" placeholder="DNI">
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
                                                <div class="col-md-4">
                                                    <label for="sl_nacionalidad_hijo">Nacionalidad</label>
                                                    <select class="form-control" required id="sl_nacionalidad_hijo" name="sl_nacionalidad_hijo"></select>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="txt_celular_alumno">Celular</label>
                                                    <input type="text" class="form-control" id="txt_celular_alumno" name="txt_celular_alumno" placeholder="Celular">
                                                </div>
                                                <div class="col-md-4">
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
                                            <div class="row top-buffer">
                                                <div class="col-md-12">
                                                    <label for="estudia_canto">¿Toca algún instrumento? </label> 
                                                    <textarea class="form-control" id="txt_instrumento" name="txt_instrumento" placeholder="Indique que instrumento(s) toca"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="salud">
                                            <div class="row top-buffer">
                                                <div class="col-md-4">
                                                    <label for="txt_seguro_salud">Seguro de salud</label>
                                                    <input type="text" class="form-control" id="txt_seguro_salud" name="txt_seguro_salud" placeholder="Seguro de salud">
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="txt_seguro_caducidad">Caducidad Seguro</label>
                                                    <input type="text" class="form-control" id="txt_seguro_caducidad" name="txt_seguro_caducidad" >
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="txt_alergias">Alergias</label>
                                                    <input type="text" class="form-control" id="txt_alergias" name="txt_alergias" placeholder="Alergias">
                                                </div>
                                            </div>
                                            <div class="row top-buffer">
                                                <div class="col-md-12">
                                                    <label for="txt_enfermedades">Enfermedades</label>
                                                    <textarea class="form-control" id="txt_enfermedades" name="txt_enfermedades" placeholder="Enfermedades">

                                                    </textarea>
                                                </div>
                                            </div>
                                            <div class="row top-buffer">
                                                <div class="col-md-12" style="margin-top:10px;margin-bottom:10px;">
                                                    <strong>MEDICAMENTOS QUE EL ALUMNO TOMA PARA:</strong>
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
</div>

<!-- Main Footer -->
<?PHP require 'views/footer.php'; ?>
<!-- /.main-footer -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs/dt-1.10.18/b-1.5.4/b-html5-1.5.4/r-2.2.2/datatables.min.css"/>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs/dt-1.10.18/b-1.5.4/b-html5-1.5.4/r-2.2.2/datatables.min.js"></script>
<script src='<?PHP echo constant('URL'); ?>views/public/js/bootstrap-datepicker.min.js'></script>
<script src='<?PHP echo constant('URL'); ?>views/public/js/bootstrap-datepicker.es.min.js'></script>
<script src='<?PHP echo constant('URL'); ?>views/public/js/moment.min.js'></script>
<script src='<?PHP echo constant('URL'); ?>views/public/js/bootstrap-datetimepicker.js'></script>
<script src="https://nightly.datatables.net/select/js/dataTables.select.js?_=9a6592f8d74f8f520ff7b22342fa1183"></script>

<script src='<?PHP echo constant('URL'); ?>views/plugins/excelexportjs.js'></script>
<script>
var hijos = "";

$(document).ready(function(){

    CargaPaises();

    $('#txt_seguro_caducidad').datepicker({
        maxViewMode: 2,
        language: "es"
    });

    $('#txt_seguro_caducidad').on('changeDate', function(ev){
        $(this).datepicker('hide');
    });

    $('#txt_nacimiento').datepicker({
        maxViewMode: 2,
        language: "es"
    });

    $('#txt_nacimiento').on('changeDate', function(ev){
        $(this).datepicker('hide');
    });
    
    var datos = "";
    var info = {};
    info["idapoderado"] = $("#txt_idparticipante").val();
    var datos           = JSON.stringify(info);

    hijos = $('#hijos_tabla').DataTable( {
        "ajax": {
            "type": "POST",
            "url": "<?PHP echo constant('URL'); ?>participante/GetHijosPorApoderado",
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
                "targets": [0],
                "data": "nombres"
            },
            {
                "targets": [1],
                "data":"apellidos"
            },
            {
                "targets": [2],
                "data":"idparticipante",
                "render": function(url, type, full){
                    var idparticipante = full['idparticipante'];
                    return '<button class="edit btn btn-primary" onclick="ver_participante('+ idparticipante +');"><i class="fa fa-pencil"></i> Editar</button>'
                    return false;
                }
            }            
        ],
        "columns":[
            
        ],
        "dom": 'Bfrtip',
        "buttons": [
            {
                text: 'Nuevo',
                action: function ( e, dt, node, config ) {
                    opcion = "nuevo";
                    $('#md_nuevo').modal();
                    $("#modal_title").html("Nuevo Grupo");
                    $("#btn_enviar").text("Guardar");
                    $("#txt_descripcion").val("");
                    $("#txt_descripcion").focus();
                }
            }
        ]
    } );

    $("#frm_alumno").submit(function(event){
        event.preventDefault();
        idalumno                    = $("#btn_enviar").attr('data-value');
        var txt_nombres             = $("#txt_nombres").val();
        var txt_apellidos           = $("#txt_apellidos").val();
        var txt_nacimiento          = $("#txt_nacimiento").val();
        var txt_dni                 = $("#txt_dni").val();
        var txt_direccion           = $("#txt_direccion").val();
        var txt_distrito            = $("#txt_distrito").val();
        var nacionalidad            = $("#sl_nacionalidad_hijo").val();
        var txt_celular_alumno      = $("#txt_celular_alumno").val();
        var txt_correo_alumno       = $("#txt_correo_alumno").val();
        var txt_centro_estudios     = $("#txt_centro_estudios").val();
        var txt_grado_instruccion   = $("#txt_grado_instruccion").val();
        //var estudia_canto           = $("#estudia_canto").val();
        var estudia_canto           = $("input[name=estudia_canto]:checked").val();
        var txt_centro_instruccion  = $("#txt_centro_instruccion").val();
        var txt_seguro_salud        = $("#txt_seguro_salud").val();
        var txt_seguro_caducidad    = $("#txt_seguro_caducidad").val();
        var txt_enfermedades        = $("#txt_enfermedades").val();
        var txt_alergias            = $("#txt_alergias").val();
        var txt_dolor_cabeza        = $("#txt_dolor_cabeza").val();
        var txt_fiebre              = $("#txt_fiebre").val();
        var txt_dolor_estomago      = $("#txt_dolor_estomago").val();
        //var opcion_diario           = $("#opcion_diario").val();
        var opcion_diario           = $("input[name=opcion_diario]:checked").val();
        var txt_medicamento_diario  = $("#txt_medicamento_diario").val();
        var txt_instrumento         = $("#txt_instrumento").val();

        var info = {};
        info["idalumno"]                = idalumno;
        info["txt_nombres"]             = txt_nombres;
        info["txt_apellidos"]           = txt_apellidos;
        info["txt_nacimiento"]          = txt_nacimiento;
        info["txt_dni"]                 = txt_dni;
        info["txt_direccion"]           = txt_direccion;
        info["txt_distrito"]            = txt_distrito;
        info["nacionalidad"]            = nacionalidad;
        info["txt_celular_alumno"]      = txt_celular_alumno;
        info["txt_correo_alumno"]       = txt_correo_alumno;
        info["txt_centro_estudios"]     = txt_centro_estudios;
        info["txt_grado_instruccion"]   = txt_grado_instruccion;
        info["estudia_canto"]           = estudia_canto;
        info["txt_centro_instruccion"]  = txt_centro_instruccion;
        info["txt_seguro_salud"]        = txt_seguro_salud;
        info["txt_seguro_caducidad"]    = txt_seguro_caducidad;
        info["txt_enfermedades"]        = txt_enfermedades;
        info["txt_alergias"]            = txt_alergias;
        info["txt_dolor_cabeza"]        = txt_dolor_cabeza;
        info["txt_fiebre"]              = txt_fiebre;
        info["txt_dolor_estomago"]      = txt_dolor_estomago;
        info["opcion_diario"]           = opcion_diario;
        info["txt_medicamento_diario"]  = txt_medicamento_diario;
        info["txt_instrumento"]         = txt_instrumento;
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
                hijos.ajax.reload();	
                $("#mensaje_confirmacion_data").html("Se ha actualizado la información del alumno.");
                $("#confirm_data").show().delay(2000).fadeOut();
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
});

function ver_participante(id){
    $("#tab_estudios").removeClass("active");
    $("#tab_salud").removeClass("active");
    $("#tab_datos_generales").addClass("active");

    $("#estudios").removeClass("active");
    $("#salud").removeClass("active");
    $("#datos_generales").addClass("active");
    
    $("#btn_enviar").attr("data-value", id);
    $('#md_nuevo').modal();
    $("#txt_idparticipante").val(id);
    $("#modal_title_nuevo").html("Actualizar Datos");
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
            var fecha_nacimiento = moment(datos.fecha_nacimiento, 'YYYY-MM-DD')
            //console.log(datos.fecha_nacimiento);
            $("#txt_nacimiento").val(fecha_nacimiento.format('DD/MM/YYYY'));
            $("#txt_dni").val(datos.dni);
            $("#txt_distrito").val(datos.distrito);
            $("#sl_nacionalidad_hijo").val(datos.nacionalidad);
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
            $("#txt_instrumento").val(datos.instrumento);
            $("#txt_seguro_salud").val(datos.seguro_salud);
            var seguro_caducidad = moment(datos.seguro_caducidad, 'YYYY-MM-DD')
            $("#txt_seguro_caducidad").val(seguro_caducidad.format('DD/MM/YYYY'));
            $("#txt_enfermedades").val(datos.enfermedades);
            $("#txt_alergias").val(datos.alergias);
            $("#txt_dolor_cabeza").val(datos.dolor_cabeza);
            $("#txt_fiebre").val(datos.fiebre);
            $("#txt_dolor_estomago").val(datos.dolor_estomago);
            if(datos.toma_medicamento_diario == "S"){
                $('input:radio[name=opcion_diario]:nth(0)').attr('checked',true);
            }
            if(datos.toma_medicamento_diario == "N"){
                $('input:radio[name=opcion_diario]:nth(1)').attr('checked',true);
            }
            $("#txt_medicamento_diario").val(datos.medicamento_diario);
        },
        error:function(result){
            console.log(result);
        }
    });
}

function CargaPaises()
{
    $("#sl_nacionalidad_hijo").append('<option value="">Seleccione una opción</option>');
    
    $.ajax({
        type: "GET",
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        url: "<?PHP echo constant('URL'); ?>paises.json", 
        success: function(result){
            $.each(result, function(i,v){
                $("#sl_nacionalidad_hijo").append('<option value="'+v+'">'+ v +'</option>');
            });
        }
    });
}

</script>