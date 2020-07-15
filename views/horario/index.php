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
                                <span id="mensaje_confirmacion_data"></span>
                            </div>

                            <table id="horario_tabla" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Grupo</th>
                                        <th>Horario</th>
                                        <th>Tipo</th>
                                        <th>Opciones</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div id="md_nuevo" class="modal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-md" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><span id="modal_title"></span></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="frm_horario" method="POST">
                            <div class="form-row">
                                <div class="col-4">
                                    <label for="sl_grupo">Grupo</label>
                                    <select id="sl_grupo" class="form-control" required></select>
                                </div>
                            </div>
                            <div class="form-row" style="margin-top:20px;">
                                <div class="col-4">
                                    <label for="txt_descripcion">Descripción</label>
                                    <input required type="text" class="form-control" id="txt_descripcion" name="txt_descripcion" placeholder="Descripción">
                                </div>
                            </div>
                            <div class="form-row" style="margin-top:20px;">
                                <div class="col-4">
                                    <label for="sl_tipo">Tipo</label>
                                    <select id="sl_tipo" class="form-control" required>
                                        <option value="">SELECCIONE UN TIPO</option>
                                        <option value="clase_regular">CLASE REGULAR</option>
                                        <option value="ensayo">ENSAYOS</option>
                                        <option value="ensayo_general">ENSAYOS GENERALES</option>
                                        <option value="otros">OTROS</option>
                                    </select>
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

            <div id="md_asignar" class="modal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-md" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><span id="modal_title_asignar"></span></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="frm_asignar" method="POST">
                            <div class="form-row">
                                <div class="col-4">
                                    <label>Rango de Fechas</label>
                                    <div class="input-daterange input-group" id="datepicker">
                                        <input type="text" class="input-sm form-control" name="start" id="start" />
                                        <span class="input-group-addon">hasta</span>
                                        <input type="text" class="input-sm form-control" name="end" id="end" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-row" style="margin-top:20px;">
                                <div class="col-4">
                                    <label>Días</label>
                                    <div id="dias_checks">
                                        <label><input type="checkbox" name="" id="" value="1" class="grupo_dia" /> Lunes</label>
                                        <label class="left_space" ><input type="checkbox" value="2" name="" id="" class="grupo_dia" /> Martes</label>
                                        <label class="left_space" ><input type="checkbox" value="3" name="" id="" class="grupo_dia" /> Miércoles</label>
                                        <label class="left_space" ><input type="checkbox" value="4" name="" id="" class="grupo_dia" /> Jueves</label>
                                        <label class="left_space" ><input type="checkbox" value="5" name="" id="" class="grupo_dia" /> Viernes</label>
                                        <label class="left_space" ><input type="checkbox" value="6" name="" id="" class="grupo_dia" /> Sábado</label>
                                        <label class="left_space" ><input type="checkbox" value="0" name="" id="" class="grupo_dia" /> Domingo</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row" style="margin-top:20px;">
                                <div class="col-4">
                                    <label>Hora Inicio</label>
                                    <div class='input-group date' id='controlhora1'>
                                        <input type='text' class="form-control" id="txt_hora_inicio" />
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row" style="margin-top:20px;">
                                <div class="col-4">
                                    <label>Hora Fin</label>
                                    <div class='input-group date' id='controlhora2'>
                                        <input type='text' class="form-control" id="txt_hora_final" />
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row" style="margin-top:20px;">
                                <table id="horario_detalle_tabla" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Dia</th>
                                            <th>Hora Inicio</th>
                                            <th>Hora Final</th>
                                            <th>Opciones</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" id="btn_registrar" data-value="" name="btn_registrar" class="btn btn-primary">Registrar</button>
                    </div>
                    </form>
                    </div>
                </div>
            </div>



        </section>
</div>

<!-- Main Footer -->
<?PHP require 'views/footer.php'; ?>
<!-- /.main-footer -->

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs/dt-1.10.18/b-1.5.4/b-html5-1.5.4/r-2.2.2/datatables.min.css"/>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs/dt-1.10.18/b-1.5.4/b-html5-1.5.4/r-2.2.2/datatables.min.js"></script>

