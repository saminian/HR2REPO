<?php
// Include the layout file
include '../layout/layout.php';

$homeContent = "
 <main id='main-content' class='w-full transition-all duration-500 bg-gray-300  mb-10flex-grow bg-gray-300 p-1 pl-5 pb-32 overflow-y-auto'>
    <div class='p-4 w-full'>
        <div class='flex flex-col md:flex-row items-center justify-between bg-white shadow-md rounded-lg p-4 mb-4'>
            <div class='flex items-center'>
                <div class='text-xl font-bold'>Dashboard</div>
            </div>
        </div>
      
        <div class='grid grid-cols-1 ml-1 md:grid-cols-2 lg:grid-cols-4 gap-4'>
            <!-- Total New Hired  -->
            <div class='bg-white w-full rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow'>
                <div class='flex justify-between items-start mb-4'>
                    <div>
                        <h2 class='text-lg font-semibold text-gray-700'>Total New Hired</h2>
                        <div class='flex items-center mt-1'>
                            <span id='totalNewHiredEmployees' class='text-3xl font-bold'>0</span> 
                        </div>
                    </div>
                    <div class='p-3 bg-amber-100 rounded-full'>
                        <i class='fas fa-user-plus text-amber-600 text-xl'></i>
                    </div>
                </div>
                <p class='text-gray-600'>Trainees</p>
            </div>
          
            <!-- Training -->
            <div class='bg-white w-full rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow'>
                <div class='flex justify-between items-start mb-4'>
                    <div>
                        <h2 class='text-lg font-semibold text-gray-700'>Training</h2>
                        <div class='flex items-center mt-1'>
                            <span class='text-3xl font-bold' id='totalTrainees'>0</span>
                        </div>
                    </div>
                    <div class='p-3 bg-blue-100 rounded-full'>
                        <i class='fas fa-graduation-cap text-blue-600 text-xl'></i>
                    </div>
                </div>
                <p class='text-gray-600'>On going trainee</p>
            </div>
          
            <!-- Total Employee -->
            <div class='bg-white w-full rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow'>
                <div class='flex justify-between items-start mb-4'>
                    <div>
                        <h2 class='text-lg font-semibold text-gray-700'>Total Employee</h2>
                        <div class='flex items-center mt-1'>
                             <span id='totalEmployees' class='text-3xl font-bold'>0</span> 
                        </div>
                    </div>
                    <div class='p-3 bg-green-100 rounded-full'>
                        <i class='fas fa-users text-green-600 text-xl'></i>
                    </div>
                </div>
                <p class='text-gray-600'>Employee list</p>
            </div>
          
            <!-- Employee Evaluated -->
            <div class='bg-white w-full rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow'>
                <div class='flex justify-between items-start mb-4'>
                    <div>
                        <h2 class='text-lg font-semibold text-gray-700'>Employee Evaluated</h2>
                        <div class='flex items-center mt-1'>
                           <span id='evaluatedCount' class='text-3xl font-bold'>0</span>

                        </div>
                    </div>
                    <div class='p-3 bg-purple-100 rounded-full'>
                        <i class='fas fa-clipboard-check text-purple-600 text-xl'></i>
                    </div>
                </div>
                <p class='text-gray-600'>Completed</p>
            </div>
        </div>
      </div>
      
     <div class='ml-5 grid grid-cols-3 gap-4 mb-10'>
    <!-- Job Statistics -->
    <div class='col-span-2 bg-white p-6 rounded-lg shadow-lg h-[370px] flex flex-col'>
        <div class='flex justify-between items-center'>
            <h1 class='text-2xl font-bold text-gray-900'>Job Statistics</h1>
        </div>
        <canvas id='myChart' class='mt-4 w-full flex-grow'></canvas>
    </div>

    <!-- Attendance Statistics -->
   <div class='bg-white p-6 rounded-lg shadow-lg h-[370px] flex flex-col'>
    <h1 class='text-2xl font-bold text-gray-900'>Attendance Statistics</h1>
    
    <!-- Attendance Counts -->
    <div class='flex justify-around mt-4'>
        <div class='text-center'>
            <h2 class='text-lg font-semibold text-green-600'>Present</h2>
            <span id='presentCount' class='text-3xl font-bold text-green-600'>0</span>
        </div>
        <div class='text-center'>
            <h2 class='text-lg font-semibold text-red-600'>Absent</h2>
            <span id='absentCount' class='text-3xl font-bold text-red-600'>0</span>
        </div>
        <div class='text-center'>
            <h2 class='text-lg font-semibold text-yellow-600'>Late</h2>
            <span id='lateCount' class='text-3xl font-bold text-yellow-600'>0</span>
        </div>
    </div>

    <!-- Attendance Doughnut Chart -->
    <div class='flex justify-center flex-grow'>
        <canvas id='myDoughnutChart' class='max-h-[200px]'></canvas>
    </div>
