<?php
require_once 'databaseConnection.php'; // Adjust path if needed
require_once 'fetch.php';
?>
<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>EventHub - Advanced Event Management & Ticketing</title>
  <style>
    :root {
      --primary: #3a86ff;
      --secondary: #ff006e;
      --success: #38b000;
      --danger: #d90429;
      --dark: #001219;
      --light: #f8f9fa;
      --gray: #6c757d;
      --gradient: linear-gradient(45deg, #3a86ff, #ff006e);
      --gradient-alt: linear-gradient(90deg, #833ab4, #fd1d1d, #fcb045);
      --shadow-light: rgba(58, 134, 255, 0.35);
      --shadow-secondary: rgba(255, 0, 110, 0.4);
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      scroll-behavior: smooth;
    }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      color: var(--dark);
      line-height: 1.6;
      background: #f0f4ff;
      background-image: radial-gradient(circle at top left, #a0caff33, transparent 70%),
        radial-gradient(circle at bottom right, #ff4e6d22, transparent 70%);
      -webkit-font-smoothing: antialiased;
      -moz-osx-font-smoothing: grayscale;
    }

    .container {
      width: 100%;
      max-width: 1280px;
      margin: 0 auto;
      padding: 0 20px;
    }

    /* Header */
    header {
      background: var(--gradient);
      color: white;
      padding: 1rem 0;
      box-shadow: 0 6px 25px var(--shadow-light);
      position: sticky;
      top: 0;
      z-index: 1100;
      backdrop-filter: saturate(180%) blur(10px);
      border-bottom: 2px solid rgba(255, 255, 255, 0.25);
      transition: background-color 0.3s ease;
    }

    header:hover {
      background: var(--gradient-alt);
    }

    .header-container {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .logo {
      font-size: 2rem;
      font-weight: 900;
      letter-spacing: 2px;
      font-family: 'Montserrat', sans-serif;
      text-shadow: 0 2px 6px var(--shadow-light);
      user-select: none;
      cursor: pointer;
      transition: color 0.3s ease;
    }

    .logo:hover {
      color: #ffd6e8;
      text-shadow: 0 3px 10px var(--shadow-secondary);
    }

    .nav-menu {
      display: flex;
      list-style: none;
      gap: 2rem;
    }

    .nav-item {
      display: flex;
      align-items: center;
    }

    .nav-link {
      color: white;
      text-decoration: none;
      font-weight: 600;
      font-size: 1rem;
      padding: 6px 12px;
      border-radius: 12px;
      transition: background-color 0.25s ease, color 0.25s ease, transform 0.25s ease;
      position: relative;
      overflow: hidden;
    }

    .nav-link::before {
      content: "";
      position: absolute;
      width: 100%;
      height: 100%;
      top: 0;
      left: -100%;
      background: rgba(255, 255, 255, 0.15);
      transition: left 0.3s ease;
      border-radius: 12px;
      z-index: 0;
    }

    .nav-link:hover {
      color: #fff;
      background-color: rgba(255, 255, 255, 0.2);
      transform: scale(1.05);
      z-index: 1;
    }

    .nav-link:hover::before {
      left: 0;
    }

    .btn {
      display: inline-block;
      padding: 0.6rem 1.8rem;
      border-radius: 50px;
      font-weight: 700;
      cursor: pointer;
      transition: all 0.3s ease;
      border: none;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
      user-select: none;
      text-align: center;
      text-decoration: none;
      font-family: 'Montserrat', sans-serif;
      letter-spacing: 0.05em;
    }

    .btn-primary {
      background: var(--gradient);
      color: white;
      box-shadow: 0 6px 20px var(--shadow-light);
    }

    .btn-primary:hover {
      background: linear-gradient(45deg, #255ec7, #c50055);
      box-shadow: 0 8px 25px var(--shadow-secondary);
      transform: translateY(-3px) scale(1.05);
    }

    .btn-secondary {
      background-color: var(--secondary);
      color: white;
      box-shadow: 0 6px 20px var(--shadow-secondary);
    }

    .btn-secondary:hover {
      background-color: #d50058;
      box-shadow: 0 8px 25px #ff3a8a99;
      transform: translateY(-3px) scale(1.05);
    }

    .btn-danger {
      background-color: var(--danger);
      color: white;
      box-shadow: 0 6px 20px #d90429cc;
    }

    .btn-danger:hover {
      background-color: #a50020;
      box-shadow: 0 8px 25px #d9042944;
      transform: translateY(-3px) scale(1.05);
    }

    /* Hero Section */
    .hero {
      background-image:
        linear-gradient(135deg, rgba(58, 134, 255, 0.85), rgba(255, 0, 110, 0.85)),
        url('/api/placeholder/1200/500');
      background-size: cover;
      background-position: center;
      color: #fff;
      text-align: center;
      padding: 6rem 1.5rem;
      box-shadow: inset 0 0 150px 20px rgba(0, 0, 0, 0.5);
      border-radius: 20px;
      max-width: 1000px;
      margin: 2rem auto 4rem;
      user-select: none;
    }

    .hero h1 {
      font-size: 3.6rem;
      font-weight: 900;
      letter-spacing: 0.1em;
      margin-bottom: 1.2rem;
      text-shadow: 0 4px 10px rgba(0, 0, 0, 0.7);
      animation: fadeInUp 1s ease forwards;
      opacity: 0;
    }

    .hero p {
      font-size: 1.3rem;
      max-width: 700px;
      margin: 0 auto 2.5rem;
      font-weight: 600;
      text-shadow: 0 3px 6px rgba(0, 0, 0, 0.5);
      animation: fadeInUp 1.3s ease forwards;
      opacity: 0;
    }

    .hero a.btn-primary {
      font-size: 1.1rem;
      padding: 0.75rem 2.5rem;
      box-shadow: 0 8px 25px var(--shadow-light);
      animation: fadeInUp 1.6s ease forwards;
      opacity: 0;
    }

    @keyframes fadeInUp {
      to {
        opacity: 1;
        transform: translateY(0);
      }

      from {
        opacity: 0;
        transform: translateY(25px);
      }
    }

    /* Featured Events Section */
    .section {
      padding: 5rem 0 6rem;
      background: white;
      border-radius: 20px;
      box-shadow: 0 15px 40px rgba(58, 134, 255, 0.1);
      margin-bottom: 4rem;
    }

    .section-header {
      text-align: center;
      margin-bottom: 4rem;
      user-select: none;
    }

    .section-title {
      font-size: 2.8rem;
      font-weight: 900;
      letter-spacing: 0.08em;
      color: var(--dark);
      margin-bottom: 1rem;
      text-transform: uppercase;
      background: linear-gradient(90deg, #ff006e, #3a86ff);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }

    .section-description {
      font-weight: 600;
      font-size: 1.1rem;
      color: var(--gray);
      max-width: 700px;
      margin: 0 auto;
    }

    /* Events Grid */
    .events-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
      gap: 2.8rem;
      justify-items: center;
      padding: 0 10px;
    }

    .event-card {
      background: linear-gradient(145deg, #ffffff, #f0f8ff);
      border-radius: 18px;
      overflow: hidden;
      box-shadow:
        0 2px 8px rgba(58,
  </style>
</head>

<body>
  <!-- Header Navigation -->

  <header>
    <div class="container header-container">
      <div class="logo">EventHub</div>
      <ul class="nav-menu">
        <li class="nav-item"><a href="#" class="nav-link">Home</a></li>
        <li class="nav-item"><a href="#events" class="nav-link">Events</a></li>
        <li class="nav-item"><a href="client_login.html" class="btn btn-secondary">Client Registration</a></li>

        <?php if (isset($_SESSION['username'])): ?>
          <li class="nav-item">
            <span class="nav-link">👋 <?= htmlspecialchars($_SESSION['username']) ?></span>
          </li>
          <li class="nav-item">
            <a href="logout.php" class="btn btn-danger">Logout</a>
          </li>
        <?php else: ?>
          <li class="nav-item">
            <a href="index.html" class="btn btn-secondary">Login</a>
          </li>
        <?php endif; ?>

        <li class="nav-item"><a href="admin.php" class="btn btn-secondary">ADMIN</a></li>
      </ul>
    </div>
  </header>

  <!-- Hero Section -->
  <section class="hero">
    <div class="container">
      <h1>Find Events That Match Your Passion</h1>
      <p>Discover and book tickets to the most exciting events happening around you, with real-time seat selection and
        AI-powered recommendations.</p>
      <a href="#events" class="btn btn-primary">Explore Events</a>
    </div>
  </section>

  <!-- Featured Events Section -->
  <section id="events" class="section">
    <div class="container">
      <div class="section-header">
        <h2 class="section-title">Featured Events</h2>
        <p class="section-description">Discover our handpicked selection of unmissable events that you'll love</p>
      </div>

      <!DOCTYPE html>
      <html lang="en">

      <head>
        <meta charset="UTF-8">
        <title>Approved Events</title>
      </head>

      <body>
        <h1>Approved Events</h1>

        <div style="display: flex; flex-wrap: wrap; gap: 20px;">
          <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
              <div
                style="width: 300px; background: #fff; border-radius: 10px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); overflow: hidden;">
                <div style="height: 150px; background: #ddd;">
                  <?php
                  $posterPath = htmlspecialchars($row['event_poster']);
                  if (!empty($posterPath) && file_exists($posterPath)):
                    ?>
                    <img src="<?= $posterPath ?>" alt="Event Poster" style="width: 100%; height: 100%; object-fit: cover;">
                  <?php endif; ?>
                </div>
                <div style="padding: 15px;">
                  <span
                    style="display: inline-block; background-color: #3b82f6; color: white; font-size: 12px; padding: 2px 10px; border-radius: 999px; margin-bottom: 10px;">
                    <?= htmlspecialchars($row['event_category'] ?? 'Event') ?>
                  </span>

                  <h3 style="font-size: 18px; font-weight: 700; margin: 5px 0;">
                    <?= htmlspecialchars($row['event_name']) ?>
                  </h3>

                  <p style="margin: 0; color: #555; font-size: 14px;">
                    <?= date("M j, Y", strtotime($row['event_date'])) ?> • <?= htmlspecialchars($row['start_time']) ?>
                  </p>
                  <p style="margin: 0 0 10px 0; color: #555; font-size: 14px;">
                    <?= htmlspecialchars($row['venue']) ?>
                  </p>

                  <p style="color: #e11d48; font-weight: bold; margin: 5px 0;">
                    From $<?= htmlspecialchars($row['event_price']) ?>
                  </p>
                  <a href="booking_page.php?id=<?php echo urlencode($row['id']); ?>"
                    style="display: inline-block; background-color: #3b82f6; color: white; padding: 8px 16px; border-radius: 6px; text-decoration: none; font-weight: 600;">
                    Book Now
                  </a>


                </div>
              </div>
            <?php endwhile; ?>
          <?php else: ?>
            <p>No approved events found.</p>
          <?php endif; ?>
        </div>



      </body>

      </html>

      <?php $conn->close(); ?>

    </div>
  </section>


  <!-- JavaScript for functionality -->
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      // Generate Seat Map
      const seatMap = document.getElementById('seatMap');
      const selectedSeatsElement = document.getElementById('selectedSeats');
      const totalPriceElement = document.getElementById('totalPrice');
      const bookButton = document.getElementById('bookButton');

      const rows = 4;
      const cols = 10;
      const seatPrices = {
        'A': 120,
        'B': 100,
        'C': 80,
        'D': 60
      };

      const selectedSeats = [];
      let totalPrice = 0;

      // Simulate some already booked seats
      const bookedSeats = ['A3', 'A4', 'B5', 'B6', 'C2', 'D8'];

      // Create seat map
      for (let row = 0; row < rows; row++) {
        const rowLetter = String.fromCharCode(65 + row); // A, B, C, D

        for (let col = 1; col <= cols; col++) {
          const seatId = ${ rowLetter }${ col };
          const seat = document.createElement('div');
          seat.className = 'seat';
          seat.textContent = seatId;

          // Check if seat is already booked
          if (bookedSeats.includes(seatId)) {
            seat.classList.add('seat-booked');
          } else {
            seat.classList.add('seat-available');

            // Add click event for available seats
            seat.addEventListener('click', function () {
              if (seat.classList.contains('seat-selected')) {
                // Deselect seat
                seat.classList.remove('seat-selected');
                seat.classList.add('seat-available');

                // Remove from selected seats
                const index = selectedSeats.indexOf(seatId);
                if (index > -1) {
                  selectedSeats.splice(index, 1);
                }

                // Subtract price
                totalPrice -= seatPrices[rowLetter];
              } else {
                // Select seat
                seat.classList.remove('seat-available');
                seat.classList.add('seat-selected');

                // Add to selected seats
                selectedSeats.push(seatId);

                // Add price
                totalPrice += seatPrices[rowLetter];
              }

              // Update booking summary
              if (selectedSeats.length > 0) {
                selectedSeatsElement.textContent = selectedSeats.join(', ');
                totalPriceElement.textContent = $${ totalPrice.toFixed(2) };
              } else {
                selectedSeatsElement.textContent = 'None';
                totalPriceElement.textContent = '$0.00';
              }
            });
          }

          seatMap.appendChild(seat);
        }
      }

      // Book button click handler
      bookButton.addEventListener('click', function () {
        if (selectedSeats.length === 0) {
          alert('Please select at least one seat to proceed.');
          return;
        }

        alert(Booking confirmed for seats: ${ selectedSeats.join(', ') }.Total: $${ totalPrice.toFixed(2) });

      // In a real application, this would redirect to a checkout page
      // or create a booking in the database
    });

    // AI Recommendations (simulated)
    const eventRecommendations = [
      { name: "Rock & Jazz Festival", match: 95 },
      { name: "Symphony Orchestra Concert", match: 88 },
      { name: "EDM Night", match: 82 }
    ];

    // Real-time updates simulation
    setInterval(() => {
      // Simulate a random seat being booked in real-time
      const availableSeats = Array.from(document.querySelectorAll('.seat-available'));
      if (availableSeats.length > 0) {
        const randomIndex = Math.floor(Math.random() * availableSeats.length);
        const randomSeat = availableSeats[randomIndex];

        if (!selectedSeats.includes(randomSeat.textContent)) {
          randomSeat.classList.remove('seat-available');
          randomSeat.classList.add('seat-booked');

          // Show notification
          const notification = document.createElement('div');
          notification.textContent = Seat ${ randomSeat.textContent } just got booked!;
          notification.style.position = 'fixed';
          notification.style.bottom = '20px';
          notification.style.right = '20px';
          notification.style.padding = '10px 20px';
          notification.style.backgroundColor = 'var(--primary)';
          notification.style.color = 'white';
          notification.style.borderRadius = '5px';
          notification.style.boxShadow = '0 3px 10px rgba(0, 0, 0, 0.2)';
          notification.style.zIndex = '1000';

          document.body.appendChild(notification);

          setTimeout(() => {
            notification.style.opacity = '0';
            notification.style.transition = 'opacity 0.5s';
            setTimeout(() => {
              document.body.removeChild(notification);
            }, 500);
          }, 3000);
        }
      }
    }, 30000); // Every 30 seconds
    });
  </script>
</body>

</html>