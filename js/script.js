// Toggle between Sign In and Sign Up forms
document.getElementById('toSignUp').addEventListener('click', function() {
    document.getElementById('signInForm').classList.add('hidden');
    document.getElementById('signUpForm').classList.remove('hidden');
});

document.getElementById('toSignIn').addEventListener('click', function() {
    document.getElementById('signUpForm').classList.add('hidden');
    document.getElementById('signInForm').classList.remove('hidden');
});