</div>

</div>

      
      
      
  </main>
";

// Call the layout function with the home page content
hrLayout($homeContent);
?>

<script>
   function fetchTotalEmployees() {
    fetch('http://localhost/HR2REPO/api/regularCount.php')
        .then(response => response.json())
        .then(data => {
            document.getElementById('totalEmployees').textContent = data.total;
        })
        .catch(error => console.error('Error fetching total employees:', error));
}

function fetchEmployeeCount() {
    fetch('http://localhost/HR2REPO/api/employeeCount.php')
        .then(response => response.json())
        .then(data => {
            if (data.total !== undefined) {
                document.getElementById('evaluatedCount').textContent = data.total;
            } else {
                console.error('Failed to retrieve employee count:', data);
            }
        })
        .catch(error => console.error('Error fetching employee count:', error));
}

function fetchTotalNewHired() {
    fetch('http://localhost/HR2REPO/api/NewHiredApi.php')
        .then(response => response.json())
        .then(data => {
            document.getElementById('totalNewHiredEmployees').textContent = data.total;
        })
        .catch(error => console.error('Error fetching total new hires:', error));
}

function fetchTotalTrainees() {
    fetch('http://localhost/HR2REPO/api/totalTrainees.php')
        .then(response => response.json())
        .then(data => {
            document.getElementById('totalTrainees').textContent = data.total;
        })
        .catch(error => console.error('Error fetching total trainees:', error));
}

// Call functions when page loads
fetchTotalEmployees();
fetchEmployeeCount();
fetchTotalNewHired();
fetchTotalTrainees();






    async function fetchCounts() {
        try {
            const [newHiredRes, traineesRes, employeesRes, evaluatedRes] = await Promise.all([
                fetch('http://localhost/HR2REPO/api/NewHiredApi.php').then(res => res.json()),
                fetch('http://localhost/HR2REPO/api/totalTrainees.php').then(res => res.json()),
                fetch('http://localhost/HR2REPO/api/regularCount.php').then(res => res.json()),
                fetch('http://localhost/HR2REPO/api/employeeCount.php').then(res => res.json())
            ]);

            const newHiredCount = newHiredRes.total || 0;
            const traineesCount = traineesRes.total || 0;
            const employeesCount = employeesRes.total || 0;
            const evaluatedCount = evaluatedRes.total || 0;

            // Update UI Elements
            document.getElementById('totalNewHiredEmployees').textContent = newHiredCount;
            document.getElementById('totalTrainees').textContent = traineesCount;
            document.getElementById('totalEmployees').textContent = employeesCount;
            document.getElementById('evaluatedCount').textContent = evaluatedCount;

            // Initialize Bar Chart
            const ctxBar = document.getElementById('myChart').getContext('2d');
            new Chart(ctxBar, {
                type: 'bar',
                data: {
                    labels: ['New Hired', 'Trainees', 'Total Employees', 'Evaluated'],
                    datasets: [{
                        label: 'Employee Statistics',
                        data: [newHiredCount, traineesCount, employeesCount, evaluatedCount],
                        backgroundColor: ['#f59e0b', '#3b82f6', '#10b981', '#9333ea'],
                        borderColor: ['#ffffff'],
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: function(tooltipItem) {
                                    return tooltipItem.label + ': ' + tooltipItem.raw;
                                }
                            }
                        }
                    }
                }
            });

        } catch (error) {
            console.error('Error fetching counts:', error);
        }
    }

    // Call the function on page load
    fetchCounts();
    
    
    fetch("http://localhost/HR2REPO/api/attendance_summary.php")
    .then(response => response.json())
    .then(data => {
        document.getElementById("presentCount").textContent = data.presentCount;
        document.getElementById("absentCount").textContent = data.absentCount;
        document.getElementById("lateCount").textContent = data.lateCount;

        // Initialize Doughnut Chart with Attendance Data
        const ctxDoughnut = document.getElementById('myDoughnutChart').getContext('2d');
        new Chart(ctxDoughnut, {
            type: 'doughnut',
            data: {
                labels: ['Present', 'Absent', 'Late'],
                datasets: [{
                    label: 'Attendance',
                    data: [data.presentCount, data.absentCount, data.lateCount],
                    backgroundColor: ['#22c55e', '#ef4444', '#facc15'],
                    borderColor: ['#ffffff'],
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.label + ': ' + tooltipItem.raw;
                            }
                        }
                    }
                }
            }
        });
    })
    .catch(error => console.error("Error fetching attendance data:", error));





</script>
<!-- Include Chart.js library -->
<script src='https://cdn.jsdelivr.net/npm/chart.js'></script>


