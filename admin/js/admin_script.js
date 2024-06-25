//SHOW HIDE SECTIONS

// CONTENT SECTIONS
const storeList = document.getElementById("storeList");
const categoryList = document.getElementById("categoryList");
const adminWelcome = document.getElementById("admin-welcome");
const addStore = document.getElementById("addStoreFormContainer");
const addCategory = document.getElementById("addCategoryFormContainer");
const addNews = document.getElementById("addNewsFormContainer");
const newsList = document.getElementById("newsList");
const offerList = document.getElementById("offerList");
const addOffers = document.getElementById("addOfferFormContainer");
const usersList = document.getElementById("usersList");
const uploadedImagesList = document.getElementById("uploadedImagesList"); 
const uploadImagesForm = document.getElementById("uploadImagesForm"); 
const dashboardSection = document.getElementById('dashboardSection');
const dashboardStats = document.getElementById('dashboardStats');
const paymentSection = document.getElementById('paymentSection');
const archivedStoresList = document.getElementById('archivedStoreList');

// CONTENT NAV-LINKS
const viewStoresBtn = document.getElementById("viewStoresBtn");
const viewCategoriesBtn = document.getElementById("viewCategoriesBtn");
const addStoresBtn = document.getElementById("addStoresBtn");
const addCategoriesBtn = document.getElementById("addCategoriesBtn");
const addNewsBtn = document.getElementById("addNewsBtn");
const viewNewsBtn = document.getElementById("viewNewsBtn");
const viewOffersBtn = document.getElementById("viewOffersBtn");
const addOffersBtn = document.getElementById("addOffersBtn");
const viewUsersBtn = document.getElementById("viewUsersBtn"); 
const viewImagesBtn = document.getElementById("viewImagesBtn"); 
const uploadImagesLink = document.getElementById("uploadImagesLink");
const dashboardBtn = document.getElementById('dashboardBtn');
const paymentBtn = document.getElementById('paymentBtn');
const archivedStoresBtn = document.getElementById("archivedStoresBtn");

function hideAllSections() {
  storeList.style.display = "none";
  categoryList.style.display = "none";
  adminWelcome.style.display = "none";
  addStore.style.display = "none";
  addCategory.style.display = "none";
  addNews.style.display = "none";
  newsList.style.display = "none";
  offerList.style.display = "none";
  addOffers.style.display = "none";
  uploadedImagesList.style.display = "none"; 
  uploadImagesForm.style.display = "none";
  usersList.style.display = "none";
  dashboardSection.style.display = "none";
  paymentSection.style.display = "none";
  archivedStoresList.style.display = "none";
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
      xhr.open("POST", "https://ansarportal-deaa9ded50c7.herokuapp.com/admin/php/login_admin.php", true);
      xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

      // Define the callback function
      xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
          try {
            console.log(xhr.responseText);
            var response = JSON.parse(xhr.responseText);

            if (response.message) {
              // Redirect to the admin panel or perform any other action on successful login
              window.location.href = "https://ansarportal-deaa9ded50c7.herokuapp.com/index.php";
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
  document.getElementById("registerForm").addEventListener("submit", function (event) {
    event.preventDefault();

    var registrationCode = document.getElementById("registration_code").value;
    var username = document.getElementById("username").value;
    var password = document.getElementById("password").value;

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "https://ansarportal-deaa9ded50c7.herokuapp.com/admin/php/register_admin.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                try {
                    var response = JSON.parse(xhr.responseText);
                    if (response.message) {
                        alert(response.message);
                        window.location.href = "https://ansarportal-deaa9ded50c7.herokuapp.com/admin/php/login.php";
                    } else if (response.error) {
                        alert(response.error);
                    }
                } catch (error) {
                    console.error("Error parsing JSON:", error);
                }
            } else {
                console.error("Request failed with status:", xhr.status);
            }
        }
    };

    xhr.send("registration_code=" + registrationCode + "&username=" + username + "&password=" + password);
});
}
// LOGOUT

