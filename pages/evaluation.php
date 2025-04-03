<?php
// Include the layout file
include '../layout/layout.php';

$homeContent = "
  <div class='flex-grow bg-gray-300 p-1 pl-5 overflow-y-auto'>
        <div class='p-6 '>
            <h2 class='text-xl font-bold mb-4 bg-white rounded-xl pt-2 pb-2 indent-4'>Employee Evaluation</h2>

             <div class='container mx-auto bg-white h-[70%] mt-5 rounded-xl p-4 shadow-lg'>
                <div class='flex justify-between items-center mb-4'>
            <button onclick='openModal()' class='bg-amber-500 text-white px-4 py-2 rounded-lg hover:bg-amber-600'>
                Evaluate Employee
            </button>
        </div>

        <table class='w-full border-collapse  bg-white'>
            <thead class='bg-amber-500 text-white'>
                <tr>
                    <th class=' p-2'>ID</th>
                    <th class=' p-2'>Name</th>
                    <th class=' p-2'>Final Score</th>
                    <th class=' p-2'>Status</th>
                </tr>
            </thead>
            <tbody id='employeeTable'>
                <tr>
                    <td colspan='4' class='text-center p-4'>Loading...</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Employee Search Modal -->
    <div id='employeeModal' class='hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center'>
        <div class='bg-white p-6 rounded-lg shadow-lg w-2/3'>
            <h2 class='text-xl font-bold mb-4'>Search Employee</h2>
            <input type='text' id='searchInput' onkeyup='filterEmployees()' 
                class='w-full p-2 border rounded' placeholder='Search by name...' />

            <table class='w-full border-collapse border  mt-4'>
                <thead class='bg-amber-500 text-white'>
                    <tr>
                        <th class=' p-2'>ID</th>
                        <th class=' p-2'>Name</th>
                        <th class=' p-2'>Action</th>
                    </tr>
                </thead>
                <tbody id='modalEmployeeTable'>
                    <tr>
                        <td colspan='3' class='text-center p-4'>Loading...</td>
                    </tr>
                </tbody>
            </table>

            <div class='text-right mt-4'>
                <button onclick='closeModal()' class='bg-amber-500 text-white px-4 py-2 rounded hover:bg-amber-600'>
                    Close
                </button>
            </div>
        </div>
    </div>

    <!-- Evaluation Form Modal -->
    <div id='evaluationModal' class='hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center'>
        <div class='bg-white p-6 rounded-lg shadow-lg w-3/4 max-h-screen overflow-y-auto'>
            <h2 class='text-xl font-bold mb-4' id='evaluationTitle'>Employee Evaluation</h2>
            
            <!-- Rating Scale Legend -->
            <div class='mb-6 p-4 bg-gray-100 rounded-lg'>
                <h4 class='font-semibold mb-2'>Rating Scale:</h4>
                <div class='grid grid-cols-5 gap-2 text-center'>
                    <div class='p-2 border border-gray-300 bg-red-100 text-red-800 font-medium'>1 - Poor</div>
                    <div class='p-2 border border-gray-300 bg-orange-100 text-orange-800 font-medium'>2 - Fair</div>
                    <div class='p-2 border border-gray-300 bg-yellow-100 text-yellow-800 font-medium'>3 - Satisfactory</div>
                    <div class='p-2 border border-gray-300 bg-blue-100 text-blue-800 font-medium'>4 - Good</div>
                    <div class='p-2 border border-gray-300 bg-green-100 text-green-800 font-medium'>5 - Excellent</div>
                </div>
            </div>

            <div class='mb-6'>
                <h3 class='font-semibold text-lg mb-2'>Work Performance (30%)</h3>
                <table class='w-full border-collapse'>
                    <tr>
                        <td class='border p-2 w-1/3'>Works to Full Potential</td>
                        <td class='border p-2'>
                            <div class='rating flex justify-center gap-1' data-category='work_performance' data-criteria='full_potential'></div>
                            <div class='rating-value text-center mt-1 text-sm text-gray-600'></div>
                        </td>
                    </tr>
                    <tr>
                        <td class='border p-2'>Quality of Work</td>
                        <td class='border p-2'>
                            <div class='rating flex justify-center gap-1' data-category='work_performance' data-criteria='quality'></div>
                            <div class='rating-value text-center mt-1 text-sm text-gray-600'></div>
                        </td>
                    </tr>
                    <tr>
                        <td class='border p-2'>Work Consistency</td>
                        <td class='border p-2'>
                            <div class='rating flex justify-center gap-1' data-category='work_performance' data-criteria='consistency'></div>
                            <div class='rating-value text-center mt-1 text-sm text-gray-600'></div>
                        </td>
                    </tr>
                    <tr>
                        <td class='border p-2'>Productivity</td>
                        <td class='border p-2'>
                            <div class='rating flex justify-center gap-1' data-category='work_performance' data-criteria='productivity'></div>
                            <div class='rating-value text-center mt-1 text-sm text-gray-600'></div>
                        </td>
                    </tr>
                    <tr>
                        <td class='border p-2'>Technical Skills</td>
                        <td class='border p-2'>
                            <div class='rating flex justify-center gap-1' data-category='work_performance' data-criteria='technical_skills'></div>
                            <div class='rating-value text-center mt-1 text-sm text-gray-600'></div>
                        </td>
                    </tr>
                </table>
            </div>

            <div class='mb-6'>
                <h3 class='font-semibold text-lg mb-2'>Communication & Collaboration (30%)</h3>
                <table class='w-full border-collapse'>
                    <tr>
                        <td class='border p-2'>Communication</td>
                        <td class='border p-2'>
                            <div class='rating flex justify-center gap-1' data-category='communication' data-criteria='communication'></div>
                            <div class='rating-value text-center mt-1 text-sm text-gray-600'></div>
                        </td>
                    </tr>
                    <tr>
                        <td class='border p-2'>Independent Work</td>
                        <td class='border p-2'>
                            <div class='rating flex justify-center gap-1' data-category='communication' data-criteria='independent_work'></div>
                            <div class='rating-value text-center mt-1 text-sm text-gray-600'></div>
                        </td>
                    </tr>
                    <tr>
                        <td class='border p-2'>Group Work</td>
                        <td class='border p-2'>
                            <div class='rating flex justify-center gap-1' data-category='communication' data-criteria='group_work'></div>
                            <div class='rating-value text-center mt-1 text-sm text-gray-600'></div>
                        </td>
                    </tr>
                    <tr>
                        <td class='border p-2'>Client Relations</td>
                        <td class='border p-2'>
                            <div class='rating flex justify-center gap-1' data-category='communication' data-criteria='client_relations'></div>
                            <div class='rating-value text-center mt-1 text-sm text-gray-600'></div>
                        </td>
                    </tr>
                    <tr>
                        <td class='border p-2'>Coworker Relations</td>
                        <td class='border p-2'>
                            <div class='rating flex justify-center gap-1' data-category='communication' data-criteria='coworker_relations'></div>
                            <div class='rating-value text-center mt-1 text-sm text-gray-600'></div>
                        </td>
                    </tr>
                </table>
            </div>

            <div class='mb-6'>
                <h3 class='font-semibold text-lg mb-2'>Initiative & Creativity (10%)</h3>
                <table class='w-full border-collapse'>
                    <tr>
                        <td class='border p-2'>Takes Initiative</td>
                        <td class='border p-2'>
                            <div class='rating flex justify-center gap-1' data-category='initiative' data-criteria='initiative'></div>
                            <div class='rating-value text-center mt-1 text-sm text-gray-600'></div>
                        </td>
                    </tr>
                    <tr>
                        <td class='border p-2'>Creativity</td>
                        <td class='border p-2'>
                            <div class='rating flex justify-center gap-1' data-category='initiative' data-criteria='creativity'></div>
                            <div class='rating-value text-center mt-1 text-sm text-gray-600'></div>
                        </td>
                    </tr>
                </table>
            </div>

            <div class='mb-6'>
                <h3 class='font-semibold text-lg mb-2'>Integrity & Professionalism (20%)</h3>
                <table class='w-full border-collapse'>
                    <tr>
                        <td class='border p-2'>Honesty</td>
                        <td class='border p-2'>
                            <div class='rating flex justify-center gap-1' data-category='integrity' data-criteria='honesty'></div>
                            <div class='rating-value text-center mt-1 text-sm text-gray-600'></div>
                        </td>
                    </tr>
                    <tr>
                        <td class='border p-2'>Integrity</td>
                        <td class='border p-2'>
                            <div class='rating flex justify-center gap-1' data-category='integrity' data-criteria='integrity'></div>
                            <div class='rating-value text-center mt-1 text-sm text-gray-600'></div>
                        </td>
                    </tr>
                    <tr>
                        <td class='border p-2'>Dependability</td>
                        <td class='border p-2'>
                            <div class='rating flex justify-center gap-1' data-category='integrity' data-criteria='dependability'></div>
                            <div class='rating-value text-center mt-1 text-sm text-gray-600'></div>
                        </td>
                    </tr>
                </table>
            </div>

            <div class='mb-6'>
                <h3 class='font-semibold text-lg mb-2'>Punctuality & Attendance (10%)</h3>
                <table class='w-full border-collapse'>
                    <tr>
                        <td class='border p-2'>Punctuality</td>
                        <td class='border p-2'>
                            <div class='rating flex justify-center gap-1' data-category='punctuality' data-criteria='punctuality'></div>
                            <div class='rating-value text-center mt-1 text-sm text-gray-600'></div>
                        </td>
                    </tr>
                    <tr>
                        <td class='border p-2'>Attendance</td>
                        <td class='border p-2'>
                            <div class='rating flex justify-center gap-1' data-category='punctuality' data-criteria='attendance'></div>
                            <div class='rating-value text-center mt-1 text-sm text-gray-600'></div>
                        </td>
                    </tr>
                </table>
            </div>

            <div class='flex justify-between items-center mt-6'>
                <div class='text-xl font-bold'>
                    Average Total: <span id='finalScore'>0</span>%
                </div>
                <div>
                    <button onclick='closeEvaluationModal()' class='bg-black text-white px-4 py-2 rounded hover:bg-gray-600 mr-2'>
                        Cancel
                    </button>
                    <button onclick='submitEvaluation()' class='bg-amber-500 text-white px-4 py-2 rounded hover:bg-amber-600'>
                        Submit Evaluation
                    </button>
                </div>
            </div>
        </div>
    </div>
