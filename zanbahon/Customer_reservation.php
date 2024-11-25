<?php
require 'ReservationDB.php';
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "zanbahon"; // Replace with your database name

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $action = $_POST['action'] ?? null;

        if ($action === "confirm") {
            // Safely retrieve data from POST request
            $pickup_location = $_POST['pickup_location'] ?? "Unknown";
            $destination = $_POST['destination'] ?? "Unknown";
            $vehicle_type = $_POST['vehicle_type'] ?? "Unknown";
            $payment_method = $_POST['payment_method'] ?? "Unknown";
            $trip_start = $_POST['strip_start'] ?? "00:00:00";
            $trip_end = $_POST['trip_end'] ?? null;

            // Fixed values for userID and driverID
            $userID = 1;
            $driverID = null;
            $status = 'Pending';

            // Insert data into Reservation_Table
            $sql = "INSERT INTO Reservation_Table 
            (pickup_location, destination, vehicle_type, payment_method, userID, driverID, status, trip_start, trip_end) 
            VALUES 
            (:pickup_location, :destination, :vehicle_type, :payment_method, :userID, :driverID, :status, :trip_start, :trip_end)";

            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':pickup_location', $pickup_location);
            $stmt->bindParam(':destination', $destination);
            $stmt->bindParam(':vehicle_type', $vehicle_type);
            $stmt->bindParam(':payment_method', $payment_method);
            $stmt->bindParam(':userID', $userID);
            $stmt->bindParam(':driverID', $driverID);
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':trip_start', $trip_start);
            $stmt->bindParam(':trip_end', $trip_end);

            if ($stmt->execute()) {
                echo "Reservation added successfully!";

                // Redirect to avoid re-submission
                header("Location: " . $_SERVER['PHP_SELF']);
                exit;
            } else {
                echo "Error adding reservation.";
            }
        }
    }
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.14/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/cc6fad79da.js" crossorigin="anonymous"></script>
    <title>Vehicle Reservation</title>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        pantone: "rgba(16, 132, 128, 1)",
                    }
                }
            }
        }
    </script>
</head>

