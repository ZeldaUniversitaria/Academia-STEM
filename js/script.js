function votar(universidad) {
    fetch('votar.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: 'universidad=' + encodeURIComponent(universidad)
    })
    .then(response => response.json())
    .then(data => {
        if (data.exito) {
            // Actualizar contador correspondiente
            switch (universidad) {
                case 'ITCJ':
                    document.getElementById('contador1').textContent = data.votos;
                    break;
                case 'TEC':
                    document.getElementById('contador2').textContent = data.votos;
                    break;
                case 'URN':
                    document.getElementById('contador3').textContent = data.votos;
                    break;
                case 'UACJ':
                    document.getElementById('contador4').textContent = data.votos;
                    break;
                case 'UACH':
                    document.getElementById('contador5').textContent = data.votos;
                    break;
            }

            // Deshabilitar todos los botones
            const botones = document.querySelectorAll('.boton-votar');
            botones.forEach(boton => {
                boton.disabled = true;
                boton.textContent = 'Votado';
            });

            // Mostrar texto de confirmación
            const subtitulo = document.getElementById('subtitulo');
            const mensaje = document.createElement('p');
            mensaje.textContent = "Usted ha votado por " + universidad;
            mensaje.style.color = "green";
            subtitulo.insertAdjacentElement('afterend', mensaje);
        } else {
            alert(data.mensaje || "Error al registrar el voto.");
        }
    })
    .catch(error => {
        console.error("Error en la solicitud:", error);
        alert("Ocurrió un error. Intente más tarde.");
    });
}

// const boton1 = document.getElementById('miBoton1');
// const contador1 = document.getElementById('contador1');

// const boton2 = document.getElementById('miBoton2');
// const contador2 = document.getElementById('contador2');

// const boton3 = document.getElementById('miBoton3');
// const contador3 = document.getElementById('contador3');

// const boton4 = document.getElementById('miBoton4');
// const contador4 = document.getElementById('contador4');

// const boton5 = document.getElementById('miBoton5');
// const contador5 = document.getElementById('contador5');

// let itcj =0, tec =0, urn =0, uacj =0, uach=0;

// boton1.addEventListener('click', function() {
//     itcj++;
//     contador1.textContent = itcj;
//     boton1.disabeled = true;
//     boton1.textContent = 'votado';
// });

// boton2.addEventListener('click', function() {
//     tec++;
//     contador2.textContent = tec;
//     boton2.disabeled = true;
//     boton2.textContent = 'votado';
// });

// boton3.addEventListener('click', function() {
//     urn++;
//     contador3.textContent = urn;
//     boton3.disabeled = true;
//     boton3.textContent = 'votado';
// });

// boton4.addEventListener('click', function() {
//     uacj++;
//     contador4.textContent = uacj;
//     boton4.disabeled = true;
//     boton4.textContent = 'votado';
// });

// boton5.addEventListener('click', function() {
//     uach++;
//     contador5.textContent = uach;
//     boton5.disabeled = true;
//     boton5.textContent = 'votado';
// });