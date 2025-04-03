<?php


function hrLayout($children) {
    
    ?>
    <!DOCTYPE html>
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
        <style>
        .active {
            display: flex;                       
            justify-content: flex-start;        
            align-items: center;              
            margin-top: 0.125rem;               
            gap: 1rem;                          
            padding: 0.5rem;                   
            border-radius: 0.375rem;            
            background-color: rgba(229, 231, 235, 0.12); 
            padding-left: 1.25rem;              
            padding-right: 1.25rem;             
            color: #ffffff;                     
        }

      </style>
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
    <!-- Notification Button -->
    <div class="relative">
        <button onclick="toggleNotificationDropdown()" class="relative">
            <i class="fas fa-bell text-black text-xl cursor-pointer"></i>
            <!-- Notification Counter -->
            <span id="notifCount" class="absolute -top-2 -right-2 bg-red-600 text-white text-xs px-1.5 py-0.5 rounded-full hidden">0</span>
        </button>

        <!-- Notification Dropdown -->
        <div id="notifDropdown" class="absolute right-0 mt-2 w-64 bg-white shadow-lg rounded-lg hidden">
            <div class="px-4 py-2 border-b text-black font-semibold">Notifications</div>
            <div id="notifList" class="max-h-60 overflow-y-auto">
                <p class="p-4 text-gray-500 text-sm">Loading notifications...</p>
            </div>
        </div>
    </div>

    <!-- Profile Dropdown -->
    <div class="relative">
        <a href="#" onclick="toggleDropdown()" id="profile-icon" class="rounded-full w-9 h-9 cursor-pointer">
            <img src="../images/HR.png" alt="Profile" class="w-9 h-9 rounded-full">
        </a>

        <!-- Dropdown Menu -->
        <div id="profileDropdown" class="absolute right-0 mt-2 w-40 bg-white shadow-lg rounded-lg hidden">
            <a href="#" class="block px-4 py-2 text-black hover:bg-gray-200">HR DEPT.</a>
            <a class="block px-4 py-2 text-black hover:bg-gray-200" onclick="logout()">Log Out</a>
        </div>
    </div>
</div>
    </nav>

    <div class="flex h-screen">
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


    <?php echo $children; ?>
    



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
    const sidebar = document.getElementById("sidebar");
    const sidebarIcon = document.getElementById("sidebarToggleIcon");

    sidebar.classList.toggle("collapsed");
    sidebar.classList.toggle("expanded");

    if (sidebarIcon) {
        // Change icon when sidebar is collapsed
        if (sidebar.classList.contains("collapsed")) {
            sidebarIcon.classList.replace("fa-bars", "fa-chevron-right");
        } else {
            sidebarIcon.classList.replace("fa-chevron-right", "fa-bars");
        }
    }
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


    document.getElementById("openModal").addEventListener("click", function () {
    document.getElementById("evaluationModal").classList.remove("hidden");
});
document.getElementById("closeModal").addEventListener("click", function () {
    document.getElementById("evaluationModal").classList.add("hidden");
});

async function logout() {
            await fetch("logout.php", { method: "POST", credentials: "include" });
            window.location.href = "https://hr2.gwamerchandise.com";
        }
        
        
        
    function toggleNotificationDropdown() {
        document.getElementById("notifDropdown").classList.toggle("hidden");
    }

    document.addEventListener("DOMContentLoaded", function () {
    async function fetchNotifications() {
        try {
            const response = await fetch("https://hr1.gwamerchandise.com/api/employee", {
                method: "GET",
                headers: {
                    "Content-Type": "application/json"
                }
            });

            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }

            const data = await response.json();
            const notifList = document.getElementById("notifList");
            const notifCount = document.getElementById("notifCount");

            notifList.innerHTML = ""; // Clear existing notifications

            if (data.length > 0) {
                notifCount.textContent = data.length;
                notifCount.classList.remove("hidden");

                data.forEach(emp => {
                    const notifItem = document.createElement("div");
                    notifItem.className = "px-4 py-2 border-b text-black hover:bg-gray-200 cursor-pointer";
                    notifItem.innerHTML = `
                        <p class="font-semibold">${emp.email}</p>
                        <p class="text-sm text-gray-500">${emp.department}</p>
                    `;
                    notifList.appendChild(notifItem);
                });
            } else {
                notifCount.classList.add("hidden");
                notifList.innerHTML = '<p class="p-4 text-gray-500 text-sm">No new notifications</p>';
            }
        } catch (error) {
            console.error("Error fetching notifications:", error);
            document.getElementById("notifList").innerHTML = '<p class="p-4 text-red-500 text-sm">Failed to load notifications</p>';
        }
    }

    // Fetch notifications initially
    fetchNotifications();

    
});


      
    </script>
    </body>
    </html>
    <?php
}
?>