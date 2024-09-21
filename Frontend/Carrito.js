document.getElementById("submitPayment").addEventListener("click", function (e) {
    e.preventDefault();
    const cardHolder = document.getElementById("cardHolderName").value.trim();
    const cardNumber = document.getElementById("cardNumber").value.trim();
    const expirationMonth = document.getElementById("expirationMonth").value.trim();
    const expirationYear = document.getElementById("expirationYear").value.trim();
    const cvv = document.getElementById("cvv").value.trim();
    let isValid = true;

    // Regex patterns
    const cardNumberPattern = /^\d{16}$/; // 16 digits
    const monthPattern = /^(0[1-9]|1[0-2])$/; // 01-12 for months
    const yearPattern = /^\d{2}$/; // 2 digits for year
    const cvvPattern = /^\d{3}$/; // 3 digits for CVV
    const cardHolderPattern = /^[A-Za-z\s]+$/; // Solo permite letras y espacios
    // Card Holder name validation
    if(cardHolder==""|| !cardHolderPattern.test(cardHolder)){
      document.getElementById("cardNameError").style.display = "block";
        isValid = false;
    } else {
        document.getElementById("cardNameError").style.display = "none";
    }

    // Card number validation
    if (!cardNumberPattern.test(cardNumber)) {
        document.getElementById("cardNumberError").style.display = "block";
        isValid = false;
    } else {
        document.getElementById("cardNumberError").style.display = "none";
    }

    // Expiration month and year validation
    if (!monthPattern.test(expirationMonth) || !yearPattern.test(expirationYear)) {
        document.getElementById("expirationError").style.display = "block";
        isValid = false;
    } else {
        document.getElementById("expirationError").style.display = "none";
    }

    // CVV validation
    if (!cvvPattern.test(cvv)) {
        document.getElementById("cvvError").style.display = "block";
        isValid = false;
    } else {
        document.getElementById("cvvError").style.display = "none";
    }

    // If all validations pass
    if (isValid) {
        alert("Compra exitosa");
        $('#exampleModal').modal('hide');
    }
  });

  document.addEventListener('DOMContentLoaded', () => {
    const deleteButtons = document.querySelectorAll('.delete-btn');
    

    deleteButtons.forEach(button => {
      button.addEventListener('click', (event) => {
        event.preventDefault();
        // Muestra el mensaje de confirmación
        if (confirm('¿Estás seguro de que quieres eliminar este elemento del carrito?')) {
          alert('El elemento ha sido borrado.');
          button.closest('.car-item').remove();
        }
      });
    });
  });