<?PHP
class MultimediaAlumnoModel extends Model
{
    function __construct(){
        parent::__construct();
    }

    public function ListaMultimedia($datos)
    {
        $items = [];

        try{
            $query = $this->db->connect()->prepare("
            SELECT 
            m.idmultimedia,
            m.titulo,
            m.url,
            m.comentario,
            m.aprobado
            FROM 
            multimedia m
            inner join multimedia_alumno ma
            on m.idmultimedia = ma.idmultimedia
            and ma.idalumno = :idalumno");
            $query->execute([
                'idalumno'        => $datos['idalumno']
            ]);

            while($row =  $query->fetch()){
                $items['data'][] = $row;
            }

            if(count($items) == 0){
                $items['data'] = "";
            }
            
            return $items;
        }catch(PDOException $e){
            return $e->getCode();
        }
    }

    function GuardarMultimedia($datos)
    {
        try{
            $con = $this->db->connect();
            $query = $this->db->connect()->prepare('call inserta_multimedia_alumno
            (:titulo, :descripcion, :url, :idalumno, :idregistro)');
            $query->execute([
                'titulo'            => $datos['titulo'],
                'descripcion'       => $datos['descripcion'],
                'url'               => $datos['url'],
                'idalumno'          => $datos['idalumno'],
                'idregistro'          => $datos['idregistro']
            ]);
            $latest_id = $con->lastInsertId();
            return $latest_id;
        }catch(PDOException $e){
            return $e->getCode();
            //die(parent::outputPDOerror($e->getCode()));
        }
    }

    function EliminaMultimedia($id, $idalumno)
    {
        $archivo = "";
        
        try{
            $query = $this->db->connect()->prepare('delete from multimedia where idmultimedia = :id');
            $query->execute([
                'id'   => $id
            ]);

            $query = $this->db->connect()->prepare('delete from multimedia_alumno where idmultimedia = :id and idalumno = :idalumno');
            $query->execute([
                'id'   => $id,
                'idalumno'   => $idalumno
            ]);

            return "Eliminado";    
            
        }catch(PDOException $e){
            return $e->getMessage();
            
        }
    }

    function EliminaMultimediaSingle($id)
    {
        $archivo = "";
        
        try{
            $query = $this->db->connect()->prepare('delete from multimedia where idmultimedia = :id');
            $query->execute([
                'id'   => $id
            ]);

            $query = $this->db->connect()->prepare('delete from multimedia_alumno where idmultimedia = :id');
            $query->execute([
                'id'   => $id
            ]);

            return "Eliminado";    
            
        }catch(PDOException $e){
            return $e->getMessage();
            
        }
    }

    public function EnviarNotificaciones($datos){
        try{
            $correos_profes    = "";
            
            //CORREO PROFES
            $query = $this->db->connect()->prepare('
            SELECT
            d.correo
            from docente d
            inner join grupo_docente gd
            on gd.iddocente = d.iddocente
            inner join grupo_participante gp
            on gp.idgrupo = gd.idgrupo
            inner join participantes p
            on p.idparticipante = gp.idparticipante
            inner join grupo g
            on g.idgrupo = gd.idgrupo
            where p.idparticipante = :idparticipante
            ');
            $query->execute([
                'idparticipante' => $datos['idparticipante']
            ]);

            while($row =  $query->fetch()){
                $correos_profes .= $row['correo'] . ",";
            }
            $correos_profes = substr($correos_profes, 0, (strlen($correos_profes) - 1));

            $from_email     = 'administracion@vocesdelsol.com'; 
            $to             = ''; 
            $subject        = 'Voces del Sol - Nuevo material multimedia publicado por el alumno'; 
            
            $htmlContent = '<h1>Voces del Sol - Nuevo Material Multimedia Publicado</h1>
                <p>Uno de tus alumnos ha publicado un nuevo material multimedia para que pueda ser revisado.</p>
                <p>Por favor ingresa a la Intranet de Voces del Sol para poder revisarlo.</p>
                <p><a href="https://vocesdelsol.com/intranet/">https://vocesdelsol.com/intranet/</a></p>';

            $correos = $correos_profes;
            //header for sender info
            $headers = "From: ".$from_email;
            $headers .= "\nBcc: ".$correos;

            //boundary 
            $semi_rand = md5(time()); 
            $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x"; 

            //headers for attachment 
            $headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\""; 

            //multipart boundary 
            $message = "--{$mime_boundary}\n" . "Content-Type: text/html; charset=\"UTF-8\"\n" .
            "Content-Transfer-Encoding: 7bit\n\n" . $htmlContent . "\n\n"; 

            $message .= "--{$mime_boundary}--";
            $returnpath = "-f" . $from_email;

            //send email
            $mail = @mail($to, $subject, $message, $headers, $returnpath); 
        
            return 'Notificaciones Enviadas';

        }catch(PDOException $e){
            return $e->getCode();
        }
    }

    public function getRegistros(){
        $items = [];

        try{
            $query = $this->db->connect()->query("select * from registro where estado=1 order by descripcion asc");

            while($row =  $query->fetch()){
                $items['data'][] = $row;
            }

            if(count($items) == 0){
                $items['data'] = "";
            }
            
            return $items;
        }catch(PDOException $e){
            return [];
        }
    }
}
?>