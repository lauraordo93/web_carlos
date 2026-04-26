<?php

class EntradaModel extends Model {
    
    /**
     * Obtiene entradas por sección
     */
    public function getBySeccion($seccion_id, $limit = null, $offset = 0, $order = 'id DESC') {
        $sql = "SELECT id, titulo, contenido, foto_url, video_url, enlace_url, seccion_id, fecha FROM entradas WHERE seccion_id = :seccion_id ORDER BY $order";
        
        if ($limit !== null) {
            $sql .= " LIMIT :limit OFFSET :offset";
        }

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':seccion_id', $seccion_id, PDO::PARAM_INT);
        
        if ($limit !== null) {
            $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
            $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        }

        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Cuenta el total de entradas por sección (para paginación)
     */
    public function countBySeccion($seccion_id) {
        $sql = "SELECT COUNT(*) as total FROM entradas WHERE seccion_id = :seccion_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['seccion_id' => $seccion_id]);
        $result = $stmt->fetch();
        return $result['total'];
    }

    /**
     * Obtiene entradas con foto válida para la galería
     */
    public function getGaleria() {
        $sql = "SELECT foto_url FROM entradas 
                WHERE seccion_id = 2 
                  AND foto_url IS NOT NULL 
                  AND TRIM(foto_url) <> '' 
                ORDER BY id ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Obtiene videos ordenados por fecha
     */
    public function getVideos() {
        return $this->getBySeccion(5, null, 0, 'fecha DESC');
    }

    /**
     * Obtiene entrevistas
     */
    public function getEntrevistas() {
        return $this->getBySeccion(6, null, 0, 'id ASC');
    }

    /**
     * Obtiene la entrada de "Sobre mí"
     */
    public function getSobreMi() {
        $sql = "SELECT * FROM `entradas` WHERE titulo = 'sobre mi' LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetch();
    }

    /**
     * Obtiene la biografía (seccion_id = 1)
     */
    public function getBiografia() {
        $sql = "SELECT titulo, contenido FROM entradas WHERE seccion_id = 1 ORDER BY fecha DESC LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetch();
    }

    /**
     * Obtiene una entrada por su ID
     */
    public function getById($id) {
        $sql = "SELECT * FROM entradas WHERE id = :id LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    /**
     * Crea un nuevo registro
     */
    public function create($data) {
        $sql = "INSERT INTO entradas (titulo, contenido, foto_url, video_url, fecha, seccion_id, enlace_url) 
                VALUES (:titulo, :contenido, :foto_url, :video_url, :fecha, :seccion_id, :enlace_url)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }

    /**
     * Actualiza un registro existente
     */
    public function update($id, $data) {
        $data['id'] = $id;
        $sql = "UPDATE entradas SET 
                titulo = :titulo, 
                contenido = :contenido, 
                foto_url = :foto_url, 
                video_url = :video_url, 
                fecha = :fecha, 
                seccion_id = :seccion_id, 
                enlace_url = :enlace_url 
                WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }

    /**
     * Elimina un registro
     */
    public function delete($id) {
        $sql = "DELETE FROM entradas WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
}
