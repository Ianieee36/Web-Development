import { useState } from 'react';

function BookingTracker() {
  const [bookingRef, setBookingRef] = useState('');
  const [booking, setBooking] = useState(null);
  const [message, setMessage] = useState(null);

  const API_URL =
    'https://webdev.aut.ac.nz/~vpk8065/assign/part2/api/trackBooking.php'; // Fixed: was missing "/" before "api"

  async function trackBooking(event) {
    event.preventDefault();

    setBooking(null);
    setMessage(null);

    if (bookingRef.trim() === '') {
      setMessage({
        type: 'error',
        text: 'Please enter a booking reference number.',
      });
      return;
    }

    if (!/^BRN\d{5}$/.test(bookingRef.trim())) {
      setMessage({
        type: 'error',
        text: 'Invalid booking reference format. Example: BRN00001',
      });
      return;
    }

    const bodyData = new URLSearchParams({
      booking_ref: bookingRef.trim(),
    });

    try {
      const response = await fetch(API_URL, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: bodyData.toString(),
      });

      const data = await response.json();

      if (data.success) {
        setBooking(data.booking);
      } else {
        setMessage({
          type: 'error',
          text: data.message,
        });
      }
    } catch (error) {
      console.error(error);

      setMessage({
        type: 'error',
        text: 'Server error occurred while tracking booking.',
      });
    }
  }

  return (
    <div className="tracker-card">
      <div className="tracker-left">
        <h2>Track Your <span>Booking</span></h2>
        <p>Enter your booking reference number to check the status of your ride.</p>
      </div>

      <div className="tracker-form-card">
        <h3>Check Status</h3>
        <form onSubmit={trackBooking}>
          <label>Booking Reference Number</label>
          <input
            type="text"
            placeholder="Example: BRN00001"
            value={bookingRef}
            onChange={(event) => setBookingRef(event.target.value)}
          />
          <button type="submit">Track Booking →</button>
        </form>

        {message && (
          <div className={message.type === 'success' ? 'success-box' : 'error-box'}>
            {message.text}
          </div>
        )}

        {booking && (
          <div className="booking-status-card">
            <h3>Booking Status</h3>
            <p><strong>Reference:</strong> {booking.booking_ref}</p>
            <p><strong>Customer:</strong> {booking.cname}</p>
            <p><strong>Pickup:</strong> {booking.sbname}</p>
            <p><strong>Destination:</strong> {booking.dsbname}</p>
            <p><strong>Date & Time:</strong> {booking.pickup_date} {booking.pickup_time}</p>
            <p><strong>Status:</strong> {booking.status}</p>
          </div>
        )}
      </div>
    </div>
  );
}

export default BookingTracker;
