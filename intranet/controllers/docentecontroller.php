<?PHP
class DocenteController extends Controller
{
    function __construct()
    {
        parent::__construct();
    }

    function render()
    {
        $this->view->title = "Docentes";
        $this->view->subtitle = "Listado de Docentes";
        $this->view->render('docente/index');
    }

    public function GetDocentes()
    {
        $docentes = $this->model->GetDocentes();
        echo(json_encode($docentes));
    }

    public function VerDocente()
    {
        $datos = $_REQUEST['datos'];
        $datos = json_decode($datos, true);
        $docente = $this->model->VerDocente($datos['id']);
        echo(json_encode($docente));
    }

    public function RegistraDocente()
    {
        $datos = $_REQUEST['datos'];
        $datos = json_decode($datos, true);
        $mensaje = $this->model->RegistraDocente($datos);
        echo $mensaje;
    }

    public function ActualizaDocente()
    {
        $datos = $_REQUEST['datos'];
        $datos = json_decode($datos, true);
        $mensaje = $this->model->ActualizaDocente($datos);
        echo $mensaje;
    }

    public function EliminaDocente()
    {
        $datos = $_REQUEST['datos'];
        $datos = json_decode($datos, true);
        $this->model->EliminaDocente($datos['id']);
        echo "Registro Eliminado";
    }
}
?>