<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Official Booking Voucher | Bin Saleem Umrah Taxi</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&family=Playfair+Display:wght@400;500;600&display=swap" rel="stylesheet"/>
    <style>
      /* Professional Color Scheme */
      :root {
        --primary-navy: #0a1a3a;
        --secondary-navy: #1a2f5a;
        --accent-gold: #c9a35e;
        --accent-light-gold: #e8d4b0;
        --light-bg: #f8fafc;
        --border-color: #e2e8f0;
        --text-primary: #1e293b;
        --text-secondary: #64748b;
        --success-green: #10b981;
        --warning-orange: #f59e0b;
      }

      /* Print Styles */
      @media print {
        @page {
          size: A4 portrait;
          margin: 0.25in;
        }

        body {
          margin: 0;
          padding: 0;
          background: white !important;
        }

        .voucher-container {
          box-shadow: none !important;
          border: 1px solid #ddd !important;
          margin: 0 !important;
          max-width: 100% !important;
          page-break-inside: avoid;
        }

        .no-print {
          display: none !important;
        }

        .watermark,
        .security-pattern {
          opacity: 0.1 !important;
        }
      }

      /* Base Styles */
      * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
      }

      body {
        font-family: "Montserrat", "Segoe UI", Roboto, sans-serif;
        line-height: 1.4;
        background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
        color: var(--text-primary);
        padding: 20px 10px;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
      }

      /* Voucher Container */
      .voucher-container {
        width: 100%;
        max-width: 900px;
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(10, 26, 58, 0.15);
        position: relative;
        border: 1px solid var(--border-color);
      }

      /* Security Background Pattern */
      .security-pattern {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-image: radial-gradient(
            circle at 25% 25%,
            rgba(201, 163, 94, 0.03) 2px,
            transparent 2px
          ),
          radial-gradient(
            circle at 75% 75%,
            rgba(10, 26, 58, 0.03) 2px,
            transparent 2px
          );
        background-size: 60px 60px;
        z-index: 0;
        pointer-events: none;
      }

      /* Header Section */
      .header-section {
        background: linear-gradient(
          135deg,
          var(--primary-navy) 0%,
          var(--secondary-navy) 100%
        );
        color: white;
        padding: 20px 20px 5px;
        position: relative;
        overflow: hidden;
      }

      .header-pattern {
        position: absolute;
        top: 0;
        right: 0;
        width: 300px;
        height: 100%;
        background: linear-gradient(
            45deg,
            transparent 49.5%,
            rgba(255, 255, 255, 0.03) 49.5%,
            rgba(255, 255, 255, 0.03) 50.5%,
            transparent 50.5%
          ),
          linear-gradient(
            -45deg,
            transparent 49.5%,
            rgba(255, 255, 255, 0.03) 49.5%,
            rgba(255, 255, 255, 0.03) 50.5%,
            transparent 50.5%
          );
        background-size: 20px 20px;
        opacity: 0.4;
      }

      /* Logo and Company Branding */
      .company-branding {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
        position: relative;
        z-index: 1;
      }

      .logo-container {
        width: 80px;
        height: 80px;
        background: white;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
        margin-right: 15px;
        flex-shrink: 0;
      }

      .logo-container img {
        max-width: 135%;
        max-height: 135%;
        object-fit: contain;
      }

      .company-info {
        flex-grow: 1;
      }

      .company-info h1 {
        font-family: "Playfair Display", serif;
        font-size: 28px;
        font-weight: 700;
        letter-spacing: -0.5px;
        margin-bottom: 5px;
        color: white;
      }

      .company-info .tagline {
        font-size: 14px;
        opacity: 0.9;
        font-weight: 400;
        letter-spacing: 0.5px;
      }

      /* Voucher Title Section */
      .voucher-title-section {
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: relative;
        z-index: 1;
        padding-top: 5px;
        border-top: 1px solid rgba(255, 255, 255, 0.15);
      }

      .voucher-title {
        font-size: 18px;
        font-weight: 600;
        color: white;
        position: relative;
        padding-left: 15px;
      }

      .voucher-title:before {
        content: "";
        position: absolute;
        left: 0;
        top: 4px;
        height: calc(100% - 8px);
        width: 4px;
        background: var(--accent-gold);
        border-radius: 3px;
      }

      .voucher-meta {
        text-align: right;
        background: rgba(255, 255, 255, 0.1);
        padding: 10px 15px;
        border-radius: 8px;
        backdrop-filter: blur(5px);
        border: 1px solid rgba(255, 255, 255, 0.15);
      }

      .booking-ref {
        font-size: 20px;
        font-weight: 800;
        letter-spacing: 1px;
        color: var(--accent-light-gold);
        margin-bottom: 3px;
      }

      .booking-date {
        font-size: 12px;
        opacity: 0.9;
      }

      /* QR Code Section */
      .qr-section {
        position: absolute;
        top: 15px;
        right: 30px;
        z-index: 2;
      }

      .qr-container {
        background: white;
        padding: 8px;
        border-radius: 8px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
        display: inline-block;
        text-align: center;
      }

      .qr-container img {
        width: 80px;
        height: 80px;
        display: block;
      }

      .qr-label {
        font-size: 10px;
        text-align: center;
        margin-top: 5px;
        color: var(--text-secondary);
        font-weight: 600;
      }

      /* Main Content */
      .main-content {
        padding: 25px 30px;
        position: relative;
        z-index: 1;
      }

      /* Section Styling */
      .section-block {
        margin-bottom: 20px;
      }

      .section-header {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
        padding-bottom: 10px;
        border-bottom: 1px solid var(--border-color);
      }

      .section-icon {
        background: linear-gradient(
          135deg,
          var(--primary-navy) 0%,
          var(--secondary-navy) 100%
        );
        width: 40px;
        height: 40px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 15px;
        color: white;
        font-size: 16px;
        box-shadow: 0 5px 15px rgba(10, 26, 58, 0.15);
      }

      .section-title {
        font-size: 18px;
        font-weight: 700;
        color: var(--primary-navy);
        flex-grow: 1;
      }

      /* Customer Info Grid */
      .info-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 15px 30px;
      }

      .info-item {
        margin-bottom: 10px;
      }

      .info-label {
        font-size: 12px;
        font-weight: 700;
        color: var(--text-secondary);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 5px;
        display: flex;
        align-items: center;
      }

      .info-label i {
        margin-right: 8px;
        color: var(--accent-gold);
        font-size: 12px;
      }

      .info-value {
        font-size: 15px;
        font-weight: 600;
        color: var(--text-primary);
        padding: 8px 0;
        border-bottom: 1px solid var(--border-color);
        min-height: 20px;
      }

      .highlight-value {
        color: var(--primary-navy);
        font-weight: 700;
        font-size: 16px;
      }

      /* Passenger Badges */
      .pax-section {
        display: flex;
        gap: 10px;
        margin-top: 10px;
        flex-wrap: wrap;
      }

      .pax-badge {
        background: var(--light-bg);
        border-radius: 20px;
        padding: 8px 15px;
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        font-weight: 600;
        border: 1px solid var(--border-color);
        transition: all 0.3s ease;
      }

      .pax-badge:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 10px rgba(10, 26, 58, 0.08);
      }

      .pax-count {
        background: var(--secondary-navy);
        color: white;
        width: 24px;
        height: 24px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: 700;
      }

      .total-badge {
        background: linear-gradient(
          135deg,
          var(--primary-navy) 0%,
          var(--secondary-navy) 100%
        );
        color: white;
        border: none;
      }

      .total-badge .pax-count {
        background: white;
        color: var(--primary-navy);
      }

      /* Transport Contact Highlight */
      .transport-highlight {
        background: linear-gradient(
          to right,
          rgba(10, 26, 58, 0.03) 0%,
          rgba(201, 163, 94, 0.03) 100%
        );
        border-left: 4px solid var(--accent-gold);
        padding: 15px 20px;
        border-radius: 0 10px 10px 0;
        margin: 20px 0;
        position: relative;
        overflow: hidden;
      }

      .transport-highlight:before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%230a1a3a' fill-opacity='0.03' fill-rule='evenodd'/%3E%3C/svg%3E");
        opacity: 0.4;
      }

      .transport-content {
        position: relative;
        z-index: 1;
      }

      .transport-label {
        font-size: 13px;
        font-weight: 700;
        color: var(--primary-navy);
        margin-bottom: 8px;
        display: flex;
        align-items: center;
      }

      .transport-label i {
        margin-right: 8px;
        color: var(--accent-gold);
      }

      .transport-details {
        display: flex;
        align-items: center;
        gap: 15px;
        flex-wrap: wrap;
        margin-bottom: 10px;
      }

      .contact-person {
        font-size: 18px;
        font-weight: 700;
        color: var(--primary-navy);
      }

      .contact-number {
        font-size: 20px;
        font-weight: 800;
        color: var(--accent-gold);
        letter-spacing: 0.5px;
        background: white;
        padding: 8px 15px;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(201, 163, 94, 0.15);
      }

      .contact-note {
        font-size: 13px;
        color: var(--text-secondary);
        margin-top: 8px;
        font-style: italic;
        line-height: 1.4;
      }

      /* Tables for Itinerary */
      .itinerary-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        margin-top: 8px;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
      }

      .itinerary-table th {
        background: linear-gradient(
          135deg,
          var(--primary-navy) 0%,
          var(--secondary-navy) 100%
        );
        padding: 12px 15px;
        text-align: left;
        font-size: 12px;
        font-weight: 700;
        color: white;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border: none;
      }

      .itinerary-table td {
        padding: 12px 15px;
        border-bottom: 1px solid var(--border-color);
        font-size: 13.5px;
        color: var(--text-primary);
        background: white;
      }

      .itinerary-table tr:last-child td {
        border-bottom: none;
      }

      .itinerary-table tr:hover td {
        background-color: var(--light-bg);
      }

      .hotel-name {
        font-weight: 700;
        color: var(--primary-navy);
      }

      .flight-code {
        font-weight: 700;
        color: var(--secondary-navy);
      }

      /* Status Badge */
      .status-badge {
        display: inline-flex;
        align-items: center;
        padding: 6px 15px;
        background: linear-gradient(
          135deg,
          var(--success-green) 0%,
          #34d399 100%
        );
        color: white;
        border-radius: 50px;
        font-weight: 700;
        font-size: 12px;
        letter-spacing: 0.5px;
        margin-top: 8px;
      }

      /* Notes Section */
      .notes-section {
        background: linear-gradient(135deg, #fff9ed 0%, #fff4e0 100%);
        border: 1px solid var(--accent-light-gold);
        border-radius: 10px;
        padding: 18px;
        margin-top: 20px;
        position: relative;
        overflow: hidden;
      }

      .notes-section:before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 6px;
        height: 100%;
        background: var(--accent-gold);
      }

      .notes-title {
        display: flex;
        align-items: center;
        margin-bottom: 12px;
        color: var(--primary-navy);
        font-weight: 700;
        font-size: 16px;
      }

      .notes-title i {
        margin-right: 10px;
        color: var(--accent-gold);
        font-size: 18px;
      }

      .notes-list {
        list-style-type: none;
      }

      .notes-list li {
        margin-bottom: 8px;
        padding-left: 25px;
        position: relative;
        font-size: 13px;
        color: var(--text-primary);
        line-height: 1.4;
      }

      .notes-list li:before {
        content: "✓";
        position: absolute;
        left: 0;
        top: 0;
        color: var(--accent-gold);
        font-weight: bold;
        font-size: 14px;
      }

      /* Footer */
      .footer-section {
        background: linear-gradient(
          135deg,
          var(--primary-navy) 0%,
          var(--secondary-navy) 100%
        );
        padding: 20px 30px;
        color: white;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
      }

      .footer-logo {
        font-family: "Playfair Display", serif;
        font-size: 20px;
        font-weight: 700;
        color: white;
      }

      .footer-contact {
        font-size: 13px;
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
      }

      .footer-contact i {
        color: var(--accent-light-gold);
        margin-right: 6px;
      }

      .footer-disclaimer {
        width: 100%;
        text-align: center;
        margin-top: 15px;
        font-size: 11px;
        opacity: 0.8;
        padding-top: 15px;
        border-top: 1px solid rgba(255, 255, 255, 0.15);
      }

      /* Print Button */
      .print-btn {
        position: fixed;
        bottom: 20px;
        right: 20px;
        background: linear-gradient(
          135deg,
          var(--primary-navy) 0%,
          var(--secondary-navy) 100%
        );
        color: white;
        border: none;
        padding: 12px 20px;
        border-radius: 50px;
        font-weight: 700;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 8px 20px rgba(10, 26, 58, 0.25);
        transition: all 0.3s ease;
        z-index: 100;
        font-size: 14px;
      }

      .print-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 25px rgba(10, 26, 58, 0.35);
      }

      /* Watermark */
      .watermark {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%) rotate(-45deg);
        font-size: 100px;
        opacity: 0.03;
        color: var(--primary-navy);
        font-weight: 900;
        pointer-events: none;
        z-index: 0;
        white-space: nowrap;
        font-family: "Playfair Display", serif;
      }

      /* Responsive */
      @media (max-width: 992px) {
        .info-grid {
          grid-template-columns: 1fr;
          gap: 15px;
        }

        .transport-details {
          flex-direction: column;
          align-items: flex-start;
          gap: 10px;
        }

        .watermark {
          font-size: 70px;
        }
      }

      @media (max-width: 768px) {
        body {
          padding: 10px 8px;
        }

        .header-section,
        .main-content,
        .footer-section {
          padding: 15px 20px;
        }

        .company-branding {
          flex-direction: column;
          align-items: flex-start;
          gap: 15px;
        }

        .logo-container {
          margin-right: 0;
          width: 60px;
          height: 60px;
        }

        .qr-section {
          position: relative;
          top: 0;
          right: 0;
          margin-top: 15px;
          margin-bottom: 15px;
        }

        .voucher-title-section {
          flex-direction: column;
          align-items: flex-start;
          gap: 15px;
        }

        .voucher-meta {
          width: 100%;
          text-align: left;
        }

        .footer-section {
          flex-direction: column;
          align-items: flex-start;
          gap: 15px;
        }

        .footer-contact {
          flex-direction: column;
          align-items: flex-start;
          gap: 8px;
        }

        .print-btn {
          bottom: 15px;
          right: 15px;
          padding: 10px 18px;
          font-size: 13px;
        }

        .watermark {
          font-size: 50px;
        }
      }

      /* Utility Classes */
      .text-center {
        text-align: center;
      }
      .text-right {
        text-align: right;
      }
      .mb-10 {
        margin-bottom: 10px;
      }
      .mb-20 {
        margin-bottom: 20px;
      }
      .mt-20 {
        margin-top: 20px;
      }
      .mt-30 {
        margin-top: 30px;
      }
    </style>
  </head>
  <body>
    <!-- Voucher Container -->
    <div class="voucher-container">
        <!-- Security Pattern Background -->
        <div class="security-pattern"></div>
        <!-- Watermark -->
        <div class="watermark">Bin-Saleem Umrah Taxi</div>

        <!-- Header Section -->
        <div class="header-section">
            <div class="header-pattern"></div>
            <!-- QR Code -->
            <div class="qr-section">
                <div class="qr-container">
                    <img src="{{ asset('images/QR.jpg') }}" alt="Booking QR Code" />
                    <div class="qr-label">SCAN TO VERIFY</div>
                </div>
            </div>

            <!-- Company Branding with Logo -->
            <div class="company-branding">
                <div class="logo-container">
                    <img src="{{ asset('images/logo-dark.png') }}" alt="Bin Saleem Logo"/>
                </div>
                <div class="company-info">
                    <h1>Bin-Saleem Umrah Taxi Service</h1>
                    <div class="tagline">
                        Premium Transport & Hotel Reservation Services
                    </div>
                    <div class="status-badge">
                        <i class="fas fa-check-circle"></i> CONFIRMED BOOKING
                    </div>
                </div>
            </div>

            <!-- Voucher Title Section -->
            <div class="voucher-title-section">
                <div class="voucher-title">OFFICIAL BOOKING VOUCHER</div>
                <div class="voucher-meta">
                    <div class="booking-ref">
                        REF: {{ optional($booking)->voucher_number }}
                    </div>
                    <div class="booking-date">
                        Date: {{ date('F d, Y') }}<br>
                        Booked By: Mr. {{ optional($booking->bookedBy)->name ?? 'N/A' }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">

            <!-- Customer Details Section -->
            <div class="section-block">
                <div class="section-header">
                    <div class="section-icon">
                        <i class="fas fa-user-tie"></i>
                    </div>
                    <div class="section-title">Customer Details</div>
                </div>

                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">
                            <i class="fas fa-user"></i> Customer Name
                        </div>
                        <div class="info-value highlight-value">
                            {{ optional($booking)->customer_name }}
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">
                                <i class="fas fa-phone"></i> Contact Number
                        </div>
                        <div class="info-value">
                            {{ optional($booking)->customer_contact }}
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-label">
                        <i class="fas fa-envelope"></i> Email
                        </div>
                    <div class="info-value">{{ $booking->customer_email ?? 'N/A' }}</div>
                </div>

                <div class="info-item">
                    <div class="info-label">
                        <i class="fas fa-map-marker-alt"></i> Pick-up Location
                    </div>
                    <div class="info-value">
                      {{ $booking->routeDetails->first()?->route?->from_location ?? 'N/A' }}
                      {{-- @foreach($booking->routeDetails as $detail)
                        <div class="info-value">
                            {{ $detail->route?->from_location }}
                        </div>
                      @endforeach --}}
                    </div>
                </div>
            </div>

            <!-- Passenger Details -->
            <div class="info-label mt-20">
                <i class="fas fa-user-friends"></i>Passenger Detail
            </div>
            <div class="pax-section">
                <div class="pax-badge">
                    <div class="pax-count">{{ $booking->adult_person }}</div>
                    <span>Adults</span>
                </div>
                <div class="pax-badge">
                <div class="pax-count">{{ $booking->child_person }}</div>
                <span>Children</span>
                </div>
                <div class="pax-badge">
                <div class="pax-count">{{ $booking->infant_person }}</div>
                <span>Infants</span>
                </div>
                <div class="pax-badge total-badge">
                <div class="pax-count">{{ $booking->number_of_pax }}</div>
                <span>Total Passengers</span>
                </div>
            </div>
            </div>
            
            <!-- Accommodation Details -->
            @if($booking->hotelDetails->count() > 0)
                <div class="section-block">
                    <div class="section-header">
                        <div class="section-icon">
                            <i class="fas fa-hotel"></i>
                        </div>
                        <div class="section-title">Accommodation Details ({{ $totalHotels }})</div>
                    </div>
                    <table class="itinerary-table">
                        <thead>
                            <tr>
                                <th>City</th>
                                <th>Hotel</th>
                                <th>Check-in</th>
                                <th>Check-out</th>
                                <th>Duration</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($booking->hotelDetails as $hotel)
                                <tr>
                                    <td><strong>{{ $hotel->city }}</strong></td>
                                    <td class="hotel-name">{{ $hotel->hotel_name }}</td>
                                    <td>{{ $hotel->check_in_date ? Carbon\Carbon::parse($hotel->check_in_date)->format('d M, Y') : 'N/A' }}</td>
                                    <td>{{ $hotel->check_out_date ? Carbon\Carbon::parse($hotel->check_out_date)->format('d M, Y') : 'N/A' }}</td>
                                    <td>{{ $hotel->duration ?? 'N/A' }} Nights</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                        {{-- <div class="text-right mt-20" style="font-size: 14px; color: var(--text-secondary)">
                                <i class="fas fa-clock"></i> Hotel Check-in: 3:00 PM | Check-out: 12:00 PM
                            </div> --}}
                </div>
            @endif

            <!-- Flight Details -->
            @if($booking->flightDetails->count() > 0)
            <div class="section-block">
                <div class="section-header">
                <div class="section-icon">
                    <i class="fas fa-plane"></i>
                </div>
                    <div class="section-title">Flight Schedule ({{ $totalFlights }})</div>
                </div>
                <table class="itinerary-table">
                    <thead>
                        <tr>
                            <th>Flight Code</th>
                            <th>From</th>
                            <th>To</th>
                            <th>Date</th>
                            <th>Departure</th>
                            <th>Arrival</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($booking->flightDetails as $flight)
                        <tr>
                            <td class="flight-code">{{ $flight->flight_code ?? 'N/A' }}</td>
                            <td>{{ $flight->flight_from ?? 'N/A' }}</td>
                            <td>{{ $flight->flight_to ?? 'N/A' }}</td>
                            <td>{{ $flight->flight_date ? Carbon\Carbon::parse($flight->flight_date)->format('d M, Y') : 'N/A' }}</td>
                            <td>{{ $flight->departure_time ?? 'N/A' }}</td>
                            <td>{{ $flight->arrival_time ?? 'N/A' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif

            <!-- Route & Vehicle Details -->
            @if($booking->routeDetails->count() > 0)
            <div class="section-block">
                <div class="section-header">
                    <div class="section-icon">
                        <i class="fas fa-route"></i>
                    </div>
                    <div class="section-title">Transport Details ({{ $totalRoutes }})</div>
                </div>
                <table class="itinerary-table">
                    <thead>
                        <tr>
                            <th>Pick & Drop</th>
                            <th>Pick Up Date</th>
                            <th>Pick Up Time</th>
                            <th>Vehicle</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($booking->routeDetails as $route)
                        <tr>
                          <td>{{ $route->route_name }}</td>
                          <td>{{ Carbon\Carbon::parse($route->pickup_date)->format('d M, Y') }}</td>
                          <td>{{ $route->pickup_time }}</td>
                          <td>{{ optional($route->vehicle)->name ?? 'N/A' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif

            <!-- Transport Contact -->
            <div class="transport-highlight">
                <div class="transport-content">
                    <div class="transport-label">
                        <i class="fas fa-car-alt"></i> Transportation Contact (Call Upon Arrival)
                    </div>
                    <div class="transport-details">
                        <div class="contact-person">
                            Mr. Hamza - Transportation Manager
                        </div>
                        <div class="contact-number">+966 59 555 7578</div>
                    </div>
                    <div class="contact-note">
                        Please contact our transportation staff immediately after landing
                        at Jeddah (JED) or Madinah (MED) airports for timely arrangements.
                    </div>
                </div>
            </div>

            <!-- Important Notes -->
            <div class="notes-section">
                <div class="notes-title">
                    <i class="fas fa-exclamation-circle"></i> Important Information & Conditions
                </div>
                <ul class="notes-list">
                    <li>
                        Guests must be ready for transportation at the specified times.
                        Delays caused by guest unavailability are not the responsibility of Bin Saleem Umrah Taxi.
                    </li>
                    <li>
                        Transportation may be delayed due to road closures for prayer times or interventions by Saudi authorities.
                    </li>
                    <li>
                        This voucher must be presented upon arrival at hotels and for all transportation services.
                    </li>
                    <li>All timings are in local Saudi time (GMT+3).</li>
                    <li>
                        Any changes to this itinerary must be requested through your tour operator at least 48 hours in advance.
                    </li>
                    <li>
                        Hotel rooms are subject to availability at the time of check-in.
                        Early check-in or late check-out requests are subject to additional charges.
                    </li>
                </ul>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer-section">
            <div class="footer-logo">BIN-SALEEM UMRAH TAXI</div>
            <div class="footer-contact">
                <div>
                    <i class="fas fa-headset"></i> Customer Service: +966 59 555 7578
                </div>
                <div><i class="fas fa-envelope"></i> info@binsaleem.com</div>
                <div><i class="fas fa-globe"></i> www.binsaleemtaxi.com</div>
            </div>
            <div class="footer-disclaimer">
                This is an official booking document. Electronic copy is valid for
                check-in. Generated on {{ date('F d, Y \a\t H:i') }} | Document ID: {{
                optional($booking)->voucher_number }} | Voucher Version: 2.1
            </div>
        </div>
    </div>

    <!-- Print Button -->
    <button class="print-btn no-print" onclick="window.print()">
      <i class="fas fa-print"></i> Print Voucher
    </button>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script>
      $(document).ready(function () {
        // Add subtle animation to elements
        $(".section-block, .transport-highlight, .notes-section").each(
          function (index) {
            $(this).css({
              opacity: "0",
              transform: "translateY(20px)",
            });

            setTimeout(() => {
              $(this).css({
                transition: "opacity 0.5s ease, transform 0.5s ease",
                opacity: "1",
                transform: "translateY(0)",
              });
            }, 100 + index * 100);
          }
        );

        // Add current date if not provided
        $(".booking-date").each(function () {
          const text = $(this).text();
          if (text.includes("{{")) {
            const now = new Date();
            const formattedDate = now.toLocaleDateString("en-US", {
              year: "numeric",
              month: "long",
              day: "numeric",
            });
            const validUntil = new Date(now);
            validUntil.setDate(validUntil.getDate() + 30);
            const validFormatted = validUntil.toLocaleDateString("en-US", {
              year: "numeric",
              month: "long",
              day: "numeric",
            });
            $(this).text(
              `Issued: ${formattedDate} | Valid until: ${validFormatted}`
            );
          }
        });

        // Add booking reference if not provided
        $(".booking-ref").each(function () {
          const text = $(this).text();
          if (text.includes("{{")) {
            const ref =
              "BST-" +
              new Date().getFullYear() +
              "-" +
              Math.floor(1000 + Math.random() * 9000);
            $(this).text(`REF: ${ref}`);
          }
        });

        // Enhance print functionality
        $(".print-btn").on("click", function () {
          const $btn = $(this);
          const originalHTML = $btn.html();

          // Add loading state
          $btn.html(
            '<i class="fas fa-spinner fa-spin"></i> Preparing for Print...'
          );
          $btn.prop("disabled", true);

          setTimeout(() => {
            window.print();

            // Restore button after print
            setTimeout(() => {
              $btn.html(originalHTML);
              $btn.prop("disabled", false);
            }, 500);
          }, 500);
        });

        // Add hover effect to print button
        $(".print-btn").hover(
          function () {
            $(this).css("transform", "translateY(-5px)");
            $(this).css("box-shadow", "0 15px 35px rgba(10, 26, 58, 0.35)");
          },
          function () {
            $(this).css("transform", "translateY(0)");
            $(this).css("box-shadow", "0 10px 30px rgba(10, 26, 58, 0.25)");
          }
        );

        // Add hover effect to passenger badges
        $(".pax-badge").hover(
          function () {
            if (!$(this).hasClass("total-badge")) {
              $(this).css("transform", "translateY(-3px)");
              $(this).css("box-shadow", "0 8px 15px rgba(10, 26, 58, 0.08)");
            }
          },
          function () {
            if (!$(this).hasClass("total-badge")) {
              $(this).css("transform", "translateY(0)");
              $(this).css("box-shadow", "none");
            }
          }
        );

        // Add hover effect to table rows
        $(".itinerary-table tbody tr").hover(
          function () {
            $(this).find("td").css("background-color", "#f8fafc");
          },
          function () {
            $(this).find("td").css("background-color", "white");
          }
        );

        // Update footer timestamp
        const now = new Date();
        const timestamp = now.toLocaleDateString("en-US", {
          year: "numeric",
          month: "long",
          day: "numeric",
          hour: "2-digit",
          minute: "2-digit",
        });

        const footerText = $(".footer-disclaimer").text();
        if (footerText.includes("{{")) {
          $(".footer-disclaimer").text(
            `This is an official booking document. Electronic copy is valid for check-in. 
                    Generated on ${timestamp} | Document ID: BST-${now.getFullYear()}-${Math.floor(
              1000 + Math.random() * 9000
            )} | Voucher Version: 2.1`
          );
        }
      });
    </script>
  </body>
</html>