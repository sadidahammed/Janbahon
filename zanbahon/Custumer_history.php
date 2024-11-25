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
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cancel'])) {
  $reservationId = $_POST['reservation_id'];

  // Update reservation status to "Cancelled"
  $updateSql = "UPDATE Reservation_Table SET status = 'Cancelled' WHERE id = ?";
  $stmt = $conn->prepare($updateSql);
  $stmt->bind_param("i", $reservationId);
  $stmt->execute();

  // Redirect to reload the page after update
  header("Location: " . $_SERVER['PHP_SELF']);
  exit();
}

// Fetch all reservations with status 'Pending'
$sqlPending = "SELECT * FROM Reservation_Table WHERE status = 'Pending'";
$resultPending = $conn->query($sqlPending);

$reservationsPending = [];
if ($resultPending->num_rows > 0) {
  while ($row = $resultPending->fetch_assoc()) {
    $reservationsPending[] = $row;
  }
}
// Fetch reservations with status 'Accepted' for userID = 1
$sqlAccepted = "SELECT * FROM Reservation_Table WHERE userID = 1 AND status = 'Accepted'";
$resultAccepted = $conn->query($sqlAccepted);

$reservationsAccepted = [];
if ($resultAccepted->num_rows > 0) {
  while ($row = $resultAccepted->fetch_assoc()) {
    $reservationsAccepted[] = $row;
  }
}

// Handle Cancel button click
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cancel_reservation_id'])) {
  $reservationId = $_POST['cancel_reservation_id'];

  // Update the status to 'Cancelled'
  $updateSql = "UPDATE Reservation_Table SET status = 'Cancelled' WHERE id = ?";
  $stmt = $conn->prepare($updateSql);
  $stmt->bind_param("i", $reservationId);
  $stmt->execute();

  // Reload the page to reflect changes
  header("Location: " . $_SERVER['PHP_SELF']);
  exit();
}

// Fetch reservations with status 'Cancelled' and driverID = 8
$sqlCancelled = "SELECT * FROM Reservation_Table WHERE status = 'Cancelled' AND userID = 1";
$resultCancelled = $conn->query($sqlCancelled);

$cancelledReservations = [];
if ($resultCancelled->num_rows > 0) {
  while ($row = $resultCancelled->fetch_assoc()) {
    $cancelledReservations[] = $row;
  }
}

// Fetch reservations with status 'Successful' and driverID = 8
$querySuccessful = "SELECT * FROM Reservation_Table WHERE status = 'Successful' AND userID = 1";
$resultSuccessful = $conn->query($querySuccessful);

$successfulReservations = [];
if ($resultSuccessful->num_rows > 0) {
  while ($record = $resultSuccessful->fetch_assoc()) {
    $successfulReservations[] = $record;
  }
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
        <a href="http://localhost/zanbahon/Customer_reservation.php">
            <i class="fa-solid fa-arrow-left text-white"></i></a>
        <p class="text-white">Vehicle Reservation</p>
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
                  <p class="text-lg font-semibold text-green-500"><?php echo $reservation['pickup_location']; ?> → <?php echo $reservation['destination']; ?></p>
                  <p class="text-sm text-gray-600">Vehicle Type: <?php echo $reservation['vehicle_type']; ?></p>
                  <p class="text-sm text-gray-600">Pickup Time: <?php echo $reservation['trip_start']; ?></p>
                  <p class="text-sm text-gray-600">Payment Method: <?php echo $reservation['payment_method']; ?></p>
                </div>
                <div>
                  <!-- Accept Button -->
                  <form method="POST">
                    <input type="hidden" name="reservation_id" value="<?php echo $reservation['id']; ?>">
                    <button type="submit" name="cancel" class="mt-4 bg-red-500 text-white py-2 px-4 rounded-lg hover:bg-red-400">Cancelled</button>
                  </form>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>

      <!-- Accepted Tab -->
      <input id="Accepted_tab" type="radio" name="my_tabs_1" class="tab" aria-label="Accepted "  />
      <div class="tab-content p-3">
      <div id="Accepted_request" class="block">
            <div class="space-y-4">
            <?php foreach ($reservationsAccepted as $reservation): ?>
                <div class="flex justify-between bg-white p-5 rounded-lg shadow-md hover:shadow-xl cursor-pointer reservation-item">
                <div>
                    <p class="text-lg font-semibold"><?php echo $reservation['pickup_location']; ?> → <?php echo $reservation['destination']; ?></p>
                    <p class="text-sm text-gray-500">Vehicle: <?php echo $reservation['vehicle_type']; ?></p>
                    <p class="text-sm text-gray-500">Pickup Time: <?php echo $reservation['trip_start']; ?></p>
                    <p class="text-sm text-gray-500">Payment Method: <?php echo $reservation['payment_method']; ?></p>
                </div>
                <div>
                    <!-- Cancel Button -->
                    <form method="POST">
                    <input type="hidden" name="cancel_reservation_id" value="<?php echo $reservation['id']; ?>" />
                    <button type="submit" class="mt-4 bg-red-500 text-white py-2 px-4 rounded-lg hover:bg-red-400">Cancelled</button>
                    </form>
                </div>
                </div>
            <?php endforeach; ?>
            </div>
        </div>

        
      </div>
    

       <input type="radio" name="my_tabs_1" role="tab" class="tab" aria-label="Cancelled" />
      <div role="tabpanel" class="tab-content p-3">

        <!-- Cancelled Reservations Section -->
        <div id="Cancelled_request" class="block">
          <div class="space-y-4">
          <?php if (!empty($cancelledReservations)): ?>
            <?php foreach ($cancelledReservations as $cancelled): ?>
                <div class="flex justify-between bg-gray-100 p-5 rounded-lg shadow-md hover:shadow-xl reservation-item">
                  <div>
                      <p class="text-lg font-semibold"><?php echo $cancelled['pickup_location']; ?> → <?php echo $cancelled['destination']; ?></p>
                      <p class="text-sm text-gray-500">Vehicle: <?php echo $cancelled['vehicle_type']; ?></p>
                      <p class="text-sm text-gray-500">Pickup Time: <?php echo $cancelled['trip_start']; ?></p>
                      <p class="text-sm text-gray-500">Payment Method: <?php echo $cancelled['payment_method']; ?></p>
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



       <input type="radio" name="my_tabs_1" role="tab" class="tab" aria-label="Successful" />
      <div role="tabpanel" class="tab-content p-3">
        <!-- Successful Reservations Section -->
        <div id="Successful_request" class="block">
          <div class="space-y-4">
            <?php if (!empty($successfulReservations)): ?>
              <?php foreach ($successfulReservations as $successful): ?>
                <div class="flex justify-between bg-green-50 p-5 rounded-lg shadow-md hover:shadow-xl reservation-item">
                  <div>
                    <p class="text-lg font-semibold"><?php echo $successful['pickup_location']; ?> → <?php echo $successful['destination']; ?></p>
                    <p class="text-sm text-gray-500">Vehicle: <?php echo $successful['vehicle_type']; ?></p>
                    <p class="text-sm text-gray-500">Pickup Time: <?php echo $successful['trip_start']; ?></p>
                    <p class="text-sm text-gray-500">Payment Method: <?php echo $successful['payment_method']; ?></p>
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

</html>