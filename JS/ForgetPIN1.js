
 //Phone number code
 const errorMessageDiv = document.getElementById('errorMessage');

        function PhonenumberSubmit(){
            // Change color to green on click
            const nextButton = document.getElementById('NextButton');
            nextButton.classList.toggle('bg-[#108480F7]');
            nextButton.classList.toggle('text-white');
            
            // Get the phone number input
            const phoneNumber = document.getElementById('PhoneNumber').value;

            // Clear previous messages
            errorMessageDiv.innerHTML = '';

            // Validate the phone number
            if (!phoneNumber) {
                errorMessageDiv.innerHTML = 'Please provide your phone number.';
                return;
            }else{
                document.getElementById("phoneNumberSection").style.display = "none";
                document.getElementById("verificationCodeSection").style.display = "block";
            }
        };
        function PreviewFromPhoneNumber() {
            
            window.location.href = 'SignIn.html';
        };
        
//Varification code
    
        const inputs = document.querySelectorAll('input[type="number"]');
               
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
                function CompleteVarification(){
                    const nextButton = document.getElementById('NextButton1');
                
                    nextButton.classList.toggle('bg-[#108480F7]');
                    nextButton.classList.toggle('text-white');
        
                    const code = Array.from(inputs).map(input => input.value).join('');
                    if (code.length === 6) {
                        //Here is your verification code and next page
                        window.location.href = 'ForgetPIN.html';
                    } else {
                        Verification_message.textContent = 'Please enter a valid 6-digit code.';
                    }
                    
                };
                function VarificationPreviewBtn(){
                    document.getElementById("verificationCodeSection").style.display = "none";
                    document.getElementById("phoneNumberSection").style.display = "block";
                };
