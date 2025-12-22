<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Bin Saleem Umrah Taxi Service — Luxury Transfers in Saudi Arabia</title>
    <meta name="description"
          content="Premium Umrah taxi service offering luxury transfers between Jeddah, Makkah, and Madinah. Book Camry, Innova, HiAce, Staria, GMC, H1 with 24/7 support." />

    <!-- Preload Critical Resources -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Playfair+Display:wght@700;800&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/welcomeblade.css') }}">
</head>
<body data-theme="light">
<div class="container">

    {{-- ==================== HEADER ==================== --}}
    <header>
        <div class="header-inner">
            <div class="brand">
                <img src="{{ asset('images/logo-dark.jpg') }}" alt="Bin Saleem Umrah Taxi Service Logo" />
                <div class="brand-text">
                    <h1>Bin Saleem Umrah Taxi Service</h1>
                    <div class="tagline">Luxury Transfers • Saudi Arabia</div>
                </div>
            </div>

            <div class="header-right">
                <button class="theme-toggle" aria-label="Toggle Theme">
                    <span class="sun"><i class="bi bi-brightness-high-fill"></i></span>
                    <span class="moon"><i class="bi bi-moon-stars-fill"></i></span>
                </button>
                <button onclick="window.location.href='{{ route('login') }}'" class="admin-login">Admin</button>
            </div>

            <nav>
                <a href="#">Dashboard</a>
                <a href="#">Book Now</a>
                <a href="#">Fleet</a>
                <a href="#">Contact</a>
                <a class="cta" href="#book">Book Transfer</a>
            </nav>
        </div>
    </header>

    {{-- ==================== SLIDER ==================== --}}
    <div class="slider-container">
        <div class="slider">
            <div class="slide active">
                <img src="{{ asset('images/main slider.jpg') }}" alt="Luxury Transfer in Makkah" />
                <div class="slide-overlay">
                    <h2>Seamless Umrah Journeys</h2>
                    <p>Luxury transfers between Jeddah, Makkah & Madinah</p>
                </div>
            </div>

            <div class="slide slide-2">
                <img src="{{ asset('images/slider2.jpg') }}" alt="Premium Fleet" />
                <div class="slide-overlay">
                    <h2>Modern & Comfortable Fleet</h2>
                    <p>Camry • Innova • HiAce • Staria • GMC</p>
                </div>
            </div>

            <div class="slide slide-3">
                <img src="https://picsum.photos/1600/600?random=3" alt="24/7 Support" />
                <div class="slide-overlay">
                    <h2>24/7 Dedicated Support</h2>
                    <p>Instant booking • Real-time tracking • Meet & Greet</p>
                </div>
            </div>
        </div>

        <div class="slider-dots">
            <span class="dot active" onclick="currentSlide(0)"></span>
            <span class="dot" onclick="currentSlide(1)"></span>
            <span class="dot" onclick="currentSlide(2)"></span>
        </div>
    </div>

    {{-- ==================== HERO ==================== --}}
    <section class="hero">
        <div class="hero-content">
            <h2>Premium Umrah Transfers Across Saudi Arabia</h2>
            <p>Experience seamless, luxury transportation between Jeddah, Makkah, and Madinah with professional drivers,
                modern vehicles, and 24/7 dedicated support.</p>

            <div class="features">
                <div class="feature-item"><div class="feature-icon">✓</div>Modern Fleet: Camry, Innova, HiAce, Staria, GMC, H1</div>
                <div class="feature-item"><div class="feature-icon">✓</div>Airport Meet & Greet with Flight Tracking</div>
                <div class="feature-item"><div class="feature-icon">✓</div>Transparent Pricing — No Hidden Fees</div>
                <div class="feature-item"><div class="feature-icon">✓</div>English-Speaking Professional Drivers</div>
            </div>

            <div class="hero-actions">
                <a href="#fleet" class="btn btn-outline">Explore Fleet</a>
                <a href="#book" class="btn btn-primary">Book Your Ride</a>
                <div class="contact-badge">Call: +92317 7211074</div>
            </div>
        </div>

        {{-- ==================== BOOKING CARD ==================== --}}
        <aside class="booking-card" id="book">
            <h3>Instant Booking</h3>
            <p class="subtitle">Select vehicle and route — get confirmed in 60 seconds.</p>

            <form id="quick-book" onsubmit="return false">
                @csrf
                <div class="form-group">
                    <label for="vehicle">Vehicle Type</label>
                    <select id="vehicle" class="form-control">
                        <option value="">— Select Vehicle —</option>
                        <option value="camry">Toyota Camry — 4 Seats (Executive)</option>
                        <option value="GMC">GMC Yukon — 7 Seats (Executive)</option>
                        <option value="innova">Toyota Innova — 7 Seats (Family)</option>
                        <option value="hiace">Toyota HiAce — 10 Seats (Group)</option>
                        <option value="staria">Hyundai Staria — 8 Seats (Premium Van)</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="pickup">Pickup Location</label>
                    <input type="text" id="pickup" class="form-control"
                           placeholder="e.g., Jeddah King Abdulaziz Airport"/>
                </div>

                <div class="form-group">
                    <label for="dropoff">Dropoff Location</label>
                    <input type="text" id="dropoff" class="form-control"
                           placeholder="e.g., Hilton Makkah Convention Hotel"/>
                </div>

                <button type="submit" class="btn-book" id="bookBtn">Book Now</button>
                <div id="book-msg" role="alert" aria-live="polite"></div>
            </form>
        </aside>
    </section>

    {{-- ==================== FLEET ==================== --}}
    <section id="fleet">
        <h2 class="section-title">Our Luxury Fleet</h2>
        <p class="section-subtitle">Choose from our meticulously maintained vehicles for comfort, safety, and style.</p>

        <div class="fleet-grid">
            <!-- Camry -->
            <article class="fleet-card">
                <img src="{{ asset('images/camry.jpg') }}" alt="Toyota Camry" />
                <div class="fleet-card-body">
                    <h3>Toyota Camry</h3>
                    <div class="fleet-meta">
                        <span class="meta-item">4 Seats</span>
                        <span class="meta-item">2 Large Bags</span>
                        <span class="meta-item">WiFi</span>
                        <span class="meta-item">AC</span>
                    </div>
                    <a href="#book" class="btn book-now" data-vehicle="Camry">Book Camry</a>
                </div>
            </article>

            <!-- Innova -->
            <article class="fleet-card">
                <img src="{{ asset('images/innova.jpg') }}" alt="Toyota Innova" />
                <div class="fleet-card-body">
                    <h3>Toyota Innova</h3>
                    <div class="fleet-meta">
                        <span class="meta-item">7 Seats</span>
                        <span class="meta-item">5 Bags</span>
                        <span class="meta-item">Child Seat</span>
                        <span class="meta-item">Spacious</span>
                    </div>
                    <a href="#book" class="btn book-now" data-vehicle="Innova">Book Innova</a>
                </div>
            </article>

            <!-- HiAce -->
            <article class="fleet-card">
                <img src="{{ asset('images/hiace.jpg') }}" alt="Toyota HiAce" />
                <div class="fleet-card-body">
                    <h3>Toyota HiAce</h3>
                    <div class="fleet-meta">
                        <span class="meta-item">10 Seats</span>
                        <span class="meta-item">10 Bags</span>
                        <span class="meta-item">Group Travel</span>
                        <span class="meta-item">Extra Legroom</span>
                    </div>
                    <a href="#book" class="btn book-now" data-vehicle="HiAce">Book HiAce</a>
                </div>
            </article>

            <!-- Staria -->
            <article class="fleet-card">
                <img src="{{ asset('images/staria.jpg') }}" alt="Hyundai Staria" />
                <div class="fleet-card-body">
                    <h3>Hyundai Staria</h3>
                    <div class="fleet-meta">
                        <span class="meta-item">8 Seats</span>
                        <span class="meta-item">8 Bags</span>
                        <span class="meta-item">Panoramic Roof</span>
                        <span class="meta-item">Premium Interior</span>
                    </div>
                    <a href="#book" class="btn book-now" data-vehicle="Staria">Book Staria</a>
                </div>
            </article>

            <!-- GMC -->
            <article class="fleet-card">
                <img src="{{ asset('images/gmc.jpg') }}" alt="GMC Yukon" />
                <div class="fleet-card-body">
                    <h3>GMC Yukon</h3>
                    <div class="fleet-meta">
                        <span class="meta-item">7 Seats</span>
                        <span class="meta-item">4 Bags</span>
                        <span class="meta-item">AC Chilled</span>
                        <span class="meta-item">Premium Interior</span>
                    </div>
                    <a href="#book" class="btn book-now" data-vehicle="GMC">Book GMC Yukon</a>
                </div>
            </article>
        </div>
    </section>

    {{-- ==================== WHY CHOOSE US ==================== --}}
    <section class="why-choose-section">
        <h2 class="section-title">Why Choose Us</h2>
        <div class="why-grid">
            <div class="why-box"><i class="bi bi-clock-history why-icon"></i><h3>24/7 Taxi Service</h3><p>We operate non-stop around the clock for all your Umrah / travel needs.</p></div>
            <div class="why-box"><i class="bi bi-shield-check why-icon"></i><h3>Safe & Reliable Drivers</h3><p>Professional licensed drivers with excellent safety record & experience.</p></div>
            <div class="why-box"><i class="bi bi-chat-dots why-icon"></i><h3>Easy Online & WhatsApp Booking</h3><p>Very simple booking flow with fast communication response.</p></div>
            <div class="why-box"><i class="bi bi-car-front why-icon"></i><h3>Modern Luxury Fleet</h3><p>Latest model cars, clean, comfortable and UAE/KSA executive level standard.</p></div>
            <div class="why-box"><i class="bi bi-airplane why-icon"></i><h3>Airport Pickup & Drop</h3><p>We serve all Saudi major airports with pre-booked fast arrivals support.</p></div>
            <div class="why-box"><i class="bi bi-lightning why-icon"></i><h3>Instant Quick Support</h3><p>Our support team is active and ready for any assistance required.</p></div>
        </div>
    </section>

    {{-- ==================== POPULAR ROUTES ==================== --}}
    <section>
        <h2 class="section-title">Popular Routes</h2>
        <p class="section-subtitle">Fixed-price transfers with no surge pricing — book with confidence.</p>

        <div class="routes-grid">
            <div class="route-card">
                <img src="{{ asset('images/route1.jpg') }}" alt="Jeddah to Makkah" />
                <div class="route-body"><strong>Jeddah Airport → Makkah Hotel</strong><div class="price">300 SR</div><a href="#book" class="btn">Book Now</a></div>
            </div>

            <div class="route-card">
                <img src="{{ asset('images/route2.jpg') }}" alt="Makkah to Madinah" />
                <div class="route-body"><strong>Makkah → Madinah Hotel</strong><div class="price">800 SR</div><a href="#book" class="btn">Book Long Trip</a></div>
            </div>

            <div class="route-card">
                <img src="{{ asset('images/route3.jpeg') }}" alt="Airport Pickup" />
                <div class="route-body"><strong>Jeddah Airport → Madinah</strong><div class="price">1,000 SR</div><a href="#book" class="btn">Book Direct</a></div>
            </div>
        </div>
    </section>

    {{-- ==================== FAQ ==================== --}}
    <section class="faq-section">
        <h2 class="section-title">Frequently Asked Questions</h2>
        <details open><summary>Do you offer meet-and-greet service at the airport?</summary><p>Yes. Your driver will track your flight, meet you at arrivals with a name sign, and assist with luggage. No extra charge.</p></details>
        <details><summary>Can I pay online or with cash?</summary><p>Both options available. Pay securely online via card, Apple Pay, or STC Pay. Cash payment to driver is also accepted.</p></details>
        <details><summary>Are child seats available?</summary><p>Yes, we provide child and booster seats free of charge. Please request during booking.</p></details>
        <details><summary>What if my flight is delayed?</summary><p>We monitor all flights in real-time. Your driver will adjust pickup time automatically — no extra fees.</p></details>
    </section>

    {{-- ==================== HOW IT WORKS ==================== --}}
    <section class="process-section">
        <h2 class="section-title">How It Works</h2>
        <ol class="process-list">
            <li><strong>Choose Your Vehicle</strong> Select from our luxury fleet and enter pickup/dropoff locations.</li>
            <li><strong>Enter Passenger Details</strong> Add names, flight info, and any special requests.</li>
            <li><strong>Secure Payment</strong> Pay online or choose cash. Instant confirmation via WhatsApp & email.</li>
            <li><strong>Meet Your Driver</strong> Professional driver arrives on time. Track in real-time via link.</li>
        </ol>
    </section>

    {{-- ==================== REVIEWS ==================== --}}
    <section class="reviews-section" aria-label="Customer reviews">
        <div class="container">
            <h2 class="section-title">What Our Customers Say</h2>
            <p class="section-subtitle">Real feedback from our Umrah & travel customers — trusted transfers across Saudi Arabia.</p>

            <div class="reviews-wrap" id="reviewsWrap">
                <button class="rev-nav rev-prev" aria-label="Previous review"><i class="bi bi-chevron-left"></i></button>

                <div class="reviews-viewport" id="reviewsViewport" tabindex="0" aria-live="polite">
                    <div class="reviews-track" id="reviewsTrack">
                        {{-- Review 1 --}}
                        <article class="review-card">
                            <div class="rev-head">
                                <div class="rev-avatar">AH</div>
                                <div class="rev-meta"><strong>Ahmed H.</strong><span class="rev-loc">Jeddah, Saudi Arabia</span>
                                    <div class="rev-stars" aria-hidden="true"><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i></div>
                                </div>
                            </div>
                            <p class="rev-text">Driver arrived before time, assisted with luggage and the car was spotless. Smooth ride from the airport to our hotel — highly recommended.</p>
                            <div class="rev-footer">Booked: Jeddah → Makkah • 5 Mar 2025</div>
                        </article>

                        {{-- Review 2 --}}
                        <article class="review-card">
                            <div class="rev-head">
                                <div class="rev-avatar">SM</div>
                                <div class="rev-meta"><strong>Sara M.</strong><span class="rev-loc">Madinah, Saudi Arabia</span>
                                    <div class="rev-stars" aria-hidden="true"><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i></div>
                                </div>
                            </div>
                            <p class="rev-text">Excellent service and clear communication via WhatsApp. The price was fair and there were no surprises.</p>
                            <div class="rev-footer">Booked: Madinah Airport Pickup • 12 Apr 2025</div>
                        </article>

                        {{-- ... (the rest of the reviews – copy-paste the original HTML) ... --}}
                        {{-- For brevity I’m showing only two; paste the rest exactly as in your original file --}}
                    </div>
                </div>

                <button class="rev-nav rev-next" aria-label="Next review"><i class="bi bi-chevron-right"></i></button>
            </div>
        </div>
    </section>

    {{-- ==================== FOOTER ==================== --}}
