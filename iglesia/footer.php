</div>
</div>
  <footer>
    © <?php echo date("Y"); ?> Iglesia - Todos los derechos reservados
    <p> esta pagina es hecha por fernando peñate</p>
  </footer>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Redirigir al seleccionar un ministerio
    document.addEventListener("DOMContentLoaded", function() {
      const select = document.getElementById("ministeriosSelect");
      select.addEventListener("change", function() {
        if (this.value) {
          window.location.href = this.value;
        }
      });
    });
  </script>
</body>
</html>
