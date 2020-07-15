<?PHP require 'views/header.php'; ?>
<link href='<?PHP echo constant('URL'); ?>views/public/css/bootstrap-datepicker.min.css' rel='stylesheet' />  <!-- Content Wrapper. Contains page content -->
<link href='<?PHP echo constant('URL'); ?>views/public/css/bootstrap-datetimepicker.min.css' rel='stylesheet' />  <!-- Content Wrapper. Contains page content -->
<style>
     .selected{
         background-color:#acbad4 !important;
     }
 </style>
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
                <li class="active">Listado de Registros</li>
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

                            <table id="eventos_tabla" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Título</th>
                                        <th>Fecha</th>
                                        <th>Hora</th>
                                        <th>Alumnos Inscritos</th>
                                        <th>Alumnos Registrados</th>
                                        <th>Opciones</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Div Asignar Alumnos -->
        <div id="md_asignaralumnos" class="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title"><span id="modal_title_fotos">Registro de Eventos</span></h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body extrab">
                        <input type="hidden" id="txt_id">
                        <table id="alumnos_table" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Nombres</th>
                                    <th>Apellidos</th>
                                    <th>Grupo</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Div -->

        <!-- Div Alumnos Autorizados -->
        <div id="md_alumnosautorizados" class="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title"><span id="modal_title_fotos">Lista de Alumnos Registrados</span></h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body extrab">
                        <input type="hidden" id="txt_id">
                        <table id="autorizados_table" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Apellidos</th>
                                    <th>Nombres</th>
                                    <th>Correo</th>
                                    <th>Celular</th>
                                    <th>Estado</th>
                                    <th>Motivo</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
            <div id="dvjson"></div>
        </div>
        <!-- End Div Alumnos Autorizados -->

        <!-- Nuevo Modal -->
        <div id="md_nuevo" class="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title"><span id="modal_title"></span></h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="frm_evento" data-value="" method="POST">
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label for="txt_titulo">Título</label>
                                <input required type="text" class="form-control" id="txt_titulo" name="txt_titulo" placeholder="Título">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label for="txt_descripcion">Descripción</label>
                                <textarea required rows="5" class="form-control" id="txt_descripcion" name="txt_descripcion" placeholder="Descripción"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label for="txt_fecha">Fecha</label>
                                <input required type="text" class="form-control" id="txt_fecha" name="txt_fecha" placeholder="Fecha">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label for="txt_hora">Hora</label>
                                <!--input required type="text" class="form-control" id="txt_hora" name="txt_hora" placeholder="Hora"-->
                                <div class='input-group date' id='controlhora'>
                                    <input type='text' class="form-control" id="txt_hora" />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
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
        <!-- Fin Nuevo Modal --> 

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
                <p id="mensaje_elimina"></p>
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
var alumnos = "";
var eventos = "";