<body class="h-full overflow-auto">
    <!-- Home Page -->
    <div id="vehicleReservation" class="min-h-screen flex flex-col pb-64 overflow-auto">
        <div class="flex items-center p-5 bg-pantone space-x-3 text-lg font-bold">
            <div class=" flex items-center space-x-3 md:hidden">
                <i class="fa-solid fa-arrow-left text-white"></i>
                <p class="text-white">Vehicle Reservation</p>
            </div>
            <div class="md:flex space-x-5 text-white hidden">
                <p>Home</p>
                <p>Services</p>
                <p>Offers</p>
                <p onclick="History()">History</p>
                <p>Modes</p>
            </div>
        </div>

        <div class="flex md:flex-row flex-col items-center  pt-10 justify-center">
            <div class="flex flex-col">
                <form >

                    <div class="flex flex-col gap-2 border-2 rounded-box p-2 mb-4">
                        <p class="text-lg font-semibold text-left">Pick up & Drop:</p>
                        <div class="mb-4">
                            <div class="flex relative">
                                <input id="pickUpLocation"
                                    class="border-2 border-black rounded-full h-12 w-full pl-4 pr-10"
                                    placeholder="Pick up"
                                    type="text" required>
                                <i class="fa-solid fa-location-dot absolute top-1/2 right-4 transform -translate-y-1/2 "></i>
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="flex relative">
                                <input id="dropOffLocation"
                                    class="border-2 border-black rounded-full h-12 w-full pl-4 pr-10"
                                    placeholder="Drop off"
                                    type="text" required>
                                <i class="fa-solid fa-location-crosshairs absolute top-1/2 right-4 transform -translate-y-1/2 "></i>
                            </div>
                        </div>
                    </div>

                    <!-- Vehicle Type dropdown menu -->
                    <div class="flex flex-col gap-2 border-2 rounded-box p-2 mb-4">
                        <p class="text-lg font-semibold text-left">Vehicle Type:</p>
                        <ul class="menu border-2 border-black rounded-full h-12 relative z-40">
                            <li class="h-10" style="margin-top: -4px;">
                                <details id="vehicleMenu" close>
                                    <summary id="menuSummary" class="cursor-pointer">Vehicle Type</summary>
                                    <ul class="shadow-2xl bg-white absolute w-full rounded-lg">
                                        <li class="flex flex-row">
                                            <a class="flex flex-row justify-between w-full">Car <img class="w-8 h-8" src="Source/Car.png" alt="Car image"></a>
                                        </li>
                                        <li class="flex flex-row">
                                            <a class="flex flex-row justify-between w-full">Bicycle <img class="w-8 h-8" src="Source/Bicycle.png" alt="Bicycle image"></a>
                                        </li>
                                        <li class="flex flex-row">
                                            <a class="flex flex-row justify-between w-full">CNG <img class="w-8 h-8" src="Source/CNG.png" alt="CNG image"></a>
                                        </li>
                                        <li class="flex flex-row">
                                            <a class="flex flex-row justify-between w-full">Bike <img class="w-8 h-8" src="Source/Bike.png" alt="Bike image"></a>
                                        </li>
                                        <li class="flex flex-row">
                                            <a class="flex flex-row justify-between w-full">Auto Rickshaw <img class="w-8 h-8" src="Source/Auto_Riskshaw.png" alt="Auto Rickshaw image"></a>
                                        </li>
                                        <li class="flex flex-row">
                                            <a class="flex flex-row justify-between w-full">Micro-Bus <img class="w-8 h-8" src="Source/Micro_Bus.png" alt="Micro Bus image"></a>
                                        </li>
                                        <li class="flex flex-row">
                                            <a class="flex flex-row justify-between w-full">Pickup Van <img class="w-8 h-8" src="Source/Pickup_van.png" alt="Pickup Van Image"></a>
                                        </li>
                                        <li class="flex flex-row">
                                            <a class="flex flex-row justify-between w-full">Truck <img class="w-8 h-8" src="Source/Truck.png" alt="Truck image"></a>
                                        </li>
                                    </ul>
                                </details>
                            </li>
                        </ul>
                    </div>

                    <!-- Select trip type and time select -->
                    <div class="pt-4 pb-4 border-2 rounded-box mt-4 mb-4 p-2">
                        <p class="mb-1 text-lg font-semibold text-left">Select Trip Type:</p>
                        <div class="flex justify-center space-x-6">
                            <!-- One way Trip group -->
                            <div class="flex items-center">
                                <input
                                    type="radio"
                                    id="oneWay"
                                    name="tripType"
                                    value="OneWay"
                                    class="form-radio h-5 w-5 text-blue-600"
                                    onclick="toggleTripType('OneWay')"
                                    checked>
                                <label for="oneWay" class="ml-2 text-gray-700">One Way Trip</label>
                            </div>

                            <!-- Round Trip group -->
                            <div class="flex items-center">
                                <input
                                    type="radio"
                                    id="roundTrip"
                                    name="tripType"
                                    value="RoundTrip"
                                    class="form-radio h-5 w-5 text-blue-600"
                                    onclick="toggleTripType('RoundTrip')">
                                <label for="roundTrip" class="ml-2 text-gray-700">Round Trip</label>
                            </div>
                        </div>


                        <!-- One Way Trip Section -->
                        <div id="OneWay_trip" class="flex flex-col w-1/2 mt-4">
                            <label for="pickup_time">Pickup Time</label>
                            <input id="pickup_time" type="time" value="12:00">
                        </div>

                        <!-- Round Trip Section -->
                        <div id="round_trip" class="flex flex-row justify-between mt-4 hidden">
                            <div class="flex flex-col">
                                <label for="pickup_time">Pickup Time</label>
                                <input id="pickup_time" type="time" value="12:00">
                            </div>
                            <div class="flex flex-col">
                                <label for="drop_time">Drop Time</label>
                                <input id="drop_time" type="time" value="12:00">
                            </div>
                        </div>
                    </div>


                    <!-- Select Payment methods -->
                    <div class="flex flex-col gap-2 border-2 rounded-box p-2 mb-4">
                        <p class="text-lg font-semibold text-left">Payment method:</p>

                        <ul class="menu border-2 border-black rounded-full h-12 relative z-20">
                            <li class="h-10" style="margin-top: -4px;">
                                <details id="PaymentMenu" close>
                                    <summary id="menuSummaryForPaymet" class="cursor-pointer">Payment method</summary>
                                    <ul class="shadow-2xl bg-white absolute w-full rounded-lg">
                                        <li class="flex flex-row">
                                            <a class="flex flex-row justify-between w-full">Cash</a>
                                        </li>
                                        <li class="flex flex-row">
                                            <a class="flex flex-row justify-between w-full">BKash</a>
                                        </li>
                                        <li class="flex flex-row">
                                            <a class="flex flex-row justify-between w-full">Nagad</a>
                                        </li>
                                        <li class="flex flex-row">
                                            <a class="flex flex-row justify-between w-full">Rocket</a>
                                        </li>
                                        <li class="flex flex-row">
                                            <a class="flex flex-row justify-between w-full">Ucash</a>
                                        </li>
                                    </ul>
                                </details>
                            </li>
                        </ul>
                    </div>



                    <button id="requestButton" class="border-2 border-black w-full rounded-full h-12 text-white text-[1.2rem] bg-pantone hover:bg-pantone/75" type="menu">Request</button>

                </form>
            </div>
        </div>
    </div>

    <!-- Popup Modal Structure -->
    <div id="popupModal" class="fixed inset-0 z-50 flex items-center justify-center hidden">
        <div class="bg-white p-6 rounded-lg shadow-2xl border-2 border-pantone w-96">
            <h2 class="text-2xl font-semibold mb-4">Reservation Summary</h2>
            <div id="popupContent">
                <!-- Reservation details will be injected here -->
            </div>
            <div class="flex justify-between mt-4">
                <button id="closePopupButton" class="bg-gray-300 px-4 py-2 rounded-lg">Close</button>
                <button id="confirmButton" onclick="insertdata()" class="bg-green-500 text-white px-4 py-2 rounded-lg">Confirm</button>
            </div>
        </div>
    </div>

    <!-- Hidden Form -->
    <form id="data-form" method="POST">
        <input type="hidden" id="pickup_location-input" name="pickup_location">
        <input type="hidden" id="destination-input" name="destination">
        <input type="hidden" id="vehicle_type-input" name="vehicle_type">
        <input type="hidden" id="payment_method-input" name="payment_method">
        <input type="hidden" id="strip_start-input" name="strip_start">
        <input type="hidden" id="trip_end-input" name="trip_end">
        <input type="hidden" name="action" id="action">
    </form>




    <!-- Don't remove it should be there  -->
    <div id="historyPage">
        <div class="flex items-center p-5 bg-pantone space-x-3 text-lg font-bold">
            <div onclick="backToHome()" class=" flex items-center space-x-3 md:hidden">
                <i class="fa-solid fa-arrow-left text-white"></i>
                <p class="text-white">Vehicle Reservation</p>
            </div>
            <div class="md:flex space-x-5 text-white hidden">
                <p>Home</p>
                <p>Services</p>
                <p>Offers</p>
                <p onclick="History()">History</p>
                <p>Modes</p>
            </div>
        </div>

        <div class="max-w-screen-xl mx-auto">
            <div class="flex justify-between border-b-2 border-pantone rounded-lg m-2 p-2">
                <!-- Print all data from here -->
                <div id="panddingData">
                </div>
                <!-- Padding Showing from here -->
                <div class="flex items-center">
                    <p id="msg" class="bg-green-600 rounded-full pr-2 pl-2 text-white">Pending...</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom Navigation Bar -->
    <div class="fixed bottom-0 w-full bg-pantone p-3 z-40 flex justify-around text-white md:hidden">
        <div class="flex flex-col items-center space-y-1">
            <i class="fa-solid fa-th-large text-lg"></i>
            <p class="text-xs">Services</p>
        </div>
        <a href="http://localhost/zanbahon/Custumer_history.php">
        <div class="flex flex-col items-center space-y-1">
            <i class="fa-solid fa-clock text-lg"></i>
            <p class="text-xs">History</p>
        </div></a>

        <div class="flex flex-col items-center space-y-1">
            <i class="fa-solid fa-home text-lg"></i>
            <p class="text-xs">Home</p>
        </div>
        <div class="flex flex-col items-center space-y-1">
            <i class="fa-solid fa-percent text-lg"></i>
            <p class="text-xs">Offers</p>
        </div>
        <div class="flex flex-col items-center space-y-1">
            <i class="fa-solid fa-layer-group text-lg"></i>
            <p class="text-xs">Modes</p>
        </div>
    </div>

