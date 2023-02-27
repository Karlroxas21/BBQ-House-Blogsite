var passwordInput = document.getElementById("Password");
var toggleCheckbox = document.getElementById("togglepw");

toggleCheckbox.addEventListener("change", function () {
  if (toggleCheckbox.checked) {
    passwordInput.type = "text";
  } else {
    passwordInput.type = "password";
  }
});
