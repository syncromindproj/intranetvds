<?PHP
class Datos_HijosController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    function render()
    {
        $this->view->title = "Datos de Hijos";
        $this->view->subtitle = "Listado";
        $this->view->render("datos_hijos/index");
    }
}
?>