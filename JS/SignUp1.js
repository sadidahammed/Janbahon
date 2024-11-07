const nextButton = document.getElementById('NextButton');
        const previewButton = document.getElementById('PreviewButton');
        const userInfoDiv = document.getElementById('userInfo');
        const errorMessageDiv = document.getElementById('errorMessage');

        nextButton.addEventListener('click', () => {
            // Change color to green on click
            nextButton.classList.toggle('bg-[#108480F7]');
            nextButton.classList.toggle('text-white');
            
            const firstName = document.getElementById('FirstName').value;
            const lastName = document.getElementById('LastName').value;
            const dob = document.getElementById('dateInput').value;

            // Clear previous messages
            userInfoDiv.innerHTML = '';
            errorMessageDiv.innerHTML = '';

            if (!firstName || !lastName || !dob) {
                errorMessageDiv.innerHTML = 'Please provide all information.';
                return;
            }else{
                window.location.href = `SignUp2.html?firstName=${firstName}&lastName=${lastName}&dob=${dob}`;
            }

            //All given information here
            userInfoDiv.innerHTML = `
                <p class="text-lg font-semibold">Entered Information:</p>
                <p>First Name: ${firstName}</p>
                <p>Last Name: ${lastName}</p>
                <p>Date of Birth: ${dob}</p>
            `;
        });

        previewButton.addEventListener('click', () => {
            // Change color to green on click
            previewButton.classList.toggle('text-white');
            previewButton.classList.toggle('bg-[#108480F7]');
            window.location.href = "SignIn.html";

        });

        function SignIn(){
            window.location.href = "SignIn.html";
        }