<!DOCTYPE php>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HR2</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="main.css">

  
</head>

<body class="overflow-hidden bg-white-100 font-sans">
  <!-- Navbar -->
  <nav>
    <div class="flex h-16 items-center p-5 justify-between drop-shadow-xl cursor-pointer shadow-lg shadow-gray-300/50">
      <!-- Left Nav -->
      <ul class="flex flex-row items-center space-x-3">
        <li>
          <button onclick="toggleSidebar()">
            <i class="fas fa-bars text-black text-2xl cursor-pointer"></i>
          </button>
        </li>
        <img src="../images/gwamlogo.png" alt="LOGO" class="w-11">
        <li class="lg:block md:block text-black text-m font-semibold">HR L&D PERFORMANCE TRAINING MANAGEMENT SYSTEM</li>
      </ul>
  
      <!-- Right Nav -->
      <div class="flex flex-row items-center space-x-3">
        
        <button>
          <i class="fas fa-bell text-black text-xl cursor-pointer"></i>
        </button>
        <div class="relative">
          <a href="#" onclick="toggleDropdown()" id="profile-icon" class="rounded-full w-9 h-9 cursor-pointer">
            <img src="../images/HR.png" alt="Profile" class="w-9 h-9 rounded-full"/>
          </a>
          
          <!-- Dropdown Menu -->
          <div id="profileDropdown" class="absolute right-0 mt-2 w-40 bg-white shadow-lg rounded-lg hidden">
            <a href="#" class="block px-4 py-2 text-black hover:bg-gray-200">HR DEPT.</a>
            <a onclick="logout()" class="block px-4 py-2 text-black hover:bg-gray-200">Log Out</a>
          </div>
        </div>
      </div>
  </nav>


  <div class="flex h-screen">
    <!-- Sidebar -->
    <aside id="sidebar" class="w-64 bg-white shadow-lg flex-shrink-0 h-screen overflow-y-auto expanded">
      <div class="p-5 mb-14">
        <!-- Dashboard -->
        <div class="sidebar-item">
          <i class="fas fa-tachometer-alt text-amber-500 sidebar-icon"></i>
          <a href="dashboard.php" class="text-xl font-bold text-amber-500 font-sans sidebar-text">DASHBOARD</a>
        </div>
        
        <ul class="mt-5">
         <!-- Learning and Development Dropdown -->
<li class="sidebar-item mb-2 font-bold font-sans text-amber-500 relative grid">
    <div class="flex items-center justify-between">
        <div class="flex items-center">
            <i class="fas fa-book-reader text-amber-500 sidebar-icon"></i>
            <span class="text-l sidebar-text ml-2 cursor-pointer">Learning and Development</span>
        </div>
        <!-- Arrow Icon (Click to toggle dropdown) -->
        <i class="fas fa-chevron-down text-amber-500 transition-transform duration-300 cursor-pointer dropdownArrow"></i>
    </div>

   <!-- Dropdown Menu with Icons -->
<ul class="hidden bg-gray-100 rounded-md mt-2 space-y-2 pl-6 py-2 dropdownMenu">
    <li class="text-gray-700 hover:text-amber-500 cursor-pointer flex items-center">
        <i class="fas fa-user-plus mr-2 text-gray-500"></i> 
        <a href="new_hired.php" class="text-gray-700 hover:text-amber-500">New Hired</a>
    </li>
    <li class="text-gray-700 hover:text-amber-500 cursor-pointer flex items-center">
        <i class="fas fa-users mr-2 text-gray-500"></i> 
        <a href="regular_employee.php" class="text-gray-700 hover:text-amber-500">Regular Employee</a>
    </li>
</ul>

