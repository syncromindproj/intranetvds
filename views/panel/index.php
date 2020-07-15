<?PHP require 'views/header.php'; ?>

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
        <li class="active">Panel de Administración</li>
      </ol>
    </section>

<?PHP
    if(isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'PDF'){
?>
    <!-- Enviar Modal -->
    <div class="modal modal-primary fade" id="modal_autorizar">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">¿Desea autorizar el evento?</h4>
            </div>
            <div class="modal-body">
            <p><span id="sp_mensaje_autorizar"></span></p>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Cancelar</button>
            <button type="button" id="btn_autorizar" data-value="" class="btn btn-outline">Autorizar</button>
            </div>
        </div>
        </div>
    </div>
    <!-- End Enviar Modal -->

    <!-- No Autorizar Modal -->
    <div class="modal modal-primary fade" id="modal_noautorizar">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Por favor ingrese el motivo</h4>
            </div>
            <div class="modal-body">
                <p>
                    <textarea class="form-control" id="txt_noautoriza" rows="8"></textarea>
                </p>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Cancelar</button>
            <button type="button" id="btn_noautorizar" data-value="" class="btn btn-outline">Enviar</button>
            </div>
        </div>
        </div>
    </div>
    <!-- End Modal No Autorizar -->
    
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <section class="col-lg-4 connectedSortable">
                <div class="box box-primary">
                    <div class="box-header">
                        <i class="ion ion-clipboard"></i>
                        <h3 class="box-title">Eventos Programados</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body" id="body_eventos">
                        
                        
                    </div>
                </div>
            
            </section>
            <section class="col-lg-4 connectedSortable">
            <!-- TO DO List -->
            <div class="box box-primary">
                <div class="box-header">
                    <i class="ion ion-clipboard"></i>
                    <h3 class="box-title">Comunicados</h3>
                </div>
                <div class="box-body" id="body_comunicados">
                    
                </div>
                <div class="box-footer clearfix no-border">
                
                </div>
            </div>
            <!-- /.box -->
            </section>
            <section class="col-lg-4 connectedSortable">
            <!-- TO DO List -->
            <div class="box box-primary">
                <div class="box-header">
                <i class="ion ion-clipboard"></i>

                <h3 class="box-title">Materiales Disponibles</h3>

                </div>
                <!-- /.box-header -->
                <div class="box-body" id="body_materiales">
                <!-- See dist/js/pages/dashboard.js to activate the todoList plugin -->
                
                </div>
                <!-- /.box-body -->
                <div class="box-footer clearfix no-border">
                
                </div>
            </div>
            <!-- /.box -->
            </section>

            <section class="col-lg-12 connectedSortable">
            <!-- TO DO List -->
            <div class="box box-primary">
                <div class="box-header">
                <i class="ion ion-clipboard"></i>

                <h3 class="box-title">Reportes Académicos</h3>

                </div>
                <!-- /.box-header -->
                <div class="box-body" id="body_reportes">
                <!-- See dist/js/pages/dashboard.js to activate the todoList plugin -->
                
                </div>
                <!-- /.box-body -->
                <div class="box-footer clearfix no-border">
                
                </div>
            </div>
            <!-- /.box -->
            </section>
        </div>

        
        
    </section>
<?PHP } ?>

<?PHP
    if(isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'ALU'){
?>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <section class="col-lg-4 connectedSortable">
                <div class="box box-primary" id="box_eventos">
                    <div class="box-header">
                        <i class="ion ion-clipboard"></i>
                        <h3 class="box-title">Eventos Programados</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body" id="div_eventos">
                        
                        
                    </div>
                </div>
            
            </section>
            <section class="col-lg-4 connectedSortable">
            <!-- TO DO List -->
            <div class="box box-primary">
                <div class="box-header">
                    <i class="ion ion-clipboard"></i>
                    <h3 class="box-title">Comunicados</h3>
                </div>
                <div class="box-body">
                    <ul class="todo-list" id="lista_comunicados">
                        
                        
                    </ul>
                    </div>
                <div class="box-footer clearfix no-border">
                
                </div>
            </div>
            <!-- /.box -->
            </section>
            <section class="col-lg-4 connectedSortable">
            <!-- TO DO List -->
            <div class="box box-primary">
                <div class="box-header">
                <i class="ion ion-clipboard"></i>

                <h3 class="box-title">Materiales Disponibles</h3>

                </div>
                <!-- /.box-header -->
                <div class="box-body">
                <!-- See dist/js/pages/dashboard.js to activate the todoList plugin -->
                <ul class="todo-list" id="div_docrecibidos">
                    
                </ul>
                </div>
                <!-- /.box-body -->
                <div class="box-footer clearfix no-border">
                
                </div>
            </div>
            <!-- /.box -->
            </section>
        </div>

        <div class="row">
            <section class="col-lg-12 connectedSortable">
                <div class="box box-primary">
                    <div class="box-header">
                        <i class="ion ion-clipboard"></i>
                        <h3 class="box-title">Lista de compañeros</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="alumnos_tabla" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Nombres</th>
                                    <th>Apellidos</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            
            </section>
            
        </div>
        
    </section>
<?PHP } ?>

