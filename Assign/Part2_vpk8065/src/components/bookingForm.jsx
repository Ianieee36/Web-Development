import { useState } from 'react';
import AddressSearch from './addressSearch';
import BookingTracker from './bookingTracker';
import AboutSection from './AboutSection';
import ContactSection from './ContactSection';

function BookingForm() {
  const [pickupCoords, setPickupCoords] = useState(null);
  const [dropoffCoords, setDropoffCoords] = useState(null);
  const [fareEstimate, setFareEstimate] = useState(null);
  const [formData, setFormData] = useState({
    cname: '',
    phone: '',
    sbname: '',
    dsbname: '',
    pickupDateTime: '',
  });

  const [message, setMessage] = useState(null);

  const API_URL = 'https://webdev.aut.ac.nz/~vpk8065/assign/part2/api/createBooking.php';

  function handleChange(event) {
    const { name, value } = event.target;
    setFormData({ ...formData, [name]: value });
  }

  function validateForm() {
    if (
      formData.cname.trim() === '' ||
      formData.phone.trim() === '' ||
      formData.sbname.trim() === '' ||
      formData.dsbname.trim() === '' ||
      formData.pickupDateTime.trim() === ''
    ) {
      setMessage({ type: 'error', text: 'Please complete all required fields.' });
      return false;
    }

    if (!/^\d{10,12}$/.test(formData.phone)) {
      setMessage({ type: 'error', text: 'Phone number must contain 10 to 12 digits only.' });
      return false;
    }

    return true;
  }

  async function handleSubmit(event) {
    event.preventDefault();

    if (!validateForm()) return;

    const [datePart, timePart] = formData.pickupDateTime.split('T');
    const [year, month, day] = datePart.split('-');

    const bodyData = new URLSearchParams({
      cname:   formData.cname,
      phone:   formData.phone,
      sbname:  formData.sbname,
      dsbname: formData.dsbname,
      date:    `${day}/${month}/${year}`,
      time:    timePart,
    });

    try {
      const response = await fetch(API_URL, {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: bodyData.toString(),
      });

      const data = await response.json();

      if (data.success) {
        setMessage({
          type: 'success',
          text: `Booking successful! Your booking reference is ${data.reference}. Pickup date: ${data.pickup_date}, pickup time: ${data.pickup_time}.`,
        });

        setFormData({ cname: '', phone: '', sbname: '', dsbname: '', pickupDateTime: '' });
      } else {
        setMessage({ type: 'error', text: data.message });
      }
    } catch (error) {
      console.error(error);
      setMessage({ type: 'error', text: 'Server error occurred. Please try again.' });
    }
  }

  function estimateFare() {
  if (!pickupCoords || !dropoffCoords) {
    setMessage({ type: 'error', text: 'Please select both pickup and dropoff locations from the suggestions to estimate fare.' });
    return;
  }

  // Haversine formula — calculates distance between two coordinates
  const R = 6371; // Earth radius in km
  const dLat = (dropoffCoords.lat - pickupCoords.lat) * Math.PI / 180;
  const dLon = (dropoffCoords.lon - pickupCoords.lon) * Math.PI / 180;
  const a =
    Math.sin(dLat / 2) * Math.sin(dLat / 2) +
    Math.cos(pickupCoords.lat * Math.PI / 180) *
    Math.cos(dropoffCoords.lat * Math.PI / 180) *
    Math.sin(dLon / 2) * Math.sin(dLon / 2);
  const distance = R * 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));

  // Fare calculation: $3.50 base + $2.20 per km
  const base = 3.50;
  const perKm = 2.20;
  const fare = base + distance * perKm;

  setFareEstimate({ distance: distance.toFixed(1), fare: fare.toFixed(2) });
}

  return (
    <>
    <section className="booking-hero">
      <div className="hero-left">
        <h1>Your Ride, <span>On Demand</span></h1>
        <p>Book a reliable cab in seconds. Available 24/7 with professional drivers and competitive rates.</p>
        <div className="hero-features">
          <span>● 24/7 Service</span>
          <span>● Professional Drivers</span>
          <span>● GPS Tracking</span>
        </div>
      </div>

      <div className="booking-card">
        
        <h2>Book Your Ride</h2>

        <form onSubmit={handleSubmit}>
          <label>Customer Name *</label>
          <input
            type="text"
            name="cname"
            placeholder="Enter your full name"
            value={formData.cname}
            onChange={handleChange}
          />

          <label>Phone Number *</label>
          <input
            type="text"
            name="phone"
            placeholder="Enter phone number"
            value={formData.phone}
            onChange={handleChange}
          />

          <label>Pickup Location *</label>
          <AddressSearch
            value={formData.sbname}
            placeholder="Search pickup address"
            onAddressSelect={(address, lat, lon) => {
              setFormData({ ...formData, sbname: address });
              if (lat && lon) setPickupCoords({ lat, lon });
              else setPickupCoords(null);
            }}
          />

          <label>Drop-off Location *</label>
          <AddressSearch
            value={formData.dsbname}
            placeholder="Search destination address"
            onAddressSelect={(address, lat, lon) => {
              setFormData({ ...formData, dsbname: address });
              if (lat && lon) setDropoffCoords({ lat, lon });
              else setDropoffCoords(null);
            }}
          />

          <label>Pickup Date and Time *</label>
          <input
            type="datetime-local"
            name="pickupDateTime"
            value={formData.pickupDateTime}
            onChange={handleChange}
          />

          {/* Fare estimator — add these 3 things here, above Book Now */}
          <button type="button" onClick={estimateFare} className="estimate-btn">
            Estimate Fare
          </button>

          {fareEstimate && (
            <div className="fare-result">
              <span>📍 {fareEstimate.distance} km</span>
              <span>Estimated Fare: <strong>${fareEstimate.fare}</strong></span>
            </div>
          )}

          <button type="submit">Book Now →</button>
        </form>

        {message && (
          <div className={message.type === 'success' ? 'success-box' : 'error-box'}>
            {message.text}
          </div>
        )}
      </div>
    </section>

    <section id="tracker">
        <BookingTracker />
      </section>

      <AboutSection />      {/* ← add this */}
      <ContactSection />    {/* ← add this */}
    </>
  );
}

export default BookingForm;
