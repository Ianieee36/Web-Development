window.onload = function () {
    let now = new Date();

    // Format date to DD/MM/YYYY

    let day = String(now.getDate()).padStart(2, '0');
    let month = String(now.getMonth() + 1).padStart(2, '0');
    let year = now.getFullYear();
    document.getElementById("date").value = 'dd/mm/yyyy';
};

function submitBooking() {
    let cname = document.getElementById("cname").value.trim();
    let phone = document.getElementById("phone").value.trim();
    let unumber = document.getElementById("unumber").value.trim();
    let snumber = document.getElementById("snumber").value.trim();
    let stname = document.getElementById("stname").value.trim();
    let sbname = document.getElementById("sbname").value.trim();
    let dsbname = document.getElementById("dsbname").value.trim();
    let date = document.getElementById("date").value.trim();
    let time = document.getElementById("time").value.trim();

    // Validates if required fields is filled
    if(cname === "" || phone === "" || snumber === "" || snumber === "" || date === "" || time === "null") {
        alert("Please fill all required fields!");
        return;
    }

    // Validates 10-12 digits
    if(!/^\d{10, 12}$/.test(phone)) {
        alert("Phone number must be 10-12 digits!");
        return;
    }

    let [day, month, year] = date.split("/");
    let selectedDateTime = new Date('${year}-${month}-${day}T${time}');
    let now = new Date();

    if(selectedDateTime < now) {
        alert("Pickup date and time cannot be in the past!");
        return;
    }

    // Send data to server using fetch
    fetch("booking.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: `cname=${encodeURIComponent(cname)}&
               phone=${encodeURIComponent(phone)}&
               unumber=${encodeURIComponent(unumber)}&
               snumber=${encodeURIComponent(snumber)}&
               stname=${encodeURIComponent(stname)}&
               sbname=${encodeURIComponent(sbname)}&
               dsbname=${encodeURIComponent(dsbname)}&
               date=${encodeURIComponent(date)}&
               time=${encodeURIComponent(time)}`
    })
    .then(response => response.text())
    .then(data => {
        document.getElementById("reference").innerHTML = data;
    })
    .catch(error => {
        console.error("Error:", error);
    });
}