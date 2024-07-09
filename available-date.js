const date = document.getElementById("date");
const dateSpan = document.getElementById("date-span");

date.addEventListener('blur', function () {
    const input = this.value;
    const dateEntered = new Date(input);
    checkAvailableDate(dateEntered);
});

function checkAvailableDate(date) {
    fetch('check_date.php', { // Send AJAX request to separate script
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ date: date }) // Send email in JSON format
    })
        .then(response => {
            console.log('Raw response:', response); // Log raw response
            return response.text(); // Get the response text
        })
        .then(text => {
            console.log('Response text:', text); // Log the response text
            let data;
            try {
                data = JSON.parse(text); // Attempt to parse JSON
            } catch (error) {
                throw new Error('Failed to parse JSON: ' + error.message);
            }
            console.log('Parsed JSON data:', data); // Log parsed JSON data
            dateSpan.textContent = data.message;
            dateSpan.style.color = data.available ? "green" : "red";
        })
        .catch(error => {
            console.error('Error checking email availability:', error);
            emailAvailabilitySpan.textContent = "Error checking. Please try again."; // Display error message
            emailAvailabilitySpan.style.color = "red";
        });

}