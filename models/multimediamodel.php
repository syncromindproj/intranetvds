<?php
class MultimediaModel extends Model
{
    function __construct()
    {
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
            coalesce(GROUP_CONCAT(g.descripcion), 'SIN GRUPO') as grupo,
            m.url
            FROM 
            multimedia m
            left join multimedia_grupo mg
            on mg.idmultimedia = m.idmultimedia
            left join grupo g
            on g.idgrupo = mg.idgrupo
            inner join multimedia_docente md
            on md.iddocente = :iddocente
            and m.idmultimedia = md.idmultimedia
            group by m.idmultimedia");
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

    function GuardarMultimedia($datos)
    {
        try{
            
            $query = $this->db->connect()->prepare('call inserta_multimedia_docente
            (:titulo, :descripcion, :url, :iddocente)');
            $query->execute([
                'titulo'            => $datos['titulo'],
                'descripcion'       => $datos['descripcion'],
                'url'               => $datos['url'],
                'iddocente'         => $datos['iddocente']
            ]);
            return "Multimedia Insertado";
        }catch(PDOException $e){
            return $e->getCode();
            //die(parent::outputPDOerror($e->getCode()));
        }
    }

    public function AsignaGrupo($datos){
        /*$idmultimedia_grupo = "";
        $query = $this->db->connect()->prepare('select idmultimedia_grupo from multimedia_grupo where idmultimedia = :idmultimedia');
        $query->execute([
            'idmultimedia'    => $datos['idmultimedia']
        ]);
        while($row =  $query->fetch()){
            $idmultimedia_grupo = $row['idmultimedia_grupo'];
        }
        
        if($idmultimedia_grupo == ""){
            $query = $this->db->connect()->prepare('insert into multimedia_grupo (idgrupo, idmultimedia) values (:idgrupo, :idmultimedia)');
            $query->execute([
                'idgrupo'           => $datos['idgrupo'],
                'idmultimedia'      => $datos['idmultimedia']
            ]);
        }else{
            $query = $this->db->connect()->prepare('update multimedia_grupo set idgrupo = :idgrupo where idmultimedia_grupo = :idmultimedia_grupo');
            $query->execute([
                'idgrupo'               => $datos['idgrupo'],
                'idmultimedia_grupo'    => $idmultimedia_grupo
            ]);
        }*/
        $query = $this->db->connect()->prepare('insert into multimedia_grupo (idgrupo, idmultimedia) values (:idgrupo, :idmultimedia)');
        $query->execute([
            'idgrupo'           => $datos['idgrupo'],
            'idmultimedia'      => $datos['idmultimedia']
        ]);
    }

    function EliminaMultimedia($id, $iddocente)
    {
        $archivo = "";
        
        try{
            $query = $this->db->connect()->prepare('delete from multimedia where idmultimedia = :id');
            $query->execute([
                'id'   => $id
            ]);

            $query = $this->db->connect()->prepare('delete from multimedia_docente where idmultimedia = :id and iddocente = :iddocente');
            $query->execute([
                'id'   => $id,
                'iddocente' => $iddocente
            ]);

            return "Eliminado";    
            
        }catch(PDOException $e){
            return $e->getMessage();
            
        }
    }

    public function GetMultimediaByGrupo($datos)
    {
        $items = [];
        try{
            $query = $this->db->connect()->prepare('
            SELECT 
            m.* ,
            mg.idgrupo
            from multimedia m
            inner join multimedia_grupo mg
            on m.idmultimedia = mg.idmultimedia
            and mg.idgrupo = :idgrupo');
            $query->execute([
                'idgrupo' => $datos['idgrupo']
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

    public function EnviarNotificaciones($datos){
        try{
            $correos_postulantes    = "";
            
            //CORREO POSTULANTES
            $query = $this->db->connect()->prepare('
            select 
            p.correo_postulante,
            p.nombres,
            p.apellidos
            from grupo_participante gp
            inner join participantes p
            on p.idparticipante = gp.idparticipante
            inner join grupo g
            on g.idgrupo=gp.idgrupo
            where g.idgrupo=:idgrupo
            ');
            $query->execute([
                'idgrupo' => $datos['idgrupo']
            ]);

            while($row =  $query->fetch()){
                $correos_postulantes .= $row['correo_postulante'] . ",";
            }
            $correos_postulantes = substr($correos_postulantes, 0, (strlen($correos_postulantes) - 1));

            $from_email     = 'administracion@vocesdelsol.com'; 
            $to             = ''; 
            $subject        = 'Voces del Sol - Nuevo Material Multimedia Publicado'; 
            
            $htmlContent = '<h1>Voces del Sol - Nuevo Material Multimedia Publicado</h1>
                <p>El profesor ha publicado un nuevo material multimedia para que pueda ser revisado.</p>
                <p>Por favor ingresa a la Intranet de Voces del Sol para poder revisarlo.</p>
                <p><a href="https://vocesdelsol.com/intranet/">https://vocesdelsol.com/intranet/</a></p>';

            $correos = $correos_postulantes;
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
}
?>