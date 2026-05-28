import { useState } from 'react';
import DriverSelector from './driverSelector';

function AdminDashboard() {
  const [bookingRef, setBookingRef] = useState('');
  const [bookings, setBookings] = useState([]);
  const [message, setMessage] = useState(null);
  const [selectedDriver, setSelectedDriver] = useState('');

  const SEARCH_API_URL = 'https://webdev.aut.ac.nz/~vpk8065/assign/part2/api/getBookings.php';
  const ASSIGN_API_URL = 'https://webdev.aut.ac.nz/~vpk8065/assign/part2/api/assignBooking.php';

  async function searchBookings(event) {
    event.preventDefault();
    setMessage(null);

    if (bookingRef !== '' && !/^BRN\d{5}$/.test(bookingRef)) {
      setMessage({ type: 'error', text: 'Invalid booking reference format. Example: BRN00001' });
      return;
    }

    const bodyData = new URLSearchParams({ bsearch: bookingRef });

    try {
      const response = await fetch(SEARCH_API_URL, {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: bodyData.toString(),
      });
      const data = await response.json();
      setBookings(data);
    } catch (error) {
      console.error(error);
      setMessage({ type: 'error', text: 'Server error occurred while searching bookings.' });
    }
  }

  async function assignBooking(reference) {
    if (selectedDriver === '') {
      setMessage({ type: 'error', text: 'Please select a driver before assigning a booking.' });
      return;
    }

    const bodyData = new URLSearchParams({ reference, driver_id: selectedDriver });

    try {
      const response = await fetch(ASSIGN_API_URL, {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: bodyData.toString(),
      });
      const data = await response.json();

      setMessage({ type: data.success ? 'success' : 'error', text: data.message });

      if (data.success) {
        setBookings((current) =>
          current.map((b) =>
            b.booking_ref === reference ? { ...b, status: 'assigned' } : b
          )
        );
      }
    } catch (error) {
      console.error(error);
      setMessage({ type: 'error', text: 'Server error occurred while assigning booking.' });
    }
  }

  return (
    <section className="admin-hero">
      <h2>Admin <span>Dashboard</span></h2>
      <p className="admin-subtitle">Manage and assign incoming booking requests</p>

      <div className="admin-controls">
        {/* Search card */}
        <div className="admin-card">
          <h3>Search Bookings</h3>
          <form onSubmit={searchBookings}>
            <label>Booking Reference Number</label>
            <input
              type="text"
              placeholder="Example: BRN00001"
              value={bookingRef}
              onChange={(e) => setBookingRef(e.target.value.trim())}
            />
            <button type="submit">Search Bookings</button>
          </form>
        </div>

        {/* Driver selector card */}
        <div className="admin-card">
          <h3>Select Driver</h3>
          <DriverSelector
            selectedDriver={selectedDriver}
            onDriverChange={setSelectedDriver}
          />
        </div>
      </div>

      {message && (
        <div className={message.type === 'success' ? 'success-box' : 'error-box'}
          style={{ marginBottom: '24px' }}>
          {message.text}
        </div>
      )}

      {/* Bookings table card */}
      <div className="table-card">
        <div className="table-card-header">
          <h3>Booking Requests</h3>
          {bookings.length > 0 && (
            <span className="booking-count">{bookings.length} result{bookings.length !== 1 ? 's' : ''}</span>
          )}
        </div>

        {bookings.length === 0 ? (
          <p className="table-empty">No booking requests found. Search above or leave blank to load all unassigned bookings.</p>
        ) : (
          <div className="table-container">
            <table>
              <thead>
                <tr>
                  <th>Reference</th>
                  <th>Customer</th>
                  <th>Phone</th>
                  <th>Pickup</th>
                  <th>Destination</th>
                  <th>Date & Time</th>
                  <th>Status</th>
                  <th>Assign</th>
                </tr>
              </thead>
              <tbody>
                {bookings.map((booking) => (
                  <tr key={booking.booking_ref}>
                    <td><strong>{booking.booking_ref}</strong></td>
                    <td>{booking.cname}</td>
                    <td>{booking.phone}</td>
                    <td>{booking.sbname}</td>
                    <td>{booking.dsbname}</td>
                    <td>{booking.pickup_date} {booking.pickup_time}</td>
                    <td>
                      <span className={`status-badge ${booking.status}`}>
                        {booking.status}
                      </span>
                    </td>
                    <td>
                      <button
                        className="assign-btn"
                        onClick={() => assignBooking(booking.booking_ref)}
                        disabled={booking.status === 'assigned'}
                      >
                        {booking.status === 'assigned' ? '✓ Assigned' : 'Assign'}
                      </button>
                    </td>
                  </tr>
                ))}
              </tbody>
            </table>
          </div>
        )}
      </div>
    </section>
  );
}

export default AdminDashboard;
