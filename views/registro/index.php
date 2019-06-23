<?PHP require 'views/header.php'; ?>
<link href='<?PHP echo constant('URL'); ?>views/public/css/bootstrap-datepicker.min.css' rel='stylesheet' />

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
                
                <div class="col-md-6">
                    <div class="box box-info">
                        <div class="box-header">
                            <h3 class="box-title">Registro de Madre de Familia <small>Registro de datos</small></h3>
                            <div class="pull-right box-tools">
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div id="confirm_madre" class="alert alert-success alert-dismissible" style="display:none;">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <h4><i class="icon fa fa-check"></i> Confirmación</h4>
                                <span id="mensaje_confirmacion_madre"></span>
                            </div>

                            <form action="" method="POST" id="frm_madre">
                                <input type="hidden" id="txt_id_madre">
                                <div class="col-md-6 form-group" id="grupo_madre">
                                    <label for="txt_dni_madre">DNI</label> <small id="mensaje_madre" style="display:none;">El DNI ya fue registrado</small>
                                    <input type="text" maxlength="8" class="form-control" required id="txt_dni_madre" name="txt_dni_madre" placeholder="DNI">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="txt_correo_madre">Correo</label>
                                    <input type="email" class="form-control" required id="txt_correo_madre" name="txt_correo_madre" placeholder="Correo">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="txt_nombres_madre">Nombres</label>
                                    <input type="text" class="form-control" required id="txt_nombres_madre" name="txt_nombres_madre" placeholder="Nombres">
                                </div>
                                
                                <div class="col-md-6 form-group">
                                    <label for="txt_apellidos_madre">Apellidos</label>
                                    <input type="text" class="form-control" required id="txt_apellidos_madre" name="txt_apellidos_madre" placeholder="Apellidos">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="txt_celular_madre">Celular</label>
                                    <input type="text" class="form-control" required id="txt_celular_madre" name="txt_celular_madre" placeholder="Celular">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="txt_fijo_madre">Telefono Fijo</label>
                                    <input type="text" class="form-control" required id="txt_fijo_madre" name="txt_fijo_madre" placeholder="Telefono Fijo">
                                </div>
                                <div class="col-md-12 form-group">
                                    <label for="txt_direccion_madre">Direccion</label>
                                    <input type="text" class="form-control" required id="txt_direccion_madre" name="txt_direccion_madre" placeholder="Direccion">
                                </div>
                                <div class="col-md-12 form-group">
                                    <label id="lbl_chkpagos">
                                        <input id="chk_pagos_madre" checked type="checkbox"> Encargado de pagos
                                    </label>
                                </div>
                                <div class="pull-right">
                                    <button id="btn_guardar_madre" class="btn btn-primary">Guardar</button>
                                </div>
                        
                                <div id="confirm_data" class="alert alert-success alert-dismissible" style="display:none;">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    <h4><i class="icon fa fa-check"></i> Confirmación</h4>
                                    <span id="mensaje_confirmacion_data"></span>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="box box-success">
                        <div class="box-header">
                            <h3 class="box-title">Registro de Padre de Familia <small>Registro de datos</small></h3>
                            <div class="pull-right box-tools">
                                
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div id="confirm_padre" class="alert alert-success alert-dismissible" style="display:none;">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <h4><i class="icon fa fa-check"></i> Confirmación</h4>
                                <span id="mensaje_confirmacion_padre"></span>
                            </div>

                            <form action="" method="POST" id="frm_padre">
                                <input type="hidden" id="txt_id_padre">
                                <div class="col-md-6 form-group" id="grupo_padre">
                                    <label for="txt_dni_padre">DNI</label> <small id="mensaje_padre" style="display:none;">El DNI ya fue registrado</small>
                                    <input type="text" maxlength="8" class="form-control" required id="txt_dni_padre" name="txt_dni_padre" placeholder="DNI">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="txt_correo_padre">Correo</label>
                                    <input type="email" class="form-control" required id="txt_correo_padre" name="txt_correo_padre" placeholder="Correo">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="txt_nombres_padre">Nombres</label>
                                    <input type="text" class="form-control" required id="txt_nombres_padre" name="txt_nombres_padre" placeholder="Nombres">
                                </div>
                                
                                <div class="col-md-6 form-group">
                                    <label for="txt_apellidos_padre">Apellidos</label>
                                    <input type="text" class="form-control" required id="txt_apellidos_padre" name="txt_apellidos_padre" placeholder="Apellidos">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="txt_celular_padre">Celular</label>
                                    <input type="text" class="form-control" required id="txt_celular_padre" name="txt_celular_padre" placeholder="Celular">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="txt_fijo_padre">Telefono Fijo</label>
                                    <input type="text" class="form-control" required id="txt_fijo_padre" name="txt_fijo_padre" placeholder="Telefono Fijo">
                                </div>
                                <div class="col-md-12 form-group">
                                    <label for="txt_direccion_padre">Direccion</label>
                                    <input type="text" class="form-control" required id="txt_direccion_padre" name="txt_direccion_padre" placeholder="Direccion">
                                </div>
                                <div class="col-md-12 form-group">
                                    <label id="lbl_chkpagos">
                                        <input id="chk_pagos_padre" type="checkbox"> Encargado de pagos
                                    </label>
                                </div>
                                <div class="pull-right">
                                    <button id="btn_guardar_padre" class="btn btn-primary">Guardar</button>
                                </div>
                        
                                <div id="confirm_data" class="alert alert-success alert-dismissible" style="display:none;">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    <h4><i class="icon fa fa-check"></i> Confirmación</h4>
                                    <span id="mensaje_confirmacion_data"></span>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="box box-success">
                        <div class="box-header">
                            <h3 class="box-title">Registro de Hijos <small>Registro de datos</small></h3>
                            <div class="pull-right box-tools">
                                
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
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
            <button type="button" class="btn btn-primary" id="btn_guardar_todo">Registrar Datos</button>
        </section>

        <!-- Div Ver -->
        <div id="md_confirmar" class="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">Confirmación</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h3>Gracias por registrar la información.</h3>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Fin Div Ver -->

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
                                        <li id="tab_datos_generales" class="active"><a href="#datos_generales" data-toggle="tab">Datos Generales del Alumno</a></li>
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
                                                    <input type="text" required class="form-control" id="txt_nacimiento" name="txt_nacimiento" placeholder="Nacimiento">
                                                </div>
                                            </div>
                                            <div class="row top-buffer">
                                                <div class="col-md-4 form-group" id="grupo_alumno">
                                                    <label for="txt_dni">DNI</label> <small id="mensaje_alumno" style="display: none; color: rgb(221, 75, 57);">El DNI ya fue registrado</small>
                                                    <input type="text" required maxlength="8" class="form-control" id="txt_dni" name="txt_dni" placeholder="DNI">
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="txt_direccion">Direccion</label>
                                                    <input type="text" required class="form-control" id="txt_direccion" name="txt_direccion" placeholder="Direccion">
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="txt_distrito">Distrito</label>
                            						<select required class="form-control" id="txt_distrito" name="txt_distrito"></select>
                                                </div>
                                            </div>
                                            <div class="row top-buffer">
                                                <div class="col-md-6">
                                                    <label for="txt_celular_alumno">Celular</label>
                                                    <input type="text" class="form-control" id="txt_celular_alumno" name="txt_celular_alumno" placeholder="Celular">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="txt_correo_alumno">Correo</label>
                                                    <input type="email" required class="form-control" id="txt_correo_alumno" name="txt_correo_alumno" placeholder="Correo">
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
                                                    <label for="estudia_canto">¿Estudia música en otra institución/de manera particular? </label> 
                                                    <label>
                                                        <input type="radio" name="estudia_canto" id="estudia_canto" value="S" >
                                                        Sí
                                                    </label>
                                                    <label>
                                                        <input type="radio" name="estudia_canto" id="estudia_canto" value="N" >
                                                        No
                                                    </label>
                                                    <textarea class="form-control" id="txt_centro_instruccion" name="txt_grado_instruccion" placeholder="¿Donde?"></textarea>
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
                                                    <input type="text" class="form-control" id="txt_seguro_caducidad" name="txt_seguro_caducidad" placeholder="Caducidad Seguro" >
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="txt_alergias">Alergias</label>
                                                    <input type="text" class="form-control" id="txt_alergias" name="txt_alergias" placeholder="Alergias">
                                                </div>
                                            </div>
                                            <div class="row top-buffer">
                                                <div class="col-md-12">
                                                    <label for="txt_enfermedades">Antecedentes Clínicos Importantes</label>
                                                    <textarea class="form-control" id="txt_enfermedades" name="txt_enfermedades" placeholder="Enfermedades"></textarea>
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

