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
        <li><a href="#">Reportes</a></li>
        <li class="active">Reporte de Audiciones 2019</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
       
      <!--------------------------
        | Your Page Content Here |
        -------------------------->
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Registro</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" id="frm_grupo">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="txt_descripcion">Descripción</label>
                                <input required type="text" class="form-control" id="txt_descripcion" placeholder="Ingrese un nombre">
                            </div>
                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <button type="submit" id="btn_guardar" class="btn btn-primary">Guardar</button>
                        </div>
                    </form>
                </div>
                <!-- /.box -->
            </div>
        </div>


        


    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


<!-- Main Footer -->
<?PHP require 'views/footer.php'; ?>
<!-- /.main-footer -->


<script>
	$(document).ready(function() {
        $("#frm_grupo").submit(function(event){
            event.preventDefault();
            var descripcion = $("#txt_descripcion").val();
            $.ajax({
                type: "POST",
                url: "http://localhost:8080/intranet/grupo/GuardarGrupo", 
                data:{
                    datos: '{"descripcion": "' + descripcion + '"}'
                },
                success: function(result){
                    console.log(result);
                },
                error:function(result){
                    console.log(result);
                }
            });
        });
	} );
</script>

<!-- Optionally, you can add Slimscroll and FastClick plugins.
     Both of these plugins are recommended to enhance the
     user experience. -->
     </body>
</html>