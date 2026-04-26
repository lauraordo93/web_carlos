<?php

class AdminModel extends Model {
    
    /**
     * Buscar un administrador por su usuario
     */
    public function getByUser($username) {
        $sql = "SELECT id, usuario, password_hash FROM admin_usuario WHERE usuario = :usuario LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['usuario' => $username]);
        return $stmt->fetch();
    }

    /**
     * Verificar las credenciales usando password_verify
     */
    public function login($username, $password) {
        $user = $this->getByUser($username);
        
        if ($user) {
            // Usamos password_verify tal como estaba en tu iniciar_sesion.php
            if (password_verify($password, $user['password_hash'])) {
                return $user;
            }
        }
        
        return false;
    }
}
