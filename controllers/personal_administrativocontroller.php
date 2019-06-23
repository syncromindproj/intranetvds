<?PHP
class Personal_AdministrativoController extends Controller
{
    function __construct()
    {
        parent::__construct();
    }

    function render()
    {
        $this->view->title = "Personal Académico y Administrativo";
        $this->view->subtitle = "Personal Académico y Administrativo";
        $this->view->render('personal_administrativo/index');
    }

    public function ListaPersonalAdm()
    {
        $personal = $this->model->ListaPersonalAdm();
        echo(json_encode($personal));
    }
}
?>