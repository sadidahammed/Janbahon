const urlParams = new URLSearchParams(window.location.search);
    const firstName = urlParams.get("firstName");
    const lastName = urlParams.get("lastName");
    const dob = urlParams.get("dob");

    document.write(`Welcome, ${firstName} ${lastName}. Your DOB is ${dob}.`);


const nextButton = document.getElementById('NextButton');
        const previewButton = document.getElementById('PreviewButton');
        const userInfoDiv = document.getElementById('userInfo');
        const errorMessageDiv = document.getElementById('errorMessage');

        nextButton.addEventListener('click', () => {
            // Change color to green on click
            nextButton.classList.toggle('bg-[#108480F7]');
            nextButton.classList.toggle('text-white');
            
            // Get the phone number input
            const phoneNumber = document.getElementById('PhoneNumber').value;

            // Clear previous messages
            userInfoDiv.innerHTML = '';
            errorMessageDiv.innerHTML = '';

            // Validate the phone number
            if (!phoneNumber) {
                errorMessageDiv.innerHTML = 'Please provide your phone number.';
                return;
            }else{
                window.location.href = `SignUp3.html?firstName=${firstName}&lastName=${lastName}&dob=${dob}&phoneNumber=${phoneNumber}`;
                // Display entered information
            userInfoDiv.innerHTML = `
            <p class="text-lg font-semibold">Entered Information:</p>
            <p>Phone Number: ${phoneNumber}</p>`;
            }
        });

        previewButton.addEventListener('click', () => {
            // Change color to green on click
            previewButton.classList.toggle('text-white');
            previewButton.classList.toggle('bg-[#108480F7]');
            window.location.href = "SignUp1.html";
        });