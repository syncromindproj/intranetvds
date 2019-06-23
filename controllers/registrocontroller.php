<?PHP
class RegistroController extends Controller
{
    function __construct()
    {
        parent::__construct();
    }

    function render()
    {
        $this->view->title = "Registro";
        $this->view->subtitle = "Registro";
        $this->view->render("registro/index");
    }
}
?>