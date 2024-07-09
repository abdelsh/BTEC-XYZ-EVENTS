var submitted = false;

  function validateForm() {
    if (submitted) {
      alert("Form already submitted!");
      return false;
    } else {
      submitted = true;
      return true;
    }
  }