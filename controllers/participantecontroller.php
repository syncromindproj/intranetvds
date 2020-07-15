<?PHP
class ParticipanteController extends Controller{
    function __construct(){
        parent::__construct(); 
        $this->view->participantes = [];
    }

    function render(){
        $participantes = $this->model->get();
        $this->view->participantes = $participantes;
        $this->view->render('participante/index');
    }

    public function getParticipantes()
    {
        $participantes = $this->model->get();
        echo(json_encode($participantes));
    }

    public function Aprobar(){
        $data = $_REQUEST['data'];
		$resultado = $this->model->Aprobar($data);
		echo(json_encode($resultado));
    }

    public function InsertaAlumno()
    {
        $datos = $_REQUEST['datos'];
        $datos = json_decode($datos, true);
        $id = $this->model->InsertaAlumno($datos);
        echo(json_encode($id));
    }

    public function EnviaCorreo()
    {
        $datos = $_REQUEST['datos'];
        $datos = json_decode($datos, true);
        $mensaje = "";
        $madre = json_decode($datos['madre'], true);
        $padre = json_decode($datos['padre'], true);
        
        $mensaje .= "<p>Registro de Alumno</p>";
        $mensaje .= "<p>Gracias por registrarte en le Intranet de Voces del Sol. Se han registrado las siguientes personas:</p>";
        if(count($madre)>0){
            $mensaje .= "<p><b>MADRE</b></p>";
            $mensaje .= "<p>Nombres: ".$madre['nombres']."</p>";
            $mensaje .= "<p>Apellidos: ".$madre['apellidos']."</p>";
            $mensaje .= "<p>DNI: ".$madre['dni']."</p>";
        }
        if(count($padre)>0){
            $mensaje .= "<p><b>PADRE</b></p>";
            $mensaje .= "<p>Nombres: ".$padre['nombres']."</p>";
            $mensaje .= "<p>Apellidos: ".$padre['apellidos']."</p>";
            $mensaje .= "<p>DNI: ".$padre['dni']."</p>";
        }
        if(count($datos['hijos'])>0){
            $mensaje .= "<p><b>HIJOS</b></p>";
            
            for($x=0;$x<count($datos['hijos']);$x++){
                $mensaje .= "<p>Nombres: ".$datos['hijos'][$x]['txt_nombres']."</p>";
                $mensaje .= "<p>Apellidos: ".$datos['hijos'][$x]['txt_apellidos']."</p>";
                $mensaje .= "<p>DNI: ".$datos['hijos'][$x]['txt_dni']."</p>";
            }
        }

        $to = "crheineck@vocesdelsol.com, administracion@vocesdelsol.com, alejandro.diaz@syncromind.net"; 
		//$to = "alejandro.diaz@syncromind.net"; 
		$from = "audiciones@vocesdelsol.com"; 
		$subject = "Registro de Alumno"; 
        $message = "<p>Registro de Alumno</p>";
        
        $separator = md5(time());
        $eol = PHP_EOL;
        $headers  = "From: ".$from.$eol;
		//$headers .= "CC: ".$correo_postulante.",".$mail_apoderado.$eol;
		$headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
		
        $body .= $mensaje;
		
		mail($to, $subject, $body, $headers);
    }

    public function GetHijosPorApoderado()
    {
        $datos = $_REQUEST['datos'];
        $datos = json_decode($datos, true);
        $hijos = $this->model->GetHijosPorApoderado($datos);
        echo json_encode($hijos);
    }
}

?>