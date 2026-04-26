<?php

class HeaderModel extends Model {
    public function getLogo() {
        $sql = "SELECT nombre_pagina, logo FROM encabezado_logo LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetch();
    }
}
