<?php
require 'ReservationDB.php';
// Database connection
$servername = "localhost";
$username = "root";  // Your DB username
$password = "";      // Your DB password
$dbName = "zanbahon"; // Your DB name

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbName);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Handle Accept button click (update status to "Accepted")
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accept'])) {
  $reservationId = $_POST['reservation_id'];

  // Update reservation status to "Accepted" and set driverID to 8
  $updateSql = "UPDATE Reservation_Table SET status = 'Accepted', driverID = 8 WHERE Service_ID = 1 AND id = ?";
  $stmt = $conn->prepare($updateSql);
  $stmt->bind_param("i", $reservationId);
  $stmt->execute();

  // Redirect to reload the page after update
  header("Location: " . $_SERVER['PHP_SELF']);
  exit();
}

// Fetch all reservations with status 'Pending'
$sqlPending = "SELECT * FROM Reservation_Table WHERE Service_ID = 1 AND status = 'Pending'";
$resultPending = $conn->query($sqlPending);

$reservationsPending = [];
if ($resultPending->num_rows > 0) {
  while ($row = $resultPending->fetch_assoc()) {
    $reservationsPending[] = $row;
  }
}
// Fetch reservations where driverID = 8 and status = 'Accepted'
$sqlAccepted = "SELECT * FROM Reservation_Table WHERE Service_ID = 1 AND driverID = 8 AND status = 'Accepted'";
$resultAccepted = $conn->query($sqlAccepted);

$reservationsAccepted = [];
if ($resultAccepted->num_rows > 0) {
  while ($row = $resultAccepted->fetch_assoc()) {
    $reservationsAccepted[] = $row;
  }
}

// Fetch reservations with status 'Cancelled' and driverID = 8
$sqlCancelled = "SELECT * FROM Reservation_Table WHERE Service_ID = 1 AND status = 'Cancelled' AND driverID = 8";
$resultCancelled = $conn->query($sqlCancelled);

$cancelledReservations = [];
if ($resultCancelled->num_rows > 0) {
  while ($row = $resultCancelled->fetch_assoc()) {
    $cancelledReservations[] = $row;
  }
}

// Fetch reservations with status 'Successful' and driverID = 8
$querySuccessful = "SELECT * FROM Reservation_Table WHERE Service_ID = 1 AND status = 'Successful' AND driverID = 8";
$resultSuccessful = $conn->query($querySuccessful);

$successfulReservations = [];
if ($resultSuccessful->num_rows > 0) {
  while ($record = $resultSuccessful->fetch_assoc()) {
    $successfulReservations[] = $record;
  }
}