<script src='<?PHP echo constant('URL'); ?>views/public/js/bootstrap-datepicker.min.js'></script>
<script src='<?PHP echo constant('URL'); ?>views/public/js/bootstrap-datepicker.es.min.js'></script>
<script src='<?PHP echo constant('URL'); ?>views/public/js/moment.min.js'></script>
<script src='<?PHP echo constant('URL'); ?>views/public/js/bootstrap-datetimepicker.js'></script>

<script>
    var horarios        = "";
    var horario_detalle = "";

    function getDates(startDate, stopDate) {
        var dateArray = [];
        var currentDate = moment(startDate, 'DD-MM-YYYY')
        var stopDate = moment(stopDate, 'DD-MM-YYYY')
        
        while (currentDate <= stopDate) {
            //dateArray.push( moment(currentDate).format('YYYY-MM-DD') )
            var date_info = {
                "nombre_dia": moment(currentDate).day(),
                "fecha": moment(currentDate).format('YYYY-MM-DD')
            }
            dateArray.push(date_info);
            currentDate = moment(currentDate).add(1, 'days');
        }
        return dateArray;
    }
    
    $(document).ready(function() {
        var idgrupo = "";
        var opcion = "";
        cargaGrupos();

        $('.input-daterange').datepicker({
            language: "es",
            keyboardNavigation: false,
            forceParse: false,
            autoclose: true,
            todayHighlight: true
        });

        $('#controlhora1').datetimepicker({
            format: 'LT',
            locale: 'es'
        });

        $('#controlhora2').datetimepicker({
            format: 'LT',
            locale: 'es'
        });

        $('#fecha_inicial').datepicker({
            maxViewMode: 2,
            language: "es"
        });

        
        horarios = $('#horario_tabla').DataTable( {
		    "ajax": "<?PHP echo constant('URL'); ?>horario/GetHorarios",
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
                    "data":"grupo"
			    },
                {
			        "targets": [1],
                    "data":"descripcion"
                },
                {
			        "targets": [2],
                    "data":"tipo"
			    },
                {
                    "targets": [3],
                    "data":"idhorario",
                    "render": function(url, type, full){
                        var idhorario = full[0];
                        return '<button type="button" onclick="asignar_grupo('+ idhorario +');" class="btn btn-warning"><i class="fa fa-plus-square"></i> Registrar Horas</button> <button onclick="alert_elimina('+ idhorario +');" title="Eliminar horario" class="btn btn-danger"><i class="fa fa-trash"></i></button>'
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
                        $("#modal_title").html("Nuevo Horario");
                        $("#btn_enviar").text("Guardar");
                        $("#txt_descripcion").val("");
                        $("#txt_descripcion").focus();
					}
                }
			]
		} );

        $("#frm_horario").submit(function(event){
            event.preventDefault();
            var idgrupo     = $("#sl_grupo").val();
            var descripcion = $("#txt_descripcion").val();
            var tipo        = $("#sl_tipo").val();
            var info = {};
            info["idgrupo"]     = idgrupo;
            info["descripcion"] = descripcion;
            info["tipo"]        = tipo;
            var myJsonString = JSON.stringify(info);

            $.ajax({
                type: "POST",
                url: "<?PHP echo constant('URL'); ?>horario/InsertaHorario", 
                data:{
                    datos: myJsonString
                },
                success: function(result){
                    console.log(result);
                    $('#md_nuevo').modal('hide');
                    horarios.ajax.reload();	
                    $("#mensaje_confirmacion").html("Se ha registrado el nuevo grupo.");
                    $("#confirm_grupo").show().delay(2000).fadeOut();
                },
                error:function(result){
                    console.log(result);
                }
            });
        });

        $("#frm_asignar").submit(function(event){
            event.preventDefault();
            var start = $("#start").val();
            var end = $("#end").val()
            var dates = [];
            var fechas_finales = [];
            dates = getDates(start, end);
            
            var arr_dias_seleccionados = [];
            var i = 0;
            $('.grupo_dia:checked').each(function () {
                arr_dias_seleccionados[i++] = $(this).val();
            });    
            
            for(var x=0;x<dates.length;x++){
                for(var y=0;y<arr_dias_seleccionados.length;y++){
                    if(dates[x].nombre_dia == arr_dias_seleccionados[y]){
                        fechas_finales.push(dates[x].fecha);
                    }
                }
            }

            console.log(fechas_finales);

            var idhorario       = $("#btn_registrar").attr("data-value");
            //var dia             = $("#txt_fecha").val();
            //var date            = moment(dia, 'DD-MM-YYYY')
            //var fecha           = date.format('YYYY-MM-DD');

            var hora_inicio     = $("#txt_hora_inicio").val();
            var hora_final      = $("#txt_hora_final").val();

            for(var x=0;x<fechas_finales.length;x++){
                var date            = moment(fechas_finales[x])
                var fecha           = date.format('YYYY-MM-DD');
                var info            = {};
                info["idhorario"]   = idhorario;
                info["dia"]         = fecha;
                info["hora_inicio"] = moment(hora_inicio, 'hh:mm A').format('HH:mm');
                info["hora_final"]  = moment(hora_final, 'hh:mm A').format('HH:mm');
                var myJsonString    = JSON.stringify(info);
                $.ajax({
                    type: "POST",
                    url: "<?PHP echo constant('URL'); ?>horario/AsignarHorario", 
                    data:{
                        datos: myJsonString
                    },
                    success: function(result){
                        console.log(result);
                        $('#sl_dia').val('');
                        $('#sl_horainicio').val('');
                        $('#sl_horafinal').val('');
                        horario_detalle.ajax.reload();
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
                url: "<?PHP echo constant('URL'); ?>horario/EliminaHorario", 
                data:{
                    datos: '{"idhorario": "' + id + '"}'
                },
                success: function(result){
                    console.log(result);
                    $('#modal-delete').modal('hide');
                    horarios.ajax.reload();	
                    $("#mensaje_confirmacion").html(result);
                    $("#confirm_data").show().delay(2000).fadeOut();
                },
                error:function(result){
                    console.log(result);
                }
            });
        });

        
    });

    function cargaGrupos()
    {
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

    function alert_elimina(idhorario)
    {
        $('#modal-delete').modal();
        $("#mensaje_elimina").html("Desea eliminar el horario: " + idhorario + "?");
        $("#btn_elimina").attr("data-value", idhorario);
    }

    function asignar_grupo(id)
    {
        $("#md_asignar").modal();
        $("#btn_registrar").attr("data-value", id);
        $("#modal_title_asignar").html("Registrar fecha");
        cargar_detalles(id);
    }

    function cargar_detalles(id)
    {
        var info = {};
        info["idhorario"]   = id;
        var myJsonString    = JSON.stringify(info);

        horario_detalle = $('#horario_detalle_tabla').DataTable( {
		    "ajax": {
                "type": "POST",
                "url": "<?PHP echo constant('URL'); ?>horario/GetHorarioDetalle",
                "data": {
                    "datos": myJsonString
                }
            },
			"responsive":true,
            "bSort" : false,
            "bDestroy": true,
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
                    "data":"dia"
			    },
                {
			        "targets": [1],
                    "data":"hora_inicio"
			    },
                {
			        "targets": [2],
                    "data":"hora_fin"
			    },
                {
                    "targets": [3],
                    "data":"idhorario_detalle",
                    "render": function(url, type, full){
                        var idhorario_detalle = full[0];
                        return '<button type="button" title="Eliminar detalle" onclick="eliminar_detalle('+ idhorario_detalle +');" class="btn btn-danger"><i class="fa fa-trash"></i></button> '
                        return false;
                    }
                }        
			]
			
		} );
    }

    function eliminar_detalle(id)
    {
        var info            = {};
        info["id"]          = id;
        var myJsonString    = JSON.stringify(info);
        $.ajax({
            type: "POST",
            url: "<?PHP echo constant('URL'); ?>horario/EliminarDetalle", 
            data:{
                datos: myJsonString
            },
            success: function(result){
                console.log(result);
                //$('#md_asignar').modal('hide');
                horario_detalle.ajax.reload();
            },
            error:function(result){
                console.log(result);
            }
        });
    }

</script>