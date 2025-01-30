document.getElementById("contact-form").addEventListener("submit", function(e) {
    e.preventDefault();

    // Get form data
    const name = document.getElementById("name").value;
    const email = document.getElementById("email").value;
    const message = document.getElementById("message").value;
    const recaptchaResponse = grecaptcha.getResponse(); // Get reCAPTCHA response

    // Validate form data and reCAPTCHA response
    if (name && email && message && recaptchaResponse) {
        // Prepare form data
        const formData = new FormData();
        formData.append("name", name);
        formData.append("email", email);
        formData.append("message", message);
        formData.append("recaptcha_response", recaptchaResponse);

        // Send data to server via AJAX (POST request)
        fetch("process_form.php", {
            method: "POST",
            body: formData
        })
        .then(response => response.json())  // Parse JSON response from server
        .then(data => {
            if (data.success) {
                document.getElementById("form-response").innerHTML = 
                    `<p>Thank you, ${name}! We have received your message and will get back to you shortly.</p>`;
                document.getElementById("contact-form").reset();
            } else {
                document.getElementById("form-response").innerHTML = 
                    `<p style="color: red;">There was an error submitting your form. Please try again.</p>`;
            }
        })
        .catch(error => {
            document.getElementById("form-response").innerHTML = 
                `<p style="color: red;">Error: ${error}</p>`;
        });
    } else {
        // If reCAPTCHA or form fields are empty, show error
        document.getElementById("form-response").innerHTML = 
            `<p style="color: red;">Please fill in all fields and complete the reCAPTCHA.</p>`;
    }
});