if (window.location.pathname.includes("index.php")) {

  // Hamburger menu

  document.addEventListener("DOMContentLoaded", function() {
    const hamburgerBtn = document.getElementById("hamburgerBtn");
    const sidebar = document.getElementById("sidebar");

    hamburgerBtn.addEventListener("click", function() {
        sidebar.classList.toggle("open");
        hamburgerBtn.classList.toggle("open");
    });
});

  // Add event listener to the logout button
  document.getElementById("logoutBtn").addEventListener("click", function () {
    // Create XMLHttpRequest object
    var xhr = new XMLHttpRequest();

    // Configure the request
    xhr.open("GET", "https://ansarportal-deaa9ded50c7.herokuapp.com/admin/php/logout.php", true);

    // Define the callback function
    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4) {
        try {
          console.log(xhr.responseText);
          var response = JSON.parse(xhr.responseText);

          if (response.success) {
            // Logout successful
            window.location.href = "https://ansarportal-deaa9ded50c7.herokuapp.com/admin/php/login.php";
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


// ARCHIVE STORES

function archiveStore(storeId) {
  // Confirm if the user wants to archive the store
  var confirmArchive = confirm("Are you sure you want to archive this store?");

  if (confirmArchive) {
      // Make an AJAX request to update the store's archived status
      var xhr = new XMLHttpRequest();
      xhr.open("POST", "https://ansarportal-deaa9ded50c7.herokuapp.com/admin/php/archive_store.php", true);
      xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
      xhr.onreadystatechange = function() {
          if (xhr.readyState === 4 && xhr.status === 200) {
              // Check if the archive operation was successful
              var response = JSON.parse(xhr.responseText);
              if (response.status === "success") {
                  // Refresh the store list to reflect changes
                  fetchAndDisplayStores();
              } else {
                  alert("Failed to archive store: " + response.message);
              }
          }
      };
      // Send the store ID in the request body
      xhr.send("store_id=" + storeId);
  }
}

// VIEW ARCHIVED STORES 

// Function to fetch and display archived stores using AJAX
function fetchAndDisplayArchivedStores() {
  var xhr = new XMLHttpRequest();

  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      try {
        var storesData = JSON.parse(xhr.responseText);
        // Filter archived stores
        var archivedStores = storesData.filter(store => store.archived);
        displayArchivedStores(archivedStores);
      } catch (error) {
        console.error("Error parsing JSON:", error);
      }
    }
  };

  xhr.open("GET", "https://ansarportal-deaa9ded50c7.herokuapp.com/admin/php/view_stores.php", true);
  xhr.send();
}

// Function to display archived stores
function displayArchivedStores(archivedStores) {
  var archivedStoresList = document.getElementById("archivedStoreList");

  // Clear existing content
  archivedStoresList.innerHTML = "";

  archivedStores.forEach(function(store) {
    // Create a list item for each archived store
    var listItem = document.createElement("li");
    listItem.setAttribute("data-store-id", store.store_id); // Set a unique identifier

    listItem.innerHTML = `
      <div class="store-container">
          <img src="${store.images[0]}" alt="Store Image" class="store-image">
          <h2 class="store-name">${store.store_name}</h2>
          <p class="store-description">${store.description}</p>
          <div class="store-actions">
              <button class="restore-btn" onclick="restoreStore(${store.store_id})">Restore</button>
          </div>
      </div>
    `;

    // Append the list item to the archived stores list
    archivedStoresList.appendChild(listItem);
  });
}



// Call the fetchAndDisplayArchivedStores function when the archivedStoresBtn is clicked
archivedStoresBtn.addEventListener("click", function () {
  hideAllSections(); // Hide other sections
  fetchAndDisplayArchivedStores(); // Fetch and display archived stores
  archivedStoresList.style.display = "flex"; // Display the archived stores section
});

function restoreStore(storeId) {
  // Send an AJAX request to your server to restore the store
  var xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function() {
      if (xhr.readyState === 4) {
          if (xhr.status === 200) {
              // Store restored successfully, you can update the UI or take further actions if needed
              alert("Store restored successfully!");
              // Refresh the archived stores list
              fetchAndDisplayArchivedStores();
          } else {
              // Error handling if the request fails
              alert("Error restoring store: " + xhr.statusText);
          }
      }
  };
  xhr.open("POST", "https://ansarportal-deaa9ded50c7.herokuapp.com/admin/php/restore_store.php", true);
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.send("store_id=" + storeId);
}




// EDIT AND DELETE STORES

// Function to delete store
function deleteStore(storeId) {
  // Make an AJAX request to delete the store
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "https://ansarportal-deaa9ded50c7.herokuapp.com/admin/php/delete_store.php", true);
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
  xhr.open("GET", "https://ansarportal-deaa9ded50c7.herokuapp.com/admin/php/view_stores.php?store_id=" + storeId, true);
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      try {
        var storeDetails = JSON.parse(xhr.responseText);

        // Fetch categories for the dropdown
        fetchCategories(storeId);
      } catch (error) {
        console.error("Error parsing JSON:", error);
      }
    }
  };
  xhr.send();
}

// Function to fetch categories and then call createEditForm
function fetchCategories(storeId) {
  var xhr = new XMLHttpRequest();
  xhr.open("GET", "https://ansarportal-deaa9ded50c7.herokuapp.com/admin/php/view_categories.php", true);
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      try {
        var categories = JSON.parse(xhr.responseText);

        // Create a dynamic form with fields filled with store details
        createEditForm(storeId, categories);
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
  formData.append("store_id", storeId);

  // Update these lines to match your PHP script expectations
  formData.append("new_store_name", updatedData.name);
  formData.append("new_category", updatedData.category);
  formData.append("new_description", updatedData.description);
  formData.append("new_phone_number", updatedData.phone);
  formData.append("new_instagram_url", updatedData.instagram_url);
  formData.append("new_facebook_url", updatedData.facebook_url);
  formData.append("new_tiktok_url", updatedData.tiktok_url);
  formData.append("new_whatsapp_number", updatedData.whatsapp_number);
  formData.append("new_location", updatedData.location);

  // Make an AJAX request to save the changes
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "https://ansarportal-deaa9ded50c7.herokuapp.com/admin/php/edit_store.php", true);
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4) {
      console.log(xhr.responseText);
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

  // Send the request with FormData
  xhr.send(formData);
}

// Function to create an edit form dynamically
function createEditForm(storeId, categories) {
  // Fetch store details using AJAX
  var xhr = new XMLHttpRequest();
  xhr.open("GET", "https://ansarportal-deaa9ded50c7.herokuapp.com/admin/php/view_store_details.php?store_id=" + storeId, true);
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      try {
        var storeDetails = JSON.parse(xhr.responseText);
        console.log(storeDetails);

        // Create the form container and populate it with store details
        var formContainer = document.createElement("div");
        formContainer.innerHTML = `
            <form id="editStoreForm">
                <label for="editStoreName">Store Name:</label>
                <input type="text" id="editStoreName" value="${storeDetails.store_name}" required>

                <label for="editStoreCategory">Category:</label>
                <select id="editStoreCategory" required>
                    ${categories
                      .map(
                        (category) =>
                          `<option value="${category.category_id}">${category.category_name}</option>`
                      )
                      .join("")}
                </select>

                <label for="editStoreDescription">Description:</label>
                <textarea id="editStoreDescription" required>${storeDetails.store_description}</textarea>

                <label for="editStorePhone">Phone Number:</label>
                <input type="text" id="editStorePhone" value="${storeDetails.phone_number}" required>

                <label for="editStoreInstagram">Instagram:</label>
                <input type="text" id="editStoreInstagram" value="${storeDetails.instagram_url}" required>

                <label for="editStoreFacebook">Facebook:</label>
                <input type="text" id="editStoreFacebook" value="${storeDetails.facebook_url}" required>

                <label for="editStoreTiktok">Tiktok:</label>
                <input type="text" id="editStoreTiktok" value="${storeDetails.tiktok_url}" required>

                <label for="editStoreWhatsapp">Whatsapp:</label>
                <input type="text" id="editStoreWhatsapp" value="${storeDetails.whatsapp_number}" required>

                <label for="editStoreLocation">Location:</label>
                <input type="text" id="editStoreLocation" value="${storeDetails.location}" required>                

                <button type="button" onclick="saveChanges(${storeId}, getUpdatedData())">Save Changes</button>
            </form>
        `;

        // Set the selected category in the dropdown
        var editStoreCategorySelect = formContainer.querySelector("#editStoreCategory");
        editStoreCategorySelect.value = storeDetails.category_id;

        // Replace the existing store container with the edit form
        var existingStoreContainer = document.getElementById("storeList").querySelector(`[data-store-id="${storeId}"]`);
        existingStoreContainer.innerHTML = "";
        existingStoreContainer.appendChild(formContainer);
      } catch (error) {
        console.error("Error parsing JSON:", error);
      }
    }
  };
  xhr.send();
}


