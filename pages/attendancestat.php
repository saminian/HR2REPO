<?php
// Include the layout file
include '../layout/layout.php';

$homeContent = "
<div class='flex-grow bg-gray-300 p-1 pl-5 overflow-y-auto'>
    <div class='p-6'>
        <h2 class='text-xl font-bold mb-4 bg-white rounded-xl pt-2 pb-2 indent-4'>Attendance</h2>
        <div class='container mx-auto bg-white h-[70%] mt-5 rounded-xl p-4 shadow-lg'>
            <!-- Button to trigger modal -->
            <button id='openAttendanceModal' class='mb-6 bg-amber-500 text-white py-2 px-6 rounded-lg hover:bg-amber-600'>
                Mark Attendance
            </button>
            
            <div class='flex justify-between items-center mb-4'>
                <!-- Attendance Records Table -->
                <div class='w-full overflow-y-auto' style='max-height: 400px;'>
                    <h3 class='text-xl font-bold text-black mb-4'>Attendance Records</h3>
                    <table class='w-full border-collapse'>
                <thead>
                    <tr class='bg-amber-500 text-white'>
                        <th class=' p-2 text-left'>ID</th>
                        <th class=' p-2 text-left'>Full Name</th>
                        <th class=' p-2 text-left'>Workshop</th>
                        <th class=' p-2 text-left'>Status</th>
                        <th class=' p-2 text-left'>Date</th>
                    </tr>
                </thead>
                <tbody id='attendanceTableBody' class='bg-white'></tbody>
            </table>
        </div>
    </div>
    
    <!-- Attendance Modal -->
    <div id='attendanceModal' class='hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50'>
        <div class='bg-white rounded-lg w-full max-w-md'>
            <div class='p-4 border-b flex justify-between items-center'>
                <h3 class='text-xl font-bold'>Mark Attendance</h3>
                <button id='closeModal' class='text-gray-500 hover:text-gray-700'>
                    <svg xmlns='http://www.w3.org/2000/svg' class='h-6 w-6' fill='none' viewBox='0 0 24 24' stroke='currentColor'>
                        <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M6 18L18 6M6 6l12 12' />
                    </svg>
                </button>
            </div>
            
            <form id='attendanceForm' class='p-4 space-y-4'>
                <div>
                    <label class='block text-gray-700 font-semibold'>Trainee</label>
                    <select id='trainee_id' class='w-full p-2 border rounded-md focus:ring-2 focus:ring-blue-400' required>
                        <option value=''>Select Trainee</option>
                    </select>
                </div>
                
                <div>
                    <label class='block text-gray-700 font-semibold'>Workshop</label>
                    <select id='workshop_id' class='w-full p-2 border rounded-md focus:ring-2 focus:ring-blue-400' required>
                        <option value=''>Select Workshop</option>
                    </select>
                </div>
                
                <div>
                    <label class='block text-gray-700 font-semibold'>Status</label>
                    <select id='status' class='w-full p-2 border rounded-md focus:ring-2 focus:ring-blue-400' required>
                        <option value='Present'>Present</option>
                        <option value='Absent'>Absent</option>
                        <option value='Late'>Late</option>
                    </select>
                </div>
                
                <button type='submit' class='w-full mt-6 text-center bg-orange-500 text-white py-2 px-4 rounded-lg hover:bg-orange-600'>
                    Submit Attendance
                </button>
            </form>
        </div>
    </div>
</div>
";
hrLayout($homeContent);
?>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Modal control elements
    const modal = document.getElementById('attendanceModal');
    const openModalBtn = document.getElementById('openAttendanceModal');
    const closeModalBtn = document.getElementById('closeModal');
    
    // Open modal
    openModalBtn.addEventListener('click', function() {
        modal.classList.remove('hidden');
    });
    
    // Close modal
    closeModalBtn.addEventListener('click', function() {
        modal.classList.add('hidden');
    });
    
    // Close modal when clicking outside
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            modal.classList.add('hidden');
        }
    });

    // Load trainees and workshops
    fetch('http://localhost/HR2REPO/api/attendanceApi.php?fetchOptions=true')
        .then(response => response.json())
        .then(data => {
            const traineeSelect = document.getElementById('trainee_id');
            const workshopSelect = document.getElementById('workshop_id');

            data.trainees.forEach(trainee => {
                let option = new Option(trainee.full_name, trainee.id);
                traineeSelect.appendChild(option);
            });

            data.workshops.forEach(workshop => {
                let option = new Option(workshop.title, workshop.id);
                workshopSelect.appendChild(option);
            });
        })
        .catch(error => console.error('Error loading trainees/workshops:', error));

    // Handle form submission
    document.getElementById('attendanceForm').addEventListener('submit', function (event) {
        event.preventDefault();

        const trainee_id = document.getElementById('trainee_id').value;
        const workshop_id = document.getElementById('workshop_id').value;
        const status = document.getElementById('status').value;

        fetch('http://localhost/HR2REPO/api/attendanceApi.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ trainee_id, workshop_id, status })
        })
        .then(response => response.json())
        .then(data => {
            showToast(data.message || data.error, data.error ? 'error' : 'success');
            loadAttendanceRecords();
            modal.classList.add('hidden');
            // Reset form
            document.getElementById('attendanceForm').reset();
        })
        .catch(error => console.error('Error submitting attendance:', error));
    });

    // Load initial attendance records
    loadAttendanceRecords();
});

// Load Attendance Records
function loadAttendanceRecords() {
    fetch('http://localhost/HR2REPO/api/attendanceApi.php')
        .then(response => response.json())
        .then(data => {
            const tableBody = document.getElementById('attendanceTableBody');
            tableBody.innerHTML = ""; 

            if (data.length === 0) {
                tableBody.innerHTML = `<tr><td colspan='5' class='p-2 text-center'>No records found</td></tr>`;
                return;
            }

            data.forEach(row => {
                let statusClass = '';
                if (row.status === 'Present') statusClass = 'text-green-600';
                if (row.status === 'Absent') statusClass = 'text-red-600';
                if (row.status === 'Late') statusClass = 'text-yellow-600';
                
                tableBody.innerHTML += `
                    <tr class='border'>
                        <td class='p-2 border'>${row.id}</td>
                        <td class='p-2 border'>${row.full_name}</td>
                        <td class='p-2 border'>${row.workshop_name}</td>
                        <td class='p-2 border font-semibold ${statusClass}'>${row.status}</td>
                        <td class='p-2 border'>${row.date}</td>
                    </tr>`;
            });
        })
        .catch(error => console.error('Error loading attendance:', error));
}

// Show Toast Notification
function showToast(message, type) {
    Toastify({
        text: message,
        duration: 3000,
        close: true,
        gravity: "top",
        position: "right",
        stopOnFocus: true,
        style: {
            background: type === 'success' 
                ? 'linear-gradient(to right, #00b09b, #96c93d)' 
                : 'linear-gradient(to right, #ff5f6d, #ffc371)'
        }
    }).showToast();
}
</script> 