/**
 * File: admin.js
 * Student : Christian Danielle B. Cantos || 23188023
 * Description: Client side which gets and validate the 
 * submitted booking reference, fetch data from server
 */



// Adds a click event listener to the Search button
// When the button is clicked, the searchBookings function will run
document.getElementById("sbutton").addEventListener("click", searchBookings);

// Searches for booking requests from the database
// clearMessage controls whether the message area should be cleared or not
function searchBookings(clearMessage = true) {

  // Gets the booking reference entered by the admin
  const bsearch = document.getElementById("bsearch").value.trim();

  // Gets the message area where validation or success messages appear
  const message = document.getElementById("message");

  // Clears the message only when needed
  // This prevents the success message from disappearing after assigning a booking
  if (clearMessage) {
    message.innerHTML = "";
  }

  // Validates booking reference format
  // Correct format example: BRN00001
  if (bsearch !== "" && !/^BRN\d{5}$/.test(bsearch)) {
    message.innerHTML = "Invalid booking reference format. Example: BRN00001";
    return;
  }

  // Sends a POST request to admin.php to search for bookings
  fetch("admin.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded"
    },

    // Sends the action and search value to PHP
    body: "action=search&bsearch=" + encodeURIComponent(bsearch)
  })

  // Converts the PHP JSON response into a JavaScript object
  .then(response => response.json())

  // Sends the returned booking data to the displayTable function
  .then(data => {
    displayTable(data);
  });
}

// Displays the booking results inside an HTML table
function displayTable(bookings) {

  // Gets the content area where the booking table will be displayed
  const content = document.getElementById("content");

  // If no bookings are returned, show a message
  if (bookings.length === 0) {
    content.innerHTML = "<p>No booking requests found.</p>";
    return;
  }

  // Creates the table heading
  let html = `
    <table border="1">
      <tr>
        <th>Booking Reference Number</th>
        <th>Customer Name</th>
        <th>Phone</th>
        <th>Pickup Suburb</th>
        <th>Destination Suburb</th>
        <th>Pickup Date and Time</th>
        <th>Status</th>
        <th>Assign</th>
      </tr>
  `;

  // Loops through each booking returned from the database
  // and adds a row to the table
  bookings.forEach(booking => {
    html += `
      <tr>
        <td>${booking.booking_ref}</td>
        <td>${booking.cname}</td>
        <td>${booking.phone}</td>
        <td>${booking.sbname}</td>
        <td>${booking.dsbname}</td>
        <td>${booking.pickup_date} ${booking.pickup_time}</td>
        <td>${booking.status}</td>
        <td>
          <button onclick="assignBooking('${booking.booking_ref}')">
            Assign
          </button>
        </td>
      </tr>
    `;
  });

  // Closes the table
  html += "</table>";

  // Displays the completed table on the webpage
  content.innerHTML = html;
}

// Assigns a booking request when the admin clicks the Assign button
function assignBooking(reference) {

  // Sends a POST request to admin.php to update the booking status
  fetch("admin.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded"
    },

    // Sends the assign action and booking reference to PHP
    body: "action=assign&reference=" + encodeURIComponent(reference)
  })

  // Converts the PHP JSON response into a JavaScript object
  .then(response => response.json())

  // Runs after the booking status has been updated
  .then(data => {

    // Refreshes the booking table without clearing the success message
    searchBookings(false);

    // Displays confirmation message on the webpage
    document.getElementById("message").innerHTML = `
      <div class="confirmation-box">
        <h2>Booking Assigned Successfully</h2>
        <p>${data.message}</p>
      </div>
    `;
  })

  // Handles JavaScript or server errors
  .catch(error => {
    console.error("Error:", error);

    // Displays an error message on the webpage
    document.getElementById("message").innerHTML = `
      <p class="error">Server error occurred.</p>
    `;
  });
}