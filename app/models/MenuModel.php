<?php

class MenuModel extends Model {
    public function getAll() {
        $sql = "SELECT * FROM menu 
                ORDER BY FIELD(nombre, 'Biografía', 'Madrid Sax Academy', 'Galería', 'Videos', 'Entrevistas', 'Agenda','Contacto')";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