// Function to get updated data from the edit form
function getUpdatedData() {
  var updatedData = {
    name: document.getElementById("editStoreName").value,
    category: document.getElementById("editStoreCategory").value,
    description: document.getElementById("editStoreDescription").value,
    phone: document.getElementById("editStorePhone").value,
    instagram_url: document.getElementById("editStoreInstagram").value,
    facebook_url: document.getElementById("editStoreFacebook").value,
    tiktok_url: document.getElementById("editStoreTiktok").value,
    whatsapp_number: document.getElementById("editStoreWhatsapp").value,
    location: document.getElementById("editStoreLocation").value,
    // Add more fields as needed
  };

  return updatedData;
}

function displayStores(storesData, categories) {
  var storeList = document.getElementById("storeList");

  // Clear existing content
  storeList.innerHTML = "";

  // Filter out archived stores
  var activeStores = storesData.filter(store => !store.archived);

  activeStores.forEach(function(store) {
      // Find the category name based on the category ID
      var categoryName = categories.find(category => category.category_id === store.category)?.category_name;

      // Create a list item for each store
      var listItem = document.createElement("li");
      listItem.setAttribute("data-store-id", store.store_id); // Set a unique identifier

      listItem.innerHTML = `
          <div class="store-container">
              <div class="store-images">
                  <div class="slider">
                      <ul class="slides">
                          ${store.images.map(image =>
                              `<li class="slide"><img src="${image}" alt="Store Image"></li>`
                          ).join('')}
                      </ul>
                  </div>
                  <div class="slider-btn">
                  <button class="slide-btn prev">❮</button>
                  <button class="slide-btn next">❯</button>
                  </div>
              </div>
              <h2 class="store-name"><strong>Name: </strong>${store.store_name}</h2>
              <p class="store-category"><strong>Category: </strong>${categoryName}</p>
              <p class="store-description"><strong>Description: </strong>${store.description}</p>
              <p class="store-phone"><strong>Phone Number: </strong>${store.phone_number}</p>
              <p class="store-likes"><strong>Total Likes:</strong> ${store.total_likes}</p>
              <p class="store-socials"><strong>Instagram:</strong> ${store.instagram_url !== 'null' ? store.instagram_url : "N/A"}</p>
              <p class="store-socials"><strong>Facebook:</strong> ${store.facebook_url !== 'null' ? store.facebook_url : "N/A"}</p>
              <p class="store-socials"><strong>Tiktok:</strong> ${store.tiktok_url !== 'null' ? store.tiktok_url : "N/A"}</p>
              <p class="store-socials"><strong>Whatsapp:</strong> ${store.whatsapp_number !== 'null' ? store.whatsapp_number : "N/A"}</p>
              <p class="store-location"><strong>Location:</strong> ${store.location}</p>
              <div class="store-actions">
                  <button class="edit-btn" onclick="editStore(${store.store_id})">Edit</button>
                  <button class="delete-btn" onclick="confirmDelete(${store.store_id})">Delete</button>
                  <button class="archive-btn" onclick="archiveStore(${store.store_id})">Archive</button>
              </div>
          </div>
      `;

      // Append the list item to the store list
      storeList.appendChild(listItem);

      // Get the store container
      var storeContainer = listItem.querySelector(".store-container");

      // Add event listeners to the prev and next buttons to move the slide
      var prevButton = storeContainer.querySelector(".slide-btn.prev");
      var nextButton = storeContainer.querySelector(".slide-btn.next");

      prevButton.addEventListener("click", function() {
          moveSlide(storeContainer, -1); // Move the slide to the previous one
      });

      nextButton.addEventListener("click", function() {
          moveSlide(storeContainer, 1); // Move the slide to the next one
      });
  });
}



function moveSlide(storeContainer, n) {
  console.log("moveSlide function is called with n =", n);
  const slides = storeContainer.querySelectorAll('.slide');
  console.log("Number of slides found:", slides.length);
  let slideIndex = 0;

  // Find the currently active slide
  slides.forEach((slide, index) => {
    if (slide.classList.contains('active')) {
      slideIndex = index;
    }
  });

  // Calculate the index of the next slide
  let nextSlideIndex = slideIndex + n;

  // Ensure the next slide index stays within bounds
  if (nextSlideIndex < 0) {
    nextSlideIndex = slides.length - 1;
  } else if (nextSlideIndex >= slides.length) {
    nextSlideIndex = 0;
  }

  // Remove active class from all slides
  slides.forEach((slide) => {
    slide.classList.remove('active');
    slide.style.display = 'none'; // Hide all slides
  });

  // Add active class to the next slide and display it
  slides[nextSlideIndex].classList.add('active');
  slides[nextSlideIndex].style.display = 'block';
}







// VIEW STORES

// Function to fetch and display stores using AJAX
function fetchAndDisplayStores() {
  var xhr = new XMLHttpRequest();

  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      try {
        var storesData = JSON.parse(xhr.responseText);
        // Assuming you have already fetched categories and stored them in the categoryList variable
        fetchStoreCategories(storesData);
      } catch (error) {
        console.error("Error parsing JSON:", error);
      }
    }
  };

  xhr.open("GET", "https://ansarportal-deaa9ded50c7.herokuapp.com/admin/php/view_stores.php", true);
  xhr.send();
}

