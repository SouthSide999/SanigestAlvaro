(function () {


    const tagsInput = document.querySelector('#tags_input')
    if (tagsInput) {

        const tagsDiv = document.querySelector('#tags')
        const tagsInputHidden = document.querySelector('[name="tags"]')

        let tags = [];
        
        // Recuperar del input oculto
        if(tagsInputHidden.value !== '') {
            tags = tagsInputHidden.value.split(',');
            mostrarTags();
        }


        //escuchar los cambios en el input
        tagsInput.addEventListener('keypress', guardarTag)

        function guardarTag(e) {
            if (e.keyCode === 44) {

                if (e.target.value.trim() === '' || e.target.value < 1) {
                    return
                }
                e.preventDefault()

                //agregar al arreglo y hacer copia con destructurind
                tags = [...tags, e.target.value.trim()]
                tagsInput.value = ''; //limpiar 


                mostrarTags()
            }
        }


        function mostrarTags() {
            tagsDiv.textContent = ''

            tags.forEach(tag => {
                const etiqueta = document.createElement('LI')
                etiqueta.classList.add('formulario__tag')
                etiqueta.textContent = tag
                etiqueta.ondblclick = eleminarTag //eliminar tag
                tagsDiv.appendChild(etiqueta)

            });
            actualizarInputHidden()
        }

        function eleminarTag(e) {
            e.target.remove()
            tags = tags.filter(tag => tag !== e.target.textContent)
            actualizarInputHidden()

        }
        function actualizarInputHidden() {
            tagsInputHidden.value = tags.toString()
        }
    }
})()

