<?php
// Include the layout file
include '../layout/layout.php';

$homeContent = "
  <main class='w-full bg-gray-300'>
    <div class='bg-white p-6 rounded-lg shadow-lg mt-[2rem] overflow-y-scroll w-[95%] h-[85%] mx-4'>
        <h2 class='text-xl font-bold mb-4'>List of New Hired Employees</h2>

        <div class=''> <!-- Ensures horizontal scrolling -->
            <table class='min-w-[1200px] border-collapse border border-gray-300'> <!-- Forces a wide table -->
                <thead>
                    <tr class='bg-gray-200'>
                        <th class='border border-gray-300 px-4 py-2'>ID</th>
                        <th class='border border-gray-300 px-4 py-2'>Name</th>
                        <th class='border border-gray-300 px-4 py-2'>Email</th>
                        <th class='border border-gray-300 px-4 py-2'>Gender</th>
                        <th class='border border-gray-300 px-4 py-2'>Birth Date</th>
                        <th class='border border-gray-300 px-4 py-2'>Contact</th>
                        <th class='border border-gray-300 px-4 py-2'>Job Position</th>
                        <th class='border border-gray-300 px-4 py-2'>Salary</th>
                        <th class='border border-gray-300 px-4 py-2'>Department</th>
                    </tr>
                </thead>
                <tbody id='employeeTable'>
                    <tr><td colspan='9' class='text-center p-4'>Loading employees...</td></tr>
                </tbody>
            </table>
        </div> <!-- Closing wrapper -->
    </div>
  </main>
";

hrLayout($homeContent);
?>

<script>
   


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
