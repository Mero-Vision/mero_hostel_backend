var togglePassword = document.getElementById("toggle-password");
var togglePassword1 = document.getElementById("toggle-password1");

var passwordInput = document.getElementById("password");
var confirmInput = document.getElementById("password1");

var formContent = document.getElementsByClassName('form-content')[0];
var getFormContentHeight = formContent.clientHeight;

var formImage = document.getElementsByClassName('form-image')[0];
if (formImage) {
  var setFormImageHeight = formImage.style.height = getFormContentHeight + 'px';
}

if (togglePassword) {
  togglePassword.addEventListener('click', function() {
    if (passwordInput.type === "password") {
      passwordInput.type = "text";
    } else {
      passwordInput.type = "password";
    }
  });
}

if (togglePassword1) {
  togglePassword1.addEventListener('click', function() {
    if (confirmInput.type === "password") {
      confirmInput.type = "text";
    } else {
      confirmInput.type = "password";
    }
  });
}
