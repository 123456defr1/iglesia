<?php
include_once(__DIR__ . "/../MODELO/modeloUsuario.php");

class ControladorUsuario {
    private $modeloUsuario;
    
    public function __construct() {
        $this->modeloUsuario = new ModeloUsuario();
    }
    
    public function login() {
        if ($_POST) {
            $email = $_POST['email'];
            $password = $_POST['password'];
         
            $usuario = $this->modeloUsuario->login($email, $password);
            
            if ($usuario) {
                session_start();
                $_SESSION['usuario'] = $usuario;
                $_SESSION['rol'] = $usuario['rol'];
                $_SESSION['estado'] = $usuario['estado'];
                
                // Array de redirecciones por rol
                $redirects = [
                    'admin' => '/iglesia/vistas/admin/index.php',
                    'distrital' => '/iglesia/vistas/distrital/index.php',
                    'miembro' => '/iglesia/vistas/usuario_registrado/index.php',
                    'nacional' => '/iglesia/vistas/nacional/index.php',
                    'visitante' => '/iglesia/vistas/visitas/index.php'
                ];
                
                
                // Redirigir según el rol
                if (isset($redirects[$usuario['rol']])) {
                    header("Location: " . $redirects[$usuario['rol']]);
                    exit();
                } else {
                    return "Rol de usuario no reconocido";
                }
            } else {
                return "Usuario o contraseña incorrectos";
            }
        }
    }
    
    
    public function listarUsuarios() {
        $usuarios = $this->modeloUsuario->listarUsuarios();
        return $usuarios;
    }
    
    public function verificarSesion() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        
        if (!isset($_SESSION['usuario'])) {
            header("Location: /iglesia/vistas/visitas/login.php");
            exit();
        }
        return $_SESSION['usuario'];
    }
    

    public function verificarRol($rolesPermitidos) {
        
        if (!isset($_SESSION['rol']) || !in_array($_SESSION['rol'], $rolesPermitidos)) {
            header("Location: /iglesia/vistas/error/sin_permisos.php");
            exit();
        }
    }
    public function nuevoUsuario($nombre, $email,  $password,$estado,$rol) {
        $resultado = $this->modeloUsuario->existeUsuario($email);
        if (!$resultado) {
            $this->modeloUsuario->nuevoUsuario($nombre, $email, $password,$estado,$rol);
        }else{
           throw new Exception("El email ya está registrado");
        }
       
    }

    public function editarUsuario($id, $nombre, $email,$password,$estado,$rol) {
        $respuesta=$this->modeloUsuario->editarUsuario($id, $nombre, $email,$password,$estado,$rol);
        if($respuesta){
            return ['status' => 'success', 'message' => 'Usuario editado exitosamente.'];
        }else{
            return ['status' => 'error', 'message' => 'Error al editar el usuario.'];
        }
    }

    public function getUsuarioPorId($id) {
        return $this->modeloUsuario->getUsuarioPorId($id);
    }
}

function login() {
    $controlador = new ControladorUsuario();
    return $controlador->login();
}

function logout() {
    $controlador = new ControladorUsuario();
    return $controlador->logout();
}

function verificarSesion() {
    $controlador = new ControladorUsuario();
    return $controlador->verificarSesion();
}

function verificarRol($roles) {
    $controlador = new ControladorUsuario();
    return $controlador->verificarRol($roles);
}
?>