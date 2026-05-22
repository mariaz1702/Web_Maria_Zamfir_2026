document.addEventListener("DOMContentLoaded", function() {
    const tripForm = document.querySelector('form[action="upload.php"]');
    
    if(tripForm) {
        tripForm.addEventListener("submit", function(e) {
            const locInput = tripForm.querySelector('input[name="loc"]');
            if(locInput.value.trim().length < 3) {
                alert("Te rugăm să introduci o locație validă (minim 3 caractere)!");
                e.preventDefault();
            }
        });
    }
});