document.addEventListener("DOMContentLoaded", function() {
    const form = document.getElementById("register-form");
    const modal = document.getElementById("modal");
    const modalContent = document.getElementById("modal-content");
    const closeModal = document.getElementById("close");

    form.addEventListener("submit", function (event){
        event.preventDefault();

        let formData = new FormData(form);
        let userData = {
            username: formData.get("username").trim(),
            email: formData.get("email").trim(),
            password: formData.get("password"),
            rePassword: formData.get("re-password"),
            role: formData.get("role"),
        };

        let errors = validateForm(userData);
        if (errors.length > 0) {
            showValidationErrors(errors);
            return;
        }

        registerUser(userData);
    });

    function validateForm(data) {
        let errors = [];

        if (data.username.length < 3) {
            errors.push({ field: "username", message: "Username must be at least 3 characters." });
        }

        if (!validateEmail(data.email)) {
            errors.push({ field: "email", message: "Invalid email format." });
        }

        if (data.password.length < 6) {
            errors.push({ field: "password", message: "Password must be at least 6 characters." });
        }

        if (data.password !== data.rePassword) {
            errors.push({ field: "re-password", message: "Passwords do not match." });
        }

        return errors;
    }

    function validateEmail(email) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    }

    function showValidationErrors(errors) {
        document.querySelectorAll(".form-control").forEach((msg) => {
            msg.remove();
        });

        errors.forEach((error) => {
            let inputField = document.querySelector(`[name="${error.field}"]`);
            inputField.classList.add("is-invalid");

            let errorMsg = document.createElement("div");
            errorMsg.className = "error-msg text-danger mt-1";
            errorMsg.innerText = error.message;
            inputField.parentNode.appendChild(errorMsg);
        });
    }
    
    function registerUser(userData) {
        $.ajax({
            url: "/register",
            method: "POST",
            contentType: "application/json",
            data: JSON.stringify(userData),
            success: function(response) {
                if (response.success) {
                    showModal("Your account has been created successfully!");
                    form.reset();
                } else {
                    showModal(response.message || "Registration failed. Please try again.");
                }
            },
            error: function(xhr, status, error) {
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    showModal(xhr.responseJSON.message);
                } else {
                    showModal("Something went wrong. Please try again.");
                }
            }
        });
    }

    function showModal(message) {
        document.getElementById("success").innerText = message;
        modal.style.display = "block";

        closeModal.addEventListener("click", function () {
            modal.style.display = "none";
        });

        window.addEventListener("click", function (event) {
            if (event.target === modal) {
                modal.style.display = "none";
            }
        });
    }

});