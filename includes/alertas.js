document.addEventListener("DOMContentLoaded", () => {
    const params = new URLSearchParams(window.location.search);

    if (params.get("creado") === "1") {
        Swal.fire({
            icon: "success",
            title: "¡Clase creada!",
            text: "La clase se registró correctamente.",
            confirmButtonText: "Aceptar",
            timer: 3000,
            timerProgressBar: true
        }).then(() => {
            const cleanUrl = window.location.origin + window.location.pathname;
            window.history.replaceState({}, document.title, cleanUrl);
        });
    }

    if (params.get("mensaje") === "Clase eliminada") {
        Swal.fire({
            icon: 'success',
            title: '¡Clase eliminada!',
            text: 'La clase ha sido eliminada con éxito.',
            confirmButtonColor: '#3085d6',
            timer: 3000
        });

        history.replaceState(null, "", window.location.pathname);
    }
});

document.addEventListener("DOMContentLoaded", () => {
    const params = new URLSearchParams(window.location.search);

    if (params.get("pqrs") === "enviado") {
        Swal.fire({
            icon: "success",
            title: "¡PQRS enviado!",
            text: "Tu solicitud fue enviada con éxito.",
            confirmButtonText: "Aceptar",
            timer: 3000,
            timerProgressBar: true
        }).then(() => {
            const cleanUrl = window.location.origin + window.location.pathname;
            window.history.replaceState({}, document.title, cleanUrl);
        });
    }
});

document.addEventListener("DOMContentLoaded", () => {
    const params = new URLSearchParams(window.location.search);

    if (params.get("pqrs") === "enviado") {
        Swal.fire({
            icon: "success",
            title: "¡PQR enviada!",
            text: "Tu solicitud fue enviada con éxito.",
            confirmButtonText: "Aceptar",
            timer: 3000,
            timerProgressBar: true
        }).then(() => {
            const cleanUrl = window.location.origin + window.location.pathname;
            window.history.replaceState({}, document.title, cleanUrl);
        });
    }
});

 document.addEventListener('DOMContentLoaded', function () {
    console.log("alertas.js activo");

    const params = new URLSearchParams(window.location.search);
    const mensaje = params.get('mensaje');
    const error = params.get('error');

    console.log("mensaje:", mensaje);
    console.log("error:", error);

    if (mensaje === 'clase_aceptada') {
        Swal.fire({
            icon: 'success',
            title: 'Clase aceptada',
            text: 'Se aceptó la solicitud de clase correctamente.',
            confirmButtonColor: '#3085d6',
            timer: 3000,
            timerProgressBar: true
        });
    } else if (mensaje === 'clase_rechazada') {
        Swal.fire({
            icon: 'info',
            title: 'Clase rechazada',
            text: 'Has rechazado esta inscripción.',
            confirmButtonColor: '#3085d6',
            timer: 3000,
            timerProgressBar: true
        });
    } else if (error === 'no_actualizado') {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'No se pudo actualizar el estado de la inscripción.',
            confirmButtonColor: '#d33'
        });
    }
   



});


