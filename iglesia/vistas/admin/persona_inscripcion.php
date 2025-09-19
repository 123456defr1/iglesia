<?php
include_once(__DIR__ . "/../../controladores/controladorpersona.php");

$usuario = verificarSesion();
verificarRol(['admin']);

$controlador = new controlador_persona();

// Listados para los select
$iglesias = $controlador->listarIglesias();
$distritos = $controlador->listarDistritos();
$tallas = $controlador->listarTallasCamisa();
$condiciones = $controlador->listarCondicionesMedicas();
$actividades = $controlador->listarActividades();

// Convertimos actividades a JSON para JS
$actividades_json = json_encode(array_column($actividades, null, 'id'), JSON_NUMERIC_CHECK);

// Procesar formulario
if (isset($_POST['agregar_persona'])) {
    // Validaciones adicionales según el estado
    $estado = $_POST['estado'];
    $monto_total = floatval($_POST['monto_total'] ?? 0);
    $cantidad_pagos = floatval($_POST['cantidad_pagos'] ?? 0);
    
    // Validar según el estado seleccionado
    if ($estado === 'pagado' && $cantidad_pagos == 0) {
        $mensaje = "Error: Si el estado es 'Pagado', debe indicar el monto pagado";
        $tipoMensaje = "danger";
    } else if ($estado === 'parcial' && $cantidad_pagos == 0) {
        $mensaje = "Error: Si el estado es 'Parcial', debe indicar el monto del pago parcial";
        $tipoMensaje = "danger";
    } else if ($estado === 'parcial' && $cantidad_pagos >= $monto_total) {
        $mensaje = "Error: El pago parcial no puede ser mayor o igual al monto total";
        $tipoMensaje = "danger";
    } else {
        // Calcular montos según el estado
        $monto_pagado = 0;
        $monto_restante = $monto_total;
        
        if ($estado === 'pagado') {
            $monto_pagado = $monto_total;
            $monto_restante = 0;
            $cantidad_pagos = $monto_total;
        } else if ($estado === 'parcial') {
            $monto_pagado = $cantidad_pagos;
            $monto_restante = $monto_total - $cantidad_pagos;
        }
        
        $datos = [
            'nombre' => $_POST['nombre'],
            'apellido' => $_POST['apellido'],
            'edad' => $_POST['edad'],
            'genero' => $_POST['genero'],
            'rol' => $_POST['rol'],
            'estado' => $estado,
            'cantidad_pagos' => $cantidad_pagos,
            'monto_total' => $monto_total,
            'metodo_pago' => $_POST['metodo_pago'] ?? 'efectivo',
            'iglesia_id' => $_POST['iglesia_id'],
            'distrito_id' => $_POST['distrito_id'],
            'usuario_id' => $_SESSION['usuario']['id'] ?? 1,
            'talla_camisa_id' => $_POST['talla_camisa_id'],
            'condicion_medica_id' => $_POST['condicion_medica_id'],
            'actividad_id' => $_POST['actividad_id'],
            'monto_pagado' => $monto_pagado,
            'monto_restante' => $monto_restante,
            'estado_inscripcion' => 'inscrito'
        ];

        $persona_id = $controlador->registrarPersonaEInscripcion($datos);
        if ($persona_id) {
            $mensaje = "Persona registrada con ID: $persona_id";
            $tipoMensaje = "success";
        } else {
            $mensaje = "Error al registrar persona";
            $tipoMensaje = "danger";
        }
    }
}
?>