";

hrLayout($homeContent);
?>

<script>
    // Toastify function
    function showToast(message, type) {
        Toastify({
            text: message,
            style: {
                background: type === 'success' 
                    ? "linear-gradient(to right, #00b09b, #96c93d)" 
                    : "linear-gradient(to right, #ff5f6d, #ffc371)"
            },
            duration: 3000,
            close: true
        }).showToast();
    }

    let allEmployees = [];
    let currentEmployee = null;
    const ratings = {
        work_performance: {
            full_potential: 0,
            quality: 0,
            consistency: 0,
            productivity: 0,
            technical_skills: 0
        },
        communication: {
            communication: 0,
            independent_work: 0,
            group_work: 0,
            client_relations: 0,
            coworker_relations: 0
        },
        initiative: {
            initiative: 0,
            creativity: 0
        },
        integrity: {
            honesty: 0,
            integrity: 0,
            dependability: 0
        },
        punctuality: {
            punctuality: 0,
            attendance: 0
        }
    };

    // Function to fetch employee list from API
    function fetchEmployees() {
        fetch('http://localhost/HR2REPO/api/RegularEmployeeApi.php')
            .then(response => response.json())
            .then(employees => {
                if (!Array.isArray(employees)) {
                    throw new Error('Invalid employee data received.');
                }
                allEmployees = employees; // Store employees for filtering
                updateModalTable(employees); // Populate modal table
            })
            .catch(error => {
                console.error('Error fetching employees:', error);
                document.getElementById('employeeTable').innerHTML = 
                    `<tr><td colspan='4' class='text-center p-4 text-red-500'>Failed to load employees</td></tr>`;
            });
    }

    // Fetch employee evaluations
    fetch('http://localhost/HR2REPO/api/employeeEvaluation.php')
        .then(response => response.json())
        .then(employees => {
            console.log('Employee Scores:', employees);
            if (!Array.isArray(employees)) {
                throw new Error('Invalid employee data received.');
            }
            updateMainTable(employees);
        })
        .catch(error => {
            console.error('Error fetching evaluations:', error);
            document.getElementById('employeeTable').innerHTML = 
                `<tr><td colspan='4' class='text-center p-4 text-red-500'>Failed to load evaluations</td></tr>`;
        });

    function updateMainTable(employees) {
        const tableBody = document.getElementById('employeeTable');
        tableBody.innerHTML = "";

        if (employees.length === 0) {
            tableBody.innerHTML = 
                `<tr><td colspan='4' class='text-center p-4 text-gray-500'>No employee evaluations found</td></tr>`;
            return;
        }

        employees.forEach(employee => {
            const finalScore = employee.final_score ? parseFloat(employee.final_score) : 0;
            const status = finalScore < 75 ? "❌ Fail" : "✅ Pass";
            const statusClass = finalScore < 75 ? "text-red-500" : "text-green-500";

            const row = document.createElement('tr');
            row.innerHTML = `
                <td class='border p-2 text-center'>${employee.id}</td>
                <td class='border p-2'>${employee.first_name} ${employee.last_name}</td>
                <td class='border p-2 text-center'>${finalScore.toFixed(2)}%</td>
                <td class='border p-2 text-center font-bold ${statusClass}'>${status}</td>
            `;
            tableBody.appendChild(row);
        });
    }

    function updateModalTable(employees) {
        const modalTableBody = document.getElementById('modalEmployeeTable');
        modalTableBody.innerHTML = "";

        employees.forEach(employee => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td class='border p-2 text-center'>${employee.id}</td>
                <td class='border p-2'>${employee.first_name} ${employee.last_name}</td>
                <td class='border p-2 text-center'>
                    <button class='bg-amber-500 text-white px-3 py-1 rounded hover:bg-amber-600'
                        onclick="openEvaluationForm(${employee.id}, '${employee.first_name}', '${employee.last_name}')">
                        Evaluate
                    </button>
                </td>
            `;
            modalTableBody.appendChild(row);
        });
    }

    function filterEmployees() {
        const searchValue = document.getElementById('searchInput').value.toLowerCase();
        const filteredEmployees = allEmployees.filter(employee =>
            `${employee.first_name} ${employee.last_name}`.toLowerCase().includes(searchValue)
        );
        updateModalTable(filteredEmployees);
    }

    function openEvaluationForm(id, firstName, lastName) {
        currentEmployee = { id, firstName, lastName };
        document.getElementById('evaluationTitle').textContent = `Evaluating ${firstName} ${lastName}`;
        
        // Reset all ratings
        for (const category in ratings) {
            for (const criteria in ratings[category]) {
                ratings[category][criteria] = 0;
                const ratingValueElement = document.querySelector(`[data-criteria='${criteria}']`).nextElementSibling;
                ratingValueElement.textContent = 'Not rated';
            }
        }
        
        // Initialize rating options
        document.querySelectorAll('.rating').forEach(ratingDiv => {
            ratingDiv.innerHTML = '';
            for (let i = 1; i <= 5; i++) {
                const star = document.createElement('span');
                star.className = 'cursor-pointer text-2xl';
                star.textContent = '⭘';
                star.dataset.value = i;
                star.onclick = function() {
                    const category = ratingDiv.dataset.category;
                    const criteria = ratingDiv.dataset.criteria;
                    setRating(ratingDiv, category, criteria, i);
                };
                ratingDiv.appendChild(star);
            }
        });
        
        document.getElementById('finalScore').textContent = '0';
        document.getElementById('employeeModal').classList.add('hidden');
        document.getElementById('evaluationModal').classList.remove('hidden');
    }

    function setRating(ratingDiv, category, criteria, value) {
        // Update the visual rating
        const stars = ratingDiv.querySelectorAll('span');
        const ratingTexts = ['Poor', 'Fair', 'Satisfactory', 'Good', 'Excellent'];
        const ratingColors = ['text-red-500', 'text-orange-500', 'text-yellow-500', 'text-blue-500', 'text-green-500'];
        
        stars.forEach((star, index) => {
            star.textContent = index < value ? '⭑' : '⭘';
            star.className = `cursor-pointer text-2xl ${index < value ? ratingColors[value-1] : 'text-gray-300'}`;
        });
        
        // Update the ratings object
        ratings[category][criteria] = value;
        
        // Update the rating text display
        const ratingValueElement = ratingDiv.nextElementSibling;
        ratingValueElement.textContent = `${value} - ${ratingTexts[value-1]}`;
        ratingValueElement.className = `rating-value text-center mt-1 text-sm font-medium ${ratingColors[value-1]}`;
        
        // Calculate and update the final score
        calculateFinalScore();
    }

    function calculateFinalScore() {
        // Work Performance (30%)
        const workPerformance = (
            ratings.work_performance.full_potential +
            ratings.work_performance.quality +
            ratings.work_performance.consistency +
            ratings.work_performance.productivity +
            ratings.work_performance.technical_skills
        ) / 5 * 0.3;
        
        // Communication & Collaboration (30%)
        const communication = (
            ratings.communication.communication +
            ratings.communication.independent_work +
            ratings.communication.group_work +
            ratings.communication.client_relations +
            ratings.communication.coworker_relations
        ) / 5 * 0.3;
        
        // Initiative & Creativity (10%)
        const initiative = (
            ratings.initiative.initiative +
            ratings.initiative.creativity
        ) / 2 * 0.1;
        
        // Integrity & Professionalism (20%)
        const integrity = (
            ratings.integrity.honesty +
            ratings.integrity.integrity +
            ratings.integrity.dependability
        ) / 3 * 0.2;
        
        // Punctuality & Attendance (10%)
        const punctuality = (
            ratings.punctuality.punctuality +
            ratings.punctuality.attendance
        ) / 2 * 0.1;
        
        // Final score (sum of all weighted averages)
        const finalScore = (workPerformance + communication + initiative + integrity + punctuality) * 20;
        
        document.getElementById('finalScore').textContent = finalScore.toFixed(2);
    }

    function submitEvaluation() {
        const finalScore = parseFloat(document.getElementById('finalScore').textContent);
        
        if (!currentEmployee || isNaN(finalScore)) {
            showToast('Please complete the evaluation before submitting', 'error');
            return;
        }
        
        const requestData = {
            id: currentEmployee.id,
            first_name: currentEmployee.firstName,
            last_name: currentEmployee.lastName,
            final_score: finalScore.toFixed(2),
            ratings: ratings
        };
        
        console.log("Submitting evaluation:", requestData);
        
        fetch('http://localhost/HR2REPO/api/employeeEvaluation.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(requestData)
        })
        .then(response => response.json())
        .then(result => {
            if (result.error) {
                showToast(`⚠️ ${result.error}`, 'error');
            } else {
                showToast(`✅ Successfully evaluated ${currentEmployee.firstName} ${currentEmployee.lastName}`, 'success');
                closeEvaluationModal();
                window.location.reload();
            }
        })
        .catch(error => {
            console.error(`❌ Error saving evaluation for Employee ID ${currentEmployee.id}:`, error);
            showToast('Failed to submit evaluation', 'error');
        });
    }

    function closeEvaluationModal() {
        document.getElementById('evaluationModal').classList.add('hidden');
        document.getElementById('employeeModal').classList.remove('hidden');
    }

    function openModal() {
        fetchEmployees();
        document.getElementById('employeeModal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('employeeModal').classList.add('hidden');
    }
</script>