<?PHP
    if(isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'ADM'){
?>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <section class="col-lg-6">
                <div class="box box-default">
                    <div class="box-header with-border">
                    <h3 class="box-title">Alumnos por Grupos</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                    <div class="row">
                        <div class="col-md-8">
                        <div class="chart-responsive">
                            <canvas id="pieChart" height="150"></canvas>
                        </div>
                        <!-- ./chart-responsive -->
                        </div>
                        <!-- /.col -->
                        <div class="col-md-4">
                        <ul id="lista_grupos" class="chart-legend clearfix">
                        </ul>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer no-padding">
                    <ul class="nav nav-pills nav-stacked" id="grupo_porcentaje">
                        
                    </ul>
                    </div>
                    <!-- /.footer -->
                </div>
                <!-- /.box -->
            </section>
        </div>
    </section>
<?PHP } ?>
</div>

<!-- Main Footer -->
<?PHP require 'views/footer.php'; ?>
<!-- /.main-footer -->
<!-- jQuery UI 1.11.4 -->
<script src="<?PHP echo constant('URL'); ?>views/bower_components/jquery-ui/jquery-ui.min.js"></script>
<script src="<?PHP echo constant('URL'); ?>views/bower_components/moment/moment.js"></script>
<!-- Morris.js charts -->
<script src="<?PHP echo constant('URL'); ?>views/bower_components/raphael/raphael.min.js"></script>
<script src="<?PHP echo constant('URL'); ?>views/bower_components/morris.js/morris.min.js"></script>
<!-- Sparkline -->
<script src="<?PHP echo constant('URL'); ?>views/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>

<!-- jvectormap -->
<script src="<?PHP echo constant('URL'); ?>views/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="<?PHP echo constant('URL'); ?>views/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- Slimscroll -->
<script src="<?PHP echo constant('URL'); ?>views/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- ChartJS -->
<script src="<?PHP echo constant('URL'); ?>views/bower_components/chart.js/Chart.js"></script>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs/dt-1.10.18/b-1.5.4/b-html5-1.5.4/r-2.2.2/datatables.min.css"/>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs/dt-1.10.18/b-1.5.4/b-html5-1.5.4/r-2.2.2/datatables.min.js"></script>


<?PHP if(isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'ADM'){ ?>
<script src="<?PHP echo constant('URL'); ?>views/dist/js/pages/dashboard_admin.js"></script>
<?PHP } ?>

