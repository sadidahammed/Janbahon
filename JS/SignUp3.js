const urlParams = new URLSearchParams(window.location.search);
const firstName = urlParams.get("firstName");
const lastName = urlParams.get("lastName");
const dob = urlParams.get("dob");
const phoneNumber = urlParams.get("phoneNumber");

document.write(`Welcome, ${firstName} ${lastName}. Your DOB is ${dob}. Your phone number is ${phoneNumber}.`);

const PhoneNumberMassege = document.getElementById('PhoneNumberMassege');
PhoneNumberMassege.textContent = `We've sent a code to ${phoneNumber}`;


const inputs = document.querySelectorAll('input[type="number"]');
        const nextButton = document.getElementById('NextButton');
        const previewButton = document.getElementById('PreviewButton');
        const Verification_message = document.getElementById('Verification_message');
            
        inputs.forEach((input, index) => {
            input.addEventListener('input', (e) => {
                // Limit input to 1 digit
                if (input.value.length > 1) {
                    input.value = input.value.slice(0, 1);
                }

                // Move to next input
                if (e.target.value) {
                    if (index < inputs.length - 1) {
                        inputs[index + 1].focus();
                    }
                } else if (index > 0) {
                    inputs[index - 1].focus();
                }
            });
        });

        // Handle submit button click
        nextButton.addEventListener('click', () => {
            nextButton.classList.toggle('bg-[#108480F7]');
            nextButton.classList.toggle('text-white');

            const code = Array.from(inputs).map(input => input.value).join('');
            if (code.length === 6) {
                //Here is your verification code and next page
                Verification_message.textContent = `Entered Verification Code: ${code}. Account has been created.`;
                window.location.href = `SignUp4.html?firstName=${firstName}&lastName=${lastName}&dob=${dob}&phoneNumber=${phoneNumber}`;

                
            } else {
                Verification_message.textContent = 'Please enter a valid 6-digit code.';
            }
        });
        previewButton.addEventListener('click', () => {
            // Change color to green on click
            previewButton.classList.toggle('text-white');
            previewButton.classList.toggle('bg-[#108480F7]');
            window.location.href = `SignUp2.html?firstName=${firstName}&lastName=${lastName}&dob=${dob}&phoneNumber=${phoneNumber}`;
        });