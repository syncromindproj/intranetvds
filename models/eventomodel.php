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
            count(case ea.autorizacion when 1 then 1 else null end) autorizados
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
            e.hora,
            ea.autorizacion,
            ea.idevento_alumno,
            fecha as fecha_panel,
            ea.motivo
            FROM evento e
            inner join evento_alumno ea
            on ea.idevento = e.idevento
            where ea.idalumno = :idalumno
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

    public function GetEventosCalendario($datos)
    {
        $items = [];

        try{
            $query = $this->db->connect()->prepare("
            select 
            * 
            from
            evento e
            inner join evento_alumno ea
            on ea.idevento = e.idevento
            where ea.idalumno=:idparticipante");
            $query->execute([
                'idparticipante' => $datos['idparticipante']
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

    public function GetEventoByParticipantePanel($datos)
    {
        $items = [];
        try{
            $query = $this->db->connect()->prepare('
            SELECT 
            e.titulo,
            e.descripcion,
            DATE_FORMAT(e.fecha,"%d/%m/%Y") as fecha,
            e.hora,
            ea.autorizacion,
            ea.idevento_alumno,
            fecha as fecha_panel
            FROM evento e
            inner join evento_alumno ea
            on ea.idevento = e.idevento
            where ea.idalumno = :idalumno
            
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

    public function Autorizar($datos)
    {
        try{
            $query = $this->db->connect()->prepare('update evento_alumno set autorizacion=1 where 
            idevento_alumno = :idevento');
            $query->execute([
                'idevento'        => $datos['idevento']
            ]);

            return "Evento Autorizado";
        }catch(PDOException $e){
            return $e->getCode();
            //die(parent::outputPDOerror($e->getCode()));
        }
    }

    public function NoAutorizar($datos)
    {
        try{
            $query = $this->db->connect()->prepare('update evento_alumno set motivo=:motivo where 
            idevento_alumno = :idevento');
            $query->execute([
                'motivo'          => $datos['motivo'],
                'idevento'        => $datos['idevento']
            ]);

            return "Evento No Autorizado";
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
            $correos_postulantes = "";
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

            //CORREO POSTULANTES
            $query = $this->db->connect()->prepare("
            SELECT 
            p.nombres,
            p.apellidos,
            p.correo_postulante,
            e.titulo,
            e.descripcion,
            DATE_FORMAT(e.fecha, '%d/%m/%Y') as fecha,
            e.hora
            FROM evento_alumno ea
            inner join participantes p
            on p.idparticipante = ea.idalumno
            inner join evento e
            on e.idevento = ea.idevento
            where ea.idevento=:idevento
            ");
            $query->execute([
                'idevento' => $datos['idevento']
            ]);

            $nombres        = "";
            $apellidos      = "";
            $titulo         = "";
            $descripcion    = "";
            $fecha          = "";
            $hora           = "";
            while($row =  $query->fetch()){
                //$correos_postulantes    .= $row['correo_postulante'] . ",";
                $para                   = $row['correo_postulante'];
                $nombres                = $row['nombres'];
                $apellidos              = $row['apellidos'];
                $titulo                 = $row['titulo'];
                $descripcion            = $row['descripcion'];
                $fecha                  = $row['fecha'];
                $hora                   = $row['hora'];

                //$correos_postulantes = substr($correos_postulantes, 0, (strlen($correos_postulantes) - 1));

                $from_email     = 'administracion@vocesdelsol.com'; 
                $to             = ''; 
                $subject        = 'Voces del Sol - Nuevo Evento'; 
                
                $htmlContent = '<h1>Voces del Sol - Nuevo Evento</h1>
                    <p>Su hijo, '. $nombres . ' ' . $apellidos . ' ha sido invitado al siguiente evento:</p>
                    <p>Evento: '. $titulo .'</p>
                    <p>Descripción: '. $descripcion .'</p>
                    <p>Fecha: '. $fecha .'</p>
                    <p>Hora: '. $hora .'</p>
                    <p>Por favor ingrese a la Intranet de Voces del Sol para que pueda autorizar la asistencia de su hijo.</p>
                    <p>Gracias</p>';

                //header for sender info
                $headers = "From: ".$from_email;
                $headers .= "\nBcc: alejandro.diaz@syncromind.net";

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
            }
            
            
            return 'Evento Asignado';

        }catch(PDOException $e){
            return $e->getCode();
        }
    }
}
?>