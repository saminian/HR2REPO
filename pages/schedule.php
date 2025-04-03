<?php
include '../layout/layout.php';

$homeContent = "
<div class='flex h-screen w-full '>
    <!-- Main Content -->
    <div class='flex-grow bg-gray-300 p-1 pl-5 overflow-y-auto'>
        <div class='p-6 '>
            <h2 class='text-xl font-bold mb-4 bg-white rounded-xl pt-2 pb-2 indent-4'>List of Trainees</h2>

            <div class='container mx-auto bg-white h-[70%] mt-5 rounded-xl p-4 shadow-lg'>
                <div class='flex justify-between items-center mb-4'>
                    <input type='text' id='searchTrainee' placeholder='Search...' class='p-1 border border-gray-300 rounded w-1/3'>
                    <button id='addNewTraineeBtn' class='px-4 py-2 bg-amber-500 text-white rounded hover:bg-amber-600 transition'>
                     Add New Trainee
                    </button>
                </div>

                <div class='overflow-x-auto'>
                    <table class='w-full table-auto border-collapse text-sm'>
                        <thead>
                            <tr class='bg-amber-500 text-white'>
                                <th class='px-4 py-2'>Full Name</th>
                                <th class='px-4 py-2'>Email</th>
                                <th class='px-4 py-2'>Department</th>
                                <th class='px-4 py-2'>Workshop</th>
                                <th class='px-4 py-2'>Actions</th>
                            </tr>
                        </thead>
                        <tbody id='traineeTableBody'>
                            <!-- Trainees will be loaded here -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <!-- New Hires Modal -->
    <div id='newHiresModal' class='fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden'>
        <div class='bg-white p-6 rounded-lg w-3/4 mx-auto max-h-[80vh] overflow-y-auto'>
            <span id='closeNewHiresModalBtn' class='text-xl cursor-pointer float-right'>&times;</span>
            <h2 class='text-xl font-bold mb-4'>Select New Hire to Assign</h2>
            
            <table class='w-full border-collapse'>
                <thead>
                    <tr class='bg-amber-500 text-white'>
                        <th class='p-2'>Name</th>
                        <th class='p-2'>Email</th>
                        <th class='p-2'>Department</th>
                        <th class='p-2'>Action</th>
                    </tr>
                </thead>
                <tbody id='newHiresList'>
                    <!-- New hires will be inserted here dynamically -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- Assignment Modal -->
    <div id='assignmentModal' class='fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden'>
        <div class='bg-white p-6 rounded-lg w-full max-w-lg mx-4'>
            <span id='closeAssignmentModalBtn' class='text-xl cursor-pointer float-right'>&times;</span>
            <h2 class='text-xl font-semibold mb-4'>Assign Workshop</h2>
            <form id='assignmentForm'>
                <input type='hidden' id='selectedTraineeId'>
                <div class='mb-4'>
                    <label class='block text-gray-700 mb-1'>Full Name</label>
                    <input type='text' id='assignName' class='w-full p-2 border border-gray-300 rounded bg-gray-100' readonly>
                </div>
                <div class='mb-4'>
                    <label class='block text-gray-700 mb-1'>Email</label>
                    <input type='email' id='assignEmail' class='w-full p-2 border border-gray-300 rounded bg-gray-100' readonly>
                </div>
                <div class='mb-4'>
                    <label class='block text-gray-700 mb-1'>Department</label>
                    <input type='text' id='assignDept' class='w-full p-2 border border-gray-300 rounded bg-gray-100' readonly>
                </div>
                <div class='mb-4'>
                    <label class='block text-gray-700 mb-1'>Workshop <span class='text-red-500'>*</span></label>
                    <select id='workshopSelect' class='w-full p-2 border border-gray-300 rounded' required>
                        <option value=''>Select Workshop</option>
                    </select>
                </div>
                <button type='submit' class='w-full bg-amber-500 text-white py-2 rounded hover:bg-amber-600'>
                    Assign Trainee
                </button>
            </form>
        </div>
    </div>
</div>
</main>
";
hrLayout($homeContent);
?>

<script src='https://cdn.jsdelivr.net/npm/toastify-js'></script>

<script>
// Debounce function to limit how often a function is called
function debounce(func, wait) {
    let timeout;
    return function() {
        const context = this, args = arguments;
        clearTimeout(timeout);
        timeout = setTimeout(() => {
            func.apply(context, args);
        }, wait);
    };
}

