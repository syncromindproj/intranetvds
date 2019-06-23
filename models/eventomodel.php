<?PHP
class EventoModel extends Model
{
    function __construct()
    {
        parent::__construct();
    }

    public function ListaEventos()
    {
        $items = [];
        try{
            $query = $this->db->connect()->query("
            SELECT 
            e.*, 
            DATE_FORMAT(e.fecha, '%d/%m/%Y') as fecha_evento, 
            DATE_FORMAT(e.hora, '%r') as hora_evento, 
            count(ea.idalumno) cantidad,
            (select 
             count(ea.autorizacion)
             from evento_alumno ea
             where ea.autorizacion=1
            ) as autorizados
            from evento e
            left join evento_alumno ea
            on ea.idevento = e.idevento 
            where e.estado=1 
            group by e.idevento");

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

    public function GetEventoByParticipante($datos)
    {
        $items = [];
        try{
            $query = $this->db->connect()->prepare('
            SELECT 
            e.titulo,
            e.descripcion,
            DATE_FORMAT(e.fecha,"%d/%m/%Y") as fecha,
            e.hora
            FROM evento e
            inner join evento_alumno ea
            on ea.idevento = e.idevento
            where ea.idalumno = :idalumno
            and ea.autorizacion = 1
            order by e.fecha desc');
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

    public function RegistrarEvento($datos)
    {
        try{
            $query = $this->db->connect()->prepare('insert into evento (titulo, descripcion, fecha, hora)
            values (:titulo, :descripcion, :fecha, :hora)');
            $query->execute([
                'titulo'        => $datos['titulo'],
                'descripcion'   => $datos['descripcion'],
                'fecha'         => $datos['fecha'],
                'hora'          => $datos['hora']
            ]);

            return "Evento Insertado";
        }catch(PDOException $e){
            return $e->getCode();
            //die(parent::outputPDOerror($e->getCode()));
        }
    }

    public function EliminaEvento($datos)
    {
        $query = $this->db->connect()->prepare('delete from evento_alumno where idevento=:idevento');
        $query->execute([
            'idevento'  => $datos['idevento']
        ]);

        $query = $this->db->connect()->prepare('delete from evento where idevento=:idevento');
        $query->execute([
            'idevento'  => $datos['idevento']
        ]);
    }

    function AsignarEvento($datos)
    {
        try{
            $query = $this->db->connect()->prepare('delete from evento_alumno where idevento = :idevento');
            $query->execute([
                'idevento'    => $datos['idevento'],
            ]);

            for($x=0;$x<count($datos['alumnos']);$x++){
                $query = $this->db->connect()->prepare('insert into evento_alumno (idevento, idalumno)
                values (:idevento, :idalumno) ');
                $query->execute([
                    'idevento'    => $datos['idevento'],
                    'idalumno'    => $datos['alumnos'][$x]
                ]);
            }
            
            return 'Evento Asignado';

        }catch(PDOException $e){
            return $e->getCode();
        }
    }
}
?>