// Function to fetch categories
function fetchStoreCategories(storesData) {
  var xhr = new XMLHttpRequest();

  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      try {
        var categories = JSON.parse(xhr.responseText);
        console.log(xhr.responseText);
        displayStores(storesData, categories);
      } catch (error) {
        console.error("Error parsing JSON:", error);
      }
    }
  };

  xhr.open("GET", "https://ansarportal-deaa9ded50c7.herokuapp.com/admin/php/view_categories.php", true);
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
    var instagram = document.getElementById("instagram").value;
    var facebook = document.getElementById("facebook").value;
    var tiktok = document.getElementById("tiktok").value;
    var whatsapp = document.getElementById("whatsapp").value;
    var location = document.getElementById("location").value;

    console.log(instagram, facebook, tiktok, whatsapp, location);

    // Create XMLHttpRequest object (or use fetch API)
    var xhr = new XMLHttpRequest();

    // Configure the request
    xhr.open("POST", "https://ansarportal-deaa9ded50c7.herokuapp.com/admin/php/add_store.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    // Define the callback function
    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4) {
        console.log(xhr.responseText);
        try {
          var response = JSON.parse(xhr.responseText);
          if (response.status === "success") {
            alert(response.message);
            addStore.style.display = "none";
            storeList.style.display = "flex"
            fetchAndDisplayStores();
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
        phone +
        "&tiktok=" +
        tiktok +
        "&facebook=" +
        facebook +
        "&whatsapp=" +
        whatsapp +
        "&instagram=" +
        instagram +
        "&location=" +
        location
    );
  });

// Event listener for button click
addStoresBtn.addEventListener("click", function () {
  // Fetch and display products when the page loads
  hideAllSections();

  // Fetch Categories
  fetch("https://ansarportal-deaa9ded50c7.herokuapp.com/admin/php/view_categories.php")
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

// CATEGORIES

// VIEW CATEGORIES

// Function to fetch and display categories using AJAX
function fetchAndDisplayCategories() {
  var xhr = new XMLHttpRequest();

  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      try {
        var categoriesData = JSON.parse(xhr.responseText);
        displayCategories(categoriesData);
      } catch (error) {
        console.error("Error parsing JSON:", error);
      }
    }
  };

  xhr.open("GET", "https://ansarportal-deaa9ded50c7.herokuapp.com/admin/php/view_categories.php", true);
  xhr.send();
}

// Function to display categories
function displayCategories(categoriesData) {
  var categoryList = document.getElementById("categoryList");
  categoryList.innerHTML = ""; // Clear the previous content

  categoriesData.forEach(function (category) {
    var categoryItem = document.createElement("li");
    categoryItem.setAttribute("data-category-id", category.category_id);
    categoryItem.classList.add("category-item"); // Add class for styling
    categoryItem.innerHTML = ` 
          <img src="${category.category_image}" alt="${category.category_name} Image" class="category-image">
          <span><Strong> Category Name: </Strong> ${category.category_name}</span>
          <button class="edit-button" onclick="editCategory(${category.category_id})">Edit</button>
          <button class="edit-button" onclick="deleteCategory(${category.category_id})">Delete</button>
      `;
    categoryList.appendChild(categoryItem);
  });
}

viewCategoriesBtn.addEventListener("click", function () {
  // Fetch and display categories
  hideAllSections();
  fetchAndDisplayCategories();
  categoryList.style.display = "flex";
});

// Function to delete a category
function deleteCategory(categoryId) {
  var confirmation = confirm("Are you sure you want to delete this category?");
  if (confirmation) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "https://ansarportal-deaa9ded50c7.herokuapp.com/admin/php/delete_category.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4) {
        console.log(xhr.responseText);
        try {
          var response = JSON.parse(xhr.responseText);
          if (response.status === "success") {
            alert(response.message);
            fetchAndDisplayCategories();
          } else {
            alert(response.message);
          }
        } catch (error) {
          console.error("Error parsing JSON:", error);
        }
      }
    };

    // Send the request to delete the category
    xhr.send("category_id=" + categoryId);
  }
}

// Function to fetch category details and create/edit category form dynamically
function editCategory(categoryId) {
  var xhr = new XMLHttpRequest();
  xhr.open("GET", "https://ansarportal-deaa9ded50c7.herokuapp.com/admin/php/view_categories.php?category_id=" + categoryId, true);
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      try {
        var categoryData = JSON.parse(xhr.responseText);

        // Find the category that matches the categoryId
        var categoryDetails = categoryData.find(category => category.category_id === categoryId);

        if (categoryDetails) {
          // Create the form container and populate it with category details
          var formContainer = document.createElement("div");
          formContainer.innerHTML = `
              <form id="editCategoryForm">
                  <h2>Edit Category</h2>
                  <label for="editCategoryName">Category Name:</label>
                  <input type="text" id="editCategoryName" value="${categoryDetails.category_name}" required>
                  <button type="button" onclick="saveCategoryChanges(${categoryId}, getUpdatedCategoryData())">Save Changes</button>
              </form>
          `;

          // Replace the existing category container with the edit form
          var existingCategoryContainer = document.getElementById("categoryList").querySelector(`[data-category-id="${categoryId}"]`);
          existingCategoryContainer.innerHTML = "";
          existingCategoryContainer.appendChild(formContainer);

        } else {
          console.error("Category details not found for category ID:", categoryId);
        }
      } catch (error) {
        console.error("Error parsing JSON:", error);
      }
    }
  };
  xhr.send();
}



// Function to save category changes
function saveCategoryChanges(categoryId, updatedData) {
  // Create a FormData object and append the data
  var formData = new FormData();
  formData.append("category_id", categoryId);
  formData.append("new_category_name", updatedData.category_name);

  // Make an AJAX request to save the changes
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "https://ansarportal-deaa9ded50c7.herokuapp.com/admin/php/edit_category.php", true);
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4) {
      try {
        var response = JSON.parse(xhr.responseText);
        if (response.message) {
          alert(response.message);
          // Optionally, you may refresh the category list or update the UI
          fetchAndDisplayCategories();
        } else {
          alert(response.error);
        }
      } catch (error) {
        console.error("Error parsing JSON:", error);
      }
    }
  };

  // Send the request with FormData
  xhr.send(formData);
}


// Function to get updated category data from the edit form
function getUpdatedCategoryData() {
  var updatedData = {
    category_name: document.getElementById("editCategoryName").value,
    // Add more fields as needed
  };

  return updatedData;
}

