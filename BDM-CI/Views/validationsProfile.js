        
(() => {
    'use strict'

    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    const forms = document.querySelectorAll('.needs-validation')

    // Loop over them and prevent submission
    Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
                event.preventDefault()
                event.stopPropagation()
            }

            form.classList.add('was-validated')
        }, false)
    })
})();

$(document).ready(function() {
    const submitButton = $(".btn-save");
    const firstNameInput = $("#firstName");
    const lastNameInput = $("#lastName");
    const birthdateInput = $("#birthdate");
    const passwordInput = $("#password");
    const confirmPasswordInput = $("#confirmPassword");

    submitButton.on("click", function(event) {
        let valid = true;

        // Validar nombre y apellido (no vacíos ni solo espacios)
        if (firstNameInput.val().trim() === "" || lastNameInput.val().trim() === "") {
            firstNameInput.addClass("is-invalid");
            lastNameInput.addClass("is-invalid");
            valid = false;
        } else {
            firstNameInput.removeClass("is-invalid").addClass("is-valid");
            lastNameInput.removeClass("is-invalid").addClass("is-valid");
        }

        // Validar fecha de nacimiento (no en el futuro)
        const today = new Date();
        console.log(birthdateInput.val());
        console.log(today);
        const birthdate = new Date(birthdateInput.val());
        if (birthdate > today || isNaN(birthdate.getTime())) {
            birthdateInput.addClass("is-invalid");
            valid = false;
        } else {
            birthdateInput.removeClass("is-invalid").addClass("is-valid");
        }

        // Validar contraseña
        const passwordValue = passwordInput.val();
        const passwordRegex = /^(?=.*[A-Z])(?=.*\d)(?=.*[a-z])(?=.*[!@#$%^&*()_+.])[A-Za-z\d!@#$%^&*()_+\\.]{8,}$/;
        if(passwordValue===''){
            passwordInput.removeClass("is-invalid").addClass("is-valid");
        }else{
            if (passwordRegex.test(passwordValue)) {
            passwordInput.removeClass("is-invalid").addClass("is-valid");
        } else {
            passwordInput.addClass("is-invalid");
            valid = false;
        }
        }

        // Confirmar que las contraseñas coincidan
        if (passwordInput.val() !== confirmPasswordInput.val()) {
            confirmPasswordInput.addClass("is-invalid");
            valid = false;
        } else {
            confirmPasswordInput.removeClass("is-invalid").addClass("is-valid");
        }

        if (!valid) {
            event.preventDefault(); // Prevent form submission if any validation fails
        }
    });
});