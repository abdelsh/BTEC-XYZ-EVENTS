const emailInput = document.getElementById('email');
const emailAvailabilitySpan = document.getElementById('email-availability');

emailInput.addEventListener('blur', function() { // Check on blur event
  const email = this.value;
  emailAvailabilitySpan.textContent = "Checking...";
  emailAvailabilitySpan.style.color = "cyan";
  checkEmailAvailability(email);
});

function checkEmailAvailability(email) {
  emailAvailabilitySpan.textContent = "Checking..."; // Display checking message

  fetch('../Register/check_email.php', { // Send AJAX request to separate script
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({ email: email }) // Send email in JSON format
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
      emailAvailabilitySpan.textContent = data.message;
      emailAvailabilitySpan.style.color = data.available ? "green" : "red";
    })
    .catch(error => {
      console.error('Error checking email availability:', error);
      emailAvailabilitySpan.textContent = "Error checking. Please try again."; // Display error message
      emailAvailabilitySpan.style.color = "red";
    });

    console.log('Email:', document.getElementById('email').value)
}
