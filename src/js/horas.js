(function () {
    const horas = document.querySelector('#horas')
    if (horas) {
        //selecionar categoria
        const categoria = document.querySelector('[name="categoria_id"]')
        categoria.addEventListener('change', terminoBusqueda);


        //selecionar dia
        const dias = document.querySelectorAll('[name="dia"]')
        const inputHiddenDia = document.querySelector('[name="dia_id"]')
        dias.forEach(dia => dia.addEventListener('change', terminoBusqueda));


        //para ingresar al hidden hora
        const inputHiddenHora = document.querySelector('[name="hora_id"]')

        let busqueda = {
            categoria_id: categoria.value || '',//para actualizar
            dia: inputHiddenDia.value || ''//para actualizar
        }

        if (!Object.values(busqueda).includes('')) {//si ya se tiene los datos 

            // async function inicializarHora() { //primera forma
            //     await buscarEventos()
            //     //resaltar la hora actual del evento 
            //     const id = inputHiddenDia.value
            //     const horaSeleccionada = document.querySelector(`[data-hora-id="${id}"]`)

            //     //aplicar html
            //     horaSeleccionada.classList.remove('horas__hora--deshabilitada')
            //     horaSeleccionada.classList.add('horas__hora--seleccionada')
            // }

            (async () => { //segunda forma con iife
                await buscarEventos()
                //resaltar la hora actual del evento 
                const id = inputHiddenDia.value
                const horaSeleccionada = document.querySelector(`[data-hora-id="${id}"]`)

                //aplicar html
                horaSeleccionada.classList.remove('horas__hora--deshabilitada')
                horaSeleccionada.classList.add('horas__hora--seleccionada')
            })()

            inicializarHora()

        }

        console.log(busqueda);

        function terminoBusqueda(e) {//!importante
            busqueda[e.target.name] = e.target.value

            //reiniciar los campos ocultos
            inputHiddenDia.value = ''
            inputHiddenHora.value = ''

            const horaPrevia = document.querySelector('.horas__hora--seleccionada')
            if (horaPrevia) {

                horaPrevia.classList.remove('horas__hora--seleccionada')
            }

            if (Object.values(busqueda).includes('')) { //si busqueda no esta lleno no se comunica con el api
                return
            }
            buscarEventos()
        }

        //comunicarse con la api
        async function buscarEventos() {

            const { dia, categoria_id } = busqueda
            const url = `/api/eventos-horario?dia_id=${dia}&categoria_id=${categoria_id}`

            const resultado = await fetch(url)
            const eventos = await resultado.json()

            obtenerHorasDisponibles(eventos);
        }

        function obtenerHorasDisponibles(eventos) {

            //reinciar las horas
            const listadoHoras = document.querySelectorAll('#horas Li')
            listadoHoras.forEach(li => li.classList.add('horas__hora--deshabilitada'));

            //comprobar eventos y listar las desabilitadas
            const horasTomadas = eventos.map(evento => evento.hora_id)

            const listadoHorasArray = Array.from(listadoHoras)

            const resultado = listadoHorasArray.filter(li => !horasTomadas.includes(li.dataset.horaId))

            resultado.forEach(li => li.classList.remove('horas__hora--deshabilitada'));


            const horasDisponibles = document.querySelectorAll('#horas li:not(.horas__hora--deshabilitada)')
            horasDisponibles.forEach(hora => hora.addEventListener('click', seleccionarHora));

        }

        function seleccionarHora(e) {
            //desabilitar la hora previa, si hay un nuev click
            const horaPrevia = document.querySelector('.horas__hora--seleccionada')
            if (horaPrevia) {
                horaPrevia.classList.remove('horas__hora--seleccionada')
            }

            //agregar clase para saber que hora se selecciono 
            e.target.classList.add('horas__hora--seleccionada')
            inputHiddenHora.value = e.target.dataset.horaId

            //llenar campo oculto de dia
            inputHiddenDia.value = document.querySelector('[name="dia"]:checked').value
        }

    }

})()