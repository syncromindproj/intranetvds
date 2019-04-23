<?PHP
class PerfilController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    function render()
    {
        //$grupos = $this->model->get();
        //$this->view->grupos = $grupos;
        $this->view->title = "Perfil";
        $this->view->subtitle = "Mi Perfil";
        $this->view->render('perfil/index');
    }
}
?>