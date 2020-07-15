<?PHP
class ComunicadoModel extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getComunicados()
    {
        $items = [];

        try{
            $query = $this->db->connect()->prepare("
            select 
            c.idcomunicado, 
            c.url, 
            c.descripcion,
            COALESCE(ca.idcomunicado, '0') as asignado,
            count(ca.id_comunicadoalumno) as numero_alumnos,
            c.estado
            from comunicado c
            left join comunicado_alumno ca
            on ca.idcomunicado = c.idcomunicado
            group by c.idcomunicado");
            $query->execute();

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

    function InsertaComunicado($url, $descripcion)
    {
        try{
            
            $query = $this->db->connect()->prepare('insert into comunicado (url, descripcion)
            values (:url, :descripcion)');
            $query->execute([
                'url'           => $url,
                'descripcion'   => $descripcion
            ]);
            return "Comunicado Insertado";
        }catch(PDOException $e){
            return $e->getCode();
            //die(parent::outputPDOerror($e->getCode()));
        }
    }

    function AsignarComunicado($datos)
    {
        try{
            $query = $this->db->connect()->prepare('delete from comunicado_alumno where idcomunicado = :idcomunicado');
            $query->execute([
                'idcomunicado'    => $datos['idcomunicado'],
            ]);

            for($x=0;$x<count($datos['alumnos']);$x++){
                $query = $this->db->connect()->prepare('insert into comunicado_alumno (idcomunicado, idparticipante)
                values (:idcomunicado, :idparticipante) ');
                $query->execute([
                    'idcomunicado'      => $datos['idcomunicado'],
                    'idparticipante'    => $datos['alumnos'][$x]
                ]);
            }
            
            return 'Evento Asignado';

        }catch(PDOException $e){
            return $e->getCode();
        }
    }

    function EliminaComunicado($idcomunicado)
    {
        $archivo = "";
        
        try{
            $query = $this->db->connect()->prepare('select url from comunicado where idcomunicado = :idcomunicado');
            $query->execute([
                'idcomunicado'   => $idcomunicado
            ]);

            while($row =  $query->fetch()){
                $archivo = $row['url'];
            }

            $query = $this->db->connect()->prepare('delete from comunicado where idcomunicado = :idcomunicado');
            $query->execute([
                'idcomunicado'   => $idcomunicado
            ]);

            $query = $this->db->connect()->prepare('delete from comunicado_alumno where idcomunicado = :idcomunicado');
            $query->execute([
                'idcomunicado'   => $idcomunicado
            ]);

            if (file_exists($archivo)) {
                unlink($archivo);
            }

            return $archivo;    
            
        }catch(PDOException $e){
            return $e->getMessage();
            
        }
    }

    public function GetComunicadoByParticipante($datos)
    {
        $items = [];
        try{
            $query = $this->db->connect()->prepare('
            SELECT 
            p.nombres,
            p.apellidos,
            c.descripcion,
            c.url
            FROM comunicado c
            inner JOIN comunicado_alumno ca
            on ca.idcomunicado = c.idcomunicado
            inner join participantes p
            on p.idparticipante = ca.idparticipante
            where ca.idparticipante = :idalumno');
            $query->execute([
                'idalumno' => $datos['idalumno']
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

    public function EnviarComunicado($datos)
    {
        try{
            $correos_postulantes    = "";
            $correos_padres         = "";
            $archivo = "";
            $query = $this->db->connect()->prepare('
            update comunicado set estado = 0 where idcomunicado = :idcomunicado');
            $query->execute([
                'idcomunicado' => $datos['idcomunicado']
            ]);

            //CORREO POSTULANTES
            $query = $this->db->connect()->prepare('
            SELECT 
            p.correo_postulante,
            c.url
            FROM comunicado_alumno ca
            inner join participantes p
            on p.idparticipante = ca.idparticipante
            inner join comunicado c
            on c.idcomunicado = ca.idcomunicado
            where ca.idcomunicado=:idcomunicado
            ');
            $query->execute([
                'idcomunicado' => $datos['idcomunicado']
            ]);

            while($row =  $query->fetch()){
                $correos_postulantes .= $row['correo_postulante'] . ",";
                $archivo = $row['url'];
            }
            $correos_postulantes = substr($correos_postulantes, 0, (strlen($correos_postulantes) - 1));

            //CORREO PADRES
            $query = $this->db->connect()->prepare('
            SELECT 
            distinct a.correo,
            c.url
            FROM comunicado_alumno ca
            inner join participantes p
            on p.idparticipante = ca.idparticipante
            inner join comunicado c
            on c.idcomunicado = ca.idcomunicado
            inner JOIN apoderado_alumno aa
            on aa.idparticipante = p.idparticipante
            inner JOIN apoderado a
            on a.idapoderado = aa.idapoderado
            where ca.idcomunicado=:idcomunicado');
            $query->execute([
                'idcomunicado' => $datos['idcomunicado']
            ]);

            while($row =  $query->fetch()){
                $correos_padres .= $row['correo'] . ",";
                $archivo = $row['url'];
            }
            $correos_padres = substr($correos_padres, 0, (strlen($correos_padres) - 1));
            
            $from_email     = 'administracion@vocesdelsol.com'; 
            $to             = ''; 
            $subject        = 'Voces del Sol - Nuevo Comunicado'; 
            $file           = $archivo;

            $htmlContent = '<h1>Voces del Sol - Nuevo Comunicado</h1>
                <p>En el archivo adjunto puede ver el comunicado publicado por la administración de Voces del Sol.</p>';

            $correos = $correos_postulantes.",".$correos_padres;
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

            //preparing attachment
            if(!empty($file) > 0){
                if(is_file($file)){
                    $message .= "--{$mime_boundary}\n";
                    $fp =    @fopen($file,"rb");
                    $data =  @fread($fp,filesize($file));

                    @fclose($fp);
                    $data = chunk_split(base64_encode($data));
                    $message .= "Content-Type: application/octet-stream; name=\"".basename($file)."\"\n" . 
                    "Content-Description: ".basename($file)."\n" .
                    "Content-Disposition: attachment;\n" . " filename=\"".basename($file)."\"; size=".filesize($file).";\n" . 
                    "Content-Transfer-Encoding: base64\n\n" . $data . "\n\n";
                }
            }
            $message .= "--{$mime_boundary}--";
            $returnpath = "-f" . $from_email;

            //send email
            $mail = @mail($to, $subject, $message, $headers, $returnpath); 
            
            return "Comunicado enviado";
        }catch(PDOException $e){
            return $e->getCode();
        }
    }
}
?>