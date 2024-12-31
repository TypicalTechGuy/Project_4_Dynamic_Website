document.getElementById('signup-form').addEventListener('submit', function(event) {
  const password = document.getElementById('password').value;
  const confirmPassword = document.getElementById('confirm-password').value;

  if (password !== confirmPassword) {
    event.preventDefault();
    document.getElementById('password-error').style.display = 'block';
  }
});

document.getElementById('confirm-password').addEventListener('input', function() {
  const password = document.getElementById('password').value;
  const confirmPassword = document.getElementById('confirm-password').value;

  if (password === confirmPassword) {
    document.getElementById('password-error').style.display = 'none';
  } else {
    document.getElementById('password-error').style.display = 'block';
  }
});
