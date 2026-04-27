<?php

/**
 * Gestión de Persistencia de Datos
 * 
 * Clase encargada de establecer y configurar la conexión segura con el 
 * servidor de base de datos utilizando la interfaz PDO (PHP Data Objects).
 */
class Database
{
    /** @var string Host del servidor de base de datos */
    private $host = DB_HOST;
    
    /** @var string Nombre del esquema de base de datos */
    private $db_name = DB_NAME;
    
    /** @var string Credencial: Usuario */
    private $username = DB_USER;
    
    /** @var string Credencial: Contraseña */
    private $password = DB_PASS;
    
    /** @var PDO|null Instancia de la conexión activa */
    private $conn;

    /**
     * Establece una conexión persistente y segura con MySQL
     * 
     * @return PDO Instancia configurada del objeto de conexión
     * @throws PDOException En caso de fallo crítico en la conectividad
     */
    public function connect()
    {
        $this->conn = null;

        try {
            $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=utf8mb4";
            $this->conn = new PDO($dsn, $this->username, $this->password);

            // Configuración de reporte de errores mediante excepciones
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Establecimiento del modo de recuperación predeterminado (asociativo)
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            // Registro silencioso del error y terminación controlada
            error_log("Fallo crítico en conectividad de base de datos: " . $e->getMessage());
            die("Error de infraestructura: No se pudo establecer comunicación con la base de datos.");
        }

        return $this->conn;
    }
}
