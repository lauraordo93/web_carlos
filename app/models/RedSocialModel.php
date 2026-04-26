<?php

class RedSocialModel extends Model {
    public function getAll() {
        $sql = "SELECT nombre_red, enlace FROM redes";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
