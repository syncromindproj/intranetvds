<?php 
  
  //$timeNdate = gmdate($dateFormat, time()+$offset);
  //echo(gmdate($dateFormat,time()-$offset));

?>
<!DOCTYPE html>
<html>
<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <title><?PHP echo constant('TITLE'); ?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?PHP echo constant('URL'); ?>views/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?PHP echo constant('URL'); ?>views/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?PHP echo constant('URL'); ?>views/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?PHP echo constant('URL'); ?>views/dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?PHP echo constant('URL'); ?>views/plugins/iCheck/square/blue.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <style>
.pdfobject-container {
	width: 100%;
	height: 400px;
	margin: 2em 0;
}

.pdfobject { border: solid 1px #666; }

.modal {
  position: fixed;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  overflow: hidden;
}

.modal-dialog {
  position: fixed;
  margin: 0;
  width: 100%;
  height: 100%;
  padding: 0;
}



  </style>

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition login-page" style="overflow-y:hidden; background-image:url('<?PHP echo constant('URL'); ?>views/public/img/back.jpg'); background-size: cover;">

<div id="error_div" class="alert alert-danger alert-dismissible" style="display:none;">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h4><i class="icon fa fa-check"></i> Error</h4>
    <span id="mensaje_error"></span>
</div>

<!-- Delete Modal Asignacion -->
<div class="modal fade" id="modal_pdf">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Reglamento</h4>
      </div>
      <div class="modal-body">
        <div id="pdf"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary pull-left" data-dismiss="modal">Cancelar</button>
        <button type="button" id="btn_acepta" class="btn btn-primary">Aceptar</button>
      </div>
    </div>
  </div>
</div>
<!-- End Delete Modal Asignacion -->



<div class="login-box">
  <div class="login-logo">
    <img src="<?PHP echo constant('URL'); ?>views/public/img/logo.png" />
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Ingrese los datos para iniciar sesión</p>

    <form method="post" id="frm_usuario">
      <div class="form-group has-feedback">
        <input type="text" id="txt_usuario" required class="form-control" placeholder="Usuario">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" id="txt_clave" required class="form-control" placeholder="Clave">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-6">
          
        </div>
        <!-- /.col -->
        <div class="col-xs-6">
          <button type="submit" id="btn_login" class="btn btn-primary btn-block btn-flat">Iniciar Sesión</button>
        </div>
        <!-- /.col -->
      </div>
    </form>
  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 3 -->
<script src="<?PHP echo constant('URL'); ?>views/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->

<script src="<?PHP echo constant('URL'); ?>views/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="<?PHP echo constant('URL'); ?>views/public/js/pdfobject.min.js"></script>
<script>
  $(function () {
    $("#btn_acepta").click(function(){
      var id = $("#btn_acepta").attr("data-value");
      var doc = $("#btn_acepta").attr("data-doc");
      var info = {};
      info["usuario"] = id;
      var myJsonString    = JSON.stringify(info);

      if(doc == 'reglamento'){
        $.ajax({
          type: "POST",
          url: "<?PHP echo constant('URL'); ?>usuario/ActualizaAprobacionReglamento", 
          data:{
              datos: myJsonString
          },
          success: function(result){
            console.log("va");
            $(".modal-title").html("Pagos");
            var myPDF = PDFObject.embed("<?PHP echo constant('URL'); ?>views/uploads/reglamento/pagos.pdf", "#pdf");
            $("#btn_acepta").attr("data-doc", "pagos");
          },
          error:function(result){
              console.log("error");
          }
        });
      }

      if(doc == 'pagos'){
        $.ajax({
          type: "POST",
          url: "<?PHP echo constant('URL'); ?>usuario/ActualizaAprobacionPagos", 
          data:{
              datos: myJsonString
          },
          success: function(result){
            console.log("va");
            window.location = "panel";
          },
          error:function(result){
              console.log("error");
          }
        });
      }
    });

    $("#frm_usuario").submit(function(event){
      event.preventDefault();
      var usuario = $("#txt_usuario").val();
      var clave   = $("#txt_clave").val();
      var info = {};
      info["usuario"] = usuario;
      info["clave"]   = clave;
      var myJsonString    = JSON.stringify(info);
      $.ajax({
          type: "POST",
          url: "<?PHP echo constant('URL'); ?>usuario/Login", 
          dataType: "json",
          data:{
              datos: myJsonString
          },
          success: function(result){
              var idusuario   = result.data.idusuario;
              console.log(idusuario);
              var estado      = result.data.estado;
              var tipo        = result.data.tipo;
              var reglamento  = result.data.reglamento;
              var pagos       = result.data.pagos;
              var aprobado    = 0;
              console.log(reglamento);
              if(reglamento == '1' && pagos == '1'){
                aprobado = 1;
              }
              if(estado=="error_dias"){
                $("#error_div").show().delay(4000).fadeOut();
                $("#mensaje_error").html("Usted ha intentado iniciar sesión en un horario no válido.<br> <b>HORARIOS DE INGRESO</b><br>L-V 8:00 a.m. - 05:30 p.m.<br>S 8:00 a.m. - 01:00 p.m.");
              }else if(estado=="error_datos"){
                $("#mensaje_error").html("Los datos ingresados son erroneos. Inténtelo nuevamente.");
                $("#error_div").show().delay(2000).fadeOut();
              }else{
                if(tipo == 'ALU'){
                  window.location = "panel";
                }

                if(tipo == 'PDF' && aprobado == 0){
                  $("#modal_pdf").modal();
                  $("#btn_acepta").attr("data-value", idusuario);
                  if(reglamento == '0'){
                    $(".modal-title").html("Reglamento");
                    var myPDF = PDFObject.embed("<?PHP echo constant('URL'); ?>views/uploads/reglamento/reglamento.pdf", "#pdf");
                    $("#btn_acepta").attr("data-doc", "reglamento");
                    return false;
                  }
                  
                  /*if(pagos == '0'){
                    $(".modal-title").html("Pagos");
                    var myPDF = PDFObject.embed("<?PHP echo constant('URL'); ?>views/uploads/reglamento/pagos.pdf", "#pdf");
                    $("#btn_acepta").attr("data-doc", "pagos");
                    return false;
                  }*/
                }

                if(tipo != 'ALU'){
                  window.location = "panel";
                }
              }
              
          },
          error:function(result){
              console.log(result);
          }
      });
    });
  });
</script>
</body>
</html>
