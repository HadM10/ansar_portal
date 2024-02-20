document.addEventListener('DOMContentLoaded', function () {

    //SHOW HIDE SECTIONS

    // CONTENT SECTIONS
    const storeList = document.getElementById("storeList");
    const adminWelcome = document.getElementById("admin-welcome");
    const addStore = document.getElementById("addStoreFormContainer");



    //CONTENT NAV-LINKS
    const viewStoresBtn = document.getElementById('viewStoresBtn');
    const addStoresBtn = document.getElementById('addStoresBtn');

    function hideAllSections() {
        storeList.style.display = "none";
        adminWelcome.style.display = "none";
        addStore.style.display = "none";
    }

    // LOGIN

    if (window.location.pathname.includes("login.php")) {
        document.getElementById('loginForm').addEventListener('submit', function (event) {
            event.preventDefault();

            // Gather form data
            var username = document.getElementById('username').value;
            var password = document.getElementById('password').value;

            // Create XMLHttpRequest object
            var xhr = new XMLHttpRequest();

            // Configure the request
            xhr.open('POST', 'login_admin.php', true);
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

    if (window.location.pathname.includes("register.php")) {
        document.getElementById('registerForm').addEventListener('submit', function (event) {
            event.preventDefault();

            // Gather form data
            var username = document.getElementById('username').value;
            var password = document.getElementById('password').value;

            // Create XMLHttpRequest object
            var xhr = new XMLHttpRequest();

            // Configure the request
            xhr.open('POST', 'register_admin.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            // Define the callback function
            xhr.onload = function () {
                var response = JSON.parse(xhr.responseText);
                if (response.message) {
                    alert(response.message);
                    window.location.href = 'login.php';
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
                            window.location.href = 'php/login.php';
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



    // VIEW STORES

    viewStoresBtn.addEventListener('click', function (event) {
        event.preventDefault();
        // Add your AJAX logic to fetch and display stores here
        fetchAndDisplayStores();
    });

    // Function to fetch and display stores using AJAX
    function fetchAndDisplayStores() {
        var xhr = new XMLHttpRequest();

        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                try {
                    var storesData = JSON.parse(xhr.responseText);
                    console.log(xhr.responseText);
                    displayStores(storesData);
                } catch (error) {
                    console.error('Error parsing JSON:', error);
                }
            }
        };

        xhr.open('GET', 'php/view_stores.php', true);
        xhr.send();
    }

    // Function to display stores
    function displayStores(storesData) {
        var storeList = document.getElementById('storeList');

        // Clear existing content
        storeList.innerHTML = '';

        storesData.forEach(function (store) {
            // Create a list item for each store
            var listItem = document.createElement('li');
            listItem.innerHTML = `
            <div class="store-container">
            <div class="store-images">
                    
                    <ul>
                        ${store.images.map(image => `<li><img src="${image}" alt="Store Image"></li>`).join('')}
                    </ul>
                </div>
                <h2 class="store-name"> ${store.store_name}</h2>
                <p class="store-category">${store.category}</p>
                <p class="store-description">${store.description}</p>
                <p class="store-phone">${store.phone_number}</p>
                <p class="store-likes"><strong>Total Likes:</strong> ${store.total_likes}</p>
                
            </div>
        `;

            // Append the list item to the store list
            storeList.appendChild(listItem);
        });
    }

    viewStoresBtn.addEventListener('click', function () {
        // Fetch and display products when the page loads
        hideAllSections()
        fetchAndDisplayStores();
        storeList.style.display = 'flex';
    });

    // ADD STORE




    // Add Store Form Submission

    document.getElementById('addStoreForm').addEventListener('submit', function (event) {
        event.preventDefault();

        // Gather form data
        var storeName = document.getElementById('store_name').value;
        var category = document.getElementById('category_id').value;
        var description = document.getElementById('store_description').value;
        var phone = document.getElementById('phone_number').value;

        // Create XMLHttpRequest object (or use fetch API)
        var xhr = new XMLHttpRequest();

        // Configure the request
        xhr.open('POST', 'php/add_store.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        // Define the callback function
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4) {
                console.log(xhr.responseText);
                try {
                    var response = JSON.parse(xhr.responseText);

                    if (response.status === 'success') {
                        alert(response.message);
                        // You may perform additional actions on successful store addition
                    } else {
                        alert(response.message);
                    }
                } catch (error) {
                    console.log(xhr.responseText);
                    console.error('Error parsing JSON:', error);
                }
            }
        };

        // Send the request with form data
        xhr.send('store_name=' + storeName + '&category_id=' + category + '&store_description=' + description + '&phone_number=' + phone);
    });

    // Event listener for button click
    addStoresBtn.addEventListener('click', function () {
        // Fetch and display products when the page loads
        hideAllSections();

        // Fetch Categories
        fetch('php/view_categories.php')
            .then(response => response.json())
            .then(categories => {
                // Populate the select dropdown with categories
                const categoryDropdown = document.getElementById('category_id');
                categories.forEach(category => {
                    const option = document.createElement('option');
                    option.value = category.category_id;
                    option.textContent = category.category_name;
                    categoryDropdown.appendChild(option);
                });
            })
            .catch(error => console.error('Error fetching categories:', error));

        addStore.style.display = 'block';
    });



});