</li>
          
          <li class="sidebar-item mb-2">
            <i class="fas fa-file-alt text-gray-400 sidebar-icon"></i>
            <a href="workshop.php" class="block rounded-lg text-sm text-black-600 font-semibold hover:bg-amber-200 hover:pt-2 pb-2 pl-2 pr-4  sidebar-text">
              Training Workshop
            </a>
          </li>

         

          
          <!-- Performance Management -->
          <li class="sidebar-item mb-2 font-bold font-sans text-amber-500">
            <i class="fa fa-bar-chart text-amber-500 sidebar-icon"></i>
            <span class="text-l sidebar-text">Performance Management</span>
          </li>
          
          <li class="sidebar-item mb-2">
            <i class="fas fa-users text-gray-400 sidebar-icon"></i>
            <a href="attendancestat.php" class="block rounded-lg text-sm text-black-600 font-semibold hover:bg-amber-200 hover:pt-2 pb-2 pl-2 pr-1 sidebar-text">
              Attendance Statistics
            </a>
          </li>
          
          <li class="sidebar-item mb-2">
            <i class="fas fa-star text-gray-400 sidebar-icon"></i>
            <a href="evaluation.php" class="block rounded-lg text-sm text-black-600 font-semibold hover:bg-amber-200 hover:pt-2 pb-2 pl-2  sidebar-text">
              Performance Evaluation
            </a>
          </li>
         
          
          <!-- Training Management -->
          <li class="sidebar-item mb-2 font-bold font-sans text-amber-500">
            <i class="fas fa-chalkboard-teacher text-amber-500 sidebar-icon"></i>
            <span class="text-l sidebar-text">Training Management</span>
          </li>
          
          <li class="sidebar-item mb-2">
            <i class="fas fa-calendar-alt text-gray-400 sidebar-icon"></i>
            <a href="schedule.php" class="block rounded-lg text-sm text-black-600 font-semibold hover:bg-amber-200 hover:pt-2 pb-2 pl-2 pr-6 sidebar-text">
              Add Trainee
            </a>
          </li>
        </ul>
      </div>
    </aside>

    <!-- Main Content -->
    <div class="flex-grow bg-gray-300 p-1 pl-5 pb-32 overflow-y-auto">
      <div class="p-6">
        <h2 class="text-xl font-bold mb-4 bg-white rounded-xl pt-2 pb-2 indent-4">Training workshop</h2>
        <div class="flex space-x-4 mb-6">
        <button onclick="openModal()" class="bg-amber-500 text-white px-4 py-2 rounded">Add Training Workshop</button>
        <button onclick="openCategoryModal()" class="bg-amber-500 text-white px-4 py-2 rounded">Workshop Category</button>
            
            
      </div>

      <!--Modal Category-->
  <!-- Modal Category -->
<div id="categoryModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
  <div class="bg-white p-6 rounded-lg shadow-lg w-96 max-h-screen overflow-y-auto">
    <h2 class="text-xl font-bold mb-4">Add Workshop Category</h2>
    
    <form id="categoryForm">
      <div class="mb-4">
        <label class="block text-sm font-medium mb-1">Category Name</label>
        <input type="text" id="categoryName" class="w-full border-gray-300 rounded px-3 py-2 border" required>
      </div>

      <div class="flex justify-around space-x-2">
        <button type="submit" class="bg-amber-500 hover:bg-amber-600 text-white px-4 py-2 rounded">Save</button>
        <button type="button" onclick="closeCategoryModal()" class="bg-black hover:bg-amber-600 text-white px-4 py-2 rounded">Cancel</button>
      </div>
    </form>
  </div>
</div>

         <!-- Modal workshopModal-->
  <div id="workshopModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
   <div class="bg-white p-6 rounded-lg shadow-lg w-96 h-[70%] overflow-y-auto">
    <h2 class="text-xl font-bold mb-4">Add Workshop</h2>
    <form id="workshopForm">
  <div class="mb-4">
    <label class="block text-sm font-medium mb-1">Workshop Title</label>
    <input type="text" id="title" class="w-full border-gray-300 rounded px-3 py-2 border">
  </div>

  <div class="mb-4">
    <label class="block text-sm font-medium mb-1">Mentor Name</label>
    <input type="text" id="mentor" class="w-full border-gray-300 rounded px-3 py-2 border">
  </div>

  <div class="mb-4">
    <label class="block text-sm font-medium mb-1">Category</label>
    <select id="category" class="w-full border-gray-300 rounded px-3 py-2 border">
      <option value="">Select Category</option>
    </select>
  </div>

  <div class="mb-4">
    <label class="block text-sm font-medium mb-1">Description</label>
    <textarea id="description" class="w-full border-gray-300 rounded px-3 py-2 border"></textarea>
  </div>

  <div class="mb-4">
    <label class="block text-sm font-medium mb-1">Date</label>
    <input type="date" id="date" class="w-full border-gray-300 rounded px-3 py-2 border">
  </div>

  <div class="mb-4">
    <label class="block text-sm font-medium mb-1">Time</label>
    <input type="time" id="time" class="w-full border-gray-300 rounded px-3 py-2 border">
  </div>

  <!-- Venue (kept, since 'mode' is removed) -->
  <div class="mb-4">
    <label class="block text-sm font-medium mb-1">Venue</label>
    <input type="text" id="venue" class="w-full border-gray-300 rounded px-3 py-2 border" placeholder="Enter Venue Location">
  </div>

  <div class="flex justify-around space-x-2">
    <button type="submit" class="bg-amber-500 hover:bg-amber-600 text-white px-4 py-2 rounded">Add</button>
    <button type="button" onclick="closeModal()" class="bg-black hover:bg-amber-600 text-white px-4 py-2 rounded">Cancel</button>
  </div>
