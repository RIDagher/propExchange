document.addEventListener("DOMContentLoaded", function() {
    const form = document.getElementById("login-form");

    form.addEventListener("submit", function (event) {
        clearValidationErrors();

        let formData = new FormData(form);
        let userData = {
            email: formData.get("email").trim(),
            password: formData.get("password"),
        };

        let errors = validateForm(userData);
        if (errors.length > 0) {
            showValidationErrors(errors);
            event.preventDefault();
        }
    });

    function validateForm(data) {
        let errors = [];

        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(data.email)) {
            errors.push({ field: "email", message: "Invalid email format." });
        }

        const passwordRegex = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/;
        if (!passwordRegex.test(data.password)) {
            errors.push({ field: "password", message: "The password must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, and one number." });
        }

        return errors;
    }

    function clearValidationErrors() {
        document.querySelectorAll(".error-msg").forEach(el => el.remove());
        document.querySelectorAll(".is-invalid").forEach(el => el.classList.remove("is-invalid"));
    }
    

    function showValidationErrors(errors) {
        errors.forEach(error => {
            let inputField = document.querySelector(`[name="${error.field}"]`);
            if (inputField) {
                inputField.classList.add("is-invalid");
                let errorMsg = document.createElement("div");
                errorMsg.className = "error-msg text-danger mt-1";
                errorMsg.innerText = error.message;
                inputField.parentNode.appendChild(errorMsg);
            }
        });
    }
});