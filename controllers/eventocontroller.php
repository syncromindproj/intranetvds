<?PHP
class EventoController extends Controller
{
    function __construct()
    {
        parent::__construct();
    }

    function render()
    {
        $this->view->title = "Eventos";
        $this->view->subtitle = "Listado de Eventos";
        $this->view->render('evento/index');
    }

    public function ListaEventos()
    {
        $eventos = $this->model->ListaEventos();
        echo(json_encode($eventos));
    }

    public function VerCategoria()
    {
        $datos = $_REQUEST['datos'];
        $datos = json_decode($datos, true);
        $idcategoria = $datos['idcategoria'];
        $categoria = $this->model->VerCategoria($idcategoria);
        echo json_encode($categoria);
    }

    public function RegistrarEvento()
    {
        $datos = $_REQUEST['datos'];
        $datos = json_decode($datos, true);
        $eventos = $this->model->RegistrarEvento($datos);
        echo $eventos;
    }

    public function EliminaEvento()
    {
        $datos = $_REQUEST['datos'];
        $datos = json_decode($datos, true);
        $this->model->EliminaEvento($datos);
        echo "Evento Eliminado";
    }

    public function ActualizaCategoria()
    {
        $datos = $_REQUEST['datos'];
        $datos = json_decode($datos, true);
        $this->model->ActualizaCategoria($datos);
        echo "Categoria Actualizada";
    }

    public function AsignarEvento()
    {
        $datos = $_REQUEST['datos'];
        $evento = $this->model->AsignarEvento($datos);
        echo json_encode($evento);
    }

    public function GetEventoByParticipante()
    {
        $datos = $_REQUEST['datos'];
        $datos = json_decode($datos, true);
        $eventos = $this->model->GetEventoByParticipante($datos);
        echo json_encode($eventos);
    }
}
?>