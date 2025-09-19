<?php
include_once(__DIR__ . "/../config/database.php");

class modelo_condicionmedica {
    private $pdo;

    public function __construct() {
        $this->pdo = getConnection();
    }

    /**
     * Lista todas las condiciones médicas disponibles en el catálogo.
     * @return array Retorna un array de arrays asociativos con los IDs y las descripciones.
     */
    public function listarCondicionesMedicas() {
        $sql = "SELECT id, descripcion FROM Condicion_Medica ORDER BY id ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtiene una condición médica específica por su ID.
     * @param int $id El ID de la condición médica.
     * @return array|false Retorna un array asociativo con la condición o false si no se encuentra.
     */
    public function getCondicionMedicaPorId($id) {
        $sql = "SELECT id, descripcion FROM Condicion_Medica WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>