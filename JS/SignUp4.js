//Recieve information
const urlParams = new URLSearchParams(window.location.search);
const firstName = urlParams.get("firstName");
const lastName = urlParams.get("lastName");
const dob = urlParams.get("dob");
const phoneNumber = urlParams.get("phoneNumber");

document.write(`Welcome, ${firstName} ${lastName}. Your DOB is ${dob}. Your phone number is ${phoneNumber}.`);

// Get references to the elements
const firstPINInput = document.getElementById('FirstPIN');
const confPINInput = document.getElementById('ConfPIN');
const checkbox = document.getElementById('checkbox');
const popupMessage = document.getElementById('popupMessage');
const popup = document.getElementById('popup');
const closePopupButton = document.getElementById('closePopupButton');


//Next Button connection and color change
const nextButton = document.getElementById('NextButton');
nextButton.addEventListener('click', () => {
    nextButton.classList.toggle('bg-[#108480F7]');
    nextButton.classList.toggle('text-white');});


// Show the popup for Term of Services and Privacy Policy
TermOfServices.addEventListener('click', () => {
    popup.style.display = 'flex'; // Use flex to center the popup
    document.getElementById('popupMessage').textContent = 'Term of services';
});
PrivacyPolicy.addEventListener('click', () => {
    popup.style.display = 'flex'; // Use flex to center the popup
    document.getElementById('popupMessage').textContent = 'Privacy Policy';
});

// Function to validate inputs Like both PIN and ReType PIN and Checkbox
const validateInputs = () => {
    // Clear previous messages
    popupMessage.textContent = '';
    
    // Check if both PINs are provided
    if (!firstPINInput.value || !confPINInput.value) {
        popupMessage.textContent = 'Please enter both PIN and Re-type PIN.';
        popup.style.display = 'flex';
        return false;
    }

    // Check if both PINs match
    if (firstPINInput.value !== confPINInput.value) {
        popupMessage.textContent = 'The PINs do not match. Please try again.';
        popup.style.display = 'flex';
        return false;
    }

    // Check if the checkbox is checked
    if (!checkbox.checked) {
        popupMessage.textContent = 'You must accept the Terms of Service and Privacy Policy.';
        popup.style.display = 'flex';
        return false;
    }

    return true; // All validations passed
};

// Function to close popup
const closePopup = () => {
    popup.style.display = 'none';
};

// Event listener for the Next button
const previewButton = document.getElementById('PreviewButton');
nextButton.addEventListener('click', () => {
    if (validateInputs()) {
        // Proceed to the next step
        alert('All inputs are valid! Proceeding...');
        // You can add your logic for the next step here
    }
});

// Event listener for closing the popup
closePopupButton.addEventListener('click', closePopup);

// Event listener for Enter key on First PIN input
firstPINInput.addEventListener('keypress', (event) => {
    if (event.key === 'Enter') {
        confPINInput.focus(); // Move focus to the Re-type PIN input
    }
});

// Event listener for Enter key on Re-type PIN input
confPINInput.addEventListener('keypress', (event) => {
    if (event.key === 'Enter') {
        nextButton.click(); // Trigger the click event on the Next button
    }
});
previewButton.addEventListener('click', () => {
    // Change color to green on click
    previewButton.classList.toggle('text-white');
    previewButton.classList.toggle('bg-[#108480F7]');
    window.location.href = "SignUp3.html";
});

const togglePasswordIcons = document.querySelectorAll('.toggle-icon');
const passwordInputs = document.querySelectorAll('input[type="password"]');
// Loop through each toggle icon
togglePasswordIcons.forEach((icon, index) => {
    icon.addEventListener('click', () => {
        // Toggle the type of the password input
        const input = passwordInputs[index];
        if (input.type === 'password') {
            input.type = 'text'; // Show password
            icon.classList.remove('fa-eye'); // Change icon to open eye
            icon.classList.add('fa-eye-slash'); // Change icon to closed eye
        } else {
            input.type = 'password'; // Hide password
            icon.classList.remove('fa-eye-slash'); // Change icon to open eye
            icon.classList.add('fa-eye'); // Change icon to closed eye
        }
    });
});