<footer class="site-footer">
    <div class="footer-top">
        <div class="footer-container">
            <div class="footer-section main-info">
                <div class="footer-brand">
                    <img src="{{ asset('images/logo-dark.jpg') }}" alt="Bin Saleem Umrah Taxi Service Logo" class="footer-logo" />
                    <div class="footer-brand-text">
                        <h3>Bin Saleem Umrah Taxi Service</h3>
                        <p class="tagline">Luxury Transfers Across Saudi Arabia</p>
                    </div>
                </div>
                <p class="footer-description">Providing premium 24/7 private taxi services for Umrah pilgrims, tourists, and families with safety, comfort, and reliability.</p>
                
                <div class="trust-badges">
                    <div class="badge">
                        <i class="bi bi-shield-check"></i>
                        <span>Licensed & Insured</span>
                    </div>
                    <div class="badge">
                        <i class="bi bi-star-fill"></i>
                        <span>5-Star Rated</span>
                    </div>
                    <div class="badge">
                        <i class="bi bi-clock-history"></i>
                        <span>24/7 Service</span>
                    </div>
                </div>
            </div>

            <div class="footer-section quick-links">
                <h4>Quick Links</h4>
                <ul class="footer-links">
                    <li><a href="{{ url('/') }}"><i class="bi bi-house-door"></i> Home</a></li>
                    <li><a href="#book"><i class="bi bi-calendar-check"></i> Book Now</a></li>
                    <li><a href="#fleet"><i class="bi bi-car-front"></i> Our Fleet</a></li>
                    <li><a href="#"><i class="bi bi-geo-alt"></i> Popular Routes</a></li>
                    <li><a href="#"><i class="bi bi-question-circle"></i> FAQ</a></li>
                    <li><a href="#"><i class="bi bi-person"></i> About Us</a></li>
                </ul>
            </div>

            <div class="footer-section contact-info">
                <h4>Contact Information</h4>
                <div class="contact-details">
                    <div class="contact-item">
                        <i class="bi bi-geo-alt-fill"></i>
                        <div>
                            <strong>Office Address:</strong>
                            <p>65-B Street Mecca, Makkah, Saudi Arabia</p>
                        </div>
                    </div>
                    <div class="contact-item">
                        <i class="bi bi-telephone-fill"></i>
                        <div>
                            <strong>Phone Numbers:</strong>
                            <p>+966 50 123 4567</p>
                            <p>+923 17 721 1074</p>
                        </div>
                    </div>
                    <div class="contact-item">
                        <i class="bi bi-envelope-fill"></i>
                        <div>
                            <strong>Email:</strong>
                            <p>info@binsaleemumrahtaxi.com</p>
                            <p>bookings@binsaleemumrahtaxi.com</p>
                        </div>
                    </div>
                    <div class="contact-item">
                        <i class="bi bi-clock-fill"></i>
                        <div>
                            <strong>Business Hours:</strong>
                            <p>24/7 - 365 Days</p>
                            <p>Instant WhatsApp Response</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="footer-section newsletter">
                <h4>Newsletter</h4>
                <p>Subscribe for special offers and Umrah travel tips</p>
                <form class="newsletter-form">
                    <div class="input-group">
                        <input type="email" placeholder="Your email address" required />
                        <button type="submit" class="btn-subscribe">
                            <i class="bi bi-send-fill"></i>
                        </button>
                    </div>
                    <p class="privacy-note">We respect your privacy. Unsubscribe anytime.</p>
                </form>
                
                <div class="emergency-contact">
                    <div class="emergency-badge">
                        <i class="bi bi-telephone-plus"></i>
                        <div>
                            <strong>Emergency Support</strong>
                            <p>+923 17 721 1074</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="footer-middle">
        <div class="footer-container">
            <div class="social-section">
                <h5>Follow Us</h5>
                <div class="social-links">
                    <a href="https://wa.me/923177211074" class="social-link whatsapp" target="_blank" aria-label="WhatsApp">
                        <i class="bi bi-whatsapp"></i>
                        <span>WhatsApp</span>
                    </a>
                    <a href="https://facebook.com/binsaleemumrahtaxi" class="social-link facebook" target="_blank" aria-label="Facebook">
                        <i class="bi bi-facebook"></i>
                        <span>Facebook</span>
                    </a>
                    <a href="https://twitter.com/binsaleemtaxi" class="social-link twitter" target="_blank" aria-label="Twitter">
                        <i class="bi bi-twitter-x"></i>
                        <span>Twitter</span>
                    </a>
                    <a href="https://instagram.com/binsaleemumrahtaxi" class="social-link instagram" target="_blank" aria-label="Instagram">
                        <i class="bi bi-instagram"></i>
                        <span>Instagram</span>
                    </a>
                    <a href="https://linkedin.com/company/binsaleemumrahtaxi" class="social-link linkedin" target="_blank" aria-label="LinkedIn">
                        <i class="bi bi-linkedin"></i>
                        <span>LinkedIn</span>
                    </a>
                    <a href="https://youtube.com/@binsaleemumrahtaxi" class="social-link youtube" target="_blank" aria-label="YouTube">
                        <i class="bi bi-youtube"></i>
                        <span>YouTube</span>
                    </a>
                </div>
            </div>
            
            <div class="payment-methods">
                <h5>We Accept</h5>
                <div class="payment-icons">
                    <div class="payment-icon" title="Cash">
                        <i class="bi bi-cash"></i>
                    </div>
                    <div class="payment-icon" title="Credit Card">
                        <i class="bi bi-credit-card"></i>
                    </div>
                    <div class="payment-icon" title="Apple Pay">
                        <i class="bi bi-apple"></i>
                    </div>
                    <div class="payment-icon" title="STC Pay">
                        <span class="stc-pay">STC Pay</span>
                    </div>
                    <div class="payment-icon" title="Mada">
                        <span class="mada">مدى</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <div class="footer-container">
            <div class="copyright">
                <p>&copy; {{ date('Y') }} Bin Saleem Umrah Taxi Service. All Rights Reserved.</p>
                <p class="vat">VAT Registration Number: 310456789100003</p>
            </div>
            
            <div class="legal-links">
                <a href="#">Privacy Policy</a>
                <span class="separator">•</span>
                <a href="#">Terms & Conditions</a>
                <span class="separator">•</span>
                <a href="#">Cookie Policy</a>
                <span class="separator">•</span>
                <a href="#">Cancellation Policy</a>
                <span class="separator">•</span>
                <a href="#">Sitemap</a>
            </div>
            
            <div class="certifications">
                <span class="cert-badge">
                    <i class="bi bi-patch-check-fill"></i>
                    Ministry of Transport Licensed
                </span>
                <span class="cert-badge">
                    <i class="bi bi-shield-fill-check"></i>
                    Verified Service Provider
                </span>
            </div>
        </div>
    </div>
