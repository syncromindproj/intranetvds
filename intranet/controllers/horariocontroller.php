<?PHP
class HorarioController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    function render()
    {
        //$grupos = $this->model->get();
        //$this->view->grupos = $grupos;
        $this->view->title = "Horarios";
        $this->view->subtitle = "Listado de Horarios";
        $this->view->render('horario/index');
    }

    public function GetHorarios()
    {
        $horarios = $this->model->GetHorarios();
        echo(json_encode($horarios));
    }

    public function GetHorarioDetalle()
    {
        $datos = $_REQUEST['datos'];
        $datos = json_decode($datos, true);
        $horarios = $this->model->GetHorarioDetalle($datos);
        echo(json_encode($horarios));
    }

    public function EliminarDetalle()
    {
        $datos = $_REQUEST['datos'];
        $datos = json_decode($datos, true);
        $horarios = $this->model->EliminarDetalle($datos);
        echo(json_encode($horarios));
    }

    public function InsertaHorario()
    {
        $datos = $_REQUEST['datos'];
        $datos = json_decode($datos, true);
        $horarios = $this->model->InsertaHorario($datos);
        echo "Horario Insertado";
    }

    public function AsignarHorario()
    {
        $datos = $_REQUEST['datos'];
        $datos = json_decode($datos, true);
        $horarios = $this->model->AsignarHorario($datos);
        echo $horarios;
    }
}
?>