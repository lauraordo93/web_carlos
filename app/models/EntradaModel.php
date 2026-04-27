<?php

/**
 * Modelo de Entradas
 * 
 * Gestiona la capa de datos para la tabla 'entradas', encargándose de 
 * las consultas de lectura, creación, actualización y borrado.
 */
class EntradaModel extends Model {
    
    /**
     * Recupera registros por sección con parámetros de ordenación y límite
     * 
     * @param int $seccion_id Identificador de la sección
     * @param int|null $limit Cantidad máxima de registros
     * @param int $offset Punto de inicio para la consulta
     * @param string $order Criterio de ordenación SQL
     * @return array Listado de registros encontrados
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
     * Calcula el volumen total de registros para una sección determinada
     * Útil para la lógica de paginación en el frontend y backend.
     * 
     * @param int $seccion_id Identificador de la sección
     * @return int Total de registros contabilizados
     */
    public function countBySeccion($seccion_id) {
        $sql = "SELECT COUNT(*) as total FROM entradas WHERE seccion_id = :seccion_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['seccion_id' => $seccion_id]);
        $result = $stmt->fetch();
        return (int)$result['total'];
    }

    /**
     * Extrae los activos multimedia de la galería (Sección 2)
     * Filtra únicamente registros que posean una referencia de imagen válida.
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
     * Consulta el catálogo de vídeos
     */
    public function getVideos() {
        return $this->getBySeccion(5, null, 0, 'fecha DESC');
    }

    /**
     * Consulta el histórico de entrevistas
     */
    public function getEntrevistas() {
        return $this->getBySeccion(6, null, 0, 'id ASC');
    }

    /**
     * Obtiene la información de perfil profesional
     */
    public function getSobreMi() {
        $sql = "SELECT * FROM `entradas` WHERE titulo = 'sobre mi' LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetch();
    }

    /**
     * Recupera el contenido biográfico más reciente
     */
    public function getBiografia() {
        $sql = "SELECT titulo, contenido FROM entradas WHERE seccion_id = 1 ORDER BY fecha DESC LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetch();
    }

    /**
     * Busca un registro específico por su clave primaria
     * 
     * @param int $id Identificador único
     * @return array|false Datos del registro o false si no existe
     */
    public function getById($id) {
        $sql = "SELECT * FROM entradas WHERE id = :id LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    /**
     * Inserta un nuevo registro en la base de datos
     * 
     * @param array $data Conjunto de datos a persistir
     * @return bool Resultado de la operación
     */
    public function create($data) {
        $sql = "INSERT INTO entradas (titulo, contenido, foto_url, video_url, fecha, seccion_id, enlace_url) 
                VALUES (:titulo, :contenido, :foto_url, :video_url, :fecha, :seccion_id, :enlace_url)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }

    /**
     * Actualiza la información de un registro preexistente
     * 
     * @param int $id Identificador del registro
     * @param array $data Nuevos valores a asignar
     * @return bool Resultado de la operación
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
     * Suprime un registro de forma definitiva
     * 
     * @param int $id Identificador del registro
     * @return bool Resultado de la operación
     */
    public function delete($id) {
        $sql = "DELETE FROM entradas WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
}