</form>

  </div>
  </div>



        
<div id="workshopContainer" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

<p id="loadingMessage" class="text-gray-500 text-center col-span-full">Loading workshops...</p>


</div>


    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>    
       
  <script>
  
  document.addEventListener("DOMContentLoaded", function () {
    // Select all dropdowns
    const dropdownArrows = document.querySelectorAll(".dropdownArrow");
    const dropdownMenus = document.querySelectorAll(".dropdownMenu");

    dropdownArrows.forEach((arrow, index) => {
        arrow.addEventListener("click", function (event) {
            event.stopPropagation();

            // Toggle visibility of the corresponding menu
            dropdownMenus[index].classList.toggle("hidden");

            // Rotate arrow icon
            arrow.classList.toggle("rotate-180");
        });
    });
});
  
    function toggleSidebar() {
      const sidebar = document.getElementById('sidebar');
      sidebar.classList.toggle('collapsed');
      sidebar.classList.toggle('expanded');
    }

    function toggleDropdown() {
      const dropdown = document.getElementById("profileDropdown");
      dropdown.classList.toggle("hidden");
    }

    // Show scrollbar when the sidebar is hovered
    const sidebar = document.getElementById('sidebar');
    let timer;

    sidebar.addEventListener('mouseenter', () => {
      sidebar.style.overflowY = 'auto';  // Show scrollbar when hovered
      clearTimeout(timer); // Prevent hiding the scrollbar too soon
    });

    sidebar.addEventListener('mouseleave', () => {
      // Hide scrollbar after 2 seconds if no more interaction
      timer = setTimeout(() => {
        sidebar.style.overflowY = 'hidden';
      }, 1000);
    });

    function toggleFields() {
    const mode = document.getElementById("mode").value;
    const linkField = document.getElementById("linkField");
    const venueField = document.getElementById("venueField");

    if (mode === "virtual") {
      linkField.style.display = "block";
      venueField.style.display = "none";
    } else {
      linkField.style.display = "none";
      venueField.style.display = "block";
    }
  }

  // Run toggleFields on page load to ensure correct visibility
  document.addEventListener("DOMContentLoaded", toggleFields);


    function openModal() {
      document.getElementById('workshopModal').classList.remove('hidden');
    }
    function closeModal() {
      document.getElementById('workshopModal').classList.add('hidden');
    }

    function openCategoryModal() {
    document.getElementById("categoryModal").classList.remove("hidden");
  }

  function closeCategoryModal() {
    document.getElementById("categoryModal").classList.add("hidden");
  }
    
  window.addEventListener("click", function (event) {
    const modal = document.getElementById("workshopModal");
    const modalContent = modal.querySelector(".bg-white"); // Selects the modal container

    if (event.target === modal) {
      closeModal();
    }
  });

  window.addEventListener("click", function (event) {
    const modal = document.getElementById("categoryModal");
    const modalContent = modal.querySelector(".bg-white"); // Selects the modal container

    if (event.target === modal) {
      closeCategoryModal()
    }
  });



  document.getElementById('categoryForm').addEventListener('submit', async function(event) {
    event.preventDefault(); // Prevent default form submission

    let categoryName = document.getElementById('categoryName').value.trim();
    
    if (!categoryName) {
        showToast("Please enter a category name.", "error");
        return;
    }

    try {
        let response = await fetch('http://localhost/HR2REPO/api/categoriesApi.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ name: categoryName }) // Sending category name as JSON
        });

        let result = await response.json();

        if (response.ok) {
            showToast(result.message || "Category added successfully!", "success"); // Show success toast
            document.getElementById('categoryName').value = '';
            setTimeout(() => location.reload(), 0.1); // Clear input field
            closeCategoryModal();
            
        } else {
            showToast(result.error || "Failed to add category.", "error"); // Show error toast
        }
    } catch (error) {
        console.error("Error:", error);
        showToast("An error occurred while adding the category.", "error");
    }
});




  document.addEventListener("DOMContentLoaded", function () {
    fetchCategories();
  });

  function fetchCategories() {
    fetch("http://localhost/HR2REPO/api/categoriesApi.php")
      .then(response => response.json())
      .then(data => {
        const categorySelect = document.getElementById("category");
        categorySelect.innerHTML = '<option value="">Select Category</option>'; // Reset options

        data.forEach(category => {
          const option = document.createElement("option");
          option.value = category.name; // Adjust according to API response
          option.textContent = category.name;
          categorySelect.appendChild(option);
        });

        
      })
      .catch(error => {
        console.error("Error fetching categories:", error);
        showToast("Failed to load categories!", "error");
      });
  }

  function showToast(message, type) {
    Toastify({
      text: message,
      style: {
        background: type === "success" 
          ? "linear-gradient(to right, #00b09b, #96c93d)" 
          : "linear-gradient(to right, #ff5f6d, #ffc371)"
      },
      duration: 3000,
      close: true
    }).showToast();
   }


   document.getElementById("workshopForm").addEventListener("submit", function (event) {
    event.preventDefault(); // Prevent default form submission

    const title = document.getElementById("title").value.trim();
    const mentor = document.getElementById("mentor").value.trim();
    
    // Get category name instead of ID
    const categoryElement = document.getElementById("category");
    const categoryName = categoryElement.options[categoryElement.selectedIndex].text; 

    const description = document.getElementById("description").value.trim();
    const date = document.getElementById("date").value;
    const time = document.getElementById("time").value;
    const venue = document.getElementById("venue").value.trim();

    if (!title || !mentor || !categoryName || !description || !date || !time || !venue) {
        showToast("Please fill out all required fields!", "error");
        return;
    }

    const formData = {
        title,
        mentor,
        category_id: categoryName, // Now sending category name instead of ID
        description,
        date,
        time,
        venue
    };

    fetch("http://localhost/HR2REPO/api/workshopsApi.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify(formData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast("Workshop added successfully!", "success");
            document.getElementById("workshopForm").reset();
            closeModal();
            setTimeout(() => location.reload(), 1500);
        } else {
            showToast(data.message || "Failed to add workshop!", "error");
        }
    })
    .catch(error => {
        console.error("Error submitting form:", error);
        showToast("Something went wrong!", "error");
    });
});




