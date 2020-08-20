<?php
require 'vendor/autoload.php';
use Aws\S3\S3Client;
use Aws\Exception\AwsException;

class MultimediaController extends Controller{
    function __construct(){
        parent::__construct();
        
    }

    function render(){
        $this->view->title = "Multimedia";
        $this->view->subtitle = "Listado de Archivos";
        $this->view->render('multimedia/index');
    }

    public function ListaMultimedia()
    {
        $datos = $_REQUEST['datos'];
        $datos = json_decode($datos, true);
        $multimedia = $this->model->ListaMultimedia($datos);
        echo json_encode($multimedia);
    }

    public function S3(){
        $S3Options = [
            'version' => 'latest',
            'region'  => constant('AWS_REGION'),
            'credentials' => 
            [
                'key' => constant('AWS_ACCESS_KEY'),
                'secret' => constant('AWS_SECRET')
            ]
        ];
        $s3 = new S3Client($S3Options);
    
        if(isset($_FILES['archivo'])){
            $uploadObject = $s3->putObject([
                'Bucket' => constant('AWS_BUCKET'),
                'Key' => $_FILES['archivo']['name'],
                'SourceFile' => $_FILES['archivo']['tmp_name']
            ]);
    
            //print_r($uploadObject);
            print_r($_FILES['archivo']['name']);
        }
    }

    public function GuardarMultimedia()
    {
        $datos = $_REQUEST['datos'];
        $datos = json_decode($datos, true);
        $multimedia = $this->model->GuardarMultimedia($datos);
        echo(json_encode($multimedia));
        
    }

    public function EliminaS3Object()
    {
        $datos = $_REQUEST['datos'];
        $datos = json_decode($datos, true);

        $S3Options = [
            'version' => 'latest',
            'region'  => constant('AWS_REGION'),
            'credentials' => 
            [
                'key' => constant('AWS_ACCESS_KEY'),
                'secret' => constant('AWS_SECRET')
            ]
        ];
        $bucket = constant('AWS_BUCKET');
        $s3 = new S3Client($S3Options);

        try
        {
            $result = $s3->deleteObject([
                'Bucket' => $bucket,
                'Key'    => $datos['url']
            ]);

            echo("Eliminado S3");
            
        }
        catch (S3Exception $e) {
            exit('Error: ' . $e->getAwsErrorMessage() . PHP_EOL);
        }

    }

    public function EliminaMultimedia()
    {
        $datos = $_REQUEST['datos'];
        $datos = json_decode($datos, true);
        $multimedia = $this->model->EliminaMultimedia($datos["id"], $datos["iddocente"]);
        echo json_encode($multimedia);
        
    }

    public function S3GetObject(){
        $datos = $_REQUEST['datos'];
        $datos = json_decode($datos, true);
        $key = $datos['key'];
        
        $S3Options = [
            'version' => 'latest',
            'region'  => constant('AWS_REGION'),
            'credentials' => 
            [
                'key' => constant('AWS_ACCESS_KEY'),
                'secret' => constant('AWS_SECRET')
            ]
        ];
        $bucket = constant('AWS_BUCKET');
        $s3 = new S3Client($S3Options);
    
        try {
            $cmd = $s3->getCommand('GetObject', [
                'Bucket' => $bucket,
                'Key'    => $key
            ]);
            $signed_url = $s3->createPresignedRequest($cmd, '+20 minutes');
            $ext = pathinfo($datos['key'], PATHINFO_EXTENSION);
            $link = (string)$signed_url->getUri();

            $data = [
                "url" => $link,
                "extension" => $ext
            ];
            echo json_encode($data);

    
        } catch (S3Exception $e) {
            echo $e->getMessage() . PHP_EOL;
        }
    }

    public function AsignaGrupo()
    {
        $datos = $_REQUEST['datos'];
        $datos = json_decode($datos, true);
        $grupos = $this->model->AsignaGrupo($datos);
        echo "Asignacion Realizada";
    }

    public function GetMultimediaByGrupo()
    {
        $datos = $_REQUEST['datos'];
        $datos = json_decode($datos, true);
        $materiales = $this->model->GetMultimediaByGrupo($datos);
        echo json_encode($materiales);
    }

    public function EnviarNotificaciones()
    {
        $datos = $_REQUEST['datos'];
        $datos = json_decode($datos, true);
        $respuesta = $this->model->EnviarNotificaciones($datos);
        echo json_encode($respuesta);
    }
}
?>