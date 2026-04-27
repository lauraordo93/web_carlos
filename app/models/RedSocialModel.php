<?php

/**
 * Modelo de Redes Sociales
 * 
 * Gestiona la extracción de perfiles y enlaces a plataformas sociales 
 * configuradas en la base de datos.
 */
class RedSocialModel extends Model {
    
    /**
     * Recupera el catálogo completo de enlaces sociales
     * 
     * @return array Listado de nombres y URLs de plataformas
     */
    public function getAll() {
        $sql = "SELECT nombre_red, enlace FROM redes";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
