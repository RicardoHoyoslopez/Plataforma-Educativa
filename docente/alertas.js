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
});
// alertas.js

document.addEventListener("DOMContentLoaded", () => {
    // Obtener los parámetros de la URL
    const urlParams = new URLSearchParams(window.location.search);
  
    // Si hay un parámetro de mensaje que indique "Clase eliminada"
    if (urlParams.get("mensaje") === "Clase eliminada") {
      Swal.fire({
        icon: 'success',
        title: '¡Clase eliminada!',
        text: 'La clase ha sido eliminada con éxito.',
        confirmButtonColor: '#3085d6',
        timer: 3000, // La alerta desaparecerá después de 3 segundos
      });
  
      // Limpiar los parámetros de la URL (para evitar que se quede el mensaje después de cerrar la alerta)
      history.replaceState(null, "", window.location.pathname);
    }
  });
  