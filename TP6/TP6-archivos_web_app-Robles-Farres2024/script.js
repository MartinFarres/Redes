function validarFormulario(event) {
    event.preventDefault(); // Evitar el envío del formulario

    const emailInput = document.getElementById('email');
    const email = emailInput.value.trim();
    const equipoSeleccionado = document.querySelector('input[name="equipo"]:checked');

    // Validar formato de email
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        alert('El formato del email es incorrecto.');
        emailInput.focus();
        return;
    }

    // Validar selección de equipo
    if (!equipoSeleccionado) {
        alert('Debe seleccionar un equipo.');
        return;
    }

    // Enviar datos al servidor PHP
    const formData = new FormData();
    formData.append('email', email);
    formData.append('equipo', equipoSeleccionado.value);

    fetch('procesar_form.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        const resultadosDiv = document.getElementById('resultados');
        resultadosDiv.innerHTML = data;
    })
    .catch(error => {
        console.error('Error:', error);
    });
}