<div class="container my-5">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white text-center">
            <h2>Registrar Persona</h2>
        </div>
        <div class="card-body">
            <?php if(isset($mensaje)): ?>
                <div class="alert alert-<?= $tipoMensaje ?> alert-dismissible fade show" role="alert">
                    <?= $mensaje ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <form action="" method="post" id="formRegistro">
                <div class="row g-3">
                    <!-- Datos personales -->
                    <div class="col-md-6">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" name="nombre" id="nombre" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label for="apellido" class="form-label">Apellido</label>
                        <input type="text" name="apellido" id="apellido" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label for="edad" class="form-label">Edad</label>
                        <input type="number" name="edad" id="edad" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label for="genero" class="form-label">Género</label>
                        <select name="genero" id="genero" class="form-select" required>
                            <option value="">Seleccione género</option>
                            <option value="M">Masculino</option>
                            <option value="F">Femenino</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="rol" class="form-label">Rol</label>
                        <select name="rol" id="rol" class="form-select" required>
                            <option value="visitante">Visitante</option>
                            <option value="miembro">Miembro</option>
                        </select>
                    </div>

                    <!-- Estado, iglesia y distrito -->
                    <div class="col-md-6">
                        <label for="estado" class="form-label">Estado</label>
                        <select name="estado" id="estado" class="form-select" required>
                            <option value="pendiente">Pendiente</option>
                            <option value="pagado">Pagado</option>
                            <option value="parcial">Parcial</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="iglesia_id" class="form-label">Iglesia</label>
                        <select name="iglesia_id" id="iglesia_id" class="form-select" required>
                            <option value="">Seleccione iglesia</option>
                            <?php foreach($iglesias as $iglesia): ?>
                                <option value="<?= $iglesia['id'] ?>"><?= $iglesia['nombre'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="distrito_id" class="form-label">Distrito</label>
                        <select name="distrito_id" id="distrito_id" class="form-select" required>
                            <option value="">Seleccione distrito</option>
                            <?php foreach($distritos as $distrito): ?>
                                <option value="<?= $distrito['id'] ?>"><?= $distrito['nombre'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Talla y condición médica -->
                    <div class="col-md-3">
                        <label for="talla_camisa_id" class="form-label">Talla de camisa</label>
                        <select name="talla_camisa_id" id="talla_camisa_id" class="form-select" required>
                            <option value="">Seleccione talla</option>
                            <?php foreach($tallas as $talla): ?>
                                <option value="<?= $talla['id'] ?>"><?= $talla['talla'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="condicion_medica_id" class="form-label">Condición médica</label>
                        <select name="condicion_medica_id" id="condicion_medica_id" class="form-select" required>
                            <option value="">Seleccione condición</option>
                            <?php foreach($condiciones as $condicion): ?>
                                <option value="<?= $condicion['id'] ?>"><?= $condicion['descripcion'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Actividad y montos -->
                    <div class="col-md-6">
                        <label for="actividad_id" class="form-label">Actividad</label>
                        <select name="actividad_id" id="actividad_id" class="form-select" required>
                            <option value="">Seleccione actividad</option>
                            <?php foreach ($actividades as $actividad): ?>
                                <option value="<?= $actividad['id'] ?>" data-costo="<?= $actividad['costo'] ?>">
                                    <?= $actividad['nombre'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="monto_total" class="form-label">Monto a Pagar</label>
                        <input type="number" name="monto_total" id="monto_total" class="form-control" readonly step="0.01">
                    </div>

                    <!-- Campo para monto de pago, oculto inicialmente -->
                    <div class="col-md-6" id="div_monto_pago" style="display:none;">
                        <label for="cantidad_pagos" class="form-label">Monto del Pago</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" name="cantidad_pagos" id="cantidad_pagos" class="form-control" min="0" step="0.01">
                        </div>
                        <div class="form-text" id="texto_ayuda_pago"></div>
                    </div>

                    <!-- Método de pago, oculto inicialmente -->
                    <div class="col-md-6" id="div_metodo_pago" style="display:none;">
                        <label for="metodo_pago" class="form-label">Método de Pago</label>
                        <select name="metodo_pago" id="metodo_pago" class="form-select">
                            <option value="efectivo">Efectivo</option>
                            <option value="tarjeta">Tarjeta</option>
                            <option value="transferencia">Transferencia</option>
                            <option value="otro">Otro</option>
                        </select>
                    </div>
                </div>

                <div class="d-grid mt-4">
                    <button type="submit" name="agregar_persona" class="btn btn-success btn-lg">Registrar Persona</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const actividadSelect = document.getElementById('actividad_id');
    const montoTotalInput = document.getElementById('monto_total');
    const estadoSelect = document.getElementById('estado');
    const divMontoPago = document.getElementById('div_monto_pago');
    const divMetodoPago = document.getElementById('div_metodo_pago');
    const cantidadPagosInput = document.getElementById('cantidad_pagos');
    const textoAyudaPago = document.getElementById('texto_ayuda_pago');
    
    // Datos de actividades desde PHP
    const actividades = <?= $actividades_json ?>;
    
    // Actualizar monto total cuando se selecciona una actividad
    actividadSelect.addEventListener('change', function() {
        const actividadId = this.value;
        if (actividadId && actividades[actividadId]) {
            montoTotalInput.value = actividades[actividadId].costo;
        } else {
            montoTotalInput.value = '';
        }
        
        // Revalidar el estado al cambiar actividad
        manejarCambioEstado();
    });
    
    // Manejar cambio de estado
    estadoSelect.addEventListener('change', manejarCambioEstado);
    
    function manejarCambioEstado() {
        const estado = estadoSelect.value;
        const montoTotal = parseFloat(montoTotalInput.value) || 0;
        
        // Resetear campos
        cantidadPagosInput.value = '';
        cantidadPagosInput.removeAttribute('required');
        
        if (estado === 'pendiente') {
            // Ocultar campos de pago
            divMontoPago.style.display = 'none';
            divMetodoPago.style.display = 'none';
            textoAyudaPago.textContent = '';
            // Limpiar validaciones
            cantidadPagosInput.removeAttribute('min');
            cantidadPagosInput.removeAttribute('max');
            
        } else if (estado === 'parcial') {
            // Mostrar campos para pago parcial
            divMontoPago.style.display = 'block';
            divMetodoPago.style.display = 'block';
            cantidadPagosInput.setAttribute('required', 'required');
            cantidadPagosInput.removeAttribute('min'); // Limpiar min anterior
            cantidadPagosInput.removeAttribute('max'); // Limpiar max anterior
            cantidadPagosInput.min = '0.01';
            cantidadPagosInput.max = montoTotal - 0.01; // No puede ser igual o mayor al total
            textoAyudaPago.textContent = `Ingrese el monto del pago parcial (máximo: ${(montoTotal - 0.01).toFixed(2)})`;
            textoAyudaPago.className = 'form-text text-info';
            
        } else if (estado === 'pagado') {
            // Mostrar campos para pago completo
            divMontoPago.style.display = 'block';
            divMetodoPago.style.display = 'block';
            cantidadPagosInput.setAttribute('required', 'required');
            cantidadPagosInput.removeAttribute('min'); // Limpiar min anterior
            cantidadPagosInput.removeAttribute('max'); // Limpiar max anterior
            cantidadPagosInput.value = montoTotal;
            cantidadPagosInput.min = montoTotal;
            cantidadPagosInput.max = montoTotal;
            textoAyudaPago.textContent = `Pago completo: ${montoTotal.toFixed(2)}`;
            textoAyudaPago.className = 'form-text text-success';
        }
    }
    
    // Validar monto de pago en tiempo real
    cantidadPagosInput.addEventListener('input', function() {
        const estado = estadoSelect.value;
        const montoTotal = parseFloat(montoTotalInput.value) || 0;
        const montoPago = parseFloat(this.value) || 0;
        
        if (estado === 'parcial') {
            if (montoPago >= montoTotal) {
                textoAyudaPago.textContent = 'Error: El pago parcial debe ser menor al monto total';
                textoAyudaPago.className = 'form-text text-danger';
                this.setCustomValidity('El pago parcial debe ser menor al monto total');
            } else if (montoPago <= 0) {
                textoAyudaPago.textContent = 'Error: El monto del pago debe ser mayor a 0';
                textoAyudaPago.className = 'form-text text-danger';
                this.setCustomValidity('El monto del pago debe ser mayor a 0');
            } else {
                const montoRestante = montoTotal - montoPago;
                textoAyudaPago.textContent = `Monto restante: ${montoRestante.toFixed(2)}`;
                textoAyudaPago.className = 'form-text text-info';
                this.setCustomValidity('');
                // Actualizar dinámicamente los límites
                this.min = '0.01';
                this.max = montoTotal - 0.01;
            }
        } else if (estado === 'pagado') {
            if (montoPago !== montoTotal) {
                textoAyudaPago.textContent = 'Error: Para estado "Pagado", el monto debe ser igual al total';
                textoAyudaPago.className = 'form-text text-danger';
                this.setCustomValidity('Para estado "Pagado", el monto debe ser igual al total');
            } else {
                textoAyudaPago.textContent = `Pago completo: ${montoTotal.toFixed(2)}`;
                textoAyudaPago.className = 'form-text text-success';
                this.setCustomValidity('');
                // Fijar los límites para pago completo
                this.min = montoTotal;
                this.max = montoTotal;
            }
        }
    });
    
    // Validación adicional al enviar el formulario
    document.getElementById('formRegistro').addEventListener('submit', function(e) {
        const estado = estadoSelect.value;
        const montoTotal = parseFloat(montoTotalInput.value) || 0;
        const montoPago = parseFloat(cantidadPagosInput.value) || 0;
        
        if (estado === 'pagado' && montoPago === 0) {
            e.preventDefault();
            alert('Error: Si el estado es "Pagado", debe indicar el monto del pago');
            return false;
        }
        
        if (estado === 'parcial' && montoPago === 0) {
            e.preventDefault();
            alert('Error: Si el estado es "Parcial", debe indicar el monto del pago parcial');
            return false;
        }
        
        if (estado === 'parcial' && montoPago >= montoTotal) {
            e.preventDefault();
            alert('Error: El pago parcial no puede ser mayor o igual al monto total');
            return false;
        }
        
        return true;
    });
});
</script>