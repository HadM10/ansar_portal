document.addEventListener('DOMContentLoaded', function () {

    // LOGIN
    if (window.location.pathname.includes("login.html")) {
        document.getElementById('loginForm').addEventListener('submit', function (event) {
            event.preventDefault();

            // Gather form data
            var username = document.getElementById('username').value;
            var password = document.getElementById('password').value;

            // Create XMLHttpRequest object
            var xhr = new XMLHttpRequest();

            // Configure the request
            xhr.open('POST', '../php/login_admin.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            // Define the callback function
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4) {
                    try {
                        console.log(xhr.responseText);
                        var response = JSON.parse(xhr.responseText);

                        if (response.message) {
                            // Redirect to the admin panel or perform any other action on successful login
                            window.location.href = '/ansar_portal/admin/index.php';
                        } else {
                            alert(response.error);
                        }
                    } catch (error) {
                        console.error('Error parsing JSON:', error);
                    }
                }
            };

            // Send the request with form data
            xhr.send('username=' + username + '&password=' + password);
        });
    };




    // REGISTER

    if (window.location.pathname.includes("register.html")) {
        document.getElementById('registerForm').addEventListener('submit', function (event) {
            event.preventDefault();

            // Gather form data
            var username = document.getElementById('username').value;
            var password = document.getElementById('password').value;

            // Create XMLHttpRequest object
            var xhr = new XMLHttpRequest();

            // Configure the request
            xhr.open('POST', '../php/register_admin.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            // Define the callback function
            xhr.onload = function () {
                var response = JSON.parse(xhr.responseText);
                if (response.message) {
                    alert(response.message);
                    window.location.href = 'login.html';
                    // Redirect to the login page or perform any other action on successful registration
                } else {
                    alert(response.error);
                }
            };

            // Send the request with form data
            xhr.send('username=' + username + '&password=' + password);
        });
    };

    // LOGOUT


    if (window.location.pathname.includes("index.php")) {
        // Add event listener to the logout button
        document.getElementById('logoutBtn').addEventListener('click', function () {
            // Create XMLHttpRequest object
            var xhr = new XMLHttpRequest();

            // Configure the request
            xhr.open('GET', 'php/logout.php', true);

            // Define the callback function
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4) {
                    try {
                        console.log(xhr.responseText);
                        var response = JSON.parse(xhr.responseText);

                        if (response.success) {
                            // Logout successful
                            window.location.href = 'html/login.html';
                        } else {
                            console.error('Logout failed:', response.error);
                        }
                    } catch (error) {
                        console.error('Error parsing JSON:', error);
                    }
                }
            };

            // Send the request
            xhr.send();
        });
    }
});


