<!DOCTYPE php>
<php lang="en">
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
            <a href="dashboard.php" class="block px-4 py-2 text-black hover:bg-gray-200">Log Out</a>
          </div>
        </div>
      </div>
  </nav>

  <!-- Main Content -->
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

    <!-- Main Content -->
<div class="flex-grow bg-gray-300 p-1 pl-5 overflow-y-auto">
    <div class="p-6">
      <h2 class="text-xl font-bold mb-4 bg-white rounded-xl pt-2 pb-2 indent-4">New Hire/Employee Training Status</h2>
  
      <!-- Search Bar -->
      <div class="flex-grow container mx-auto bg-white h-[70%] mt-5 rounded-xl p-4 shadow-lg">
        <div class="mb-4">
            <input type="text" id="searchEmployee" placeholder="Search by name or department" class="p-1 border border-gray-300 rounded w-1/3"> 
        </div> 

    <div class="overflow-x-auto">
        <!-- Table -->
        <table id="traineeViewList" class="w-full table-auto border-collapse  text-sm">
          <thead>
            <tr class="bg-amber-500 text-center">
              <th class="p-3 px-5">Employee Name</th>
              <th class="p-3 px-5">Department</th>
              <th class="p-3 px-5 ">Training </th>
              <th class="p-3 px-5">Status</th>
              <th class="p-3 px-5">Training progress</th>
            </tr>
          </thead>
          <tbody>
            <tr class="text-center">
              <td class="p-3 px-5">John Doe</td>
              <td class="p-3 px-5">HR</td>
              <td class="p-3 px-5">Customer Service 101</td>
              <td class="p-3 px-5">Employee</td>
              <td class="p-3 px-5 text-green-600 font-semibold">Completed</td>
            </tr>
            <tr class="text-center">
              <td class="p-3 px-5">Jane Smith</td>
              <td class="p-3 px-5">HR</td>
              <td class="p-3 px-5">Onborading Orientation</td>
              <td class="p-3 px-5">New hire</td>
              <td class="p-3 px-5 text-red-600 font-semibold">In Progress</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
       
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

    // Search functionality
    document.getElementById("searchEmployee").addEventListener("input", function() {
    let filter = this.value.toLowerCase();  // Get the input value and convert to lowercase
    let rows = document.querySelectorAll("table tbody tr");  // Get all table rows
    rows.forEach(row => {
        let text = row.textContent.toLowerCase();  // Get the text content of the row
        row.style.display = text.includes(filter) ? "" : "none";  // Show or hide the row based on the search filter
    });
});
  
  </script>
</body>
</php>