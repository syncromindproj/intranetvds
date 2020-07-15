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
        return $grupos;
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

    public function EliminaAlumno()
    {
        $datos = $_REQUEST['datos'];
        $datos = json_decode($datos, true);
        $idalumno = $datos['idalumno'];
        $grupos = $this->model->EliminaAlumno($idalumno);
        echo "Alumno Eliminado";
    }

    public function VerAlumno()
    {
        $datos      = $_REQUEST['datos'];
        $datos      = json_decode($datos, true);
        $idalumno   = $datos['idalumno'];
        $alumno     = $this->model->getById($idalumno);
        echo json_encode($alumno);
    }

    public function GetAlumnosByGrupo()
    {
        $datos = $_REQUEST['datos'];
        $datos = json_decode($datos, true);
        $alumnos = $this->model->GetAlumnosByGrupo($datos["grupo"]);
        echo json_encode($alumnos);
    }

    public function getByDocente()
    {
        $datos      = $_REQUEST['datos'];
        $datos      = json_decode($datos, true);
        $idparticipante   = $datos['idparticipante'];
        $alumno     = $this->model->getByDocente($idparticipante);
        echo json_encode($alumno);
    }

    public function getByDocentInforme()
    {
        $datos      = $_REQUEST['datos'];
        $datos      = json_decode($datos, true);
        $idparticipante   = $datos['idparticipante'];
        $alumno     = $this->model->getByDocentInforme($idparticipante);
        echo json_encode($alumno);
    }

    public function getAlumnosEvento()
    {
        $datos      = $_REQUEST['datos'];
        $datos      = json_decode($datos, true);
        $alumnos = $this->model->getAlumnosEvento($datos);
        echo(json_encode($alumnos));
    }

    public function getAlumnosAutorizados()
    {
        $datos      = $_REQUEST['datos'];
        $datos      = json_decode($datos, true);
        $alumnos = $this->model->getAlumnosAutorizados($datos);
        echo(json_encode($alumnos));
    }

    public function getAlumnosNOAutorizados()
    {
        $datos      = $_REQUEST['datos'];
        $datos      = json_decode($datos, true);
        $alumnos = $this->model->getAlumnosNOAutorizados($datos);
        echo(json_encode($alumnos));
    }

    public function getAlumnosComunicado()
    {
        $datos      = $_REQUEST['datos'];
        $datos      = json_decode($datos, true);
        $alumnos = $this->model->getAlumnosComunicado($datos);
        echo(json_encode($alumnos));
    }

    public function VerificaDNIAlumno()
    {
        $datos = $_REQUEST['datos'];
        $datos = json_decode($datos, true);
        $info = $this->model->VerificaDNIAlumno($datos);
        echo json_encode($info);
    }

    public function Exportar()
    {
        $datos = $_REQUEST['datos'];
        $datos = json_decode($datos, true);
        $info = $this->model->Exportar($datos);
        echo json_encode($info);
    }

    public function CambiaImagen()
    {
        $img = $_FILES["fl_image"]["name"];
        $tmp = $_FILES["fl_image"]["tmp_name"];
        $id  = $_REQUEST["txt_id"];
        $mensaje = "";
        
        $ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
        
        $path   = 'views/dist/img';
        $rand = rand(10000, 99999);
        $path .= "/" . $rand . "_file.".$ext;
        if(move_uploaded_file($tmp,$path)) 
        {
            $mensaje = $this->model->ActualizaImageAlumno($id, $path);
        }
        
        echo $mensaje;
    }
}

?>