function AboutSection() {
  return (
    <section id="about">
      <div className="about-section">
        <div className="about-left">
          <h2>About <span>CabsOnline</span></h2>
          <p>CabsOnline is Auckland's most reliable on-demand cab service. Founded with a mission to make transportation simple, affordable, and accessible for everyone.</p>
          <p>With a fleet of professional drivers and a seamless booking experience, we're committed to getting you where you need to go — safely and on time.</p>
          <div className="about-stats">
            <div className="stat">
              <strong>500+</strong>
              <span>Happy Customers</span>
            </div>
            <div className="stat">
              <strong>50+</strong>
              <span>Professional Drivers</span>
            </div>
            <div className="stat">
              <strong>24/7</strong>
              <span>Available</span>
            </div>
          </div>
        </div>
        <div className="about-right">
          <div className="about-card">
            <div className="about-icon">🚕</div>
            <h3>Safe & Reliable</h3>
            <p>All drivers are fully licensed and vetted for your safety.</p>
          </div>
          <div className="about-card">
            <div className="about-icon">💰</div>
            <h3>Affordable Rates</h3>
            <p>Transparent pricing with no hidden fees. Know your fare before you ride.</p>
          </div>
          <div className="about-card">
            <div className="about-icon">📍</div>
            <h3>GPS Tracking</h3>
            <p>Track your booking in real time from pickup to destination.</p>
          </div>
        </div>
      </div>
    </section>
  );
}

export default AboutSection;