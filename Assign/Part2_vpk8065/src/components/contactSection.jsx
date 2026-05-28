function ContactSection() {
  return (
    <>
      <section id="contact">
        <div className="contact-section">
          <div className="contact-left">
            <h2>Get In <span>Touch</span></h2>
            <p>Have questions or need help with your booking? We're here for you 24/7.</p>
            <div className="contact-details">
              <div className="contact-item">
                <span className="contact-icon">📞</span>
                <div>
                  <strong>Phone</strong>
                  <p>0800 CABS ONLINE</p>
                </div>
              </div>
              <div className="contact-item">
                <span className="contact-icon">📧</span>
                <div>
                  <strong>Email</strong>
                  <p>support@cabsonline.co.nz</p>
                </div>
              </div>
              <div className="contact-item">
                <span className="contact-icon">📍</span>
                <div>
                  <strong>Location</strong>
                  <p>Auckland, New Zealand</p>
                </div>
              </div>
            </div>
          </div>
          <div className="contact-right">
            <div className="contact-card">
              <h3>Send Us a Message</h3>
              <div>
                <label>Your Name</label>
                <input type="text" placeholder="Enter your name" />
              </div>
              <div>
                <label>Email Address</label>
                <input type="email" placeholder="Enter your email" />
              </div>
              <div>
                <label>Message</label>
                <textarea placeholder="Type your message here..." rows="4"></textarea>
              </div>
              <button type="button">Send Message →</button>
            </div>
          </div>
        </div>
      </section>

      <footer className="footer">
        <p>© 2026 CabsOnline. All rights reserved. — Auckland, New Zealand</p>
      </footer>
    </>
  );
}

export default ContactSection;