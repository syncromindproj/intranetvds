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

    public function InsertaAlumno($datos){
        $items = [];
        try{
            $time               = $datos['txt_nacimiento'];
            $date               = str_replace('/', '-', $time);
            $fecha_nacimiento   = date("Y-m-d", strtotime($date));

            $time               = $datos['txt_seguro_caducidad'];
            $date               = str_replace('/', '-', $time);
            $seguro_caducidad   = date("Y-m-d", strtotime($date));
            
            $query = $this->db->connect()->prepare("
            call inserta_alumno(
                :nombres,
                :apellidos,
                :correo_postulante,
                :celular_postulante,
                :fecha_nacimiento,
                :distrito,
                :centro_estudios,
                :anio_estudios,
                :direccion,
                :dni,
                :estudia_canto,
                :donde_estudia,
                :seguro_salud,
                :seguro_caducidad,
                :alergias,
                :enfermedades,
                :dolor_cabeza,
                :fiebre,
                :dolor_estomago,
                :toma_medicamento_diario,
                :medicamento_diario
            )");
            $query->execute([
                'nombres'                   => $datos['txt_nombres'],
                'apellidos'                 => $datos['txt_apellidos'],
                'correo_postulante'         => $datos['txt_correo_alumno'],
                'celular_postulante'        => $datos['txt_celular_alumno'],
                'fecha_nacimiento'          => $fecha_nacimiento,
                'distrito'                  => $datos['txt_distrito'],
                'centro_estudios'           => $datos['txt_centro_estudios'],
                'anio_estudios'             => $datos['txt_grado_instruccion'],
                'direccion'                 => $datos['txt_direccion'],
                'dni'                       => $datos['txt_dni'],
                'estudia_canto'             => $datos['estudia_canto'],
                'donde_estudia'             => $datos['txt_centro_instruccion'],
                'seguro_salud'              => $datos['txt_seguro_salud'],
                'seguro_caducidad'          => $seguro_caducidad,
                'alergias'                  => $datos['txt_alergias'],
                'enfermedades'              => $datos['txt_enfermedades'],
                'dolor_cabeza'              => $datos['txt_dolor_cabeza'],
                'fiebre'                    => $datos['txt_fiebre'],
                'dolor_estomago'            => $datos['txt_dolor_estomago'],
                'toma_medicamento_diario'   => $datos['opcion_diario'],
                'medicamento_diario'        => $datos['txt_medicamento_diario']
            ]);

            while($row =  $query->fetch()){
                $items[] = $row;
            }

            if(count($items) == 0){
                $items = "";
            }

            $query = $this->db->connect()->prepare('insert into usuario (idparticipante, idtipo, nombres, apellidos, correo, usuario, clave)
            values (:idparticipante, :idtipo, :nombres, :apellidos, :correo, :usuario, MD5(:clave))');
            $query->execute([
                'idparticipante'    => $items[0]['lid'],
                'idtipo'            => 'ALU',
                'nombres'           => $datos['txt_nombres'],
                'apellidos'         => $datos['txt_apellidos'],
                'correo'            => $datos['txt_correo_alumno'],
                'usuario'           => $datos['txt_dni'],
                'clave'             => $datos['txt_dni']
            ]);
            
            return $items;
        }catch(PDOException $e){
            return [];
        }
    }
}
?>