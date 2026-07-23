document.addEventListener("DOMContentLoaded", function () {

    const video = document.getElementById("video");
    const btn = document.getElementById("btnFacial");
    const emailInput = document.getElementById("email");

    if (!video || !btn) return; // solo ejecuta si estamos en esa vista

    let stream;

    // Activar cámara
    navigator.mediaDevices.getUserMedia({ video: true })
        .then(s => {
            stream = s;
            video.srcObject = stream;
        })
        .catch(() => {
            alert("No se pudo acceder a la cámara");
        });

    btn.addEventListener("click", function () {

        const email = emailInput.value.trim();

        if (!email) {
            alert("Ingresa tu email primero");
            return;
        }

        const canvas = document.createElement("canvas");
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;

        canvas.getContext("2d").drawImage(video, 0, 0);

        const imagen = canvas.toDataURL("image/jpeg");

        fetch("http://localhost:5000/recognize", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({
                email: email,
                image: imagen
            })
        })
        .then(res => res.json())
        .then(data => {

            if (data.acceso) {

                stream.getTracks().forEach(track => track.stop());

                const form = document.createElement("form");
                form.method = "POST";
                form.action = "/auth/loginfacial";

                const input = document.createElement("input");
                input.type = "hidden";
                input.name = "email";
                input.value = email;

                form.appendChild(input);
                document.body.appendChild(form);
                form.submit();

            } else {
                alert("El rostro no coincide con el email");
            }
        });

    });

});
