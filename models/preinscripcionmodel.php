<?php
class PreinscripcionModel extends Model
{
    function __construct()
    {
        parent::__construct();
    }

    public function ListaPersonas()
    {
        $items = [];

        try{
            $query = $this->db->connect()->prepare("
            SELECT 
            *
            FROM 
            preinscripcion");
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

    public function GetPersonaById($datos)
    {
        $items = [];

        try{
            $query = $this->db->connect()->prepare("
            SELECT 
            *
            FROM 
            preinscripcion
            where id = :id");
            $query->execute([
                'id' => $datos['id']
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

    public function RechazarPostulante($datos)
    {
        $items = [];

        try{
            $correo_postulante    = "";
            $correo_apoderado     = "";
            $query = $this->db->connect()->prepare("
            update  
            preinscripcion
            set aprobado = 2
            where id = :id");
            $query->execute([
                'id' => $datos['id']
            ]);

            //Obtiene correo postulante
            $query = $this->db->connect()->prepare("
            select * from  
            preinscripcion
            where id = :id");
            $query->execute([
                'id' => $datos['id']
            ]);
            
            while($row =  $query->fetch()){
                $correo_postulante = $row['correo_postulante'];
                $correo_apoderado = $row['mail_apoderado'];
            }
            //Obtiene correo postulante

            $items['success'] = true;
            $items['message'] = 'El postulante ha sido rechazado';

            //Envio de correo
            $correos        = $correo_apoderado.','.$correo_postulante; 
            $from_email     = 'administracion@vocesdelsol.com'; 
            $to             = ''; 
            $subject        = 'Voces del Sol - Evaluación'; 
            
            $htmlContent = '
                <p><img src="https://vocesdelsol.com/preinscripcion/images/mail_header.png" /></p>
                <h1>Voces del Sol - Resultado</h1>
                <p>Estimado postulante,</p>

                <p>En esta oportunidad, lamentamos comunicarle que su pre-inscripción no ha sido aprobada por el comité de admisiones.</p>
                
                <p>Muchas gracias por su interés, esperamos vuelva a intentarlo más adelante.</p>
                
                <p><b>VOCES DEL SOL</b></p>

                <p>Muchas gracias, <br>
            VOCES DEL SOL</p>';

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
            //Envio de correo
            
            return $items;
        }catch(PDOException $e){
            return $e->getCode();
        }
    }

    public function AprobarPostulante($datos)
    {
        $items = [];

        try{
            $correo_postulante    = "";
            $correo_apoderado = "";

            $query = $this->db->connect()->prepare("
            update  
            preinscripcion
            set aprobado = 1
            where id = :id");
            $query->execute([
                'id' => $datos['id']
            ]);

            //Obtiene correo postulante
            $query = $this->db->connect()->prepare("
            select * from  
            preinscripcion
            where id = :id");
            $query->execute([
                'id' => $datos['id']
            ]);
            
            while($row =  $query->fetch()){
                $correo_postulante = $row['correo_postulante'];
                $correo_apoderado = $row['mail_apoderado'];
            }
            //Obtiene correo postulante

            $items['success'] = true;
            $items['message'] = 'El postulante ha sido aprobado';

            //Envio de correo
            $correos        = $correo_apoderado.','.$correo_postulante; 
            $from_email     = 'administracion@vocesdelsol.com'; 
            $to             = ''; 
            $subject        = 'Voces del Sol - Evaluación'; 
            
            $htmlContent = '
            <p><img src="https://vocesdelsol.com/preinscripcion/images/mail_header.png" /></p>
            <h1>Voces del Sol - Resultado</h1>
            <p>Estimado postulante,</p>

            <p>¡Felicitaciones, bienvenido al programa VERANO SOLAR!<br>
            Este es el primer paso para que seas parte de la Escuela Coral Voces del Sol.</p>
            
            <p>Para concretar su inscripción deberá cancelar el costo total del curso a una de las siguientes cuentas bancarias.</p>
            
            <p>Costo:<br>
            s/. 280.00</p>
            
            <p><b>BCP</b> <br>
            Ahorro Soles 19493345514096<br>
            CCI 00219419334551409693</p>
            
            <p><b>Scotiabank Perú</b> <br>
            Ahorro Soles 1700051533<br>
            CCI 00917020170005153320</p>
            
            <p>A nombre de Claudia Rheineck Moreno<br>
            DNI 09875330</p>
            
            <p><b>Una vez realizado el depósito o transferencia mandar la constancia, voucher o foto de la transacción al correo administracion@vocesdelsol.com</b></p>
            
            <p>Luego de enviar la constancia recibirá una respuesta confirmando su inscripción al Programa de Verano Solar.</p>
            
            <p>Muchas gracias, <br>
            VOCES DEL SOL</p>';

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
            //Envio de correo
            
            return $items;
        }catch(PDOException $e){
            return $e->getCode();
        }
    }
	
	public function Exportar()
    {
        $items = [];
        
        try{
            
            $sql = "select * from preinscripcion where aprobado=1";
            $query = $this->db->connect()->prepare($sql);
            $query->execute();
            
            $y=0;
            while($row =  $query->fetch(PDO::FETCH_ASSOC)){
                $items[]  = $row;
            }

            if(count($items) == 0){
                $items = "";
            }
            return $items; 
                

        }catch(PDOException $e){
            return [];
        } 
            
        
    }

}
?>