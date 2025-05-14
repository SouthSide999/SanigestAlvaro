(function () {
    const ponentesInput = document.querySelector('#ponentes')
    if (ponentesInput) {
        let ponentes = []
        let ponentesFiltrados = []

        const listadoPonentes = document.querySelector('#listado-ponentes')//elemento html para incrustar la busqueda
        const ponenteHidden = document.querySelector('[name="ponente_id"]')//elemento html para llenar valor en la base de datos


        obtenerponentes()

        ponentesInput.addEventListener('input', buscarPonentes)


        if (ponenteHidden.value) {

            (async () => { //segunda forma con iife
                const ponente = await obtenerponente(ponenteHidden.value)
                const { nombre, apellido } = ponente
                const ponenteDOM = document.createElement('LI')//crear elemento
                ponenteDOM.classList.add('listado-ponentes__ponente', 'listado-ponentes__ponente--seleccionado')//clase
                ponenteDOM.textContent = `${nombre} ${apellido}`//contenido
                console.log(ponenteHidden.value);
                listadoPonentes.appendChild(ponenteDOM)//agregar al dom
            })()

        }
        async function obtenerponentes() {//para crear

            const url = `/api/ponentes`
            const respuesta = await fetch(url)
            const resultado = await respuesta.json()

            formatearPonentes(resultado)
        }
        async function obtenerponente(id) {//para actualizar

            const url = `/api/ponente?id=${id}`
            const respuesta = await fetch(url)
            const resultado = await respuesta.json()
            return resultado
        }

        function formatearPonentes(arrayPonentes = []) {
            ponentes = arrayPonentes.map(ponente => {
                return {
                    nombre: `${ponente.nombre.trim()} ${ponente.apellido.trim()}`,
                    id: ponente.id
                }
            })
        }

        function buscarPonentes(e) {
            const busqueda = e.target.value

            if (busqueda.length > 3) {
                const expresion = new RegExp(busqueda, "i") //buscar en mayusculas y minusculas no importa  con expresion regular
                ponentesFiltrados = ponentes.filter(ponente => {
                    if (ponente.nombre.toLowerCase().search(expresion) != -1) {
                        return ponente
                    }
                })
            } else {
                ponentesFiltrados = []//limpiar resultado
            }

            mostrarPonentes()
        }

        function mostrarPonentes() {

            // listadoPonentes.innerHTML = ''//limpiar el  html primera forma

            while (listadoPonentes.firstChild) {//segunda forma para limpiar html
                listadoPonentes.removeChild(listadoPonentes.firstChild)
            }

            if (ponentesFiltrados.length > 0) { //si hay algo muestra 
                ponentesFiltrados.forEach(ponente => {
                    const ponenteHTML = document.createElement('LI')//crear elemento
                    ponenteHTML.classList.add('listado-ponentes__ponente')//clase
                    ponenteHTML.textContent = ponente.nombre//contenido
                    ponenteHTML.dataset.ponenteId = ponente.id//dar valor al input hidden

                    ponenteHTML.onclick = seleccionarPonente//si da click a un ponente

                    listadoPonentes.appendChild(ponenteHTML)//agregar al dom

                });
            } else {//no hay resultados
                const noResultado = document.createElement('P')//crear elemento
                noResultado.classList.add('listado-ponentes__no-resultado')//clase
                noResultado.textContent = 'No Hay Resultados'//contenido
                listadoPonentes.appendChild(noResultado)//agregar al dom
            }
        }

        function seleccionarPonente(e) {
            const ponente = e.target

            const ponentePrevio = document.querySelector('.listado-ponentes__ponente--seleccionado')//limpiar ponente previo
            if (ponentePrevio) {
                ponentePrevio.classList.remove('listado-ponentes__ponente--seleccionado')
            }


            ponente.classList.add('listado-ponentes__ponente--seleccionado')//agregar clase seleccionado


            ponenteHidden.value = ponente.dataset.ponenteId //valor para la base de datos 
        }
    }

})()