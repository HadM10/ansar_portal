
  //SHOW HIDE SECTIONS

  // CONTENT SECTIONS
  const storeList = document.getElementById("storeList");
  const adminWelcome = document.getElementById("admin-welcome");
  const addStore = document.getElementById("addStoreFormContainer");
  const addNews = document.getElementById("addNewsFormContainer");
  const newsList = document.getElementById("newsList");

  //CONTENT NAV-LINKS
  const viewStoresBtn = document.getElementById("viewStoresBtn");
  const addStoresBtn = document.getElementById("addStoresBtn");
  const addNewsBtn = document.getElementById("addNewsBtn");
  const viewNewsBtn = document.getElementById("viewNewsBtn");

  function hideAllSections() {
    storeList.style.display = "none";
    adminWelcome.style.display = "none";
    addStore.style.display = "none";
    addNews.style.display = "none";
    newsList.style.display = "none";
  }

  // LOGIN

  if (window.location.pathname.includes("login.php")) {
    document
      .getElementById("loginForm")
      .addEventListener("submit", function (event) {
        event.preventDefault();

        // Gather form data
        var username = document.getElementById("username").value;
        var password = document.getElementById("password").value;

        // Create XMLHttpRequest object
        var xhr = new XMLHttpRequest();

        // Configure the request
        xhr.open("POST", "login_admin.php", true);
        xhr.setRequestHeader(
          "Content-Type",
          "application/x-www-form-urlencoded"
        );

        // Define the callback function
        xhr.onreadystatechange = function () {
          if (xhr.readyState === 4) {
            try {
              console.log(xhr.responseText);
              var response = JSON.parse(xhr.responseText);

              if (response.message) {
                // Redirect to the admin panel or perform any other action on successful login
                window.location.href = "/ansar_portal/admin/index.php";
              } else {
                alert(response.error);
              }
            } catch (error) {
              console.error("Error parsing JSON:", error);
            }
          }
        };

        // Send the request with form data
        xhr.send("username=" + username + "&password=" + password);
      });
  }

  // REGISTER

  if (window.location.pathname.includes("register.php")) {
    document
      .getElementById("registerForm")
      .addEventListener("submit", function (event) {
        event.preventDefault();

        // Gather form data
        var username = document.getElementById("username").value;
        var password = document.getElementById("password").value;

        // Create XMLHttpRequest object
        var xhr = new XMLHttpRequest();

        // Configure the request
        xhr.open("POST", "register_admin.php", true);
        xhr.setRequestHeader(
          "Content-Type",
          "application/x-www-form-urlencoded"
        );

        // Define the callback function
        xhr.onload = function () {
          var response = JSON.parse(xhr.responseText);
          if (response.message) {
            alert(response.message);
            window.location.href = "login.php";
            // Redirect to the login page or perform any other action on successful registration
          } else {
            alert(response.error);
          }
        };

        // Send the request with form data
        xhr.send("username=" + username + "&password=" + password);
      });
  }

  // LOGOUT

  if (window.location.pathname.includes("index.php")) {
    // Add event listener to the logout button
    document.getElementById("logoutBtn").addEventListener("click", function () {
      // Create XMLHttpRequest object
      var xhr = new XMLHttpRequest();

      // Configure the request
      xhr.open("GET", "php/logout.php", true);

      // Define the callback function
      xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
          try {
            console.log(xhr.responseText);
            var response = JSON.parse(xhr.responseText);

            if (response.success) {
              // Logout successful
              window.location.href = "php/login.php";
            } else {
              console.error("Logout failed:", response.error);
            }
          } catch (error) {
            console.error("Error parsing JSON:", error);
          }
        }
      };

      // Send the request
      xhr.send();
    });
  }

  // EDIT AND DELETE STORES

  // Function to delete store
function deleteStore(storeId) {
    // Make an AJAX request to delete the store
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "php/delete_store.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            try {
                var response = JSON.parse(xhr.responseText);
                if (response.status === "success") {
                    alert(response.message);
                    // Optionally, you may refresh the store list or update the UI
                    fetchAndDisplayStores();
                } else {
                    alert(response.message);
                }
            } catch (error) {
                console.error("Error parsing JSON:", error);
            }
        }
    };

    // Send the request with store ID
    xhr.send("store_id=" + storeId);
}


 // Function to confirm delete
function confirmDelete(storeId) {
    var confirmDelete = confirm("Are you sure you want to delete this store?");
    if (confirmDelete) {
        // Call a function to delete the store from the database
        deleteStore(storeId);
    }
}

// Function to edit store
function editStore(storeId) {
  // Fetch store details using AJAX and create a dynamic form for editing
  var xhr = new XMLHttpRequest();
  xhr.open("GET", "php/view_stores.php?store_id=" + storeId, true);
  xhr.onreadystatechange = function () {
      if (xhr.readyState === 4 && xhr.status === 200) {
          try {
              var storeDetails = JSON.parse(xhr.responseText);

              // Fetch categories for the dropdown
              fetchCategories(storeId, storeDetails);
          } catch (error) {
              console.error("Error parsing JSON:", error);
          }
      }
  };
  xhr.send();
}

