document.addEventListener("DOMContentLoaded", function() {
    const form = document.getElementById("login-form");
    const modal = document.getElementById("modal");
    const modalContent = document.getElementById("modal-content");
    const closeModal = document.getElementById("close");

    form.addEventListener("submit", function (event) {
        event.preventDefault();

        let formData = new FormData(form);
        let userData = {
            email: formData.get("email").trim(),
            password: formData.get("password"),
        };

        let errors = validateForm(userData);
        if (errors.length > 0) {
            showValidationErrors(errors);
            return;
        }

        loginUser(userData);
    });

    function validateForm(data) {
        let errors = [];

        if (!validateEmail(data.email)) {
            errors.push({ field: "email", message: "Invalid email format." });
        }

        if (data.password.length < 6) {
            errors.push({ field: "password", message: "Password must be at least 6 characters." });
        }

        return errors;
    }

    function validateEmail(email) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    }

    function showValidationErrors(errors) {
        document.querySelectorAll(".form-control").forEach((msg) => {
            msg.classList.remove("is-invalid");
            let errorMsg = msg.nextElementSibling;
            if (errorMsg && errorMsg.classList.contains("error-msg")) {
                errorMsg.remove();
            }
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

    function loginUser(userData) {
        $.ajax({
            url: "/login",
            method: "POST",
            contentType: "application/json",
            data: JSON.stringify(userData),
            success: function(response) {
                if (response.success) {
                    sessionStorage.setItem("currentUser", JSON.stringify(response.user));
                    sessionStorage.setItem("token", response.token);

                    window.location.href = response.redirectUrl || "/";
                } else {
                    showModal(response.message || "Incorrect email or password.");
                }
            },
            error: function(xhr, status, error) {
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    showModal(xhr.responseJSON.message);
                } else {
                    showModal("An error occurred. Please try again.");
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