// Add Category Form Submission
document.getElementById("addCategoryForm").addEventListener("submit", function (event) {
  event.preventDefault();

  // Create FormData object to handle form data
  const formData = new FormData(this);

  // Make an AJAX request to send the form data to your PHP script
  const xhr = new XMLHttpRequest();
  xhr.open("POST", "https://ansarportal-deaa9ded50c7.herokuapp.com/admin/php/add_category.php", true);
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4) {
      console.log(xhr.responseText);
      try {
        const response = JSON.parse(xhr.responseText);
        if (response.status === "success") {
          alert("Category added successfully.");
          // Hide Add Category section
          addCategory.style.display = "none";
          // Show View Categories section
          categoryList.style.display = "flex";
          // Fetch and display categories
          fetchAndDisplayCategories();
        } else {
          alert("Error: " + response.error);
        }
      } catch (error) {
        console.error("Error parsing JSON:", error);
      }
    }
  };
  xhr.send(formData);
});

// Event listener for button click
addCategoriesBtn.addEventListener("click", function () {
  // Fetch and display categories when the page loads
  hideAllSections();
  fetchAndDisplayCategories();
  addCategory.style.display = "block";
});


// SPECIAL OFFERS

// Function to fetch and display offers using AJAX
function fetchAndDisplayOffers() {
  var xhr = new XMLHttpRequest();

  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      try {
        var offersData = JSON.parse(xhr.responseText);
        console.log(xhr.responseText);
        displayOffers(offersData);
      } catch (error) {
        console.error("Error parsing JSON:", error);
      }
    }
  };

  xhr.open("GET", "https://ansarportal-deaa9ded50c7.herokuapp.com/admin/php/view_offers.php", true);
  xhr.send();
}

// Function to display offers
function displayOffers(offersData) {
  offerList.innerHTML = ""; // Clear the previous content

  offersData.forEach(function (offer) {
    var offerContainer = document.createElement("div");
    offerContainer.classList.add("offer-container");
    offerContainer.setAttribute("data-offer-id", offer.offer_id); // Add data-offer-id attribute

    offerContainer.innerHTML = `
      <img src="${offer.image_url}" alt="${offer.offer_title} Image" class="offer-image">
      <h3 class="offer-name"><Strong>Name: </Strong>${offer.offer_title}</h3>
      <p><Strong>Description:</Strong> ${offer.offer_description}</p>
      <p><Strong>Start Date:</Strong> ${offer.start_date}</p>
      <p><Strong>End Date:</Strong> ${offer.end_date}</p>
      <p> <Strong>Store:</Strong> ${offer.store_name}</p>
      <div class="offer-actions">
          <button onclick="editOffer(${offer.offer_id})">Edit</button>
          <button onclick="deleteOffer(${offer.offer_id})">Delete</button>
      </div>
    `;

    offerList.appendChild(offerContainer);
  });
}


// Example usage:
// Assuming you have an element with ID "viewOffersBtn" for triggering the display

viewOffersBtn.addEventListener("click", function () {
  // Fetch and display offers
  hideAllSections(); // Assuming you have a function to hide other sections
  fetchAndDisplayOffers();
  offerList.style.display = "flex"; // Assuming you have an element with ID "offerList"
});

// Add Offer Form Submission
document.getElementById("addOfferForm").addEventListener("submit", function (event) {
  event.preventDefault();

  // Gather form data
  var storeId = document.getElementById("store_id").value;
  var offerTitle = document.getElementById("offer_title").value;
  var offerDescription = document.getElementById("offer_description").value;
  var startDate = document.getElementById("start_date").value;
  var endDate = document.getElementById("end_date").value;
  var imageInput = document.getElementById("image_url");
  
  // Check if the file input has a selected file
  if (imageInput.files.length > 0) {
      var imageFile = imageInput.files[0];

      // Create FormData object to handle file upload
      var formData = new FormData();
      formData.append('store_id', storeId);
      formData.append('offer_title', offerTitle);
      formData.append('offer_description', offerDescription);
      formData.append('start_date', startDate);
      formData.append('end_date', endDate);
      formData.append('image_url', imageFile);

      // Create XMLHttpRequest object
      var xhr = new XMLHttpRequest();

      // Configure the request
      xhr.open("POST", "https://ansarportal-deaa9ded50c7.herokuapp.com/admin/php/add_special_offer.php", true);

      // Define the callback function
      xhr.onreadystatechange = function () {
          if (xhr.readyState === 4) {
              console.log(xhr.responseText);
              try {
                  var response = JSON.parse(xhr.responseText);

                  if (response.status === "success") {
                      alert(response.message);
                      addOffers.style.display = "none";
                      offerList.style.display = "flex"
                      fetchAndDisplayOffers();
                      // You may perform additional actions on successful offer addition
                  } else {
                      alert(response.message);
                  }
              } catch (error) {
                  console.error("Error parsing JSON:", error);
              }
          }
      };

      // Send the request with FormData
      xhr.send(formData);
  } else {
      alert("Please select an offer image");
  }
});

// Event listener for button click
addOffersBtn.addEventListener("click", function () {
  // Fetch and display stores when adding an offer
  hideAllSections();
  fetchAndDisplayStoresForOffer();
  addOffers.style.display = "block";
});

// Fetch and display stores for the offer form
function fetchAndDisplayStoresForOffer() {
  var xhr = new XMLHttpRequest();

  xhr.onreadystatechange = function () {
      if (xhr.readyState === 4 && xhr.status === 200) {
          try {
              var storesData = JSON.parse(xhr.responseText);
              console.log(xhr.responseText);

              // Populate store dropdown for the offer form
              const storeDropdown = document.getElementById("store_id");
              storeDropdown.innerHTML = ""; // Clear existing options
              storesData.forEach(store => {
                  const option = document.createElement("option");
                  option.value = store.store_id;
                  option.textContent = store.store_name; // Assuming you have a 'store_name' field
                  storeDropdown.appendChild(option);
              });

          } catch (error) {
              console.error("Error parsing JSON:", error);
          }
      }
  };

  xhr.open("GET", "https://ansarportal-deaa9ded50c7.herokuapp.com/admin/php/view_stores.php", true);
  xhr.send();
}

// DELETE OFFER

// Function to delete an offer
function deleteOffer(offerId) {
  var confirmation = confirm("Are you sure you want to delete this offer?");
  if (confirmation) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "https://ansarportal-deaa9ded50c7.herokuapp.com/admin/php/delete_offer.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4) {
        console.log(xhr.responseText);
        try {
          var response = JSON.parse(xhr.responseText);
          if (response.status === "success") {
            alert(response.message);
            // Refresh the offer list or update the UI
            fetchAndDisplayOffers();
          } else {
            alert(response.message);
          }
        } catch (error) {
          console.error("Error parsing JSON:", error);
        }
      }
    };

    // Send the request to delete the offer
    xhr.send("offer_id=" + offerId);
  }
}


