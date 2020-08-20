<?PHP require 'views/header.php'; ?>
  <!-- fullCalendar -->
<link rel="stylesheet" href="<?PHP echo constant('URL'); ?>views/bower_components/fullcalendar/dist/fullcalendar.min.css">
<link rel="stylesheet" href="<?PHP echo constant('URL'); ?>views/bower_components/fullcalendar/dist/fullcalendar.print.min.css" media="print">
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?PHP echo $this->title ; ?>
        <small><?PHP echo $this->subtitle ; ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Horario de Clase</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <div class="row">
        <div class="col-md-2">
        <table class="table" style="border:1px solid #000; background:#fff; padding:20px;">
          <thead>
            <tr>
              <th scope="col">Clase Regular</th>
              <th scope="col">Ensayo</th>
              <th scope="col">Ensayos Generales</th>
              <th scope="col">Otros</th>
              <th scope="col">Eventos</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td style="background:#3c8dbc; width:10px;"></td>
              <td style="background:#F0673A; width:10px;"></td>
              <td style="background:#CCD258; width:10px;"></td>
              <td style="background:#4DDDBC; width:10px;"></td>
              <td style="background:#00a65a; width:10px;"></td>
            </tr>
            
          </tbody>
        </table>
        </div>
      </div>

      <div class="row">
        
        <!-- /.col -->
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-body no-padding">
              <!-- THE CALENDAR -->
              <div id="calendar"></div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /. box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<!-- Main Footer -->
<?PHP require 'views/footer.php'; ?>
<!-- /.main-footer -->
<!-- fullCalendar -->
<script src="<?PHP echo constant('URL'); ?>views/bower_components/moment/moment.js"></script>
<script src="<?PHP echo constant('URL'); ?>views/bower_components/fullcalendar/dist/fullcalendar.min.js"></script>
<script src='<?PHP echo constant('URL'); ?>views/public/locale/es.js'></script>


<script>
  $(function () {
    $('[data-toggle="tooltip"]').tooltip();
    /* initialize the external events
     -----------------------------------------------------------------*/
    function init_events(ele) {
      ele.each(function () {

        // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
        // it doesn't need to have a start or end
        var eventObject = {
          title: $.trim($(this).text()) // use the element's text as the event title
        }

        // store the Event Object in the DOM element so we can get to it later
        $(this).data('eventObject', eventObject)

        // make the event draggable using jQuery UI
        $(this).draggable({
          zIndex        : 1070,
          revert        : true, // will cause the event to go back to its
          revertDuration: 0  //  original position after the drag
        })

      })
    }

    init_events($('#external-events div.external-event'))

    /* initialize the calendar
     -----------------------------------------------------------------*/
    //Date for the calendar events (dummy data)
    var date = new Date()
    var d    = date.getDate(),
        m    = date.getMonth(),
        y    = date.getFullYear()

    var info = {};
    info["idparticipante"] = $("#txt_idparticipante").val();
    var datos = JSON.stringify(info);
    var eventos = [];

    <?PHP
      if(isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'ADM'  || $_SESSION['tipo'] == 'DOC'){
    ?>
    $.ajax({
      type:"POST",
      url: "<?PHP echo constant('URL'); ?>horario_coros/GetHorariosAdmin", 
      async:false,
      success: function(result){
        var datos = JSON.parse(result);
        console.log(datos);
        for(var x=0;x<datos.data.length;x++){
          var info = {};
          info["title"] = datos.data[x].grupo + " - " + datos.data[x].descripcion;
          info["description"] = datos.data[x].grupo + " - " + datos.data[x].descripcion;
          info["start"] = datos.data[x].dia_panel + ' ' + datos.data[x].hora_inicio;
          info["end"] = datos.data[x].dia_panel + ' ' + datos.data[x].hora_fin;
          info["backgroundColor"] = datos.data[x].color;
          eventos.push(info);
        }
        console.log(eventos);
      },
      error: function(result){
        console.log(result);
      }
    });

    <?PHP } ?>

    

    $.ajax({
      type:"POST",
      url: "<?PHP echo constant('URL'); ?>horario_coros/GetEventosAdmin", 
      async:false,
      success: function(result){
        var datos = JSON.parse(result);
        for(var x=0;x<datos.data.length;x++){
          var info = {};
            info["title"] = datos.data[x].descripcion;
            info["description"] = datos.data[x].descripcion;
          info["start"] = datos.data[x].fecha_panel + ' ' + datos.data[x].hora;
          info["backgroundColor"] = "#00a65a";
          eventos.push(info);
        }
        console.log(eventos);
      },
      error: function(result){
        console.log(result);
      }
    });

    $('#calendar').fullCalendar({
      header    : {
        left  : 'prev,next today',
        center: 'title',
        right : 'month,agendaWeek,agendaDay'
      },
      displayEventEnd:true,
      buttonText: {
        today: 'Hoy',
        month: 'Mes',
        week : 'Semana',
        day  : 'Día'
      },
      //Random default events
      events    : eventos,
      editable  : false,
      droppable : false, // this allows things to be dropped onto the calendar !!!
      eventClick: function(data, event, view) {
        
      },
      eventRender: function(event, element) {
          var start = moment(event.start, "DD/MM/YYYY");
          var end = moment(event.end, "DD/MM/YYYY");
          
        var tooltip = "DÍA: " + start.format('DD-MM-YYYY') + "<br> HORA INICIO: " + start.format('HH:mm') + "<br> HORA FIN: " + end.format('HH:mm') + "<br> DESCRIPCIÓN:" + event.description;
        $(element).attr("data-original-title", tooltip)
        $(element).attr("data-html", "true")
        $(element).tooltip({ container: "body"})
        console.log(event);
      }
    });

    /* ADDING EVENTS */
    var currColor = '#3c8dbc' //Red by default
    //Color chooser button
    var colorChooser = $('#color-chooser-btn')
    $('#color-chooser > li > a').click(function (e) {
      e.preventDefault()
      //Save color
      currColor = $(this).css('color')
      //Add color effect to button
      $('#add-new-event').css({ 'background-color': currColor, 'border-color': currColor })
    })
    $('#add-new-event').click(function (e) {
      e.preventDefault()
      //Get value and make sure it is not null
      var val = $('#new-event').val()
      if (val.length == 0) {
        return
      }

      //Create events
      var event = $('<div />')
      event.css({
        'background-color': currColor,
        'border-color'    : currColor,
        'color'           : '#fff'
      }).addClass('external-event')
      event.html(val)
      $('#external-events').prepend(event)

      //Add draggable funtionality
      init_events(event)

      //Remove event from text input
      $('#new-event').val('')
    })
  })
</script>