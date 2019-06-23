<?PHP
class AlumnoController extends Controller{
    function __construct(){
        parent::__construct(); 
        $this->view->alumnos = [];
        //$this->view->title = "";
    }

    function render(){
        $alumnos = $this->model->get();
        $this->view->alumnos = $alumnos;
        $this->view->title = "Alumnos";
        $this->view->subtitle = "Listado de Alumnos";
        $this->view->render('alumno/index');
    }

    public function getAlumnos()
    {
        $alumnos = $this->model->get();
        echo(json_encode($alumnos));
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

    public function ActualizaAlumno()
    {
        $datos = $_REQUEST['datos'];
        $datos = json_decode($datos, true);
        $grupos = $this->model->ActualizaAlumno($datos);
        echo "Grupo Actualizado";
        //print_r($datos);
    }

    public function AsignaGrupo()
    {
        $datos = $_REQUEST['datos'];
        $datos = json_decode($datos, true);
        $grupos = $this->model->AsignaGrupo($datos);
        echo "Asignacion Realizada";
    }

    public function EliminaGrupo()
    {
        $datos = $_REQUEST['datos'];
        $datos = json_decode($datos, true);
        $idgrupo = $datos['idgrupo'];
        $grupos = $this->model->EliminaGrupo($idgrupo);
        echo "Grupo Eliminado";
    }

    public function VerAlumno()
    {
        $datos      = $_REQUEST['datos'];
        $datos      = json_decode($datos, true);
        $idalumno   = $datos['idalumno'];
        $alumno     = $this->model->getById($idalumno);
        echo json_encode($alumno);
    }
}

?>