// Function to edit an offer
function editOffer(offerId) {
  // Fetch offer details using AJAX and create a dynamic form for editing
  var xhr = new XMLHttpRequest();
  xhr.open("GET", "https://ansarportal-deaa9ded50c7.herokuapp.com/admin/php/view_offers.php?offer_id=" + offerId, true);
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      try {
        var offerDetails = JSON.parse(xhr.responseText);

        // Create a dynamic form with fields filled with offer details
        fetchStoresForEditOffer(offerId);
      } catch (error) {
        console.error("Error parsing JSON:", error);
      }
    }
  };
  xhr.send();
}

// Function to fetch stores and then call createEditOfferForm
function fetchStoresForEditOffer(offerId) {
  var xhr = new XMLHttpRequest();
  xhr.open("GET", "https://ansarportal-deaa9ded50c7.herokuapp.com/admin/php/view_stores.php", true);
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      try {
        var storesData = JSON.parse(xhr.responseText);
        console.log(storesData);

        // Call createEditOfferForm with the fetched stores data
        createEditOfferForm(offerId, storesData);
      } catch (error) {
        console.error("Error parsing JSON:", error);
      }
    }
  };
  xhr.send();
}

// Function to save offer changes
function saveOfferChanges(offerId, updatedData) {
  // Create a FormData object and append the data
  var formData = new FormData();
  formData.append("offer_id", offerId);

  // Update these lines to match your PHP script expectations
  formData.append("store_id", updatedData.store_id);
  formData.append("offer_title", updatedData.offer_title);
  formData.append("offer_description", updatedData.offer_description);
  formData.append("start_date", updatedData.start_date);
  formData.append("end_date", updatedData.end_date);
  formData.append("image_url", updatedData.image_url);

  if (updatedData.image_file) {
    formData.append("image_file", updatedData.image_file);
  }

  // Make an AJAX request to save the changes
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "https://ansarportal-deaa9ded50c7.herokuapp.com/admin/php/edit_offer.php", true);
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4) {
      console.log(xhr.responseText);
      try {
        var response = JSON.parse(xhr.responseText);
        if (response.status === "success") {
          alert(response.message);
          // Optionally, you may refresh the offer list or update the UI
          fetchAndDisplayOffers();
        } else {
          alert(response.message);
        }
      } catch (error) {
        console.error("Error parsing JSON:", error);
      }
    }
  };

  // Send the request with FormData
  xhr.send(formData);
}


// Function to fetch and populate the store dropdown in the edit form
function fetchAndPopulateStoresDropdown(selectElement, selectedStoreId) {
  var xhr = new XMLHttpRequest();

  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      try {
        var storesData = JSON.parse(xhr.responseText);
        selectElement.innerHTML = ""; // Clear existing options
        storesData.forEach(store => {
          var option = document.createElement("option");
          option.value = store.store_id;
          option.textContent = store.store_name; // Assuming you have a 'store_name' field
          selectElement.appendChild(option);
        });

        // Set the selected store based on selectedStoreId
        if (selectedStoreId) {
          selectElement.value = selectedStoreId;
        }
      } catch (error) {
        console.error("Error parsing JSON:", error);
      }
    }
  };

  xhr.open("GET", "https://ansarportal-deaa9ded50c7.herokuapp.com/admin/php/view_stores.php", true);
  xhr.send();
}




// Function to create an edit offer form dynamically
function createEditOfferForm(offerId, storesData) {
  // Fetch offer details using AJAX
  var xhr = new XMLHttpRequest();
  xhr.open("GET", "https://ansarportal-deaa9ded50c7.herokuapp.com/admin/php/view_offer_details.php?offer_id=" + offerId, true);
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      try {
        var offerDetails = JSON.parse(xhr.responseText);

        // Create the form container and populate it with offer details
        var formContainer = document.createElement("div");
        formContainer.innerHTML = `
          <form id="editOfferForm" enctype="multipart/form-data">
              <label for="editStoreId">Store:</label>
              <select id="editStoreId" required>
                ${storesData
                  .map(
                    (store) =>
                      `<option value="${store.store_id}">${store.store_name}</option>`
                  )
                  .join("")}
              </select>

              <label for="editOfferTitle">Offer Title:</label>
              <input type="text" id="editOfferTitle" value="${offerDetails.offer_title}" required>

              <label for="editOfferDescription">Offer Description:</label>
              <textarea id="editOfferDescription" required>${offerDetails.offer_description}</textarea>

              <label for="editStartDate">Start Date:</label>
              <input type="date" id="editStartDate" value="${offerDetails.start_date}" required>

              <label for="editEndDate">End Date:</label>
              <input type="date" id="editEndDate" value="${offerDetails.end_date}" required>

              <label for="editImage">Image:</label>
              <input type="file" id="editImage" accept="image/*">

              <button type="button" onclick="saveOfferChanges(${offerId}, getUpdatedOfferData())">Save Changes</button>
          </form>
        `;

          // Set the selected category in the dropdown
          var editStoreNameSelect = formContainer.querySelector("#editStoreId");
          editStoreNameSelect.value = offerDetails.store_id;

        // Replace the existing offer container with the edit form
        var existingOfferContainer = document.getElementById("offerList").querySelector(`[data-offer-id="${offerId}"]`);
          existingOfferContainer.innerHTML = "";
          existingOfferContainer.appendChild(formContainer);
      } catch (error) {
        console.error("Error parsing JSON:", error);
      }
    }
  };
  xhr.send();
}

// Function to get updated offer data from the edit form
function getUpdatedOfferData() {
  var updatedData = {
    store_id: document.getElementById("editStoreId").value,
    offer_title: document.getElementById("editOfferTitle").value,
    offer_description: document.getElementById("editOfferDescription").value,
    start_date: document.getElementById("editStartDate").value,
    end_date: document.getElementById("editEndDate").value,
  };

  // Handle file input
  var editImageInput = document.getElementById("editImage");
  if (editImageInput.files.length > 0) {
    updatedData.image_file = editImageInput.files[0];
  }

  // Add more fields as needed

  return updatedData;
}



// Add News Form Submission

