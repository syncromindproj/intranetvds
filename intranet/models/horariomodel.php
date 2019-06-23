<?PHP
class HorarioModel extends Model
{
    function __construct()
    {
        parent::__construct();
    }

    public function GetHorarios()
    {
        $items = [];

        try{
            /*$query = $this->db->connect()->query("SELECT 
            g.idgrupo, g.descripcion as grupo, COALESCE(h.descripcion,'SIN HORARIO ASIGNADO', h.descripcion) as horario
            FROM grupo g
            left join horario h
            on g.idgrupo = h.idgrupo
            order by g.descripcion asc");*/
            $query = $this->db->connect()->query("
            SELECT h.idhorario, g.descripcion as grupo, h.descripcion
            FROM horario h 
            inner join grupo g
            on g.idgrupo = h.idgrupo");

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

    public function GetHorarioDetalle($datos)
    {
        $items = [];

        try{
            $query = $this->db->connect()->prepare("
            SELECT idhorario_detalle, idhorario, 
            case 
            when dia = 1 then 'LUNES' 
            when dia = 2 then 'MARTES'
            when dia = 3 then 'MIERCOLES'
            when dia = 4 then 'JUEVES' 
            when dia = 5 then 'VIERNES'
            when dia = 6 then 'SABADO' 
            when dia = 7 then 'DOMINGO' end as dia_str,
            hora_inicio, hora_fin from horario_detalle where idhorario = :idhorario order by dia asc");
            $query->execute([
                'idhorario'       => $datos['idhorario']
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

    public function InsertaHorario($datos)
    {
        try{
            $query = $this->db->connect()->prepare('insert into horario (idgrupo, descripcion) values (:idgrupo, :descripcion)');
            $query->execute([
                'idgrupo'       => $datos['idgrupo'],
                'descripcion'   => $datos['descripcion']
            ]);
        }catch(PDOException $e){
            return $e->getCode();
        } 
    }

    public function AsignarHorario($datos)
    {
        try{
            $query = $this->db->connect()->prepare('insert into horario_detalle (idhorario, dia, hora_inicio, hora_fin) values (:idhorario, :dia, :hora_inicio, :hora_final)');
            $query->execute([
                'idhorario'     => $datos['idhorario'],
                'dia'           => $datos['dia'],
                'hora_inicio'   => $datos['hora_inicio'],
                'hora_final'    => $datos['hora_final']
            ]);
        }catch(PDOException $e){
            return $e->getCode();
        } 
    }

    public function EliminarDetalle($datos)
    {
        try{
            $query = $this->db->connect()->prepare('delete from horario_detalle where idhorario_detalle = :idhorario_detalle');
            $query->execute([
                'idhorario_detalle'     => $datos['id']
            ]);
        }catch(PDOException $e){
            return $e->getCode();
        } 
    }
}
?>