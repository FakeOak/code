// Function to fetch data from the PHP API
function fetchData() {
    $.ajax({
        url: 'backend.php?endpoint=fetchData', // Replace with your PHP API endpoint
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            // Display the data in the frontend
            let output = '<ul>';
            response.forEach(item => {
                output += `<li>ID: ${item.id}, Name: ${item.name}, Email: ${item.email}</li>`;
            });
            output += '</ul>';
            $('#output').html(output);
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
            $('#output').html('An error occurred while fetching data.');
        }
    });
}

// Call the function when the page is ready
$(document).ready(function() {
    fetchData();
});
