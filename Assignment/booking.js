/**
 * File: booking.js
 * Student: Christian Danielle B. Cantos || 23188023
 * Description: Booking client side where submitted data
 * is being validated and submit to the server via fetch.
*/

window.onload = function () {
    
    // gets the current date and time from the user's computer
    let now = new Date();

    // gets current data and ensures 2 digits
    let day = String(now.getDate()).padStart(2, "0");
    
    // gets current month and ensures 2 digits
    let month = String(now.getMonth() + 1).padStart(2, "0");

    // gets current year
    let year = now.getFullYear();

    // Automatically inserts todays date into the date field
    // Format: dd/mm/yyyy
    document.getElementById("date").value = `${day}/${month}/${year}`;

    // gets current hour in 24-hour format
    let hours = String(now.getHours()).padStart(2, "0");

    // gets current minutes
    let minutes = String(now.getMinutes()).padStart(2, "0");

    // Automatically inserts current time into the time field
    // Format: HH:MM
    document.getElementById("time").value = `${hours}:${minutes}`;
};

// Booking Function
function submitBooking() {

    // GET VALUES FROM HTML INPUT FIELDS
    // .trim() removes extra spaces from beginning/end
    let cname = document.getElementById("cname").value.trim();
    let phone = document.getElementById("phone").value.trim();
    let unumber = document.getElementById("unumber").value.trim();
    let snumber = document.getElementById("snumber").value.trim();
    let stname = document.getElementById("stname").value.trim();
    let sbname = document.getElementById("sbname").value.trim();
    let dsbname = document.getElementById("dsbname").value.trim();
    let date = document.getElementById("date").value.trim();
    let time = document.getElementById("time").value.trim();


    // checks if fields are empty
    if (cname === "" || phone === "" || snumber === "" || stname === "" || date === "" || time === "") {
        alert("Please fill all required fields!");
        // stops the function
        return;
    }

    // validate phone number
    // must have 10-12 digits only
    if (!/^\d{10,12}$/.test(phone)) {
        alert("Phone number must be 10-12 digits!");
        return;
    }

    // splits date string into:
    // day, month, year
    let [day, month, year] = date.split("/");

    // Creates javascript Date object from selected date/time
    let selectedDateTime = new Date(`${year}-${month}-${day}T${time}`);

    // gets current date
    let now = new Date();

    // checks if selected pickup time is in the past
    if (selectedDateTime < now) {
        alert("Pickup date and time cannot be in the past!");
        return;
    }

    // sends booking data to PHP server
    fetch("booking.php", {
        
        // HTTP method
        method: "POST",
        
        // Data type sent to the server
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },

        // Form data being sent to PHP
        body:
            `cname=${encodeURIComponent(cname)}` +
            `&phone=${encodeURIComponent(phone)}` +
            `&unumber=${encodeURIComponent(unumber)}` +
            `&snumber=${encodeURIComponent(snumber)}` +
            `&stname=${encodeURIComponent(stname)}` +
            `&sbname=${encodeURIComponent(sbname)}` +
            `&dsbname=${encodeURIComponent(dsbname)}` +
            `&date=${encodeURIComponent(date)}` +
            `&time=${encodeURIComponent(time)}`
    })

    // receive json response from php
    .then(response => response.json())
    
    .then(data => {
        
        // shows JSON response in browser console
        console.log(data);


        // BOOKING SUCCESSFUL
        if (data.success === true) {

            // Dynamically inserts confirmation message
            // into the webpage
            
            document.getElementById("reference").innerHTML = `
                <div class="confirmation-box">
                    <h2>Thank you for your booking!</h2>
                    <p><strong>Booking reference number:</strong> ${data.reference}</p>
                    <p><strong>Pickup time:</strong> ${data.pickup_time}</p>
                    <p><strong>Pickup date:</strong> ${data.pickup_date}</p>
                </div>
            `;
        } 
        
        // BOOKING FAILED
        else {
            
            // displays error message
            document.getElementById("reference").innerHTML = `
                <p class="error">${data.message}</p>
            `;
        }
    })

    // handles javascript or server errors
    .catch(error => {

        // shows error in browser console
        console.error("Error:", error);

        // shows generic error message on webpage
        document.getElementById("reference").innerHTML =
            `<p class="error">Server error occurred.</p>`;
    });
}