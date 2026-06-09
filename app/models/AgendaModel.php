<?php

class AgendaModel extends Model
{
    public function getUpcomingEvents()
    {
        $sql = "SELECT id, titulo, descripcion, fecha, lugar, seccion_id
                FROM agenda
                WHERE fecha IS NOT NULL
                  AND TRIM(titulo) <> ''
                  AND fecha >= CURDATE()
                ORDER BY fecha ASC, id ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getPastEvents()
    {
        $sql = "SELECT id, titulo, descripcion, fecha, lugar, seccion_id
                FROM agenda
                WHERE fecha IS NOT NULL
                  AND TRIM(titulo) <> ''
                  AND fecha < CURDATE()
                ORDER BY fecha ASC, id ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getAllEvents()
    {
        $sql = "SELECT id, titulo, descripcion, fecha, lugar, seccion_id
                FROM agenda
                ORDER BY
                    CASE WHEN fecha >= CURDATE() THEN 0 ELSE 1 END,
                    CASE WHEN fecha >= CURDATE() THEN fecha END ASC,
                    CASE WHEN fecha < CURDATE() THEN fecha END DESC,
                    id DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function findById($id)
    {
        $sql = "SELECT id, titulo, descripcion, fecha, lugar, seccion_id
                FROM agenda
                WHERE id = :id
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', (int) $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function create($data)
    {
        $sql = "INSERT INTO agenda (titulo, descripcion, fecha, lugar, seccion_id)
                VALUES (:titulo, :descripcion, :fecha, :lugar, :seccion_id)";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'titulo' => $data['titulo'],
            'descripcion' => $data['descripcion'] ?? null,
            'fecha' => $data['fecha'],
            'lugar' => $data['lugar'] ?? null,
            'seccion_id' => $data['seccion_id'] ?? 3,
        ]);
    }

    public function update($id, $data)
    {
        $sql = "UPDATE agenda
                SET titulo = :titulo,
                    descripcion = :descripcion,
                    fecha = :fecha,
                    lugar = :lugar,
                    seccion_id = :seccion_id
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'id' => (int) $id,
            'titulo' => $data['titulo'],
            'descripcion' => $data['descripcion'] ?? null,
            'fecha' => $data['fecha'],
            'lugar' => $data['lugar'] ?? null,
            'seccion_id' => $data['seccion_id'] ?? 3,
        ]);
    }

    public function delete($id)
    {
        $sql = "DELETE FROM agenda WHERE id = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', (int) $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