document
  .getElementById("addNewsForm")
  .addEventListener("submit", function (event) {
    event.preventDefault();

    const formData = new FormData(this);

    // Make an AJAX request to send the form data to your PHP script
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "https://ansarportal-deaa9ded50c7.herokuapp.com/admin/php/add_news.php", true);
    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4 && xhr.status === 200) {
        console.log(xhr.responseText);
        // Process the response, e.g., show a success message or handle errors
        try {
          const response = JSON.parse(xhr.responseText);
          if (response.status === "success") {
            alert("News added successfully.");
            addNews.style.display = "none";
            newsList.style.display = "flex"
            fetchAndDisplayNews();
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

  xhr.open("GET", "https://ansarportal-deaa9ded50c7.herokuapp.com/admin/php/view_news.php", true);
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
                <img class="news-image" src="${news.image_url}" alt="News Image">
                <h2 class="news-title">${news.title}</h2>
                <p class="news-content">${news.content}</p>
                <div class="news-actions">
                <p class="news-publication-date"><strong>Publication Date:</strong> ${news.publication_date}</p>
                <button onclick="deleteNews(${news.news_id})">Delete</button>
            </div>
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

// DELETE NEWS

// Function to delete a news item
function deleteNews(newsId) {
  var confirmation = confirm("Are you sure you want to delete this news?");
  if (confirmation) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "https://ansarportal-deaa9ded50c7.herokuapp.com/admin/php/delete_news.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4) {
        console.log(xhr.responseText);
        try {
          var response = JSON.parse(xhr.responseText);
          if (response.status === "success") {
            alert(response.message);
            // Refresh the news list or update the UI
            fetchAndDisplayNews();
          } else {
            alert(response.message);
          }
        } catch (error) {
          console.error("Error parsing JSON:", error);
        }
      }
    };

    // Send the request to delete the news item
    xhr.send("news_id=" + newsId);
  }
}



  // UPLOAD AND DISPLAY IMAGES

// Add event listener for the link
uploadImagesLink.addEventListener("click", function () {
  // Fetch and display stores when uploading images
  hideAllSections();
  fetchAndPopulateStoresDropdown(document.getElementById("storeSelect"), null);
  uploadImagesForm.style.display = "block"; // Assuming you have an element with ID "uploadImagesForm"
});

// Fetch and populate stores for the upload form
fetchAndPopulateStoresDropdown(document.getElementById("storeSelect"), null);

// Add event listener to the form for submitting images
document.getElementById("uploadImagesForm").addEventListener("submit", function (event) {
  event.preventDefault(); // Prevent the default form submission

  var storeId = document.getElementById("storeSelect").value;
  var imageFiles = document.getElementById("imageFiles").files;

  if (storeId && imageFiles.length > 0) {
    var formData = new FormData();
    formData.append("store_id", storeId);

    for (var i = 0; i < imageFiles.length; i++) {
      formData.append("imageFiles[]", imageFiles[i]);
    }

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "https://ansarportal-deaa9ded50c7.herokuapp.com/admin/php/upload_images.php", true);

    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4) {
        console.log(xhr.responseText);
        try {
          var response = JSON.parse(xhr.responseText);
          if (response.status === "success") {
            alert(response.message);
            uploadImagesForm.style.display = "none";
            uploadedImagesList.style.display = "flex"
            
            // Optionally, you may update the uploaded images list
            fetchAndDisplayAllImages();
          } else {
            alert(response.message);
          }
        } catch (error) {
          console.error("Error parsing JSON:", error);
        }
      }
    };

    xhr.send(formData);
  } else {
    alert("Please select a store and at least one image file");
  }
});

// Function to fetch and display uploaded images
function fetchAndDisplayAllImages() {
  var xhr = new XMLHttpRequest();

  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      try {
        console.log(xhr.responseText);
        var imagesData = JSON.parse(xhr.responseText);
        displayUploadedImages(imagesData);
      } catch (error) {
        console.error("Error parsing JSON:", error);
      }
    }
  };

  xhr.open("GET", "https://ansarportal-deaa9ded50c7.herokuapp.com/admin/php/view_images.php", true);
  xhr.send();
}

// Function to display uploaded images
function displayUploadedImages(imagesData) {
  uploadedImagesList.innerHTML = ""; // Clear previous content

  imagesData.forEach(function (image) {
    var imageItem = document.createElement("li");
    imageItem.classList.add("image-item");
    imageItem.innerHTML = `
      <img src="${image.image_url}" alt="Uploaded Image">
      <p><Strong>Store:</Strong> ${image.store_name}</p>
      <button onclick="confirmDeleteImage(${image.image_id}, ${image.store_id})">Delete</button>
    `;
    uploadedImagesList.appendChild(imageItem);
  });
}


// Function to confirm deletion and delete the image
function confirmDeleteImage(imageId, storeId, imageUrl) {
  var confirmation = confirm("Are you sure you want to delete this image?");
  if (confirmation) {
    deleteImage(imageId, storeId, imageUrl);
  }
}

// Function to delete the image
function deleteImage(imageId, storeId, imageUrl) {
  var xhr = new XMLHttpRequest();

  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4) {
      try {
        console.log(xhr.responseText);
        var response = JSON.parse(xhr.responseText);
        if (response.status === "success") {
          alert(response.message);
          // Refresh the images list or update the UI
          fetchAndDisplayAllImages();
        } else {
          alert(response.message);
        }
      } catch (error) {
        console.error("Error parsing JSON:", error);
      }
    }
  };

  xhr.open("POST", "https://ansarportal-deaa9ded50c7.herokuapp.com/admin/php/delete_image.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.send("image_id=" + imageId + "&store_id=" + storeId);
}


// Add event listener for the link
viewImagesBtn.addEventListener("click", function () {
  // Fetch and display stores when uploading images
  hideAllSections();
  fetchAndDisplayAllImages();
  uploadedImagesList.style.display = "flex"; // Assuming you have an element with ID "uploadImagesForm"
});

// DISPLAY USERS 

// Function to fetch and display users using AJAX
function fetchAndDisplayUsers() {
  var xhr = new XMLHttpRequest();
  xhr.open("GET", "https://ansarportal-deaa9ded50c7.herokuapp.com/admin/php/view_all_users.php", true);
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      try {
        var usersData = JSON.parse(xhr.responseText);
        displayUsers(usersData);
      } catch (error) {
        console.error("Error parsing JSON:", error);
      }
    }
  };
  xhr.send();
}