<script>
    var existe_padre        = "NO";
    var existe_alumno      = "NO";
    
    var hijos               = [];
    var datos_madre         = [];
    var datos_padre         = [];
    var participantes       = [];
    var hijos_datatable     = "";
    var datos_apoderados    = [];

    var registrados         = {};
    registrados["madre"]    = {};
    registrados["padre"]    = {};
    registrados["hijos"]    = {};
        
    $(document).ready(function(){
        VerHijos();

        $('#txt_nacimiento').datepicker({
			maxViewMode: 2,
			language: "es"
		});

        $('#txt_nacimiento').on('changeDate', function(ev){
			$(this).datepicker('hide');
		});

        $('#txt_seguro_caducidad').datepicker({
			maxViewMode: 2,
			language: "es"
		});

        $('#txt_seguro_caducidad').on('changeDate', function(ev){
			$(this).datepicker('hide');
		});
        

        $("#chk_pagos_padre").click(function(){
            if($("#chk_pagos_padre").prop("checked")){
                $("#chk_pagos_madre").prop("checked", false);
            }
        });

        $("#chk_pagos_madre").click(function(){
            if($("#chk_pagos_madre").prop("checked")){
                $("#chk_pagos_padre").prop("checked", false);
            }
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

        $("#frm_alumno").submit(function(e){
            e.preventDefault();
            if(existe_alumno == "SI"){
                alert("El DNI ya ha sido ingresado anteriormente");
            }else{
                var info = {};
                info["txt_nombres"] = $("#txt_nombres").val();
                info["txt_apellidos"] = $("#txt_apellidos").val();
                info["txt_nacimiento"] = $("#txt_nacimiento").val();
                info["txt_dni"] = $("#txt_dni").val();
                info["txt_direccion"] = $("#txt_direccion").val();
                info["txt_distrito"] = $("#txt_distrito").val();
                info["txt_celular_alumno"] = $("#txt_celular_alumno").val();
                info["txt_correo_alumno"] = $("#txt_correo_alumno").val();

                info["txt_centro_estudios"] = $("#txt_centro_estudios").val();
                info["txt_grado_instruccion"] = $("#txt_grado_instruccion").val();
                info["estudia_canto"] = $("#estudia_canto").val();
                info["txt_centro_instruccion"] = $("#txt_centro_instruccion").val();

                info["txt_seguro_salud"] = $("#txt_seguro_salud").val();
                info["txt_seguro_caducidad"] = $("#txt_seguro_caducidad").val();
                info["txt_alergias"] = $("#txt_alergias").val();
                info["txt_enfermedades"] = $("#txt_enfermedades").val();
                info["txt_dolor_cabeza"] = $("#txt_dolor_cabeza").val();
                info["txt_fiebre"] = $("#txt_fiebre").val();
                info["txt_dolor_estomago"] = $("#txt_dolor_estomago").val();
                info["opcion_diario"] = $("#opcion_diario").val();
                info["txt_medicamento_diario"] = $("#txt_medicamento_diario").val();

                hijos.push(info);
                hijos_datatable.row.add([
                    info["txt_nombres"],
                    info["txt_apellidos"],
                    "<a href='#'>Opcion</a>"
                ]).draw(false);
                console.log(hijos);
                $("#md_nuevo").modal("hide");
                
            }
        });
        
        $("#frm_madre").submit(function(e){
            e.preventDefault();
            if(existe_padre == "SI"){
                alert("El DNI ya ha sido ingresado anteriormente");
            }else{
                var nombres         = $("#txt_nombres_madre").val();
                var apellidos       = $("#txt_apellidos_madre").val();
                var celular         = $("#txt_celular_madre").val();
                var correo          = $("#txt_correo_madre").val();
                var dni             = $("#txt_dni_madre").val();
                var direccion       = $("#txt_direccion_madre").val();
                var fijo            = $("#txt_fijo_madre").val();
                var encargado       = "0";
                if($("#chk_pagos_madre").prop("checked")){
                    encargado       = "1";
                }else{
                    encargado       = "0";
                }
                var info = {};
                info["nombres"]         = nombres;
                info["apellidos"]       = apellidos;
                info["celular"]         = celular;
                info["correo"]          = correo;
                info["dni"]             = dni;
                info["direccion"]       = direccion;
                info["fijo"]            = fijo;
                info["tipo"]            = 'M';
                info["encargado"]       = encargado;
                datos_madre.push(info);
                console.log(datos_madre);
                $("#mensaje_confirmacion_madre").html("La madre de familia ha sido registrada.");
                $("#confirm_madre").show().delay(2000).fadeOut();
                $("#btn_guardar_madre").attr("disabled", true);
            }
        });

        $("#frm_padre").submit(function(e){
            e.preventDefault();
            if(existe_padre == "SI"){
                alert("El DNI ya ha sido ingresado anteriormente");
            }else{
                var nombres         = $("#txt_nombres_padre").val();
                var apellidos       = $("#txt_apellidos_padre").val();
                var celular         = $("#txt_celular_padre").val();
                var correo          = $("#txt_correo_padre").val();
                var dni             = $("#txt_dni_padre").val();
                var direccion       = $("#txt_direccion_padre").val();
                var fijo            = $("#txt_fijo_padre").val();
                var encargado       = "0";
                if($("#chk_pagos_padre").prop("checked")){
                    encargado       = "1";
                }else{
                    encargado       = "0";
                }
                var info = {};
                info["nombres"]         = nombres;
                info["apellidos"]       = apellidos;
                info["celular"]         = celular;
                info["correo"]          = correo;
                info["dni"]             = dni;
                info["direccion"]       = direccion;
                info["fijo"]            = fijo;
                info["tipo"]            = 'P';
                info["encargado"]       = encargado;
                datos_padre.push(info);
                console.log(datos_padre);
                $("#mensaje_confirmacion_padre").html("El padre de familia ha sido registrado.");
                $("#confirm_padre").show().delay(2000).fadeOut();
                $("#btn_guardar_padre").attr("disabled", true);
            }
            
        });

        $("#txt_dni_madre").blur(function(){
            var dni_madre = $("#txt_dni_madre").val();
            if(dni_madre != ""){
                VerificaDNI(dni_madre);
                if(existe_padre == "SI"){
                    $("#grupo_madre").addClass("has-error");
                    $("#mensaje_madre").css("display", "inline");
                    $("#mensaje_madre").css("color", "#dd4b39");
                }else{
                    $("#grupo_madre").removeClass("has-error");
                    $("#mensaje_madre").css("display", "none");
                    $("#mensaje_madre").css("color", "#dd4b39");
                }
            }
        });

        $("#txt_dni_padre").blur(function(){
            var dni_padre = $("#txt_dni_padre").val();
            if(dni_padre != ""){
                VerificaDNI(dni_padre);
                if(existe_padre == "SI"){
                    $("#grupo_padre").addClass("has-error");
                    $("#mensaje_padre").css("display", "inline");
                    $("#mensaje_padre").css("color", "#dd4b39");
                }else{
                    $("#grupo_padre").removeClass("has-error");
                    $("#mensaje_padre").css("display", "none");
                    $("#mensaje_padre").css("color", "#dd4b39");
                }
            }
        });

        $("#txt_dni").blur(function(){
            var dni = $("#txt_dni").val();
            if(dni != ""){
                VerificaDNIAlumno(dni);
                if(existe_alumno == "SI"){
                    $("#grupo_alumno").addClass("has-error");
                    $("#mensaje_alumno").css("display", "inline");
                    $("#mensaje_alumno").css("color", "#dd4b39");
                }else{
                    $("#grupo_alumno").removeClass("has-error");
                    $("#mensaje_alumno").css("display", "none");
                    $("#mensaje_alumno").css("color", "#dd4b39");
                }
            }
        });

        //GUARDAR TODA LA INFORMACION
        $("#btn_guardar_todo").click(function(){
            $("#btn_guardar_todo").attr("disabled", true);
            if((datos_madre.length > 0 || datos_padre.length > 0) && hijos.length > 0){
                //GUARDAR MADRE
                if(datos_madre.length > 0){
                    datos_madre = JSON.stringify(datos_madre[0]);
                    GuardaApoderado(datos_madre, $("#txt_id_madre"));
                    var idmadre = $("#txt_id_madre").val();
                    registrados["madre"] = datos_madre;
                }

                //GUARDAR PADRE
                if(datos_padre.length > 0){
                    datos_padre = JSON.stringify(datos_padre[0]);
                    GuardaApoderado(datos_padre, $("#txt_id_padre"));
                    var idpadre = $("#txt_id_padre").val();
                    registrados["padre"] = datos_padre;
                }else{
                    registrados["padre"] = JSON.stringify({});
                }
                
                for(var x=0;x<hijos.length;x++){
                    var hijo = hijos[x];
                    var datos = JSON.stringify(hijo);
                    GuardaAlumno(datos);
                }
                registrados["hijos"] = hijos;
                //console.log(registrados);
                
                var detalle = [];
                var data = {};
                console.log(datos_apoderados.length);
                for(var x=0;x<participantes.length;x++){
                    var idparticipante = participantes[x].idparticipante;
                    for(var y=0;y<datos_apoderados.length;y++){
                        var idapoderado = datos_apoderados[y].id;
                        data['idparticipante'] = idparticipante;
                        data['idapoderado'] = idapoderado;
                        //detalle.push(data);
                        GuardaAlumnoApoderado(JSON.stringify(data));
                    }
                }
                console.log(detalle);
                var datos = JSON.stringify(registrados);
                EnviaCorreo(datos);
                $("#md_confirmar").modal();
            }else{
                alert("Los datos no han sido completados");
            }
        });

        $('#md_confirmar').on('hidden.bs.modal', function () {
            window.location = '<?PHP echo constant('URL'); ?>/registro';
        });

    });

    function EnviaCorreo(datos){
        $.ajax({
            type: "POST",
            async: false,
            url: "<?PHP echo constant('URL'); ?>participante/EnviaCorreo", 
            data:{
                datos: datos
            },
            success: function(result){
                console.log(result);
            },
            error:function(result){
                console.log(result);
            }
        });
    }

    function GuardaAlumnoApoderado(datos){
        $.ajax({
            type: "POST",
            async: false,
            url: "<?PHP echo constant('URL'); ?>apoderado/InsertaAlumnoApoderado", 
            data:{
                datos: datos
            },
            success: function(result){
                console.log(result);
            },
            error:function(result){
                console.log(result);
            }
        });
    }

    function GuardaAlumno(datos){
        $.ajax({
            type: "POST",
            async: false,
            url: "<?PHP echo constant('URL'); ?>participante/InsertaAlumno", 
            data:{
                datos: datos
            },
            success: function(result){
                var datos = JSON.parse(result);
                var idparticipante = datos[0].lid;
                var info = {};
                info['idparticipante'] = idparticipante;
                participantes.push(info);
            },
            error:function(result){
                console.log(result);
            }
        });
    }

    function GuardaApoderado(datos, txt_id){
        $.ajax({
            type: "POST",
            url: "<?PHP echo constant('URL'); ?>apoderado/RegistraApoderado", 
            async:false,
            data:{
                datos: datos
            },
            success: function(result){
                var datos = JSON.parse(result);
                txt_id.val(result);
                var info = {};
                info['id'] = result;
                datos_apoderados.push(info);
            },
            error:function(result){
                console.log(result);
            }
        });
    }

    function VerificaDNI(dni){
        var info = {};
        info["dni"] = dni;
        var datos = JSON.stringify(info);
        $.ajax({
            type:"POST",
            url: "<?PHP echo constant('URL'); ?>apoderado/VerificaDNI",
            async: false,
            data:{
                datos: datos
            },
            success: function(result){
                var existe = JSON.parse(result);
                var cantidad = existe.data[0].cantidad;
                if(cantidad > 0){
                    existe_padre = "SI";
                }else{
                    existe_padre = "NO";
                }
                //return existe.data[0].cantidad;
            },
            error: function(result){
                console.log(result);
                var datos = JSON.parse(result);
                return datos.data;
            }
        });
    }

    function VerificaDNIAlumno(dni){
        var info = {};
        info["dni"] = dni;
        var datos = JSON.stringify(info);
        $.ajax({
            type:"POST",
            url: "<?PHP echo constant('URL'); ?>alumno/VerificaDNIAlumno",
            async: false,
            data:{
                datos: datos
            },
            success: function(result){
                var existe = JSON.parse(result);
                var cantidad = existe.data[0].cantidad;
                if(cantidad > 0){
                    existe_alumno = "SI";
                }else{
                    existe_alumno = "NO";
                }
                //return existe.data[0].cantidad;
            },
            error: function(result){
                console.log(result);
                var datos = JSON.parse(result);
                return datos.data;
            }
        });
    }

    function VerHijos(){
        
        hijos_datatable = $('#hijos_tabla').DataTable( {
        	"responsive":true,
            "searching": false,
			"scrollX":        false,
			"scrollCollapse": true,
			"fixedColumns":   {
				"leftColumns": 2
			},
			"language":{
				"url":"https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
			},
			"dom": 'Bfrtip',
			"buttons": [
                {
                    text: "Nuevo",
                    action: function(e, dt, node, config){
                        $("#md_nuevo").modal();
                        $("#modal_title_nuevo").html("Registrar Datos");
                        
                        $("#txt_nombres").val("");
                        $("#txt_apellidos").val("");
                        $("#txt_nacimiento").val("");
                        $("#txt_dni").val("");
                        $("#txt_direccion").val("");
                        $("#txt_distrito").val("");
                        $("#txt_celular_alumno").val("");
                        $("#txt_correo_alumno").val("");

                        $("#txt_centro_estudios").val("");
                        $("#txt_grado_instruccion").val("");
                        $("#estudia_canto").val("");
                        $("#txt_centro_instruccion").val("");

                        $("#txt_seguro_salud").val("");
                        $("#txt_seguro_caducidad").val("");
                        $("#txt_alergias").val("");
                        $("#txt_enfermedades").val("");
                        $("#txt_dolor_cabeza").val("");
                        $("#txt_fiebre").val("");
                        $("#txt_dolor_estomago").val("");
                        $("#opcion_diario").val("");
                        $("#txt_medicamento_diario").val("");

                        $("#tab_datos_generales").removeClass("active");
                        $("#datos_generales").removeClass("active");
                        
                        $("#tab_estudios").removeClass("active");
                        $("#estudios").removeClass("active");
                        
                        $("#tab_salud").removeClass("active");
                        $("#salud").removeClass("active");
                        
                        $("#tab_datos_generales").addClass("active");
                        $("#datos_generales").addClass("active");
                    }
                }
			]
		} );
    }
</script>