<?php
// Include the layout file
include '../layout/layout.php';

$regularEmployeeContent = "
  <main class='w-full bg-gray-300'>
    <div class='max-w-6xl mx-auto bg-white p-6 rounded-lg shadow-lg mt-[2rem]'>
        <h2 class='text-xl font-bold mb-4'>List of Regular Employees</h2>

        <table class='w-full border-collapse border border-gray-300'>
            <thead>
                <tr class='bg-gray-200'>
                    <th class='border border-gray-300 px-4 py-2'>ID</th>
                    <th class='border border-gray-300 px-4 py-2'>Name</th>
                    <th class='border border-gray-300 px-4 py-2'>Email</th>
                    <th class='border border-gray-300 px-4 py-2'>Gender</th>
                    <th class='border border-gray-300 px-4 py-2'>Birth Date</th>
                    <th class='border border-gray-300 px-4 py-2'>Contact</th>
                    <th class='border border-gray-300 px-4 py-2'>Department</th>
                    <th class='border border-gray-300 px-4 py-2'>Position</th>
                    <th class='border border-gray-300 px-4 py-2'>Status</th>
                </tr>
            </thead>
            <tbody id='regularEmployeeTable'>
                <tr><td colspan='9' class='text-center p-4'>Loading employees...</td></tr>
            </tbody>
        </table>
    </div>
  </main>
";

hrLayout($regularEmployeeContent);
?>

<script>
document.addEventListener("DOMContentLoaded", function() {
    fetch("https://hr3.gwamerchandise.com/api/employees", {
        method: "GET",
        headers: { "Content-Type": "application/json" }
    })
    .then(response => response.json())
    .then(data => {
    console.log("Fetched employees:", data); // Debugging: Check the response
    let employeeTable = document.getElementById("regularEmployeeTable");
    employeeTable.innerHTML = ""; // Clear loading text

    // FIX: Extract the employees array from the object
    let employees = data.employees || [];  // Use 'data.employees' if it exists

    if (employees.length === 0) {
        employeeTable.innerHTML = `<tr><td colspan="9" class="text-center p-4 text-red-500">No employees found.</td></tr>`;
        return;
    }

    employees.forEach(employee => {
        let row = `<tr class='border border-gray-300'>
            <td class='border border-gray-300 px-4 py-2'>${employee.id}</td>
            <td class='border border-gray-300 px-4 py-2'>${employee.first_name} ${employee.middle_name || ''} ${employee.last_name}</td>
            <td class='border border-gray-300 px-4 py-2'>${employee.email}</td>
            <td class='border border-gray-300 px-4 py-2 capitalize'>${employee.gender}</td>
            <td class='border border-gray-300 px-4 py-2'>${employee.date_of_birth}</td>
            <td class='border border-gray-300 px-4 py-2'>${employee.phone}</td>
            <td class='border border-gray-300 px-4 py-2'>${employee.department}</td>
            <td class='border border-gray-300 px-4 py-2'>${employee.position}</td>
            <td class='border border-gray-300 px-4 py-2'>${employee.status}</td>
        </tr>`;
        employeeTable.innerHTML += row;

        // Send data to the local API
        fetch("http://localhost/HR2REPO/api/RegularEmployeeApi.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({
            id: employee.id,
            user_id: employee.user_id,
            first_name: employee.first_name,
            middle_name: employee.middle_name || '',
            last_name: employee.last_name,
            email: employee.email,
            gender: employee.gender,
            date_of_birth: employee.date_of_birth,  // FIXED
            phone: employee.phone,  // FIXED
            address: employee.address,
            nationality: employee.nationality,
            marital_status: employee.marital_status,
            start_date: employee.start_date,
            end_date: employee.end_date,
            employment_status: employee.employment_status,
            department: employee.department,  // FIXED
            position: employee.position,  // FIXED
            status: employee.status,
            created_at: new Date().toISOString(), // ADD TIMESTAMP
            updated_at: new Date().toISOString() // ADD TIMESTAMP
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
        document.getElementById("regularEmployeeTable").innerHTML = `<tr><td colspan="9" class="text-center p-4 text-red-500">Failed to load employees.</td></tr>`;
    });
});
</script>