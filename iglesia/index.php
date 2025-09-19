<?php
// Start output buffering at the very beginning
ob_start();

// Process the URL and check if the file exists
$url = isset($_GET['url']) ? rtrim($_GET['url'], "/") : "inicio";
$archivo = "vistas/visitas/" . $url . ".php";

// Handle redirects before any output
if (!file_exists($archivo)) {
    header("Location: /iglesia/");
    exit();
}

// If we get here, the file exists and we can include it
include "header.php";
include $archivo;
include "footer.php";

// Flush the output buffer
ob_end_flush();
?>