</body>
<script>
    document.getElementById("historyPage").classList.add("hidden");

    function backToHome() {
        document.getElementById("historyPage").classList.add("hidden");
        document.getElementById("vehicleReservation").classList.remove("hidden");
    }

    // Select the <details> element, <summary>, and all list items
    const menu = document.getElementById('vehicleMenu');
    const summary = document.getElementById('menuSummary');
    const menuItems = menu.querySelectorAll('ul > li > a');

    summary.textContent = 'Car';
    // Add click event to each menu item
    menuItems.forEach((item) => {
        item.addEventListener('click', (event) => {
            event.preventDefault(); // Prevent default link behavior
            const selectedText = item.textContent.trim(); // Get selected text
            summary.textContent = selectedText; // Update the summary text
            menu.removeAttribute('open'); // Close the dropdown menu
        });
    });

    function toggleTripType(type) {
        const oneWay = document.getElementById('OneWay_trip');
        const roundTrip = document.getElementById('round_trip');

        if (type === 'OneWay') {
            oneWay.classList.remove('hidden');
            roundTrip.classList.add('hidden');
        } else if (type === 'RoundTrip') {
            oneWay.classList.add('hidden');
            roundTrip.classList.remove('hidden');
        }
    }


    //  all list items for payment methods
    const paymentMenu = document.getElementById('PaymentMenu');
    const summaryPayment = document.getElementById('menuSummaryForPaymet');
    const paymentItems = paymentMenu.querySelectorAll('ul > li > a');

    // Set default selected payment method (BKash)
    summaryPayment.textContent = 'BKash'; // Set default selected payment to 'BKash'

    // Add click event to each menu item
    paymentItems.forEach((item) => {
        item.addEventListener('click', (event) => {
            event.preventDefault(); // Prevent default link behavior
            const selectedText = item.textContent.trim(); // Get selected text
            summaryPayment.textContent = selectedText; // Update the summary text with the selected method
            paymentMenu.removeAttribute('open'); // Close the dropdown menu
        });
    });


    // Declare all variables globally
    let pickUpLocation;
    let dropOffLocation;
    let vehicleType;
    let tripType;
    let pickupTime;
    let dropTime;
    let paymentMethod;

    document.getElementById("requestButton").addEventListener("click", function(event) {
        event.preventDefault(); // Prevent form submission

        // Gather values from the form
        pickUpLocation = document.getElementById("pickUpLocation").value.trim();
        dropOffLocation = document.getElementById("dropOffLocation").value.trim();
        vehicleType = document.querySelector('#vehicleMenu summary') ? document.querySelector('#vehicleMenu summary').innerText.trim() : '';
        tripType = document.querySelector('input[name="tripType"]:checked') ? document.querySelector('input[name="tripType"]:checked').value : '';
        pickupTime = document.getElementById("pickup_time") ? document.getElementById("pickup_time").value : '';
        dropTime = document.getElementById("drop_time") ? document.getElementById("drop_time").value : '';
        paymentMethod = document.querySelector('#PaymentMenu summary') ? document.querySelector('#PaymentMenu summary').innerText.trim() : '';

        // Validate inputs
        let missingFields = [];
        if (!pickUpLocation) missingFields.push("Pick-up Location");
        if (!dropOffLocation) missingFields.push("Drop-off Location");
        if (!vehicleType) missingFields.push("Vehicle Type");
        if (!tripType) missingFields.push("Trip Type");
        if (tripType === "OneWay" && !pickupTime) missingFields.push("Pickup Time");
        if (tripType === "RoundTrip" && (!pickupTime || !dropTime)) missingFields.push("Pickup and Drop Time");
        if (!paymentMethod) missingFields.push("Payment Method");

        // If any fields are missing, show a message
        if (missingFields.length > 0) {
            alert("Please fill out the following fields: " + missingFields.join(", "));
            return;
        }

        // Prepare the popup content
        let popupContent = `
        <p><strong>Pick-up Location:</strong> ${pickUpLocation}</p>
        <p><strong>Drop-off Location:</strong> ${dropOffLocation}</p>
        <p><strong>Vehicle Type:</strong> ${vehicleType}</p>
        <p><strong>Trip Type:</strong> ${tripType}</p>
        <p><strong>Pickup Time:</strong> ${pickupTime}</p>
    `;

        dropTime = "Unknown";

        if (tripType === "RoundTrip") {
            popupContent += `<p><strong>Drop Time:</strong> ${dropTime}</p>`;
        }

        popupContent += `
        <p><strong>Payment Method:</strong> ${paymentMethod}</p>
    `;

        // Show the popup modal
        document.getElementById("popupContent").innerHTML = popupContent;
        document.getElementById("popupModal").classList.remove("hidden");
    });


    // Close the popup when the Close button is clicked
    document.getElementById("closePopupButton").addEventListener("click", function() {
        document.getElementById("popupModal").classList.add("hidden");
    });




    function insertdata() {
        // Dynamically get the values from the form
        pickupTime = document.getElementById("pickup_time").value.trim(); // Pickup time from input field
        dropTime = document.getElementById("drop_time").value.trim() || null; // Drop time from input field (default to null if empty)
        // Set form values
        document.getElementById('pickup_location-input').value = pickUpLocation;
        document.getElementById('destination-input').value = dropOffLocation;
        document.getElementById('vehicle_type-input').value = vehicleType;
        document.getElementById('payment_method-input').value = paymentMethod;
        document.getElementById('strip_start-input').value = pickupTime;
        document.getElementById('trip_end-input').value = dropTime;
        document.getElementById("action").value = "Unknown";

        // Submit the form
        document.getElementById("action").value = "confirm";
        document.getElementById('data-form').submit();
        document.getElementById('data-form').reset();
        document.getElementById("popupModal").classList.add("hidden");

    }
</script>

</html>