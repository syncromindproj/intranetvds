<?PHP
class MultimediaPracticaModel extends Model
{
    function __construct(){
        parent::__construct();
    }

    public function ListaMultimedia($datos)
    {
        $items = [];

        try{
            $query = $this->db->connect()->prepare("select
            m.idmultimedia,
            m.titulo,
            m.url,
            m.comentario,
            m.aprobado,
            concat(p.nombres, ' ', p.apellidos) as nombres
            from multimedia m
            inner JOIN multimedia_alumno ma
            on ma.idmultimedia = m.idmultimedia
            inner join participantes p
            on p.idparticipante = ma.idalumno 
            where ma.idalumno in (
            select idalumno
            from multimedia_alumno
            where idalumno in (
            select p.idparticipante 
            from participantes p
            inner join grupo_participante gp
            on gp.idparticipante = p.idparticipante
            where gp.idgrupo in (
            select idgrupo
            from grupo_docente
            where iddocente=:iddocente)))");
            $query->execute([
                'iddocente' => $datos['iddocente']
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

    function GuardarComentario($file, $idmultimedia)
    {
        try{
            
            $query = $this->db->connect()->prepare('update multimedia set comentario = :comentario where idmultimedia = :idmultimedia');
            $query->execute([
                'comentario'    => $file,
                'idmultimedia'  => $idmultimedia,
            ]);
            return "Comentario Insertado";
        }catch(PDOException $e){
            return $e->getCode();
            //die(parent::outputPDOerror($e->getCode()));
        }
    }

    function Aprobar($id, $estado)
    {
        try{
            
            $query = $this->db->connect()->prepare('update multimedia set aprobado = :aprobado where idmultimedia = :idmultimedia');
            $query->execute([
                'aprobado'      => $estado,
                'idmultimedia'  => $id,
            ]);
            return "Trabajo Aprobado";
        }catch(PDOException $e){
            return $e->getCode();
            //die(parent::outputPDOerror($e->getCode()));
        }
    }

    function EliminaComentario($id)
    {
        $archivo = '';
        try{
            $query = $this->db->connect()->prepare('select comentario from multimedia where idmultimedia = :id');
            $query->execute([
                'id'   => $id
            ]);

            while($row =  $query->fetch()){
                $archivo = $row['comentario'];
            }
            
            $query = $this->db->connect()->prepare('update multimedia set comentario = "" where idmultimedia = :idmultimedia');
            $query->execute([
                'idmultimedia'  => $id,
            ]);

            $path   = 'views/uploads/audios/' . $archivo;
            if (file_exists($path)) {
                unlink($path);
            }

            return "Comentario Eliminado";
        }catch(PDOException $e){
            return $e->getCode();
            //die(parent::outputPDOerror($e->getCode()));
        }
    }

    public function EnviarNotificaciones($datos){
        try{
            $correos_alumno    = "";
            
            //CORREO ALUMNO
            $query = $this->db->connect()->prepare('
            SELECT 
            p.correo_postulante
            from participantes p
            inner JOIN multimedia_alumno ma
            on ma.idalumno = p.idparticipante
            inner JOIN multimedia m
            on m.idmultimedia = ma.idmultimedia
            where m.idmultimedia = :idmultimedia
            ');
            $query->execute([
                'idmultimedia' => $datos['idmultimedia']
            ]);

            while($row =  $query->fetch()){
                $correos_alumno .= $row['correo_postulante'] . ",";
            }
            $correos_alumno = substr($correos_alumno, 0, (strlen($correos_alumno) - 1));

            $from_email     = 'administracion@vocesdelsol.com'; 
            $to             = ''; 
            $subject        = 'Voces del Sol - Nuevo comentario grabado por el profesor'; 
            
            $htmlContent = '<h1>Voces del Sol - Nuevo comentario grabado por el profesor</h1>
                <p>El profesor ha grabado un comentario acerca del material multimedia que publicaste en la Intranet.</p>
                <p>Por favor ingresa a la Intranet de Voces del Sol para poder revisarlo.</p>
                <p><a href="https://vocesdelsol.com/intranet/">https://vocesdelsol.com/intranet/</a></p>';

            $correos = $correos_alumno;
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

    public function EnviarNotificacionesAprobacion($datos){
        try{
            $correos_alumno    = "";
            
            //CORREO ALUMNO
            $query = $this->db->connect()->prepare('
            SELECT 
            p.correo_postulante
            from participantes p
            inner JOIN multimedia_alumno ma
            on ma.idalumno = p.idparticipante
            inner JOIN multimedia m
            on m.idmultimedia = ma.idmultimedia
            where m.idmultimedia = :idmultimedia
            ');
            $query->execute([
                'idmultimedia' => $datos['idmultimedia']
            ]);

            while($row =  $query->fetch()){
                $correos_alumno .= $row['correo_postulante'] . ",";
            }
            $correos_alumno = substr($correos_alumno, 0, (strlen($correos_alumno) - 1));

            $from_email     = 'administracion@vocesdelsol.com'; 
            $to             = ''; 
            $subject        = 'Voces del Sol - El profesor ha aprobado el trabajo que enviaste'; 
            
            $htmlContent = '<h1>Voces del Sol - El profesor ha aprobado el trabajo que enviaste.</h1>
                <p>El profesor, luego de haber revisado el material multimedia que enviaste, ha aprobado tu material multimedia.</p>
                <p>Por favor ingresa a la Intranet de Voces del Sol para poder revisarlo.</p>
                <p><a href="https://vocesdelsol.com/intranet/">https://vocesdelsol.com/intranet/</a></p>';

            $correos = $correos_alumno;
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
        
            return 'Notificaciones Enviadas: ' . $correos_alumno;

        }catch(PDOException $e){
            return $e->getCode();
        }
    }
}
?>