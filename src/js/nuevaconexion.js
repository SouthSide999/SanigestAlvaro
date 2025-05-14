document.addEventListener("DOMContentLoaded", function () {
    // MODAL de términos y condiciones
    const requisitos = document.querySelector('.requisitos');
    const formulario = document.querySelector('.nuevaconexion__formulario');
    const modal = document.querySelector('.nuevaconexion__modal');
    const botonModal = document.querySelector('.requisitos__boton:last-child');
    const botonCerrarModal = document.querySelector('.nuevaconexion__modal__boton');

    if (modal) modal.style.display = 'none';

    if (botonModal && modal) {
        botonModal.addEventListener('click', function () {
            modal.style.display = 'flex';
        });
    }

    if (botonCerrarModal && modal) {
        botonCerrarModal.addEventListener('click', function () {
            modal.style.display = 'none';
        });
    }

    // SELECCIÓN tipo solicitante y tipo persona
    const tipoSolicitante = document.getElementById("tipo_solicitante");
    const tipoPersona = document.getElementById("tipo_persona");
    const representanteCampos = document.getElementById("representanteCampos");
    const naturalCampos = document.getElementById("naturalCampos");
    const juridicoCampos = document.getElementById("juridicoCampos");

    function actualizarRepresentante() {
        if (representanteCampos && tipoSolicitante) {
            representanteCampos.style.display = tipoSolicitante.value === "representante" ? "block" : "none";
        }
    }

    function actualizarTipoPersona() {
        if (naturalCampos && juridicoCampos && tipoPersona) {
            naturalCampos.style.display = tipoPersona.value === "natural" ? "block" : "none";
            juridicoCampos.style.display = tipoPersona.value === "juridico" ? "block" : "none";
        }
    }

    if (tipoSolicitante) tipoSolicitante.addEventListener("change", actualizarRepresentante);
    if (tipoPersona) tipoPersona.addEventListener("change", actualizarTipoPersona);

    actualizarRepresentante();
    actualizarTipoPersona();

    // PREVISUALIZACIÓN de imágenes en inputs file
    function previsualizarImagen(inputId) {
        var input = document.getElementById(inputId);
        if (!input) return;

        input.addEventListener("change", function (event) {
            var file = event.target.files[0];
            var previewId = "preview_" + inputId;
            var preview = document.getElementById(previewId);

            if (!preview) {
                preview = document.createElement("img");
                preview.id = previewId;
                preview.style.display = "none";
                preview.style.maxWidth = "200px";
                preview.style.marginTop = "10px";
                preview.style.border = "1px solid #ccc";
                preview.style.padding = "5px";
                input.parentNode.appendChild(preview);
            }

            if (file) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    preview.src = e.target.result;
                    preview.style.display = "block";
                };
                reader.readAsDataURL(file);
            } else {
                preview.src = "";
                preview.style.display = "none";
            }
        });
    }

    // Aplicar a todos los inputs file
    const inputsFile = document.querySelectorAll("input[type='file']");
    inputsFile.forEach(input => {
        if (input.id) previsualizarImagen(input.id);
    });

    // MODALES para rechazo y asignación de personal
    const btnRechazar = document.getElementById('btnRechazar');
    const btnAsignar = document.getElementById('btnAsignar');
    const btnCerrarObservaciones = document.getElementById('btnCerrarObservaciones');
    const btnCerrarAsignacion = document.getElementById('btnCerrarAsignacion');
    const btnConfirmarRechazo = document.getElementById('btnConfirmarRechazo');
    const btnConfirmarAsignacion = document.getElementById('btnConfirmarAsignacion');

    function cerrarModal(id) {
        const modal = document.getElementById(id);
        if (modal) modal.style.display = 'none';
    }

    if (btnRechazar) {
        btnRechazar.addEventListener('click', function () {
            document.getElementById('estadoSolicitud').value = '3';
            document.getElementById('modalnuevaconexionObservaciones').style.display = 'flex';
        });
    }

    if (btnAsignar) {
        btnAsignar.addEventListener('click', function () {
            document.getElementById('modalnuevaconexionAsignacion').style.display = 'flex';
        });
    }

    if (btnCerrarObservaciones) {
        btnCerrarObservaciones.addEventListener('click', function () {
            cerrarModal('modalnuevaconexionObservaciones');
        });
    }

    if (btnCerrarAsignacion) {
        btnCerrarAsignacion.addEventListener('click', function () {
            cerrarModal('modalnuevaconexionAsignacion');
        });
    }

    if (btnConfirmarRechazo) {
        btnConfirmarRechazo.addEventListener('click', function () {
            cerrarModal('modalnuevaconexionObservaciones');
        });
    }

    if (btnConfirmarAsignacion) {
        btnConfirmarAsignacion.addEventListener('click', function () {
            cerrarModal('modalnuevaconexionAsignacion');
        });
    }



});
