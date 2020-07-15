<?PHP
class ApoderadoController extends Controller
{
    function __construct()
    {
        parent::__construct();
    }

    public function GetApoderadosByAlumno()
    {
        $datos = $_REQUEST['datos'];
        $datos = json_decode($datos, true);
        $idparent = $datos['idparent'];
        $id = $this->model->GetApoderadosByAlumno($idparent);
        echo json_encode($id);
    }

    public function ListaHijos()
    {
        $datos = $_REQUEST['datos'];
        $datos = json_decode($datos, true);
        $hijos = $this->model->ListaHijos($datos);
        echo json_encode($hijos);
    }

    public function RegistraApoderado()
    {
        $datos = $_REQUEST['datos'];
        $datos = json_decode($datos, true);
        $id = $this->model->RegistraApoderado($datos);
        echo $id;
    }

    public function InsertaAlumnoApoderado()
    {
        $datos = $_REQUEST['datos'];
        $datos = json_decode($datos, true);
        $id = $this->model->InsertaAlumnoApoderado($datos);
        echo $id;
    }

    public function GetApoderado()
    {
        $datos = $_REQUEST['datos'];
        $datos = json_decode($datos, true);
        $info = $this->model->GetApoderado($datos['id']);
        echo json_encode($info);
    }

    public function EliminaApoderado()
    {
        $datos = $_REQUEST['datos'];
        $datos = json_decode($datos, true);
        $this->model->EliminaApoderado($datos['id']);
        echo "Registro Eliminado";
    }

    public function ActualizaApoderado()
    {
        $datos = $_REQUEST['datos'];
        $datos = json_decode($datos, true);
        $id = $this->model->ActualizaApoderado($datos);
        echo $id;
    }

    public function VerificaDNI()
    {
        $datos = $_REQUEST['datos'];
        $datos = json_decode($datos, true);
        $info = $this->model->VerificaDNI($datos);
        echo json_encode($info);
    }

    public function GetHijos()
    {
        $datos = $_REQUEST['datos'];
        $datos = json_decode($datos, true);
        $hijos = $this->model->GetHijos($datos);
        echo json_encode($hijos);
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
            $mensaje = $this->model->ActualizaImageApoderado($id, $path);
        }
        
        echo $mensaje;
    }

}
?>