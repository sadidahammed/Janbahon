//This code for working toggle 
const togglePassword = document.getElementById('togglePassword');
const pinInput = document.getElementById('pinInput');
const phoneNumberInput = document.getElementById('PhoneNumber');
const signInButton = document.getElementById('signInButton');
const errorMessage = document.getElementById('errorMessage');

togglePassword.addEventListener('click', () => {
    const type = pinInput.getAttribute('type') === 'password' ? 'text' : 'password';
    pinInput.setAttribute('type', type);
    togglePassword.classList.toggle('fa-eye');
    togglePassword.classList.toggle('fa-eye-slash');
});

// Function to handle the button click or Enter key press
const handleSignIn = () => {
    errorMessage.classList.add('hidden'); // Hide error message initially
    if (!phoneNumberInput.value || !pinInput.value) {
        errorMessage.classList.remove('hidden'); // Show error message
        return;
    }
    // Your sign-in logic here
    alert('Sign In button clicked! ' );
};

// Event listener for phone number Enter key press
phoneNumberInput.addEventListener('keypress', (event) => {
    if (event.key === 'Enter') {
        pinInput.focus(); // Focus on the PIN input
    }
});

// Event listener for PIN Enter key press
pinInput.addEventListener('keypress', (event) => {
    if (event.key === 'Enter') {
        handleSignIn(); // Trigger sign-in on Enter
    }
});

// Event listener for button click
signInButton.addEventListener('click', handleSignIn);

function SignUp() {
    window.location.href = "SignUp1.html";
}
function ForgetPIN(){
    window.location.href = "forgetPIN1.html";
}