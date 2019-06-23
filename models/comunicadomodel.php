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
            c.descripcion,
            c.url
            FROM comunicado c
            inner JOIN comunicado_alumno ca
            on ca.idcomunicado = c.idcomunicado
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
            $query = $this->db->connect()->prepare('
            update comunicado set estado = 0 where idcomunicado = :idcomunicado');
            $query->execute([
                'idcomunicado' => $datos['idcomunicado']
            ]);
            
            return "Comunicado enviado";
        }catch(PDOException $e){
            return $e->getCode();
        }
    }
}
?>