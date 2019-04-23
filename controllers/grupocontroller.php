<?PHP
class GrupoController extends Controller{
    function __construct(){
        parent::__construct(); 
        $this->view->grupos = [];
        //$this->view->title = "";
    }

    function render(){
        $grupos = $this->model->get();
        $this->view->grupos = $grupos;
        $this->view->title = "Grupos";
        $this->view->subtitle = "Listado de Grupos";
        $this->view->render('grupo/index');
    }

    public function getGrupos()
    {
        $grupos = $this->model->get();
        echo(json_encode($grupos));
    }

    public function GetGruposAsignados()
    {
        $grupos = $this->model->GetGruposAsignados();
        echo(json_encode($grupos));
    }

    public function nuevo()
    {
        $this->view->title = "Grupos";
        $this->view->subtitle = "Nuevo Grupo";
        $this->view->render('grupo/nuevo');
    }
    
    public function GuardarGrupo()
    {
        $datos = $_REQUEST['datos'];
        $datos = json_decode($datos, true);
        $grupos = $this->model->InsertaGrupo($datos);
        echo "Grupo Insertado";
    }

    public function ActualizaGrupo()
    {
        $datos = $_REQUEST['datos'];
        $datos = json_decode($datos, true);
        $grupos = $this->model->ActualizaGrupo($datos);
        echo "Grupo Actualizado";
    }

    public function EliminaGrupo()
    {
        $datos = $_REQUEST['datos'];
        $datos = json_decode($datos, true);
        $idgrupo = $datos['idgrupo'];
        $grupos = $this->model->EliminaGrupo($idgrupo);
        echo "Grupo Eliminado";
    }

    public function VerGrupo()
    {
        $datos = $_REQUEST['datos'];
        $datos = json_decode($datos, true);
        $idgrupo = $datos['idgrupo'];
        $grupo = $this->model->getById($idgrupo);
        echo json_encode($grupo);
    }

    public function AsignarDocente()
    {
        $datos = $_REQUEST['datos'];
        $datos = json_decode($datos, true);
        $idgrupo    = $datos['idgrupo'];
        $iddocente  = $datos['iddocente'];
        $grupo = $this->model->AsignarDocente($idgrupo, $iddocente);
        echo json_encode($grupo);
    }

    public function GetCantidadAlumnoxGrupo()
    {
        $grupos = $this->model->GetCantidadAlumnoxGrupo();
        echo json_encode($grupos);
    }

    public function GetGrupoID()
    {
        $datos = $_REQUEST['datos'];
        $datos = json_decode($datos, true);
        $usuario    = $datos['usuario'];
        $grupo = $this->model->GetGrupoID($usuario);
        echo json_encode($grupo);
    }
}

?>