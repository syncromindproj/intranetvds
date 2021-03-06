<?PHP
include_once 'models/alumno.php';

class AlumnoModel extends Model{
    public function __construct(){
        parent::__construct();
    }

    public function get(){
        $items = [];

        try{
            $query = $this->db->connect()->query("select 
            p.idparticipante,
            p.nombres,
            p.apellidos,
            TIMESTAMPDIFF(YEAR, p.fecha_nacimiento, CURDATE()) AS edad,
            COALESCE(g.descripcion, 'Sin grupo asignado') as grupo,
            COALESCE(madres.nombres, 'SIN DATOS ASIGNADOS') as datos_madre,
            COALESCE(padres.nombres, 'SIN DATOS ASIGNADOS') as datos_padre
            from 
            participantes p
            left join grupo_participante gp
             on gp.idparticipante = p.idparticipante
             left join grupo g 
             on g.idgrupo = gp.idgrupo
            left join 
            (SELECT 
            aa.idparticipante,
             a.nombres
            FROM apoderado a
            inner join apoderado_alumno aa
             on aa.idapoderado = a.idapoderado
            WHERE 
            a.tipo = 'M') madres
            on madres.idparticipante = p.idparticipante
            left join 
            (SELECT 
            aa.idparticipante,
             a.nombres
            FROM apoderado a
            inner join apoderado_alumno aa
             on aa.idapoderado = a.idapoderado
             
            WHERE 
            a.tipo = 'P') padres
            on padres.idparticipante = p.idparticipante
            
            where p.aprobado =1
            and p.estado = 1
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

    public function getAlumnosAutorizados($datos)
    {
        $items = [];

        try{
            $query = $this->db->connect()->prepare("SELECT 
            p.idparticipante,
            p.apellidos,
            p.nombres,
            p.correo_postulante,
            p.celular_postulante,
            CASE WHEN ea.autorizacion = '1' THEN 'AUTORIZADO' ELSE 'SIN AUTORIZACION' END AS autorizacion,
            ea.motivo
            FROM evento_alumno ea
            inner join participantes p
            on p.idparticipante = ea.idalumno
            WHERE ea.idevento = :idevento
            order by p.apellidos asc");

            $query->execute([
                'idevento' => $datos['idevento']
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

    public function getAlumnosNOAutorizados($datos)
    {
        $items = [];

        try{
            $query = $this->db->connect()->prepare("SELECT 
            p.correo_postulante,
            ea.motivo
            FROM evento_alumno ea
            inner join participantes p
            on p.idparticipante = ea.idalumno
            WHERE ea.idevento = :idevento
            and ea.autorizacion = '0'");

            $query->execute([
                'idevento' => $datos['idevento']
            ]);

            while($row =  $query->fetch()){
                $items[]  = $row;
            }

            if(count($items) == 0){
                $items = "";
            }
            return $items; 
            
            return $items;
        }catch(PDOException $e){
            return [];
        }
    }

    public function getAlumnosEvento($datos)
    {
        $items = [];

        try{
            $query = $this->db->connect()->prepare("select 
            idalumno
            from evento_alumno
            where idevento = :idevento");

            $query->execute([
                'idevento' => $datos['idevento']
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

    public function getAlumnosComunicado($datos)
    {
        $items = [];

        try{
            $query = $this->db->connect()->prepare("select 
            idparticipante
            from comunicado_alumno
            where idcomunicado = :idcomunicado");

            $query->execute([
                'idcomunicado' => $datos['idcomunicado']
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

    public function getByDocentInforme($iddocente)
    {
        $items = [];

        try{
            $query = $this->db->connect()->prepare("select 
            p.idparticipante, 
            p.nombres, 
            p.apellidos, 
            p.edad, 
            COALESCE(g.descripcion, 'Sin grupo asignado') as grupo,
            COALESCE(i.url, 'SIN INFORME') as informe,
            COALESCE(i.idinforme, '0') as idinforme
            from participantes p 
            left join grupo_participante gp
            on gp.idparticipante = p.idparticipante
            left join grupo g 
            on g.idgrupo = gp.idgrupo
            inner join grupo_docente gd
            on gd.idgrupo = g.idgrupo
            left join informe_participante ip
            on ip.idparticipante = p.idparticipante
            left join informe i
            on i.idinforme = ip.idinforme
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

    public function EliminaAlumno($id)
    {
        //Eliminar alumno
        $query = $this->db->connect()->prepare('update participantes set estado=0 where idparticipante=:id');
        $query->execute([
            'id' => $id
        ]);

        //Eliminar usuario
        $query = $this->db->connect()->prepare('update usuario set estado=0 where idparticipante=:id and idtipo="ALU"');
        $query->execute([
            'id' => $id
        ]);

        //Eliminar apoderados
        $query = $this->db->connect()->prepare('update apoderado_alumno set estado=0 where idparticipante=:id');
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

            $time_nacimiento    = $datos['txt_nacimiento'];
            $date_nacimiento    = str_replace('/', '-', $time_nacimiento);
            $nacimiento         = date("Y-m-d", strtotime($date_nacimiento));
            $query = $this->db->connect()->prepare('
            update participantes p
            inner join participante_detalle pd
            on p.idparticipante = pd.idparticipante
            set 
            p.nombres = :nombres,
            p.apellidos = :apellidos,
            p.fecha_nacimiento = :fecha_nacimiento,
            p.distrito = :distrito,
            p.nacionalidad = :nacionalidad,
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
            pd.medicamento_diario = :medicamento_diario,
            pd.instrumento = :instrumento
            where p.idparticipante = :idparticipante');
            $query->execute([
                'nombres'                   => $datos['txt_nombres'],
                'apellidos'                 => $datos['txt_apellidos'],
                'idparticipante'            => $datos['idalumno'],
                'fecha_nacimiento'          => $nacimiento,
                'distrito'                  => $datos['txt_distrito'],
                'nacionalidad'              => $datos['nacionalidad'],
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
                'instrumento'               => $datos['txt_instrumento']
            ]);
        }catch(PDOException $e){
            return $e->getCode();
        }
    }

    public function getById($id){
        $item = new Alumno();

        $query = $this->db->connect()->prepare("SELECT 
        p.*, pd.* from 
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
                $item->nacionalidad             = $row['nacionalidad'];
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
                $item->seguro_caducidad         = $row['seguro_caducidad'];
                $item->enfermedades             = $row['enfermedades'];
                $item->alergias                 = $row['alergias'];
                $item->dolor_cabeza             = $row['dolor_cabeza'];
                $item->fiebre                   = $row['fiebre'];
                $item->dolor_estomago           = $row['dolor_estomago'];
                $item->toma_medicamento_diario  = $row['toma_medicamento_diario'];
                $item->medicamento_diario       = $row['medicamento_diario'];
                $item->imagen                   = $row['imagen'];
                $item->instrumento              = $row['instrumento'];
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

    public function VerificaDNIAlumno($datos)
    {
        $items = [];
        try{
            $query = $this->db->connect()->prepare("
            SELECT count(idparticipante) as cantidad
            from participante_detalle
            where dni=:dni");
            $query->execute([
                'dni'  => $datos['dni']
            ]);

            while($row =  $query->fetch()){
                $items["data"][]  = $row;
            }

            if(count($items) == 0){
                $items['data'] = "";
            }

            return $items;

        }catch(PDOException $e){
            return [];
        }
    }

    public function Exportar($datos)
    {
        $items = [];
        $columnas = "";
        $filtro = "";

        try{
            $lista_columnas = $datos['columnas'];
            $filtro = $datos['filtro'];
            for($x=0;$x<count($datos['columnas']);$x++){
                $columnas.=$datos['columnas'][$x] . ", ";
            }
            $columnas = substr($columnas, 0, (strlen($columnas)-2));
            
            /*$sql = "select concat(la.nombres, ' ', la.apellidos) as nombres, ". $columnas ." from listaalumnos la ";
            $sql .= "inner join grupo_participante gp ";
            $sql .= "on gp.idparticipante = la.idparticipante ";
            $sql .= "inner join grupo g ";
            $sql .= "on g.idgrupo = gp.idgrupo ";
            $sql .= "inner join participantes p ";
            $sql .= "on p.idparticipante = la.idparticipante ";
            $sql .= "where g.descripcion like '%".$filtro."%' and p.estado=1 order by nombres asc";*/
            $sql = "select concat(la.nombres, ' ', la.apellidos) as nombres,  ";
            $sql .= "la.correo_postulante, ";
            $sql .= "concat(apo.nombres, ' ', apo.apellidos) as nombres_apoderado, ";
            $sql .= "apo.correo, ";
            $sql .= "apo.celular, " . $columnas ;
            $sql .= " from listaalumnos la  ";
            $sql .= "inner join grupo_participante gp  ";
            $sql .= "on gp.idparticipante = la.idparticipante  ";
            $sql .= "inner join grupo g  ";
            $sql .= "on g.idgrupo = gp.idgrupo  ";
            $sql .= "inner join participantes p  ";
            $sql .= "on p.idparticipante = la.idparticipante  ";
            $sql .= "INNER join apoderado_alumno aa ";
            $sql .= "on aa.idparticipante = la.idparticipante  ";
            $sql .= "inner join apoderado apo ";
            $sql .= "on apo.idapoderado = aa.idapoderado ";
            $sql .= "where g.descripcion like '%".$filtro."%' and  p.estado=1 order by nombres asc ";
            
            $query = $this->db->connect()->prepare($sql);
            $query->execute();
            
            $y=0;
            while($row =  $query->fetch(PDO::FETCH_ASSOC)){
                $items[]  = $row;
                //$item->idparticipante = $row['idparticipante'];
            }

            if(count($items) == 0){
                $items = "";
            }
            return $items; 
                

        }catch(PDOException $e){
            return [];
        } 
            
        
    }

    public function ActualizaImageAlumno($id, $imagen)
    {
        try{
            $query = $this->db->connect()->prepare('update participantes set imagen = :imagen where idparticipante = :id');
            $query->execute([
                'imagen'            => $imagen,
                'id'                => $id
            ]);

            return "Registro actualizado";
        }catch(PDOException $e){
            return $e->getCode();
        }
    }

    public function ActualizaAlumnoPerfil($datos)
    {
        try{
            print_r($datos);
            $query = $this->db->connect()->prepare('
            update participantes p
            inner join participante_detalle pd
            on p.idparticipante = pd.idparticipante
            set 
            p.nombres = :nombres,
            p.apellidos = :apellidos,
            p.celular_postulante = :celular_postulante,
            p.correo_postulante = :correo_postulante,
            pd.direccion = :direccion
            where p.idparticipante = :idparticipante');
            $query->execute([
                'nombres'                   => $datos['nombres'],
                'apellidos'                 => $datos['apellidos'],
                'idparticipante'            => $datos['id'],
                'celular_postulante'        => $datos['celular'],
                'correo_postulante'         => $datos['correo'],
                'direccion'                 => $datos['direccion']
            ]);
            

            return "Datos Actualizados";
        }catch(PDOException $e){
            //return $e->getCode();
            return "error";
        }
    }
}
?>