</footer>

</div>

{{-- ==================== WHATSAPP FLOATING BUTTON ==================== --}}
<div class="whatsapp-float">
    <a href="https://wa.me/923177211074?text=Hi!%20I'd%20like%20to%20book%20a%20transfer." target="_blank"
       class="whatsapp-btn" aria-label="Chat on WhatsApp"
       style="display:inline-flex;align-items:center;gap:8px;text-decoration:none;background:#25d366;color:white;padding:10px 16px;border-radius:24px;font-weight:600;font-size:16px;">
        <i class="bi bi-whatsapp" style="font-size:22px"></i>
    </a>
</div>

{{-- ==================== JAVASCRIPT (unchanged) ==================== --}}
<script>
    // === THEME TOGGLE ===
    const themeToggle = document.querySelector(".theme-toggle");
    const body = document.body;
    const savedTheme = localStorage.getItem("theme") || "light";
    body.setAttribute("data-theme", savedTheme);

    themeToggle.addEventListener("click", () => {
        const current = body.getAttribute("data-theme");
        const newTheme = current === "dark" ? "light" : "dark";
        body.setAttribute("data-theme", newTheme);
        localStorage.setItem("theme", newTheme);
    });

    // === ADMIN PANEL ACCESS ===
    // function openAdmin() {
    //     const pass = prompt("Enter Admin Password:");
    //     if (pass === "admin123") {
    //         window.location.href = "{{ route('login') }}";
    //     } else {
    //         alert("Incorrect password.");
    //     }
    // }

    // === VEHICLE PREFILL ===
    document.querySelectorAll(".book-now").forEach(btn => {
        btn.addEventListener("click", e => {
            e.preventDefault();
            const vehicle = btn.dataset.vehicle;
            const select = document.getElementById("vehicle");
            const option = Array.from(select.options).find(opt =>
                opt.text.toLowerCase().includes(vehicle.toLowerCase())
            );
            if (option) {
                select.value = option.value;
                document.getElementById("pickup").focus();
                document.getElementById("book").scrollIntoView({behavior: "smooth"});
            }
        });
    });

    // === BOOKING SIMULATION (you can replace with real AJAX later) ===
    document.getElementById("bookBtn").addEventListener("click", () => {
        const vehicle = document.getElementById("vehicle").value;
        const pickup = document.getElementById("pickup").value.trim();
        const dropoff = document.getElementById("dropoff").value.trim();
        const msg = document.getElementById("book-msg");

        if (!vehicle || !pickup || !dropoff) {
            msg.textContent = "Please complete all fields.";
            msg.style.color = "#d32f2f";
            return;
        }

        msg.style.color = "var(--primary)";
        msg.textContent = "Processing your booking...";

        setTimeout(() => {
            msg.innerHTML = "Booking Confirmed! <br>Driver details sent to WhatsApp.";
            msg.style.color = "#2e7d32";
        }, 1400);
    });

    // === AUTO SLIDER ===
    let slideIndex = 0;
    const slides = document.querySelectorAll(".slide");
    const dots = document.querySelectorAll(".dot");
    const totalSlides = slides.length;

    function showSlide(n) {
        slideIndex = (n + totalSlides) % totalSlides;
        const slider = document.querySelector(".slider");
        slider.style.transform = `translateX(-${slideIndex * 100}%)`;
        dots.forEach((dot, i) => dot.classList.toggle("active", i === slideIndex));
    }

    function currentSlide(n) { showSlide(n); }

    let autoSlide = setInterval(() => showSlide(slideIndex + 1), 3000);

    document.querySelector(".slider-container").addEventListener("mouseenter", () => clearInterval(autoSlide));
    document.querySelector(".slider-container").addEventListener("mouseleave", () => {
        autoSlide = setInterval(() => showSlide(slideIndex + 1), 3000);
    });
    showSlide(0);

    // === INFINITE REVIEWS SCROLL ===
    (function () {
        const track = document.getElementById("reviewsTrack");
        track.innerHTML = track.innerHTML + track.innerHTML; // duplicate
        let x = 0;
        const speed = 0.4;

        function animate() {
            x -= speed;
            if (Math.abs(x) >= track.scrollWidth / 2) x = 0;
            track.style.transform = `translateX(${x}px)`;
            requestAnimationFrame(animate);
        }
        animate();
    })();
</script>
</body>
</html>