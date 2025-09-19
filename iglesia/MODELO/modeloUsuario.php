<?php
include_once(__DIR__ . "/../config/database.php");

class ModeloUsuario {
    private $pdo;

    public function __construct() {
        $this->pdo = getConnection();
    }
    public function login($email, $password) {
        $query = "SELECT * 
                  FROM usuarios 
                  WHERE email = :email 
                    AND password = :password
                     AND estado = 'activo' LIMIT 1";
        
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function nuevoUsuario($email, $nombre, $password, $rol, $estado) {
        if ($this->existeUsuario($email)) {
            return false;
        }
    
        $query = "INSERT INTO usuarios (nombre, email, password, rol, estado) 
                  VALUES (:nombre, :email, :password, :rol, :estado)";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':estado', $estado);
        $stmt->bindParam(':rol', $rol);
    
        return $stmt->execute();
    }
    
    public function editarUsuario($id, $nombre, $email, $password, $estado, $rol) {
        
            $query = "UPDATE usuarios 
            SET nombre = :nombre,
                email = :email,
                password = :password,
                estado = :estado,
                rol = :rol,
                fecha_modificacion = NOW()
            WHERE id = :id";
        
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':estado', $estado);
        $stmt->bindParam(':rol', $rol);
        
        
        
        return $stmt->execute();
    }

    public function eliminarUsuario($id) {
        $query = "DELETE FROM usuarios WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
   
    public function listarUsuarios() {
        $query = "SELECT * FROM usuarios ORDER BY id ASC";
        $stmt = $this->pdo->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
   
    public function getUsuarioPorId($id) {
        $query = "SELECT id, nombre, email, password, estado, rol FROM usuarios WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function existeUsuario($email) {
        $query = "SELECT * FROM usuarios WHERE email = :email";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


}

    
?>
