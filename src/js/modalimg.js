document.addEventListener("DOMContentLoaded", function () {
    const imagenes = document.querySelectorAll(".imagen-evidencia");
    const modal = document.getElementById("modalEvidencia");
    const modalImg = document.getElementById("modalImg");
    const descargarBtn = document.getElementById("descargarImg");
    const closeModal = document.querySelector(".close");

    imagenes.forEach(img => {
        img.addEventListener("click", function () {
            modal.style.display = "flex"; // Muestra el modal
            modalImg.src = this.src; // Carga la imagen seleccionada
            descargarBtn.href = this.src; // Configura la descarga
        });
    });

    closeModal.addEventListener("click", function () {
        modal.style.display = "none"; // Cierra el modal
    });

    modal.addEventListener("click", function (e) {
        if (e.target === modal) {
            modal.style.display = "none";
        }
    });
});
