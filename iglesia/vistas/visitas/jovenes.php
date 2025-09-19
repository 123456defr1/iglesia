<style>
#myCarousel {
    max-width: 700px; /* ajusta el ancho que desees */
    margin: 0 auto;   /* centra el carrusel */
}
</style>

<div class="container">
    <h2>Departamento Jóvenes</h2>
    
    <!-- Carousel -->
    <div id="myCarousel" class="carousel slide" data-bs-ride="carousel">
        <!-- Indicators -->
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="0" class="active"></button>
            <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="1"></button>
            <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="2"></button>
        </div>

        <!-- Wrapper for slides -->
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="/iglesia/recursos/jovenes/jovenes1.png" class="d-block w-100" alt="Ministerio Infantil">
            </div>
            <div class="carousel-item">
                <img src="/iglesia/recursos/jovenes/jovenes2.png" class="d-block w-100" alt="Actividades">
            </div>
            <div class="carousel-item">
                <img src="/iglesia/recursos/jovenes/prueba.png" class="d-block w-100" alt="Eventos">
            </div>
        </div>

        <!-- Controls -->
        <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
    
   
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var myCarousel = new bootstrap.Carousel(document.getElementById('myCarousel'), {
        interval: 4000, // Cambia cada 5 segundos
        wrap: true
    });
});
</script>