$(document).ready(function(){
    var selected = [];

    $('#controlhora').datetimepicker({
        format: 'LT',
        locale: 'es'
    });
    
    $('#txt_fecha').datepicker({
        maxViewMode: 2,
        language: "es"
    });

    $('#txt_fecha').on('changeDate', function(ev){
        $(this).datepicker('hide');
    });

    eventos = $('#eventos_tabla').DataTable( {
        "ajax": "<?PHP echo constant('URL'); ?>evento/ListaEventos",
        "responsive":true,
        "scrollX":        false,
        "scrollCollapse": true,
        "ordering": false,
        "bDestroy": false,
        "fixedColumns":   {
            "leftColumns": 2
        },
        "language":{
            "url":"https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        },
        "columns":[
            {"data":"titulo"},
            {"data":"fecha_evento"},
            {"data":"hora_evento"},
        ],
        "columnDefs":[
            {
                "targets":3,
                "data":"cantidad",
                "render":function(url, type, full){
                    var cantidad = full["cantidad"];
                    if(cantidad == 0){
                        return '<a href="#" onclick="asignar('+ full.idevento +');">'+ cantidad +' (ASIGNAR ALUMNOS)</a>';
                    }else{
                        //return cantidad;
                        return '<a href="#" onclick="asignar('+ full.idevento +');">'+ cantidad +' (ASIGNAR ALUMNOS)</a>';
                    }
                }
            },
            {
                "targets":4,
                "data":"autorizados",
                "render":function(url, type, full){
                    var autorizados = full["autorizados"];
                    return '<a href="#" onclick="ver_autorizados('+ full.idevento +');">'+ autorizados +' (VER LISTA)</a>';
                }
            },
            {
                "targets":5,
                "data":"descripcion",
                "render": function(url, type, full){
                    var id = "'" + full[0] + "'";
                    return '<button onclick="alert_elimina('+ id +');" title="Eliminar evento" class="btn btn-danger"><i class="fa fa-trash"></i></button>';
                    return false;
                },
                "width":"15%"
            }
        ],
        "dom": 'Bfrtip',
        "buttons": [
            {
                text: 'Nuevo',
                action: function ( e, dt, node, config ) {
                    opcion = "nuevo";
                    $('#md_nuevo').modal();
                    $('#frm_evento').attr("data-value", "nuevo");
                    $("#modal_title").html("Nuevo Evento");
                    $("#btn_enviar").text("Guardar");
                    $("#txt_titulo").val("");
                    $("#txt_titulo").focus();
                    $("#txt_descripcion").val("");
                    $("#txt_fecha").val("");
                    $("#txt_hora").val("");
                }
            }
        ]
    } );

    $("#frm_evento").submit(function(event){
        event.preventDefault();
        
        var hora            = moment($('#txt_hora').val(), 'hh:mm A').format('HH:mm');
        var titulo          = $("#txt_titulo").val();
        var descripcion     = $("#txt_descripcion").val();
        var fecha           = $("#txt_fecha").val();
        var date            = moment(fecha, 'DD-MM-YYYY')
        fecha               = date.format('YYYY-MM-DD');
        var info = {};
        
        info["titulo"]      = titulo.toUpperCase();
        info["descripcion"] = descripcion.toUpperCase();
        info["fecha"]       = fecha;
        info["hora"]        = hora;
        var myJsonString    = JSON.stringify(info);
        var opcion          = $("#frm_evento").attr("data-value");
        
        if(opcion == "nuevo"){
            $.ajax({
                type: "POST",
                url: "<?PHP echo constant('URL'); ?>evento/RegistrarEvento", 
                data:{
                    datos: myJsonString
                },
                success: function(result){
                    console.log(result);
                    $('#md_nuevo').modal('hide');
                    eventos.ajax.reload();	
                    $("#mensaje_confirmacion").html("Se ha registrado el nuevo evento.");
                    $("#confirm_data").show().delay(2000).fadeOut();
                },
                error:function(result){
                    console.log(result);
                }
            });
        }
        
    });

    $("#btn_elimina").click(function(){
        var id = $("#btn_elimina").attr("data-value");
        $.ajax({
            type: "POST",
            url: "<?PHP echo constant('URL'); ?>evento/EliminaEvento", 
            data:{
                datos: '{"idevento": "' + id + '"}'
            },
            success: function(result){
                console.log(result);
                $('#modal-delete').modal('hide');
                eventos.ajax.reload();	
                $("#mensaje_confirmacion").html(result);
                $("#confirm_data").show().delay(2000).fadeOut();
            },
            error:function(result){
                console.log(result);
            }
        });
    });


    alumnos = $('#alumnos_table').DataTable( {
        "dom": "Blfrtip",
        "ajax": "<?PHP echo constant('URL'); ?>alumno/getAlumnos",
        "rowId": "0",
        "select": {
            style: 'multi'
        },
        "responsive":true,
        "ordering": true,
        "bDestroy": true,
        "scrollX": false,
        "pageLength": 5,
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
                "data": "idparticipante"
            },   
            {
                "targets": 1,
                "data": "nombres"
            },            
            {
                "targets": 2,
                "data": "apellidos",
            },            
            {
                "targets": 3,
                "data": "grupo"
            }        
        ],
        "dom": 'Bfrtip',
        "buttons": [
            {
                "text": "Seleccionar todos",
                action: function ( e, dt, node, config ) {
                    alumnos.rows({ search: 'applied' }).select();
                }
            },
            {
                "text": "Deseleccionar todos",
                action: function ( e, dt, node, config ) {
                    alumnos.rows({ search: 'applied' }).deselect();
                }
            },
            {
                "text": "Asignar Alumnos",
                action: function ( e, dt, node, config ) {
                    selected = [];
                    var filas = alumnos.rows( { selected: true } ).data();
                    if(filas.count() > 0){
                        for(var x = 0;x<filas.count();x++){
                            selected.push(filas[x].idparticipante);
                        }
                        var datos = {};
                        datos['idevento'] = $("#txt_id").val();
                        datos['alumnos'] = selected;
                        console.log(datos);

                        $.ajax({
                            type: "POST",
                            url: "<?PHP echo constant('URL'); ?>evento/AsignarEvento",
                            data: {
                                datos: datos
                            },
                            success:function(result){
                                console.log(result);
                                eventos.ajax.reload();
                            },
                            error: function(result){
                                console.log(result);
                            }
                        });

                        $("#md_asignaralumnos").modal("hide");
                        
                    }else{
                        alert("Seleccione por lo menos un alumno");
                    }
                }
            }
        ]
    } );

    alumnos
        .order( [ 2, 'asc' ] )
        .draw();

});

