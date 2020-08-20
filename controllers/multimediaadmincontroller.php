<?PHP
class MultimediaAdminController extends Controller
{
    function __construct(){
        parent::__construct();
    }

    function render(){
        $this->view->title = "Multimedia";
        $this->view->subtitle = "Listado de Archivos";
        $this->view->render('multimediaadmin/index');
    }

    public function ListaMultimedia()
    {
        $datos = $_REQUEST['datos'];
        $datos = json_decode($datos, true);
        $multimedia = $this->model->ListaMultimedia($datos);
        echo json_encode($multimedia);
    }

    public function EliminaMultimedia()
    {
        $datos = $_REQUEST['datos'];
        $datos = json_decode($datos, true);
        $multimedia = $this->model->EliminaMultimedia($datos["id"]);
        echo json_encode($multimedia);
        
    }
}

?>