<?PHP
include_once 'models/alumno.php';

class AlumnoModel extends Model{
    public function __construct(){
        parent::__construct();
    }

    public function get(){
        $items = [];

        try{
            $query = $this->db->connect()->query("select p.idparticipante, p.nombres, p.apellidos, p.edad, COALESCE(g.descripcion, 'Sin grupo asignado') as grupo
            from participantes p 
            left join grupo_participante gp
            on gp.idparticipante = p.idparticipante
            left join grupo g 
            on g.idgrupo = gp.idgrupo
            where p.aprobado = 1
            order by p.apellidos asc");

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

    public function getByDocente($iddocente)
    {
        $items = [];

        try{
            $query = $this->db->connect()->prepare("select p.idparticipante, p.nombres, p.apellidos, p.edad, COALESCE(g.descripcion, 'Sin grupo asignado') as grupo
            from participantes p 
            left join grupo_participante gp
            on gp.idparticipante = p.idparticipante
            left join grupo g 
            on g.idgrupo = gp.idgrupo
            inner join grupo_docente gd
            on gd.idgrupo = g.idgrupo
            where p.aprobado = 1
            and gd.iddocente=:iddocente
            order by p.apellidos asc");

            $query->execute([
                'iddocente'           => $iddocente
            ]);

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

    public function InsertaGrupo($datos){
        $query = $this->db->connect()->prepare('insert into grupo (descripcion) values (:descripcion)');
        $query->execute(['descripcion' => $datos['descripcion']]);
    }

    public function AsignaGrupo($datos){
        $idgrupo_participante = "";
        $query = $this->db->connect()->prepare('select idgrupo_participante from grupo_participante where idparticipante = :idparticipante');
        $query->execute([
            'idparticipante'    => $datos['idparticipante']
        ]);
        while($row =  $query->fetch()){
            $idgrupo_participante = $row['idgrupo_participante'];
        }
        
        if($idgrupo_participante == ""){
            $query = $this->db->connect()->prepare('insert into grupo_participante (idgrupo, idparticipante) values (:idgrupo, :idparticipante)');
            $query->execute([
                'idgrupo'           => $datos['idgrupo'],
                'idparticipante'    => $datos['idparticipante']
            ]);
        }else{
            $query = $this->db->connect()->prepare('update grupo_participante set idgrupo = :idgrupo where idgrupo_participante = :idgrupo_participante');
            $query->execute([
                'idgrupo'               => $datos['idgrupo'],
                'idgrupo_participante'  => $idgrupo_participante
            ]);
        }
        
    }

    public function EliminaGrupo($id){
        $query = $this->db->connect()->prepare('delete from grupo where idgrupo=:id');
        $query->execute([
            'id' => $id
        ]);
    }

    public function ActualizaAlumno($datos)
    {
        try{
            $time               = $datos['txt_seguro_caducidad'];
            $date               = str_replace('/', '-', $time);
            $seguro_caducidad   = date("Y-m-d", strtotime($date));

            $query = $this->db->connect()->prepare('
            update participantes p
            inner join participante_detalle pd
            on p.idparticipante = pd.idparticipante
            set 
            p.nombres = :nombres,
            p.apellidos = :apellidos,
            p.fecha_nacimiento = :fecha_nacimiento,
            p.distrito = :distrito,
            p.celular_postulante = :celular_postulante,
            p.correo_postulante = :correo_postulante,
            p.centro_estudios = :centro_estudios,
            p.anio_estudios = :anio_estudios,
            pd.dni = :dni,
            pd.direccion = :direccion,
            pd.estudia_canto = :estudia_canto,
            pd.donde_estudia = :donde_estudia,
            pd.seguro_salud = :seguro_salud,
            pd.enfermedades = :enfermedades,
            pd.seguro_caducidad = :seguro_caducidad,
            pd.alergias = :alergias,
            pd.dolor_cabeza = :dolor_cabeza,
            pd.fiebre = :fiebre,
            pd.dolor_estomago = :dolor_estomago,
            pd.toma_medicamento_diario = :toma_medicamento_diario,
            pd.medicamento_diario = :medicamento_diario
            where p.idparticipante = :idparticipante');
            $query->execute([
                'nombres'                   => strtoupper($datos['txt_nombres']),
                'apellidos'                 => strtoupper($datos['txt_apellidos']),
                'idparticipante'            => $datos['idalumno'],
                'fecha_nacimiento'          => $datos['txt_nacimiento'],
                'distrito'                  => $datos['txt_distrito'],
                'celular_postulante'        => $datos['txt_celular_alumno'],
                'correo_postulante'         => $datos['txt_correo_alumno'],
                'centro_estudios'           => $datos['txt_centro_estudios'],
                'anio_estudios'             => $datos['txt_grado_instruccion'],
                'dni'                       => $datos['txt_dni'],
                'direccion'                 => $datos['txt_direccion'],
                'estudia_canto'             => $datos['estudia_canto'],
                'donde_estudia'             => $datos['txt_centro_instruccion'],
                'seguro_salud'              => $datos['txt_seguro_salud'],
                'seguro_caducidad'          => $seguro_caducidad,
                'enfermedades'              => $datos['txt_enfermedades'],
                'alergias'                  => $datos['txt_alergias'],
                'dolor_cabeza'              => $datos['txt_dolor_cabeza'],
                'fiebre'                    => $datos['txt_fiebre'],
                'dolor_estomago'            => $datos['txt_dolor_estomago'],
                'toma_medicamento_diario'   => $datos['opcion_diario'],
                'medicamento_diario'        => $datos['txt_medicamento_diario'],
            ]);
        }catch(PDOException $e){
            return $e->getCode();
        }
    }

    public function getById($id){
        $item = new Alumno();

        $query = $this->db->connect()->prepare("SELECT 
        p.*, pd.*, DATE_FORMAT(pd.seguro_caducidad, '%d/%m/%Y') as fecha_seguro_caducidad from 
        participantes p
        left join participante_detalle pd
        on p.idparticipante = pd.idparticipante
        where p.idparticipante=:idalumno");
        try{
            $query->execute([
                'idalumno' => $id
            ]);
            while($row =  $query->fetch()){
                $item->idparticipante           = $row['idparticipante'];
                $item->nombres                  = $row['nombres'];
                $item->apellidos                = $row['apellidos'];
                $item->correo_postulante        = $row['correo_postulante'];
                $item->celular_postulante       = $row['celular_postulante'];
                $item->fecha_nacimiento         = $row['fecha_nacimiento'];
                $item->edad                     = $row['edad'];
                $item->distrito                 = $row['distrito'];
                $item->centro_estudios          = $row['centro_estudios'];
                $item->anio_estudios            = $row['anio_estudios'];
                $item->nombre_apoderado         = $row['nombre_apoderado'];
                $item->celular_apoderado        = $row['celular_apoderado'];
                $item->correo_apoderado         = $row['correo_apoderado'];
                $item->aprobado                 = $row['aprobado'];
                $item->estado                   = $row['estado'];
                $item->idparticipante_detalle   = $row['idparticipante_detalle'];
                $item->dni                      = $row['dni'];
                $item->direccion                = $row['direccion'];
                $item->estudia_canto            = $row['estudia_canto'];
                $item->donde_estudia            = $row['donde_estudia'];
                $item->seguro_salud             = $row['seguro_salud'];
                $item->seguro_caducidad         = $row['fecha_seguro_caducidad'];
                $item->enfermedades             = $row['enfermedades'];
                $item->alergias                 = $row['alergias'];
                $item->dolor_cabeza             = $row['dolor_cabeza'];
                $item->fiebre                   = $row['fiebre'];
                $item->dolor_estomago           = $row['dolor_estomago'];
                $item->toma_medicamento_diario  = $row['toma_medicamento_diario'];
                $item->medicamento_diario       = $row['medicamento_diario'];
            }
            
            return $item;
        }catch(PDOException $e){
            return null;
        }
    }

    function GetAlumnosByGrupo($grupo){
        $items = [];
        
        try{
            $query = $this->db->connect()->prepare("
            select 
p.idparticipante,
p.nombres, 
p.apellidos,
p.correo_postulante as correo,
p.celular_postulante as celular
from grupo_participante gp
inner join participantes p
on p.idparticipante = gp.idparticipante
where idgrupo=:grupo
order by p.apellidos asc");
            $query->execute([
                'grupo'  => $grupo
            ]);

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