// Handle status update requests
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['reservationId']) && isset($_POST['status'])) {
  $reservationId = $_POST['reservationId'];
  $status = $_POST['status'];

  $updateSql = "UPDATE Reservation_Table SET status = ? WHERE Service_ID = 1 AND id = ?";
  $stmt = $conn->prepare($updateSql);
  $stmt->bind_param("si", $status, $reservationId);

  if ($stmt->execute()) {
    echo "Reservation status updated to: $status";
  } else {
    echo "Failed to update reservation.";
  }

  $stmt->close();
  $conn->close();
  exit;
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.14/dist/full.min.css" rel="stylesheet" type="text/css" />
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://kit.fontawesome.com/cc6fad79da.js" crossorigin="anonymous"></script>
  <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.14/dist/full.min.css" rel="stylesheet" type="text/css" />
  <script src="https://cdn.tailwindcss.com"></script>
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
  <div id="vehicleReservation" class="min-h-screen flex flex-col pb-20 overflow-auto">
    <header class="flex items-center p-5 bg-pantone space-x-3 text-lg font-bold">
      <div class="flex items-center space-x-3 md:hidden">
        <i class="fa-solid fa-arrow-left text-white"></i>
        <p class="text-white">Driver Vehicle Reservation</p>
      </div>
      <div class="md:flex space-x-5 text-white hidden">
        <p>Home</p>
        <p>Services</p>
        <p>Offers</p>
        <p onclick="History()">History</p>
        <p>Modes</p>
      </div>
    </header>

    <div class="tabs tabs-bordered w-full max-w-2xl mx-auto">
      <!-- Pending Tab -->
      <input id="Pending_tab" type="radio" name="my_tabs_1" role="tab" class="tab ml-3 md:ml-40"  aria-label="Pending " checked="checked" />
      <div class="tab-content p-5">
        <div id="Pending_request" class="block">
          <div class="space-y-4">
            <?php foreach ($reservationsPending as $reservation): ?>
              <div class="flex justify-between bg-white p-5 rounded-lg shadow-md hover:shadow-xl cursor-pointer reservation-item">
                <div>
                  <p class="text-xl font-semibold text-gray-800">Name: Sadid</p>
                  <p class="md:text-xl text-sm font-semibold text-gray-800">Reservation date: <?php echo $reservation['Reservation_date']; ?></p>
                  <p class="text-lg font-semibold text-green-500"><?php echo $reservation['pickup_location']; ?> → <?php echo $reservation['destination']; ?></p>
                  <p class="text-sm text-gray-600">Trip type: <?php echo $reservation['trip_type']; ?></p>
                  <p class="text-sm text-gray-600">Vehicle Type: <?php echo $reservation['vehicle_type']; ?></p>
                  <p class="text-sm text-gray-600">Pickup Time: <?php echo $reservation['trip_start']; ?></p>
                  <p class="text-sm text-gray-600">Trip cost: <?php echo $reservation['price']; ?> <?php echo $reservation['payment_method']; ?></p>
                </div>
                <div>
                  <!-- Accept Button -->
                  <form method="POST">
                    <input type="hidden" name="reservation_id" value="<?php echo $reservation['id']; ?>">
                    <button type="submit" name="accept" class="mt-4 bg-green-500 text-white py-2 px-4 rounded-lg hover:bg-green-600">Accept</button>
                  </form>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>

      <!-- Accepted Tab -->
      <input id="Accepted_tab" type="radio" name="my_tabs_1" class="tab " aria-label="Accepted "  />
      <div class="tab-content p-3">
        <div id="Accepted_request" class="block">
          <div class="space-y-4">
            <?php foreach ($reservationsAccepted as $reservation): ?>
              <div class="flex justify-between bg-white p-5 rounded-lg shadow-md hover:shadow-xl cursor-pointer reservation-item">
                <div>
                  <p class="md:text-xl text-sm font-semibold text-gray-800">Reservation date: <?php echo $reservation['Reservation_date']; ?></p>
                  <p class="text-lg font-semibold text-green-500"><?php echo $reservation['pickup_location']; ?> → <?php echo $reservation['destination']; ?></p>
                  <p class="text-sm text-gray-600">Trip type: <?php echo $reservation['trip_type']; ?></p>
                  <p class="text-sm text-gray-600">Vehicle Type: <?php echo $reservation['vehicle_type']; ?></p>
                  <p class="text-sm text-gray-600">Pickup Time: <?php echo $reservation['trip_start']; ?></p>
                  <p class="text-sm text-gray-600">Trip cost: <?php echo $reservation['price']; ?> <?php echo $reservation['payment_method']; ?></p>
                </div>
                <div>
                  <!-- Edit Button to Open Popup -->
                  <button class="mt-3 bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600"
                    onclick="openPopupForAccept(<?php echo $reservation['id']; ?>)">Edit</button>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>

        <!-- Popup Modal for Accepted Reservation -->
        <div id="popupAccepted" class="fixed inset-0 flex justify-center items-center p-4 bg-gray-800 bg-opacity-50 hidden" onclick="closePopupAccept(event)">
          <div class="bg-white p-6 rounded-lg shadow-xl w-96" onclick="event.stopPropagation()">
            <h1 class="text-2xl mb-6">Update your reservation.</h1>
            <form id="updateForm">
              <input type="hidden" id="reservationId" name="reservationId">
              <input type="hidden" id="status" name="status">

              <div class="flex justify-end space-x-4">
                <button type="button" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600"
                  onclick="updateReservationStatus('Cancelled')">Cancel Reservation</button>
                <button type="button" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600"
                  onclick="updateReservationStatus('Successful')">Complete Reservation</button>
              </div>
            </form>
          </div>
        </div>
      </div>
      <input type="radio" name="my_tabs_1" role="tab" class="tab" aria-label="Cancelled" />
      <div role="tabpanel" class="tab-content p-3">
          <!-- Cancelled Reservations Section -->
          <div id="Cancelled_request" class="block">
            <div class="space-y-4">
              <?php if (!empty($cancelledReservations)): ?>
                <?php foreach ($cancelledReservations as $reservation): ?>
                  <div class="flex justify-between bg-gray-100 p-5 rounded-lg shadow-md hover:shadow-xl reservation-item">
                    <div>
                    <p class="md:text-xl text-sm font-semibold text-gray-800">Reservation date: <?php echo $reservation['Reservation_date']; ?></p>
                    <p class="text-lg font-semibold text-green-500"><?php echo $reservation['pickup_location']; ?> → <?php echo $reservation['destination']; ?></p>
                    <p class="text-sm text-gray-600">Trip type: <?php echo $reservation['trip_type']; ?></p>
                    <p class="text-sm text-gray-600">Vehicle Type: <?php echo $reservation['vehicle_type']; ?></p>
                    <p class="text-sm text-gray-600">Pickup Time: <?php echo $reservation['trip_start']; ?></p>
                    <p class="text-sm text-gray-600">Trip cost: <?php echo $reservation['price']; ?> <?php echo $reservation['payment_method']; ?></p>
                    </div>
                    <div>
                      <p class="mt-3 text-red-500 font-bold">Cancelled</p>
                    </div>
                  </div>
                <?php endforeach; ?>
              <?php else: ?>
                <p class="text-center text-gray-500">No cancelled reservations available.</p>
              <?php endif; ?>
            </div>
          </div>
       </div>

       <input type="radio" name="my_tabs_1" role="tab" class="tab " aria-label="Successful" />
      <div role="tabpanel" class="tab-content p-3">

        <!-- Successful Reservations Section -->
        <div id="Successful_request" class="block">
          <div class="space-y-4">
            <?php if (!empty($successfulReservations)): ?>
              <?php foreach ($successfulReservations as $reservation): ?>
                <div class="flex justify-between bg-green-50 p-5 rounded-lg shadow-md hover:shadow-xl reservation-item">
                  <div>
                  <p class="md:text-xl text-sm font-semibold text-gray-800">Reservation date: <?php echo $reservation['Reservation_date']; ?></p>
                  <p class="text-lg font-semibold text-green-500"><?php echo $reservation['pickup_location']; ?> → <?php echo $reservation['destination']; ?></p>
                  <p class="text-sm text-gray-600">Trip type: <?php echo $reservation['trip_type']; ?></p>
                  <p class="text-sm text-gray-600">Vehicle Type: <?php echo $reservation['vehicle_type']; ?></p>
                  <p class="text-sm text-gray-600">Pickup Time: <?php echo $reservation['trip_start']; ?></p>
                  <p class="text-sm text-gray-600">Trip cost: <?php echo $reservation['price']; ?> <?php echo $reservation['payment_method']; ?></p>
                  </div>
                  <div>
                    <p class="mt-3 text-green-500 font-bold">Successful</p>
                  </div>
                </div>
              <?php endforeach; ?>
            <?php else: ?>
              <p class="text-center text-gray-500">No successful reservations available.</p>
            <?php endif; ?>
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
        <div onclick="History()" class="flex flex-col items-center space-y-1">
          <i class="fa-solid fa-clock text-lg"></i>
          <p class="text-xs">History</p>
        </div>

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

      <script>
        function openPopupForAccept(reservationId) {
          document.getElementById("reservation_id").value = reservationId;
          document.getElementById("popupAccepted").classList.remove("hidden");
        }

        function closePopupAccept(event) {
          if (event.target === document.getElementById("popupAccepted")) {
            document.getElementById("popupAccepted").classList.add("hidden");
          }
        }

        // Opens the popup and sets the reservation ID
        function openPopupForAccept(reservationId) {
          document.getElementById("reservationId").value = reservationId;
          document.getElementById("popupAccepted").classList.remove("hidden");
        }

        // Closes the popup
        function closePopupAccept(event) {
          if (event) event.stopPropagation();
          document.getElementById("popupAccepted").classList.add("hidden");
        }

        // Updates the reservation status via AJAX
        function updateReservationStatus(status) {
          const reservationId = document.getElementById("reservationId").value;
          if (!reservationId) return alert("No reservation selected.");

          const xhr = new XMLHttpRequest();
          xhr.open("POST", "<?php echo $_SERVER['PHP_SELF']; ?>", true);
          xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

          xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
              alert(xhr.responseText);
              location.reload(); // Refresh to show the updated data
            }
          };

          xhr.send("reservationId=" + reservationId + "&status=" + status);
        }
      </script>

</body>

</html>