document.addEventListener('DOMContentLoaded', function() {
    // DOM Elements
    const addBtn = document.getElementById('addNewTraineeBtn');
    const newHiresModal = document.getElementById('newHiresModal');
    const closeNewHiresBtn = document.getElementById('closeNewHiresModalBtn');
    const assignmentModal = document.getElementById('assignmentModal');
    const closeAssignmentBtn = document.getElementById('closeAssignmentModalBtn');
    const assignmentForm = document.getElementById('assignmentForm');
    const traineeTableBody = document.getElementById('traineeTableBody');
    const searchInput = document.getElementById('searchTrainee');
    
    // Load initial data
    loadTrainees();
    fetchWorkshops(); // Preload workshops

    
    // Event Listeners
    addBtn.addEventListener('click', openNewHiresModal);
    closeNewHiresBtn.addEventListener('click', closeNewHiresModal);
    closeAssignmentBtn.addEventListener('click', closeAssignmentModal);
    assignmentForm.addEventListener('submit', handleFormSubmit);
    
    // Improved search with debounce
    searchInput.addEventListener('input', debounce(function() {
        const searchQuery = this.value.trim();
        loadTrainees(searchQuery);
    }, 300));
    
    // Close modals when clicking outside
    newHiresModal.addEventListener('click', function(e) {
        if (e.target === newHiresModal) closeNewHiresModal();
    });
    assignmentModal.addEventListener('click', function(e) {
        if (e.target === assignmentModal) closeAssignmentModal();
    });

    // Functions
    function openNewHiresModal() {
        newHiresModal.classList.remove('hidden');
        fetchNewHires();
    }

    function closeNewHiresModal() {
        newHiresModal.classList.add('hidden');
    }

    function openAssignmentModal(trainee = null) {
        // Reset form
        assignmentForm.reset();
        document.getElementById('selectedTraineeId').value = trainee?.id || '';
        
        // Set form title based on mode
        const formTitle = document.querySelector('#assignmentModal h2');
        const submitBtn = assignmentForm.querySelector('button[type="submit"]');
        
        if (trainee) {
            // Edit mode
            formTitle.textContent = 'Assign Trainee';
            submitBtn.textContent = 'Update Trainee';
            
            // Pre-fill trainee data
            document.getElementById('assignName').value = trainee.full_name || '';
            document.getElementById('assignEmail').value = trainee.email || '';
            document.getElementById('assignDept').value = trainee.department || '';
            
            // Set workshop selection after options are loaded
            setTimeout(() => {
                if (trainee.workshop_id) {
                    document.getElementById('workshopSelect').value = trainee.workshop_id;
                }
            }, 100);
        } else {
            // Add mode
            formTitle.textContent = 'Assign Workshop';
            submitBtn.textContent = 'Assign Trainee';
        }
        
        assignmentModal.classList.remove('hidden');
    }

    function closeAssignmentModal() {
        assignmentModal.classList.add('hidden');
    }

    function fetchNewHires() {
        fetch('https://hr1.gwamerchandise.com/api/employee')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                const tableBody = document.getElementById('newHiresList');
                tableBody.innerHTML = '';
                
                if (data.length === 0) {
                    tableBody.innerHTML = `
                        <tr>
                            <td colspan='4' class='text-center p-4 text-gray-500'>
                                <i class='fas fa-user-slash mr-2'></i> No new hires found
                            </td>
                        </tr>
                    `;
                    return;
                }
                
                data.forEach(employee => {
                    const fullName = `${employee.first_name} ${employee.middle_name || ''} ${employee.last_name}`.trim();
                    const row = document.createElement('tr');
                    row.className = 'border-b';
                    row.innerHTML = `
                        <td class='p-2'>${fullName}</td>
                        <td class='p-2'>${employee.email}</td>
                        <td class='p-2'>${employee.department}</td>
                        <td class='p-2'>
                            <button class='assign-btn bg-amber-500 text-white px-3 py-1 rounded hover:bg-amber-600'>
                                <i class='fas fa-user-plus mr-1'></i> Assign
                            </button>
                        </td>
                    `;
                    tableBody.appendChild(row);
                    
                    // Add event listener to the newly created button
                    row.querySelector('.assign-btn').addEventListener('click', function() {
                        openAssignmentModal({
                            full_name: fullName,
                            email: employee.email,
                            department: employee.department
                        });
                    });
                });
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('newHiresList').innerHTML = `
                    <tr>
                        <td colspan='4' class='text-center p-4 text-red-500'>
                            <i class='fas fa-exclamation-circle mr-2'></i>
                            Failed to load new hires. Please try again.
                        </td>
                    </tr>
                `;
            });
    }

    function fetchWorkshops() {
        fetch('http://localhost/HR2REPO/api/categoriesApi.php')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                const select = document.getElementById('workshopSelect');
                select.innerHTML = '<option value="">Select Workshop</option>';
                
                data.forEach(workshop => {
                    const option = document.createElement('option');
                    option.value = workshop.id;
                    option.textContent = workshop.name;
                    select.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Error fetching workshops:', error);
                showToast('<i class="fas fa-exclamation-circle mr-2"></i> Failed to load workshops', 'error');
            });
    }

    function loadTrainees(searchQuery = '') {
        let url = 'http://localhost/HR2REPO/api/trainees_api.php';
        
        // Only add search parameter if it exists
        if (searchQuery) {
            url += `?search=${encodeURIComponent(searchQuery)}`;
        }
        
        fetch(url)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                traineeTableBody.innerHTML = '';
                
                if (data.length === 0) {
                    traineeTableBody.innerHTML = `
                        <tr>
                            <td colspan='5' class='text-center py-4 text-gray-500'>
                                <i class='fas fa-user-slash mr-2'></i> No trainees found
                            </td>
                        </tr>
                    `;
                    return;
                }
                
                data.forEach(trainee => {
                    const row = document.createElement('tr');
                    row.className = 'border-b hover:bg-gray-50';
                    row.innerHTML = `
                        <td class='px-4 py-2'>${trainee.full_name}</td>
                        <td class='px-4 py-2'>${trainee.email}</td>
                        <td class='px-4 py-2'>${trainee.department}</td>
                        <td class='px-4 py-2'>${trainee.workshop_name || 'Not assigned'}</td>
                        <td class='px-4 py-2'>
                            <button class='edit-btn text-blue-500 hover:text-blue-700 mr-3' data-id='${trainee.id}'>
                                <i class='fas fa-edit mr-1'></i> Edit
                            </button>
                            <button class='delete-btn text-red-500 hover:text-red-700' data-id='${trainee.id}'>
                                <i class='fas fa-trash-alt mr-1'></i> Delete
                            </button>
                        </td>
                    `;
                    traineeTableBody.appendChild(row);
                    
                    // Add event listeners to action buttons
                    row.querySelector('.edit-btn').addEventListener('click', function() {
                        editTrainee(trainee);
                    });
                    
                    row.querySelector('.delete-btn').addEventListener('click', function() {
                        deleteTrainee(trainee.id);
                    });
                });
            })
            .catch(error => {
                console.error('Error:', error);
                traineeTableBody.innerHTML = `
                    <tr>
                        <td colspan='5' class='text-center py-4 text-red-500'>
                            <i class='fas fa-exclamation-circle mr-2'></i>
                            Failed to load trainees. Please try again.
                        </td>
                    </tr>
                `;
            });
    }

    function editTrainee(trainee) {
        // Open modal with trainee data
        openAssignmentModal({
            id: trainee.id,
            full_name: trainee.full_name,
            email: trainee.email,
            department: trainee.department,
            workshop_id: trainee.workshop_id
        });
    }

    function handleFormSubmit(e) {
        e.preventDefault();
        
        const traineeId = document.getElementById('selectedTraineeId').value;
        const workshopSelect = document.getElementById('workshopSelect');
        const selectedOption = workshopSelect.options[workshopSelect.selectedIndex];
        
        // Prepare data for API
        const traineeData = {
            full_name: document.getElementById('assignName').value,
            email: document.getElementById('assignEmail').value,
            department: document.getElementById('assignDept').value,
            workshop_id: workshopSelect.value,
            workshop_name: selectedOption.text
        };

        // For edit mode, include the ID
        if (traineeId) {
            traineeData.id = traineeId;
        }

        // Validate all fields
        if (!workshopSelect.value) {
            showToast('<i class="fas fa-exclamation-circle mr-2"></i> Please select a workshop', 'error');
            workshopSelect.focus();
            return;
        }

        // Show loading state
        const submitBtn = e.target.querySelector('button[type="submit"]');
        const originalBtnText = submitBtn.innerHTML;
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Processing...';
        
        // Determine API endpoint and method
        const url = 'http://localhost/HR2REPO/api/trainees_api.php';
        const method = traineeId ? 'PUT' : 'POST';
        
        // Send data to API
        fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(traineeData)
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.message && data.message.includes('successfully')) {
                showToast('<i class="fas fa-check-circle mr-2"></i> ' + data.message, 'success');
                closeAssignmentModal();
                loadTrainees(searchInput.value.trim()); // Reload with current search
            } else {
                throw new Error(data.error || 'Operation failed');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast(`<i class="fas fa-exclamation-circle mr-2"></i> ${error.message || 'Operation failed'}`, 'error');
        })
        .finally(() => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalBtnText;
        });
    }

    function deleteTrainee(traineeId) {
        if (confirm('Are you sure you want to delete this trainee?')) {
            fetch(`http://localhost/HR2REPO/api/trainees_api.php?id=${traineeId}`, {
                method: 'DELETE'
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.message && data.message.includes('successfully')) {
                    showToast('<i class="fas fa-check-circle mr-2"></i> ' + data.message, 'success');
                    loadTrainees(searchInput.value.trim()); // Reload with current search
                } else {
                    throw new Error(data.error || 'Failed to delete trainee');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast(`<i class="fas fa-exclamation-circle mr-2"></i> ${error.message || 'Failed to delete trainee'}`, 'error');
            });
        }
    }

    function showToast(message, type) {
        Toastify({
            text: message,
            duration: 3000,
            close: true,
            gravity: "top",
            position: "right",
            style: {
                background: type === 'success' ? '#4CAF50' : '#F44336',
            },
            stopOnFocus: true,
            escapeMarkup: false
        }).showToast();
    }
});
</script>