function ver_autorizados(id)
{
    var info            = {};
    info["idevento"]    = id;
    var datos           = JSON.stringify(info);
    
    $("#md_alumnosautorizados").modal();
    var alumnos_autorizados = $('#autorizados_table').DataTable( {
        "dom": "Blfrtip",
        "ajax": {
            "type": "POST",
            "url": "<?PHP echo constant('URL'); ?>alumno/getAlumnosAutorizados",
            "data": {
                "datos": datos
            }
        },
        "rowId": "0",
        "responsive":true,
        "ordering": true,
        "bDestroy": true,
        "scrollX": false,
        "pageLength": 5,
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
                "data": "idparticipante"
            },   
            {
                "targets": 1,
                "data": "apellidos"
            },            
            {
                "targets": 2,
                "data": "nombres",
            },            
            {
                "targets": 3,
                "data": "correo_postulante"
            },            
            {
                "targets": 4,
                "data": "celular_postulante"
            },
            {
                "targets": 5,
                "data": "autorizacion"
            },
            {
                "targets": 6,
                "data": "motivo"
            }
        ],
        "dom": 'Bfrtip',
        "buttons": [
            {
                "extend": "pdfHtml5",
                "orientation": "landscape",
                "pageSize": "LEGAL"
            },
            {
                text: 'Exportar',
                action: function ( e, dt, node, config ) {
                    $.ajax({
                        type:'POST',
                        url: "<?PHP echo constant('URL'); ?>alumno/getAlumnosNOAutorizados",
                        data: {
                            "datos": datos
                        },
                        success:function(result){
                            var info = JSON.parse(result);
                            $("#dvjson").excelexportjs({
                                containerid: "dvjson", 
                                datatype: 'json', 
                                dataset: info, 
                                columns: getColumns(info)     
                            });
                        },
                        error:function(){
                            alert("error");
                        }
                    });
                }
            }
        ]
    } );
}

function alert_elimina(id)
{
    $('#modal-delete').modal();
    $("#mensaje_elimina").html("Desea eliminar el evento: " + id + "?");
    $("#btn_elimina").attr("data-value", id);
}

function asignar(id){
    alumnos.page( 'first' ).draw( 'page' );
    alumnos.rows().deselect();
    $("#md_asignaralumnos").modal();
    asignar_alumnos(id);
    $("#txt_id").val(id);
}

function asignar_alumnos(id)
{
    var info            = {};
    info["idevento"]    = id;
    var datos           = JSON.stringify(info);
    $.ajax({
        type: "POST",
        url: "<?PHP echo constant('URL'); ?>alumno/getAlumnosEvento", 
        datatype: "json",
        data:{
            datos: datos
        },
        success: function(result){
            var datos = JSON.parse(result);
            for(var x=0;x<datos.data.length;x++){
                var idalumno = datos.data[x].idalumno;
                alumnos.rows().every( function ( rowIdx, tableLoop, rowLoop ) {
                    var data = this.data();
                    if(data.idparticipante == idalumno){
                        alumnos.row(this).select();
                    }
                } ); 
            }
        },
        error: function(result){
            console.log(result);
        }
    });
    
}
</script>