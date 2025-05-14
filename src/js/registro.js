import Swal from 'sweetalert2'

(function () {
    let eventos = [];
    const resumen = document.querySelector('#registro-resumen')

    if (resumen) {
        const eventoBoton = document.querySelectorAll('.evento__agregar')

        const formularioRegistro = document.querySelector('#registro')//guardar registro 
        formularioRegistro.addEventListener('submit', submitFormulario)


        eventoBoton.forEach(boton => boton.addEventListener('click', seleccionarEvento));

        mostrareventos()//llamar a mostrar eventos o mensaje por default
        function seleccionarEvento(e) {


            if (eventos.length < 5) {
                //desbilitar el evento para que no seleccione multiples veces
                e.target.disabled = true
                eventos = [...eventos, {//obtiene los datos de los eventos seleccionados
                    id: e.target.dataset.id,
                    titulo: e.target.parentElement.querySelector('.evento__nombre').textContent.trim()
                }]
                mostrareventos()
            } else {
                Swal.fire({
                    title: 'Error',
                    text: 'Máximo 5 eventos por registro',
                    icon: 'error',
                    confirmButtonText: 'OK'
                })
            }
        }

        function mostrareventos() {

            //limpiar html
            limpiarEventos()

            if (eventos.length > 0) {//crear elementos para el DOM
                eventos.forEach(evento => {
                    const eventoDOM = document.createElement('DIV')
                    eventoDOM.classList.add('registro__evento')

                    const titulo = document.createElement('H3')
                    titulo.classList.add('registro__nombre')
                    titulo.textContent = evento.titulo

                    const botonEliminar = document.createElement('BUTTON')
                    botonEliminar.classList.add('registro__eliminar')
                    botonEliminar.innerHTML = `<i class="fa-solid fa-trash"></i>`
                    botonEliminar.onclick = function () {
                        eliminarEvento(evento.id)
                    }


                    // renderizar en el html
                    eventoDOM.appendChild(titulo)
                    eventoDOM.appendChild(botonEliminar)
                    resumen.appendChild(eventoDOM)
                })
            } else {
                const noRegistro = document.createElement('P')
                noRegistro.textContent = 'No hay eventos, añade hasta 5 del lado izquierdo'
                noRegistro.classList.add('registro__texto')
                resumen.appendChild(noRegistro)
            }
        }
        function eliminarEvento(id) {
            eventos = eventos.filter(evento => evento.id !== id)
            const botonAgregar = document.querySelector(`[data-id="${id}"]`)//si se quiere volver a seleccionar ese evento
            botonAgregar.disabled = false
            mostrareventos()
        }


        function limpiarEventos() {
            while (resumen.firstChild) {
                resumen.removeChild(resumen.firstChild);
            }
        }

        async function submitFormulario(e) {
            e.preventDefault()

            const regalo = document.querySelector('#regalo').value//obtener regalo 

            const eventosId = eventos.map(evento => evento.id)//obtener eventos seleccionado 

            if (eventosId.length === 0 || regalo === '') {//validacion y alerta
                Swal.fire({
                    title: 'Error',
                    text: 'Elije al menos un Evento y un Regalo',
                    icon: 'error',
                    confirmButtonText: 'OK'
                })
                return
            }
            //objeto de form daata para mandar datos 
            const datos = new FormData();
            datos.append('eventos', eventosId)
            datos.append('regalo_id', regalo)


            const url = '/finalizar-registro/conferencias'

            const repuesta = await fetch(url, {
                method: 'POST',
                body: datos
            })

            const resultado = await repuesta.json()

            console.log(resultado);
            if (resultado.resultado) {//mostrar alerta de exito o error
                Swal.fire({
                    title: 'Registro Exitoso',
                    text: 'Se registro tu conferencias correctamente te esperamos',
                    icon: 'success',
                    timer: 3000,
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.location.href = `/boleto?id=${resultado.token}`; // Redirigir después de cerrar la alerta
                });
            } else {
                Swal.fire({
                    title: 'Error',
                    text: 'No se pudo registrar correctamente',
                    icon: 'error',
                    confirmButtonText: 'OK'
                }).then(()=> location.reload()) //recargar pagina
            }
        }
    }
}())