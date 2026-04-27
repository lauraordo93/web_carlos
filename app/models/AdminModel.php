<?php

/**
 * Modelo de Autenticación Administrativa
 * 
 * Provee los métodos necesarios para la validación de identidades 
 * y gestión de credenciales en el área administrativa.
 */
class AdminModel extends Model {
    
    /**
     * Localiza un perfil administrativo por su nombre de usuario
     * 
     * @param string $username Identificador de usuario
     * @return array|false Datos del perfil o false si no existe coincidencia
     */
    public function getByUser($username) {
        $sql = "SELECT id, usuario, password_hash FROM admin_usuario WHERE usuario = :usuario LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['usuario' => $username]);
        return $stmt->fetch();
    }

    /**
     * Valida el acceso de un usuario mediante comparación de hash de seguridad
     * 
     * @param string $username Usuario proporcionado
     * @param string $password Contraseña en texto plano
     * @return array|false Retorna el perfil del usuario en caso de éxito, de lo contrario false
     */
    public function login($username, $password) {
        $user = $this->getByUser($username);
        
        if ($user) {
            // Verificación segura mediante el algoritmo estándar de PHP
            if (password_verify($password, $user['password_hash'])) {
                return $user;
            }
        }
        
        return false;
    }
}
