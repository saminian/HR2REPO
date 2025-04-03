<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
</head>
<body class='h-screen flex justify-center bg-black/15'>
    <div id='login-container' class='mx-auto my-auto bg-white w-[95%] h-[95%] flex gap-14 items-center overflow-hidden rounded-xl relative shadow-2xl'>
        
        <!-- Left Image (Hidden on Small Screens) -->
        <div id='left-image' class='lg:block hidden h-[500px]'>
            <img src='images/waves2.png' alt='Background Image'>
        </div>
        
        <!-- Floating GIF Image (Hidden on Small Screens) -->
        <div id='floating-gif' class='absolute -left-48 ml-4 lg:block hidden'>
            <img src='images/applic.gif' alt='Animated Illustration'>
        </div>
        
        <!-- Login Section -->
        <div id='login-section' class='space-y-5 text-center mx-auto lg:w-[20%] bg-gray-100 p-6 rounded-lg shadow-md'>
            <div id='login-title' class='text-2xl font-bold'>LOGIN</div>
            <form id="loginForm" class="space-y-4">
                <label class="block text-gray-700 text-left">Email:</label>
                <input type="email" id="email" class="w-full px-3 py-2 border rounded mb-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
                
                <label class="block text-gray-700 text-left">Password:</label>
                <div class="relative">
                    <input type="password" id="password" class="w-full px-3 py-2 border rounded mb-4 focus:outline-none focus:ring-2 focus:ring-blue-500 pr-10">
                    <button type="button" id="togglePassword" class="absolute right-3 top-[38%] transform -translate-y-1/2 text-gray-500 hover:text-gray-700">
                        <i class="fas fa-eye-slash" id="eyeIcon"></i>
                    </button>
                </div>
                
                <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded hover:bg-blue-600">Login</button>
            </form>
        </div>
    </div>  

    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script>
        // Toastify function
        function showToast(message, type) {
            Toastify({
                text: message,
                style: {
                    background: type === 'success' 
                        ? "linear-gradient(to right, #00b09b, #96c93d)" 
                        : "linear-gradient(to right, #ff5f6d, #ffc371)"
                },
                duration: 3000,
                close: true
            }).showToast();
        }

        // Toggle password visibility
        document.getElementById("togglePassword").addEventListener("click", function() {
            const passwordField = document.getElementById("password");
            const eyeIcon = document.getElementById("eyeIcon");
            if (passwordField.type === "password") {
                passwordField.type = "text";
                eyeIcon.classList.remove("fa-eye-slash");
                eyeIcon.classList.add("fa-eye");
            } else {
                passwordField.type = "password";
                eyeIcon.classList.remove("fa-eye");
                eyeIcon.classList.add("fa-eye-slash");
            }
        });

        // Login form validation and submission
        document.getElementById("loginForm").addEventListener("submit", async function(event) {
            event.preventDefault();
            const email = document.getElementById("email").value.trim();
            const password = document.getElementById("password").value.trim();
            
            if (!email || password.length < 6) {
                showToast("Invalid email or password.", "error");
                return;
            }
            
            try {
                const response = await fetch("http://localhost/HR2REPO/api/user.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({ email: email, password: password })
                });
                
                const result = await response.json();
                if (result.success) {
                    showToast("Login successful!", "success");
                    setTimeout(() => { window.location.href = result.redirect; }, 1500);
                } else {
                    showToast(result.error, "error");
                }
            } catch (error) {
                showToast("Error connecting to server.", "error");
            }
        });
    </script>
</body>
</html>