// Function to display users on the webpage
function displayUsers(usersData) {
  usersList.innerHTML = ""; // Clear previous content

  usersData.forEach(function (user) {
    var userCard = document.createElement("div");
    userCard.classList.add("user-card");

    userCard.innerHTML = `
    <div class="user-info">
      <h3>User ID: <span class="highlight">${user.user_id}</span></h3>
      <p><span class="label">Username:</span> <span class="value">${user.username || "N/A"}</span></p>
      <p><span class="label">Email:</span> <span class="value">${user.email}</span></p>
      <p><span class="label">Google Id:</span> <span class="value">${user.google_id || "N/A"}</span></p>
      <p><span class="label">Created At:</span> <span class="value">${user.created_at}</span></p>
  </div>
  
    `;

    usersList.appendChild(userCard);
  });
}

// Call the fetchAndDisplayUsers
viewUsersBtn.addEventListener("click", function () {
  // Fetch and display users
  hideAllSections();
  fetchAndDisplayUsers();
  usersList.style.display = "flex"; // Assuming you have an element with ID "uploadImagesForm"
});

// DASHBOARD

// Function to fetch dashboard statistics from the server
function fetchDashboardStats() {
  fetch('https://ansarportal-deaa9ded50c7.herokuapp.com/admin/php/dashboard.php')
      .then(response => response.json())
      .then(data => {
          // Display the dashboard statistics on the page
          const dashboardStats = document.getElementById('dashboardStats');
          const totalAdmins = document.getElementById('total-admins');
          totalAdmins.innerHTML = ` 
          <p ><Strong>Total Admins:</Strong> ${data.total_admins}</p>
          `
          dashboardStats.innerHTML = ` 
          <div class="dashboard-stat">
              <div class="stat-icon">
                  <i class="fas fa-users"></i>
              </div>
              <div class="stat-info">
                  <p class="stat-label">Total Users:</p>
                  <p class="stat-value">${data.total_users}</p>
              </div>
          </div>
          <div class="dashboard-stat">
              <div class="stat-icon">
                  <i class="fas fa-store"></i>
              </div>
              <div class="stat-info">
                  <p class="stat-label">Total Stores:</p>
                  <p class="stat-value">${data.total_stores}</p>
              </div>
          </div>
          <div class="dashboard-stat">
              <div class="stat-icon">
                  <i class="fas fa-tags"></i>
              </div>
              <div class="stat-info">
                  <p class="stat-label">Total Offers:</p>
                  <p class="stat-value">${data.total_offers}</p>
              </div>
          </div>
          <div class="dashboard-stat">
              <div class="stat-icon">
                  <i class="fas fa-newspaper"></i>
              </div>
              <div class="stat-info">
                  <p class="stat-label">Total News:</p>
                  <p class="stat-value">${data.total_news}</p>
              </div>
          </div>
          <div class="dashboard-stat">
              <div class="stat-icon">
                  <i class="fas fa-list"></i>
              </div>
              <div class="stat-info">
                  <p class="stat-label">Total Categories:</p>
                  <p class="stat-value">${data.total_categories}</p>
              </div>
          </div>
          <!-- Add more statistics as needed -->
      `;
      })
      .catch(error => {
          console.error('Error fetching dashboard stats:', error);
      });
}
// Call the fetchAndDisplayUsers
dashboardBtn.addEventListener("click", function () {
  // Fetch and display users
  hideAllSections();
  fetchDashboardStats();
  dashboardSection.style.display = "block"; // Assuming you have an element with ID "uploadImagesForm"
});





// PAYMENTS

// // Function to fetch and display stores with payment status using AJAX
// function fetchAndDisplayStoresWithPaymentStatus() {
//   var xhr = new XMLHttpRequest();
//   xhr.open("GET", "php/view_stores.php", true);
//   xhr.onreadystatechange = function () {
//     if (xhr.readyState === 4 && xhr.status === 200) {
//       try {
//         var storesData = JSON.parse(xhr.responseText);
//         displayStoresWithPaymentStatus(storesData);
//       } catch (error) {
//         console.error("Error parsing JSON:", error);
//       }
//     }
//   };
//   xhr.send();
// }

// // Function to display stores with payment status
// function displayStoresWithPaymentStatus(storesData) {
//   paymentSection.innerHTML = ""; // Clear previous content

//   storesData.forEach(function(store) {
//     var storeElement = document.createElement("div");
//     storeElement.classList.add("store");

//     // Display store name
//     var storeName = document.createElement("p");
//     storeName.textContent = store.store_name;
//     storeElement.appendChild(storeName);

//     // Create button for payment status
//     var paymentButton = document.createElement("button");
//     paymentButton.textContent = "Unpaid"; // Default status
//     paymentButton.dataset.storeId = store.store_id; // Store ID as data attribute
//     paymentButton.addEventListener("click", togglePaymentStatus);
//     storeElement.appendChild(paymentButton);

//     paymentSection.appendChild(storeElement);
//   });
// }


// // Function to toggle payment status
// function togglePaymentStatus(event) {
//   var storeId = event.target.dataset.storeId;
//   var paymentDate = new Date().toISOString().slice(0, 10); // Get current date
  
//   var xhr = new XMLHttpRequest();
//   xhr.open("POST", "php/view_payments.php", true);
//   xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
//   xhr.onreadystatechange = function () {
//     if (xhr.readyState === 4 && xhr.status === 200) {
//       // Update button text based on response
//       if (xhr.responseText === "Payment submitted successfully.") {
//         event.target.textContent = "Paid";
//         event.target.disabled = true; // Disable button after payment
//       } else {
//         console.error("Error submitting payment:", xhr.responseText);
//       }
//     }
//   };
//   xhr.send("store_id=" + storeId + "&payment_date=" + paymentDate);
// }

// // Call the fetchAndDisplayUsers
// paymentBtn.addEventListener("click", function () {
//   // Fetch and display users
//   hideAllSections();
//   // Call the function to fetch and display stores with payment status
//   fetchAndDisplayStoresWithPaymentStatus();
//   paymentSection.style.display = "block"; // Assuming you have an element with ID "uploadImagesForm"
// });










}