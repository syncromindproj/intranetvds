<?PHP
include_once 'models/participante.php';

class ParticipanteModel extends Model{
    public function __construct(){
        parent::__construct();
    }

    public function get(){
        $items = [];

        try{
            $query = $this->db->connect()->query("select case p.aprobado when 0 then 'PENDIENTE' when 1 then 'APROBADO' end as aprobado, p.idparticipante as DT_RowId,p.nombres, p.apellidos, a.fecha, DATE_FORMAT(a.fecha, '%d/%m/%Y') as fecha2, a.hora, p.correo_postulante, p.celular_postulante, p.fecha_nacimiento, p.edad, p.distrito, p.centro_estudios, p.anio_estudios, p.nombre_apoderado, p.celular_apoderado, p.correo_apoderado
            from participantes p
            left join participante_audicion pa
            on p.idparticipante = pa.idparticipante
            left join audiciones a
            on pa.idaudicion = a.idaudicion
            where p.aprobado = 0
            order by p.apellidos asc,
            hora asc, aprobado desc");

            while($row =  $query->fetch()){
                /*$item = new Participante();
                $item->idparticipante = $row['idparticipante'];
                $item->nombres = $row['nombres'];
                $item->apellidos = $row['apellidos'];
                $item->correo_postulante = $row['correo_postulante'];
                $item->celular_postulante = $row['celular_postulante'];
                $item->fecha_nacimiento = $row['fecha_nacimiento'];
                $item->edad = $row['edad'];
                $item->distrito = $row['distrito'];
                $item->centro_estudios = $row['centro_estudios'];
                $item->anio_estudios = $row['anio_estudios'];
                $item->nombre_apoderado = $row['nombre_apoderado'];
                $item->celular_apoderado = $row['celular_apoderado'];
                $item->correo_apoderado = $row['correo_apoderado'];
                $item->aprobado = $row['aprobado'];
                $item->estado = $row['estado'];

                array_push($items, $item);*/
                $items['data'][] = $row;
            }
            
            return $items;
        }catch(PDOException $e){
            return [];
        }
    }

    public function Aprobar($data){
        try{
            for($x=0;$x<count($data);$x++){
                $sql = "update participantes set aprobado = 1 where idparticipante='".$data[$x]."'";
                $query = $this->db->connect()->query($sql);
            }
            return count($data);
            //echo(json_encode(count($data)));
        }catch(PDOException $e){
            return [];
        }
    }
}
?>