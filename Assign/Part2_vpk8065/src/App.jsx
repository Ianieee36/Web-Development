import { Routes, Route, Link, useLocation } from 'react-router-dom';
import Logo from './assets/Logo.png';
import BookingForm from './components/bookingForm';
import AdminDashboard from './components/adminDashboard';

function App() {
  const location = useLocation();
  const isHome = location.pathname === '/';  // ← use pathname, not hash

  return (
    <div>
      <nav className="navbar">
        <div className="navbar-brand">
          <img src={Logo} alt="CabsOnline Logo" className="navbar-logo" />
          <h1>CabsOnline</h1>
        </div>
        <div className="nav-links">

          {/* Only show Tracker on home page — no Booking link */}
          {isHome && (
            <>
            <button className="nav-btn" onClick={() => { const el = document.getElementById('tracker');
                if (el) el.scrollIntoView({ behavior: 'smooth' });
              }}
            > Tracker
            </button>
            <button className="nav-btn" onClick={() => document.getElementById('about')?.scrollIntoView({ behavior: 'smooth' })}>About</button>
            <button className="nav-btn" onClick={() => document.getElementById('contact')?.scrollIntoView({ behavior: 'smooth' })}>Contact</button>
          </>
          )}
        </div>
      </nav>

      <Routes>
        <Route path="/" element={<BookingForm />} />
        <Route path="/admin" element={<AdminDashboard />} />
      </Routes>
    </div>
  );
}

export default App;