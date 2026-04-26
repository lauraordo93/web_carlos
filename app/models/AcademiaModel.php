<?php

class AcademiaModel extends Model {
    public function getFirst() {
        $sql = "SELECT * FROM `academia` WHERE id=1 LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetch();
    }
}
