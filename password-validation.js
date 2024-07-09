const passwordInput = document.getElementById('pass');
const passwordStrength = document.getElementById('password-strength');

passwordInput.addEventListener('keyup', function() {
  // Perform client-side validation
  const strength = checkPasswordStrength(this.value);
  updatePasswordStrengthUI(strength);
  

  const submitButton = document.getElementById('submit-btn');
  
  // If user finishes typing, trigger AJAX request
  if (this.value.length >= 8) { // Adjust based on your minimum password length
    sendPasswordForValidation(this.value);
  }
});

function checkPasswordStrength(password) {
  // Implement your password strength checking logic here
  // Return a value indicating strength (e.g., "strong", "weak", "invalid")

  

  const hasUpperCase = /[A-Z]/.test(password);
  const hasLowerCase = /[a-z]/.test(password);
  const hasNumber = /[0-9]/.test(password);
  const hasSpecialChar = /[!@#$%^&*()_+\-=\[\]{};':\\|,.<>/?`~]/.test(password);
  const minLength = 8;

  let strength = "";

  if (password.length < minLength) {
    strength = "weak (minimum 8 characters)";
  } else {
    let meetsRequirements = 0;
    if (hasUpperCase) meetsRequirements++;
    if (hasLowerCase) meetsRequirements++;
    if (hasNumber) meetsRequirements++;
    if (hasSpecialChar) meetsRequirements++;

    if (meetsRequirements === 4) {
      strength = "strong";
    } else if (meetsRequirements >= 3) {
      strength = "medium";
    } else {
      strength = "weak (try adding more characters)";
    }
  }

  return strength;
}

function updatePasswordStrengthUI(strength) {
  // Update UI based on password strength (color, message)
  passwordStrength.textContent = strength;

  switch (strength) {
    case "strong":
      passwordStrength.style.color = "green";
      break;
    case "medium":
      passwordStrength.style.color = "orange";
      break;
    case "weak (minimum 8 characters)":
    case "weak (try adding more characters)":
      passwordStrength.style.color = "red";
      break;
    default:
      passwordStrength.style.color = ""; // Reset color for unexpected values
  }
}

// function sendPasswordForValidation(password) {
//   // Use AJAX to send password to server-side script for further validation
//   // ...
// }