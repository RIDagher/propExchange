console.log("🔥 createUser.js loaded!");
document.addEventListener("DOMContentLoaded", function() {
    const form = document.getElementById("register-form");

    form.addEventListener("submit", function (event){
        event.preventDefault();

        document.querySelectorAll(".error-msg").forEach((el) => el.remove());
        document.querySelectorAll(".is-invalid").forEach((el) => el.classList.remove("is-invalid"));

        let formData = new FormData(form);
        let userData = {
            username: formData.get("username").trim(),
            email: formData.get("email").trim(),
            password: formData.get("password"),
            rePassword: formData.get("password_confirmation"),
            role: formData.get("role"),
        };

        let errors = validateForm(userData);
        if (errors.length > 0) {
            showValidationErrors(errors);
            return;
        }

        form.submit();
    });

    function validateForm(data) {
        let errors = [];

        const usernameRegex = /^(?!.*\.\.)(?!.*\.$)[^\W][\w.]{0,29}$/;
        if (!usernameRegex.test(data.username)) {
            errors.push({ field: "username", message: "The username may only contain letters, numbers, and underscores, and cannot end with a dot or contain consecutive dots." });
        }

        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(data.email)) {
            errors.push({ field: "email", message: "Invalid email format." });
        }

        const passwordRegex = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/;
        if (!passwordRegex.test(data.password)) {
            errors.push({ field: "password", message: "The password must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, and one number." });
        }

        if (data.password !== data.rePassword) {
            errors.push({ field: "password_confirmation", message: "Passwords do not match." });
        }
        const validRoles = ['agent', 'client'];
        if (!validRoles.includes(data.role)) {
            errors.push({ field: "role", message: "The role must be either 'agent' or 'client'." });
        }

        return errors;
    }

    function showValidationErrors(errors) {
        errors.forEach((error) => {
            let inputField = document.querySelector(`[name="${error.field}"]`);
            inputField.classList.add("is-invalid");

            let errorMsg = document.createElement("div");
            errorMsg.className = "error-msg text-danger mt-1";
            errorMsg.innerText = error.message;
            inputField.parentNode.appendChild(errorMsg);
        });
    }
});