// Function to fetch categories and then call createEditForm
function fetchCategories(storeId, storeDetails) {
  var xhr = new XMLHttpRequest();
  xhr.open("GET", "php/view_categories.php", true);
  xhr.onreadystatechange = function () {
      if (xhr.readyState === 4 && xhr.status === 200) {
          try {
              var categories = JSON.parse(xhr.responseText);

              // Create a dynamic form with fields filled with store details
              createEditForm(storeId, storeDetails, categories);
          } catch (error) {
              console.error("Error parsing JSON:", error);
          }
      }
  };
  xhr.send();
}

// Function to save changes
function saveChanges(storeId, updatedData) {
  // Create a FormData object and append the data
  var formData = new FormData();
  formData.append('store_id', storeId);

  // Update these lines to match your PHP script expectations
  formData.append('new_store_name', updatedData.name);
  formData.append('new_category', updatedData.category);
  formData.append('new_description', updatedData.description);

  // Make an AJAX request to save the changes
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "php/edit_store.php", true);
  xhr.onreadystatechange = function () {
      if (xhr.readyState === 4) {
        console.log(xhr.responseText);
          try {
              var response = JSON.parse(xhr.responseText);
              if (response.status === 'success') {
                  alert(response.message);
                  // Optionally, you may refresh the store list or update the UI
                  fetchAndDisplayStores();
              } else {
                  alert(response.message);
              }
          } catch (error) {
              console.error('Error parsing JSON:', error);
          }
      }
  };

  // Send the request with FormData
  xhr.send(formData);
}

// Function to create an edit form dynamically
function createEditForm(storeId, storeDetailsArray, categories) {
  // Access the first element of the array
  var storeDetails = storeDetailsArray[0];

  console.log("storeDetails:", storeDetails);

  // Rest of the function remains the same...
  var formContainer = document.createElement("div");
  formContainer.innerHTML = `
      <form id="editStoreForm">
          <label for="editStoreName">Store Name:</label>
          <input type="text" id="editStoreName" required>

          <label for="editStoreCategory">Category:</label>
          <select id="editStoreCategory" required>
              ${categories.map(category => `<option value="${category.category_id}">${category.category_name}</option>`).join('')}
          </select>

          <label for="editStoreDescription">Description:</label>
          <textarea id="editStoreDescription" required></textarea>

          <label for="editStorePhone">Phone Number:</label>
          <input type="text" id="editStorePhone" required>

          <button type="button" onclick="saveChanges(${storeId}, getUpdatedData())">Save Changes</button>
      </form>
  `;

  // Set the values in the form fields
  var editStoreNameInput = formContainer.querySelector("#editStoreName");
  var editStoreCategorySelect = formContainer.querySelector("#editStoreCategory");
  var editStoreDescriptionTextarea = formContainer.querySelector("#editStoreDescription");
  var editStorePhoneInput = formContainer.querySelector("#editStorePhone");

  editStoreNameInput.value = storeDetails.store_name;
  editStoreDescriptionTextarea.value = storeDetails.description;
  editStorePhoneInput.value = storeDetails.phone_number;

  // Set the selected category in the dropdown
  editStoreCategorySelect.value = storeDetails.category;

  // Replace the existing store container with the edit form
  var existingStoreContainer = document
    .getElementById("storeList")
    .querySelector(`[data-store-id="${storeId}"]`);
  existingStoreContainer.innerHTML = "";
  existingStoreContainer.appendChild(formContainer);
}

// Function to get updated data from the edit form
function getUpdatedData() {
  var updatedData = {
    name: document.getElementById("editStoreName").value,
    category: document.getElementById("editStoreCategory").value,
    description: document.getElementById("editStoreDescription").value,
    phone: document.getElementById("editStorePhone").value,
    // Add more fields as needed
  };

  return updatedData;
}


// Function to display stores
function displayStores(storesData) {
    var storeList = document.getElementById("storeList");

    // Clear existing content
    storeList.innerHTML = "";

    storesData.forEach(function (store) {
        // Create a list item for each store
        var listItem = document.createElement("li");
        listItem.setAttribute("data-store-id", store.store_id); // Set a unique identifier

        listItem.innerHTML = `
            <div class="store-container">
                <div class="store-images">
                    <ul>
                        ${store.images
                            .map(
                                (image) =>
                                    `<li><img src="${image}" alt="Store Image"></li>`
                            )
                            .join("")}
                    </ul>
                </div>
                <h2 class="store-name">${store.store_name}</h2>
                <p class="store-category">${store.category}</p>
                <p class="store-description">${store.description}</p>
                <p class="store-phone">${store.phone_number}</p>
                <p class="store-likes"><strong>Total Likes:</strong> ${store.total_likes}</p>
                <div class="store-actions">
                    <button class="edit-btn" onclick="editStore(${store.store_id})">Edit</button>
                    <button class="delete-btn" onclick="confirmDelete(${store.store_id})">Delete</button>
                </div>
            </div>
        `;

        // Append the list item to the store list
        storeList.appendChild(listItem);
    });
}