document.addEventListener("DOMContentLoaded", function () {
    const workshopContainer = document.getElementById("workshopContainer");

    fetch("http://localhost/HR2REPO/api/workshopsApi.php")
        .then(response => response.json())
        .then(data => {
            workshopContainer.innerHTML = ""; // Clear previous content

            if (data.length === 0) {
                workshopContainer.innerHTML = `<p class="text-gray-500 text-center col-span-full">No workshops available.</p>`;
                return;
            }

            data.reverse().forEach(workshop => {
                const card = document.createElement("div");
                card.className = "bg-white p-6 rounded-lg shadow-lg flex flex-col justify-between h-full transition-transform duration-300 hover:scale-105 hover:shadow-xl";

                card.innerHTML = `
                    <div>
                        <h1 class="text-lg font-bold text-gray-800">${workshop.title}</h1>
                        <p class="text-sm text-gray-500 mt-2">Mentor: <span class="font-medium">${workshop.mentor}</span></p>
                        <p class="text-sm text-gray-500">Date: <span class="font-medium">${workshop.date}</span></p>
                        <p class="text-sm text-gray-500">Time: <span class="font-medium">${workshop.time}</span></p>
                        <p class="text-gray-600 mt-4">${workshop.description}</p>
                    </div>

                    <a href="workshop-details.php?id=${workshop.id}" class="block mt-6 text-center bg-amber-500 hover:bg-black text-white px-4 py-2 hover:bg-amber-400 rounded-sm">
                        Workshop
                    </a>
                `;

                workshopContainer.appendChild(card);
            });
        })
        .catch(error => {
            console.error("Error fetching workshops:", error);
            workshopContainer.innerHTML = `<p class="text-red-500 text-center col-span-full">Failed to load workshops.</p>`;
        });
});


async function logout() {
            await fetch("logout.php", { method: "POST", credentials: "include" });
            window.location.href = "http://localhost/HR2REPO/login.php";
        }



  
  </script>
</body>
</>