<script>
    var grupos = "";
    var alumnos = "";
    var datos_comunicado = "";
    var datos_evento = "";
    var datos_materiales = "";
    var datos_reportes = "";
    var datos_apoderado = "";

    $(document).ready(function() {
        <?PHP if(isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'ADM'){ ?>
            $.ajax({
                type: "POST",
                url: "<?PHP echo constant('URL'); ?>grupo/GetCantidadAlumnoxGrupo", 
                success: function(result){
                    grupos = JSON.parse(result);
                    console.log(grupos);
                    MuestraGruposCantidad(grupos);
                },
                error:function(result){
                    console.log(result);
                },
                complete: function() {
                    //setInterval(GetInfoPanel(tipo, div), 5000); 
                }
            });
        <?PHP } ?>

        <?PHP if(isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'ALU'){ ?>
            get_grupo();
            var idparticipante = $("#txt_idparticipante").val();
            var idgrupo = "";
            var info            = {};
            info["usuario"]     = '<?PHP echo($_SESSION['usuario']); ?>';
            var myJsonString    = JSON.stringify(info);
            //console.log(myJsonString);

            var infoparticipante = {};
            infoparticipante['idalumno'] = idparticipante;
            var datos_participante = JSON.stringify(infoparticipante);

            $.ajax({
                type: "POST",
                url: "<?PHP echo constant('URL'); ?>comunicado/GetComunicadoByParticipante", 
                data:{
                    datos: datos_participante
                },
                success: function(result){
                    var datos = JSON.parse(result);
                    console.log(datos);
                    var div_comunicados = $("#lista_comunicados");
                    var html = "";
                    if(datos.data.length == 0){
                        html += "<p>Aún no hay comunicados asignados</p>";
                    }else{
                        for(var x=0;x<datos.data.length;x++){
                            html += '<li>';
                            html += '<span class="text"><a target="_blank" href="'+datos.data[x].url+'">'+ datos.data[x].descripcion +'</a></span>';
                            html += '<div class="tools">';
                            html += '</div>';
                            html += '</li>';
                        }
                        
                    }
                    div_comunicados.html(html);
                },
                error: function(result){

                }
            });

            $.ajax({
                type: "POST",
                url: "<?PHP echo constant('URL'); ?>evento/GetEventoByParticipante", 
                data:{
                    datos: datos_participante
                },
                success: function(result){
                    console.log(result);
                    var datos = JSON.parse(result);
                    var div_eventos = $("#div_eventos");
                    var html = "";
                    if(datos.data.length == 0){
                        html += "<p>Aún no hay eventos asignados</p>";
                    }else{
                        for(var x=0;x<datos.data.length;x++){
                            if(datos.data[x].autorizacion == "1"){
                                html += '<div class="box box-success">';
                            }else{
                                html += '<div class="box box-danger">';
                            }
                            html += '<div class="box-header with-border">';
                            html += '<h3 class="box-title">'+ datos.data[x].titulo +'</h3>';
                            html += '<div class="box-tools pull-right">';
                            html += '<button type="button" class="btn btn-box-tool">';
                            html += '</button>';
                            html += '</div>';
                            html += '</div>';
                            html += '<div class="box-body">';
                            html += '<p><b>Descripción: </b>' + datos.data[x].descripcion + '</p>';
                            html += '<p><b>Fecha: </b>' + datos.data[x].fecha + '</p>';
                            html += '<p><b>Hora: </b>' + datos.data[x].hora + '</p>';
                            html += '</div>';
                            html += '</div>';
                            
                        }
                    }
                    div_eventos.html(html);
                },
                error: function(result){
                    console.log(result);
                }
            });

            $.ajax({
                type: "POST",
                url: "<?PHP echo constant('URL'); ?>material/GetMaterialByParticipante", 
                data:{
                    datos: datos_participante
                },
                success: function(result){
                    var datos = JSON.parse(result);
                    console.log(datos.data.length);
                    var div_docrecibidos = $("#div_docrecibidos");
                    var html = "";
                    if(datos.data.length == 0){
                        html += "<p>Aún no hay materiales asignados</p>";
                    }else{
                        for(var x=0;x<datos.data.length;x++){
                            html += '<li>';
                            html += '<span class="text"><a title="'+ datos.data[x].descripcion +'" target="_blank" href="'+datos.data[x].url+'">'+ datos.data[x].titulo +'</a></span>';
                            html += '<div class="tools">';
                            html += '</div>';
                            html += '</li>';
                        }
                        
                    }
                    div_docrecibidos.html(html);
                },
                error: function(result){

                }
            });
            
            $.ajax({
                type: "POST",
                url: "<?PHP echo constant('URL'); ?>grupo/GetGrupoID", 
                data:{
                    datos: myJsonString
                },
                success: function(result){
                    idgrupo     = JSON.parse(result);
                    var info    = {};
                    info["grupo"]     = idgrupo;
                    var myJsonString    = JSON.stringify(info);
                    console.log(myJsonString);
                    alumnos = $('#alumnos_tabla').DataTable( {
                        "ajax": {
                            "type": "POST",
                            "url": "<?PHP echo constant('URL'); ?>alumno/GetAlumnosByGrupo",
                            "data": {
                                "datos": myJsonString
                            },
                            "error": function (jqXHR, textStatus, errorThrown) {
                                console.log("sss");
                            }
                        },
                        "responsive":true,
                        "scrollX":        false,
                        "scrollCollapse": true,
                        "ordering": false,
                        "bLengthChange": false,
                        "pageLength": 5,
                        "bDestroy": true,
                        "fixedColumns":   {
                            "leftColumns": 2
                        },
                        "language":{
                            "url":"https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
                        },
                        "columnDefs":[
                            {
                                "targets":0,
                                "data":"nombres",
                                "width":"15%"
                            },
                            {
                                "targets":1,
                                "data":"apellidos",
                                "width":"15%"
                            }
                        ]
                        
                    } );
                },
                error:function(result){
                    console.log(result);
                },
                complete: function() {
                    //setInterval(GetInfoPanel(tipo, div), 5000); 
                }
            });

            
        <?PHP } ?>

        <?PHP if(isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'PDF'){ ?>
            //get_grupo();
            var idapoderado = $("#txt_idparticipante").val();
            var idgrupo = "";
            var info            = {};
            info["usuario"]     = '<?PHP echo($_SESSION['usuario']); ?>';
            var myJsonString    = JSON.stringify(info);
            
            var infoapoderado = {};
            infoapoderado['idapoderado'] = idapoderado;
            datos_apoderado = JSON.stringify(infoapoderado);
            
            GetHijos(datos_apoderado);
            
            /* 

            
            
             */
            $("#btn_autorizar").click(function(){
                var idevento = $("#btn_autorizar").attr("data-value");
                var info = {};
                info['idevento'] = idevento;
                var datos = JSON.stringify(info);
                $.ajax({
                    type: "POST",
                    url: "<?PHP echo constant('URL'); ?>evento/Autorizar", 
                    data:{
                        datos: datos
                    },
                    async:false,
                    success: function(result){
                        $("#modal_autorizar").modal('hide');
                        //GetHijos(datos_apoderado);
                        window.location = "panel";
                    },
                    error: function(result){

                    }
                });
            });

            $("#btn_noautorizar").click(function(){
                var idevento = $("#btn_noautorizar").attr("data-value");
                var motivo = $("#txt_noautoriza").val();
                var info = {};
                info['idevento'] = idevento;
                info['motivo'] = motivo;
                var datos = JSON.stringify(info);
                $.ajax({
                    type: "POST",
                    url: "<?PHP echo constant('URL'); ?>evento/NoAutorizar", 
                    data:{
                        datos: datos
                    },
                    async:false,
                    success: function(result){
                        $("#modal_noautorizar").modal('hide');
                        window.location = "panel";
                    },
                    error: function(result){

                    }
                });
            });

            
            
        <?PHP } ?>
    });

    function GetHijos(datos_apoderado){
        datos_comunicado = "";
        datos_evento = "";
        $.ajax({
            type: "POST",
            url: "<?PHP echo constant('URL'); ?>apoderado/GetHijos", 
            data:{
                datos: datos_apoderado
            },
            async:false,
            success: function(result){
                var datos = JSON.parse(result);
                console.log("hijos");
                console.log(datos);
                for(var x=0; x<datos.data.length;x++){
                    var idparticipante = datos.data[x].idparticipante;
                    datos_comunicado += MuestraComunicados(datos.data[x]);
                    datos_comunicado += '<ul class="todo-list" id="lista_comunicados">';
                    var infoparticipante = {};
                    infoparticipante['idalumno'] = idparticipante;
                    var datos_participante = JSON.stringify(infoparticipante);
                    console.log("datos_part");
                    console.log(datos_participante);
                    GetComunicadoByParticipante(datos_participante);
                    datos_comunicado += "</ul>";

                    //body_comunicados
                    datos_evento += MuestraComunicados(datos.data[x]);
                    GetEventoByParticipante(datos_participante);

                    //body_materiales
                    datos_materiales += MuestraComunicados(datos.data[x]);
                    datos_materiales += '<ul class="todo-list" id="lista_materiales">';
                    var infoparticipante = {};
                    infoparticipante['idalumno'] = idparticipante;
                    var datos_participante = JSON.stringify(infoparticipante);
                    GetMaterialByParticipante(datos_participante);
                    datos_materiales += "</ul>";

                    //body_reportes
                    datos_reportes += MuestraComunicados(datos.data[x]);
                    datos_reportes += '<ul class="todo-list" id="lista_materiales">';
                    var infoparticipante = {};
                    infoparticipante['idalumno'] = idparticipante;
                    var datos_participante = JSON.stringify(infoparticipante);
                    GetReporteByParticipante(datos_participante);
                    datos_reportes += "</ul>";
                }
                
            },
            error: function(result){

            }
        });
        var div_comunicados = $("#body_comunicados");
        div_comunicados.html(datos_comunicado);
        
        var div_eventos = $("#body_eventos");
        div_eventos.html(datos_evento);

        var div_materiales = $("#body_materiales");
        div_materiales.html(datos_materiales);

        var div_reportes = $("#body_reportes");
        div_reportes.html(datos_reportes);
    }

    function autorizar(id){
        $("#modal_autorizar").modal();
        $("#sp_mensaje_autorizar").html("¿Desea autorizar la asistencia de su hijo al evento?");
        $("#btn_autorizar").attr("data-value", id);
    }

    function no_autorizar(id){
        $("#modal_noautorizar").modal();
        $("#btn_noautorizar").attr("data-value", id);
    }

    function GetReporteByParticipante(datos_participante){
        $.ajax({
            type: "POST",
            url: "<?PHP echo constant('URL'); ?>reporte_academico/GetReporteByParticipante", 
            async:false,
            data:{
                datos: datos_participante
            },
            success: function(result){
                var datos = JSON.parse(result);
                if(datos.data.length == 0){
                    datos_reportes += "<p>Aún no hay reportes asignados</p>";
                }else{
                    for(var x=0;x<datos.data.length;x++){
                        datos_reportes += '<li>';
                        datos_reportes += '<span class="text"><a title="'+ datos.data[x].descripcion +'" target="_blank" href="'+datos.data[x].url+'">'+ datos.data[x].titulo +'</a></span>';
                        datos_reportes += '<div class="tools">';
                        datos_reportes += '</div>';
                        datos_reportes += '</li>';
                    }
                    
                }
            },
            error: function(result){

            }
        });
    }
    function GetMaterialByParticipante(datos_participante){
        $.ajax({
            type: "POST",
            url: "<?PHP echo constant('URL'); ?>material/GetMaterialByParticipante", 
            async:false,
            data:{
                datos: datos_participante
            },
            success: function(result){
                var datos = JSON.parse(result);
                if(datos.data.length == 0){
                    datos_materiales += "<p>Aún no hay materiales asignados</p>";
                }else{
                    for(var x=0;x<datos.data.length;x++){
                        datos_materiales += '<li>';
                        datos_materiales += '<span class="text"><a title="'+ datos.data[x].descripcion +'" target="_blank" href="'+datos.data[x].url+'">'+ datos.data[x].titulo +'</a></span>';
                        datos_materiales += '<div class="tools">';
                        datos_materiales += '</div>';
                        datos_materiales += '</li>';
                    }
                    
                }
            },
            error: function(result){

            }
        });
    }

    function GetEventoByParticipante(datos_participante){
        $.ajax({
            type: "POST",
            url: "<?PHP echo constant('URL'); ?>evento/GetEventoByParticipante", 
            data:{
                datos: datos_participante
            },
            async:false,
            success: function(result){
                var datos = JSON.parse(result);
                console.log(datos);
                if(datos.data.length == 0){
                    datos_evento += "<p>Aún no hay eventos asignados</p>";
                }else{
                    for(var x=0;x<datos.data.length;x++){
                        if(datos.data[x].autorizacion=="0"){
                            datos_evento += '<div class="box box-danger">';
                        }else{
                            datos_evento += '<div class="box box-success">';
                        }
                        datos_evento += '<div class="box-header with-border">';
                        datos_evento += '<h3 class="box-title">'+ datos.data[x].titulo +'</h3>';
                        datos_evento += '<div class="box-tools pull-right">';
                        datos_evento += '<button type="button" class="btn btn-box-tool" >';
                        datos_evento += '</button>';
                        datos_evento += '</div>';
                        datos_evento += '</div>';
                        datos_evento += '<div class="box-body">';
                        datos_evento += '<p><b>Descripción: </b>' + datos.data[x].descripcion + '</p>';
                        datos_evento += '<p><b>Fecha: </b>' + datos.data[x].fecha + '</p>';
                        datos_evento += '<p><b>Hora: </b>' + datos.data[x].hora + '</p>';
                        if(datos.data[x].autorizacion=="0" && datos.data[x].motivo == ""){
                            datos_evento += '<p><button type="button" class="btn btn-primary" onclick="autorizar('+ datos.data[x].idevento_alumno +');">Autorizar</button> <button type="button" class="btn btn-primary" onclick="no_autorizar('+ datos.data[x].idevento_alumno +');">No Autorizar</button></p>';
                        }
                        datos_evento += '</div>';
                        datos_evento += '</div>';
                        console.log(datos_evento);
                    }
                }
            },
            error: function(result){
                console.log(result);
            }
        });
    }

    function GetComunicadoByParticipante(datos_participante){
        $.ajax({
            type: "POST",
            url: "<?PHP echo constant('URL'); ?>comunicado/GetComunicadoByParticipante", 
            data:{
                datos: datos_participante
            },
            async:false,
            success: function(result){
                var datos = JSON.parse(result);
                if(datos.data.length == 0){
                    datos_comunicado += "<p>Aún no hay comunicados asignados</p>";
                }else{
                    for(var x=0;x<datos.data.length;x++){
                        datos_comunicado += '<li>';
                        datos_comunicado += '<span class="text"><a target="_blank" href="'+datos.data[x].url+'">'+ datos.data[x].descripcion +'</a></span>';
                        datos_comunicado += '<div class="tools">';
                        datos_comunicado += '</div>';
                        datos_comunicado += '</li>';
                    }
                    
                }
            },
            error: function(result){
                console.log("error");
            }
        });
    }

    function MuestraComunicados(datos){
        var nombres = datos.nombres;
        var apellidos = datos.apellidos;
        return '<h5>'+ nombres + ' ' + apellidos +'</h5>';
    }

    function MuestraGruposCantidad(data)
    {
        var color = [];
        var label = [];
        var value = [];
        var li = "";
        var li_porcentaje = "";

        var dynamicColors = function() {
            var r = Math.floor(Math.random() * 255);
            var g = Math.floor(Math.random() * 255);
            var b = Math.floor(Math.random() * 255);
            return "rgb(" + r + "," + g + "," + b + ")";
        };

        for (var i in data) {
            if(data[i].color==""){
                data[i].color = dynamicColors();
                li += '<li><i class="fa fa-circle-o" style="color:'+ data[i].color +'"></i> '+ data[i].label +'</li>';       
                li_porcentaje += '<li><a href="#">'+ data[i].label +'<span class="pull-right" style="color:'+ data[i].color +'"> '+ data[i].porce +'%</span></a></li>';
            }
        }
        var ul = $("#lista_grupos");
        ul.html(li);

        var ul_porce = $("#grupo_porcentaje");
        ul_porce.html(li_porcentaje);
        
        var pieChartCanvas = $('#pieChart').get(0).getContext('2d');
        var pieChart       = new Chart(pieChartCanvas);
        var PieData         = data;
        
        var pieOptions     = {
            // Boolean - Whether we should show a stroke on each segment
            segmentShowStroke    : true,
            // String - The colour of each segment stroke
            segmentStrokeColor   : '#fff',
            // Number - The width of each segment stroke
            segmentStrokeWidth   : 1,
            // Number - The percentage of the chart that we cut out of the middle
            percentageInnerCutout: 50, // This is 0 for Pie charts
            // Number - Amount of animation steps
            animationSteps       : 100,
            // String - Animation easing effect
            animationEasing      : 'easeOutBounce',
            // Boolean - Whether we animate the rotation of the Doughnut
            animateRotate        : true,
            // Boolean - Whether we animate scaling the Doughnut from the centre
            animateScale         : false,
            // Boolean - whether to make the chart responsive to window resizing
            responsive           : true,
            // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
            maintainAspectRatio  : false,
            // String - A legend template
            legendTemplate       : '<ul class=\'<%=name.toLowerCase()%>-legend\'><% for (var i=0; i<segments.length; i++){%><li><span style=\'background-color:<%=segments[i].fillColor%>\'></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>',
            // String - A tooltip template
            tooltipTemplate      : '<%=label%> - <%=value %> alumnos',
            title: {
					display: true,
					text: 'Chart.js Doughnut Chart'
				},
        };
        // Create pie or douhnut chart
        // You can switch between pie and douhnut using the method below.
        pieChart.Doughnut(PieData, pieOptions);
    }

    function get_grupo(){
        var info        = {};
        info["id"]    = '<?PHP echo($_SESSION['idparticipante']); ?>';
        var myJsonString  = JSON.stringify(info);
        console.log(myJsonString);

        $.ajax({
            type: "POST",
            url: "<?PHP echo constant('URL'); ?>grupo/GetGrupoParticipante", 
            data:{
                datos: myJsonString
            },
            success: function(result){
                var datos = JSON.parse(result);
                $("#txt_grupoparticipante").val(datos.data[0].idgrupo);
                console.log(datos);
            },
            error:function(result){
                console.log(result);
            },
            complete: function() {
                //setInterval(GetInfoPanel(tipo, div), 5000); 
            }
        });
    }
</script>