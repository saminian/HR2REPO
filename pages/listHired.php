<!DOCTYPE php>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HR2</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
        <img src="images/gwamlogo.png" alt="LOGO" class="w-11">
        <li class="lg:block md:block text-black text-m font-semibold">HR L&D PERFORMANCE TRAINING MANAGEMENT SYSTEM</li>
      </ul>
  
      <!-- Right Nav -->
      <div class="flex flex-row items-center space-x-3">
        <button>
          <i class="fas fa-inbox text-black text-xl cursor-pointer"></i>
        </button>
        <button>
          <i class="fas fa-bell text-black text-xl cursor-pointer"></i>
        </button>
        <div class="relative">
          <a href="#" onclick="toggleDropdown()" id="profile-icon" class="rounded-full w-9 h-9 cursor-pointer">
            <img src="images/HR.png" alt="Profile" class="w-9 h-9 rounded-full">
          </a>
          
          <!-- Dropdown Menu -->
          <div id="profileDropdown" class="absolute right-0 mt-2 w-40 bg-white shadow-lg rounded-lg hidden">
            <a href="#" class="block px-4 py-2 text-black hover:bg-gray-200">HR DEPT.</a>
            <a href="dashboard.php" class="block px-4 py-2 text-black hover:bg-gray-200" onclick="logout()">Log Out</a>
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
          <!-- Learning Management -->
          <li class="sidebar-item mb-2 font-bold font-sans text-amber-500">
            <i class="fas fa-book-reader text-amber-500 sidebar-icon"></i>
            <span class="text-l sidebar-text">Learning and Development</span>
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
            <i class="fas fa-chart-line text-gray-400 sidebar-icon"></i>
            <a href="performstatistic.php" class="block rounded-lg text-sm text-black-600 font-semibold hover:bg-amber-200 hover:pt-2 pb-2 pl-2 pr-1 sidebar-text">
              Performance Statistics
            </a>
          </li>
          
          <li class="sidebar-item mb-2">
            <i class="fas fa-star text-gray-400 sidebar-icon"></i>
            <a href="evaluation.php" class="block rounded-lg text-sm text-black-600 font-semibold hover:bg-amber-200 hover:pt-2 pb-2 pl-2  sidebar-text">
              Performance Evaluation
            </a>
          </li>
          
          <li class="sidebar-item mb-2">
            <i class="fas fa-user-check text-gray-400 sidebar-icon"></i>
            <a href="status.php" class="block rounded-lg text-sm text-black-600 font-semibold hover:bg-amber-200 hover:pt-2 pb-2 pl-2 pr-1 sidebar-text">
              Employee Training Status
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
              Training Schedule
            </a>
          </li>
        </ul>
      </div>
    </aside>

    <main>
    <div class="max-w-6xl mx-auto bg-white p-6 rounded-lg shadow-lg bg-gray-300">
        <h2 class="text-xl font-bold mb-4">List of New Hired Employees</h2>

        <table class="w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border border-gray-300 px-4 py-2">ID</th>
                    <th class="border border-gray-300 px-4 py-2">Name</th>
                    <th class="border border-gray-300 px-4 py-2">Email</th>
                    <th class="border border-gray-300 px-4 py-2">Gender</th>
                    <th class="border border-gray-300 px-4 py-2">Birth Date</th>
                    <th class="border border-gray-300 px-4 py-2">Contact</th>
                    <th class="border border-gray-300 px-4 py-2">Job Position</th>
                    <th class="border border-gray-300 px-4 py-2">Salary</th>
                    <th class="border border-gray-300 px-4 py-2">Department</th>
                </tr>
            </thead>
            <tbody id="employeeTable">
                <tr><td colspan="9" class="text-center p-4">Loading employees...</td></tr>
            </tbody>
        </table>
    </div>
    </main>
        
       
  <script>
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



    document.addEventListener("DOMContentLoaded", function() {
        fetch("https://hr1.gwamerchandise.com/api/employee", {
            method: "GET",
            headers: { "Content-Type": "application/json" }
        })
        .then(response => response.json())
        .then(data => {
            let employeeTable = document.getElementById("employeeTable");
            employeeTable.innerHTML = ""; // Clear the loading text

            if (data.length === 0) {
                employeeTable.innerHTML = `<tr><td colspan="9" class="text-center p-4 text-red-500">No employees found.</td></tr>`;
                return;
            }

            data.forEach(employee => {
                let row = `<tr class='border border-gray-300'>
                    <td class='border border-gray-300 px-4 py-2'>${employee.id}</td>
                    <td class='border border-gray-300 px-4 py-2'>${employee.first_name} ${employee.middle_name || ''} ${employee.last_name}</td>
                    <td class='border border-gray-300 px-4 py-2'>${employee.email}</td>
                    <td class='border border-gray-300 px-4 py-2 capitalize'>${employee.gender}</td>
                    <td class='border border-gray-300 px-4 py-2'>${employee.birth_date}</td>
                    <td class='border border-gray-300 px-4 py-2'>${employee.contact}</td>
                    <td class='border border-gray-300 px-4 py-2'>${employee.job_position}</td>
                    <td class='border border-gray-300 px-4 py-2'>₱${employee.salary}</td>
                    <td class='border border-gray-300 px-4 py-2'>${employee.department}</td>
                </tr>`;
                employeeTable.innerHTML += row;

                // Send data to the local API
                fetch("http://localhost/HR2REPO/api/NewHiredApi.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({
                        id: employee.id,
                        first_name: employee.first_name,
                        middle_name: employee.middle_name || '',
                        last_name: employee.last_name,
                        email: employee.email,
                        gender: employee.gender,
                        birth_date: employee.birth_date,
                        contact: employee.contact,
                        job_position: employee.job_position,
                        salary: employee.salary,
                        department: employee.department
                    })
                })
                .then(response => response.json())
                .then(result => {
                    console.log(`Employee ${employee.id} saved:`, result);
                })
                .catch(error => {
                    console.error(`Error saving employee ${employee.id}:`, error);
                });
            });
        })
        .catch(error => {
            console.error("Error fetching employees:", error);
            document.getElementById("employeeTable").innerHTML = `<tr><td colspan="9" class="text-center p-4 text-red-500">Failed to load employees.</td></tr>`;
        });
    });

    


    async function logout() {
            await fetch("logout.php", { method: "POST", credentials: "include" });
            window.location.href = "http://localhost/HR2REPO/login.php";
        }








        
  
  </script>
</body>
</>