<?PHP
class MaterialModel extends Model
{
    function __construct()
    {
        parent::__construct();
    }

    public function ListaMateriales($datos)
    {
        $items = [];

        try{
            $query = $this->db->connect()->prepare("
            SELECT 
            m.idmaterial,
            m.titulo,
            m.url,
            COALESCE(g.descripcion, 'SINGRUPO') as grupo
            FROM 
            material m
            left join material_grupo mg
            on mg.idmaterial = m.idmaterial
            left join grupo g
            on g.idgrupo = mg.idgrupo");
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

    function InsertaMaterial($url, $titulo, $descripcion)
    {
        try{
            
            $query = $this->db->connect()->prepare('insert into material (titulo, url, descripcion)
            values (:titulo, :url, :descripcion)');
            $query->execute([
                'titulo'        => $titulo,
                'url'           => $url,
                'descripcion'   => $descripcion
            ]);
            return "Material Insertado";
        }catch(PDOException $e){
            return $e->getCode();
            //die(parent::outputPDOerror($e->getCode()));
        }
    }

    function EliminaMaterial($id)
    {
        $archivo = "";
        
        try{
            $query = $this->db->connect()->prepare('select url from material where idmaterial = :id');
            $query->execute([
                'id'   => $id
            ]);

            while($row =  $query->fetch()){
                $archivo = $row['url'];
            }

            $query = $this->db->connect()->prepare('delete from material where idmaterial = :id');
            $query->execute([
                'id'   => $id
            ]);

            $query = $this->db->connect()->prepare('delete from material_grupo where idmaterial = :id');
            $query->execute([
                'id'   => $id
            ]);

            if (file_exists($archivo)) {
                unlink($archivo);
            }

            return $archivo;    
            
        }catch(PDOException $e){
            return $e->getMessage();
            
        }
    }

    function AsignarGrupo($datos)
    {
        try{
            $correos_postulantes    = "";
            $correos_padres         = "";
            $archivo = "";

            $query = $this->db->connect()->prepare('insert into material_grupo (idmaterial, idgrupo)
            values (:idmaterial, :idgrupo) ');
            $query->execute([
                'idmaterial' => $datos['idmaterial'],
                'idgrupo'    => $datos['idgrupo']
            ]);

            //CORREO POSTULANTES
            $query = $this->db->connect()->prepare('
            select 
            p.correo_postulante,
            m.url
            from grupo_participante gp
            inner join participantes p
            on p.idparticipante = gp.idparticipante
            inner join grupo g
            on g.idgrupo=gp.idgrupo
            inner join material_grupo mg
            on mg.idgrupo = g.idgrupo
            inner join material m
            on m.idmaterial = mg.idmaterial
            where g.idgrupo=:idgrupo
            ');
            $query->execute([
                'idgrupo' => $datos['idgrupo']
            ]);

            while($row =  $query->fetch()){
                $correos_postulantes .= $row['correo_postulante'] . ",";
                $archivo = $row['url'];
            }
            $correos_postulantes = substr($correos_postulantes, 0, (strlen($correos_postulantes) - 1));

            //CORREO PADRES
            $query = $this->db->connect()->prepare('
            select 
            distinct a.correo,
            m.url
            from grupo_participante gp
            inner join participantes p
            on p.idparticipante = gp.idparticipante
            inner join grupo g
            on g.idgrupo=gp.idgrupo
            inner join material_grupo mg
            on mg.idgrupo = g.idgrupo
            inner join material m
            on m.idmaterial = mg.idmaterial
            inner join apoderado_alumno aa
            on aa.idparticipante = p.idparticipante
            inner join apoderado a
            on a.idapoderado = aa.idapoderado
            where g.idgrupo=:idgrupo');
            $query->execute([
                'idgrupo' => $datos['idgrupo']
            ]);

            while($row =  $query->fetch()){
                $correos_padres .= $row['correo'] . ",";
                $archivo = $row['url'];
            }
            $correos_padres = substr($correos_padres, 0, (strlen($correos_padres) - 1));

            $from_email     = 'administracion@vocesdelsol.com'; 
            $to             = ''; 
            $subject        = 'Voces del Sol - Nuevo Material Publicado'; 
            $file           = $archivo;

            $htmlContent = '<h1>Voces del Sol - Nuevo Material Publicado</h1>
                <p>En el archivo adjunto puede ver el material publicado por el profesor asignado de Voces del Sol.</p>';

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
        
            return 'Grupo Asignado';

        }catch(PDOException $e){
            return $e->getCode();
        }
    }

    public function GetMaterialByParticipante($datos)
    {
        $items = [];
        try{
            $query = $this->db->connect()->prepare('
            SELECT 
            m.* 
            FROM grupo_participante gp
            inner join material_grupo mg
            on mg.idgrupo = gp.idgrupo
            inner join material m
            on m.idmaterial = mg.idmaterial
            where gp.idparticipante = :idparticipante');
            $query->execute([
                'idparticipante' => $datos['idalumno']
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
}
?>