// VIEW STORES

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
                console.error("Error parsing JSON:", error);
            }
        }
    };

    xhr.open("GET", "php/view_stores.php", true);
    xhr.send();
}


  viewStoresBtn.addEventListener("click", function () {
    // Fetch and display products when the page loads
    hideAllSections();
    fetchAndDisplayStores();
    storeList.style.display = "flex";
  });

  

  // ADD STORE

  // Add Store Form Submission

  document
    .getElementById("addStoreForm")
    .addEventListener("submit", function (event) {
      event.preventDefault();

      // Gather form data
      var storeName = document.getElementById("store_name").value;
      var category = document.getElementById("category_id").value;
      var description = document.getElementById("store_description").value;
      var phone = document.getElementById("phone_number").value;

      // Create XMLHttpRequest object (or use fetch API)
      var xhr = new XMLHttpRequest();

      // Configure the request
      xhr.open("POST", "php/add_store.php", true);
      xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

      // Define the callback function
      xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
          console.log(xhr.responseText);
          try {
            var response = JSON.parse(xhr.responseText);

            if (response.status === "success") {
              alert(response.message);
              // You may perform additional actions on successful store addition
            } else {
              alert(response.message);
            }
          } catch (error) {
            console.error("Error parsing JSON:", error);
          }
        }
      };

      // Send the request with form data
      xhr.send(
        "store_name=" +
          storeName +
          "&category_id=" +
          category +
          "&store_description=" +
          description +
          "&phone_number=" +
          phone
      );
    });

  // Event listener for button click
  addStoresBtn.addEventListener("click", function () {
    // Fetch and display products when the page loads
    hideAllSections();

    // Fetch Categories
    fetch("php/view_categories.php")
      .then((response) => response.json())
      .then((categories) => {
        // Populate the select dropdown with categories
        const categoryDropdown = document.getElementById("category_id");
        categories.forEach((category) => {
          const option = document.createElement("option");
          option.value = category.category_id;
          option.textContent = category.category_name;
          categoryDropdown.appendChild(option);
        });
      })
      .catch((error) => console.error("Error fetching categories:", error));

    addStore.style.display = "block";
  });

  // Add News Form Submission

  document
    .getElementById("addNewsForm")
    .addEventListener("submit", function (event) {
      event.preventDefault();

      const formData = new FormData(this);

      // Make an AJAX request to send the form data to your PHP script
      const xhr = new XMLHttpRequest();
      xhr.open("POST", "php/add_news.php", true);
      xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
          console.log(xhr.responseText);
          // Process the response, e.g., show a success message or handle errors
          try {
            const response = JSON.parse(xhr.responseText);
            if (response.status === "success") {
              alert("News added successfully.");
            } else {
              alert("Error: " + response.message);
            }
          } catch (error) {
            console.error("Error parsing JSON:", error);
          }
        }
      };
      xhr.send(formData);
    });

  addNewsBtn.addEventListener("click", function () {
    // Fetch and display products when the page loads
    hideAllSections();
    addNews.style.display = "block";
  });

  // VIEW NEWS

  // Add an event listener for the "View News" button
  viewNewsBtn.addEventListener("click", function (event) {
    event.preventDefault();
    // Add your AJAX logic to fetch and display news here
    fetchAndDisplayNews();
  });

  // Function to fetch and display news using AJAX
  function fetchAndDisplayNews() {
    var xhr = new XMLHttpRequest();

    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4 && xhr.status === 200) {
        try {
          var newsData = JSON.parse(xhr.responseText);
          console.log(xhr.responseText);
          displayNews(newsData);
        } catch (error) {
          console.error("Error parsing JSON:", error);
        }
      }
    };

    xhr.open("GET", "php/view_news.php", true);
    xhr.send();
  }

  // Function to display news
  function displayNews(newsData) {
    // Clear existing content
    newsList.innerHTML = "";

    newsData.forEach(function (news) {
      // Create a list item for each news
      var listItem = document.createElement("li");
      listItem.innerHTML = `
            <div class="news-container">
                <img class="news-image" src="ansar_portal/${news.image_url}" alt="News Image">
                <h2 class="news-title">${news.title}</h2>
                <p class="news-content">${news.content}</p>
                <p class="news-publication-date"><strong>Publication Date:</strong> ${news.publication_date}</p>
            </div>
        `;

      // Append the list item to the news list
      newsList.appendChild(listItem);
    });
  }

  // Hide other sections and display the news section
  viewNewsBtn.addEventListener("click", function () {
    hideAllSections();
    fetchAndDisplayNews();
    newsList.style.display = "flex";
  });

