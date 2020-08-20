<?PHP
class Horario_CorosController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function render()
    {
        $this->view->title = "Calendario de Actividades";
        $this->view->subtitle = "Detalle";
        $this->view->render("horario_coros/index");
    }

    public function GetHorariosAdmin()
    {
        $horarios = $this->model->GetHorariosAdmin();
        echo(json_encode($horarios));
    }

    public function GetEventosAdmin()
    {
        $eventos = $this->model->GetEventosAdmin();
        echo(json_encode($eventos));
    }
}

?>