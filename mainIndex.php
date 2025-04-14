<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>KitabiAdda | Coming Soon</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    body {
      font-family: 'Inter', sans-serif;
      height: 100vh;
      overflow: hidden;
      background: linear-gradient(-45deg, #f7c59f, #ef476f, #ffd166, #06d6a0);
      background-size: 400% 400%;
      animation: gradientBG 15s ease infinite;
      display: flex;
      justify-content: center;
      align-items: center;
      text-align: center;
      padding: 20px;
      color: #fff;
    }

    @keyframes gradientBG {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }

    .container {
      max-width: 800px;
      animation: fadeInUp 1.5s ease forwards;
      opacity: 0;
    }

    @keyframes fadeInUp {
      0% {
        opacity: 0;
        transform: translateY(50px);
      }
      100% {
        opacity: 1;
        transform: translateY(0);
      }
    }

    h1 {
      font-size: 3rem;
      margin-bottom: 20px;
      animation: fadeIn 2s ease forwards;
    }

    p {
      font-size: 1.2rem;
      line-height: 1.6;
      margin-bottom: 40px;
      animation: fadeIn 2.5s ease forwards;
    }

    @keyframes fadeIn {
      from { opacity: 0; }
      to { opacity: 1; }
    }

    .countdown {
      display: flex;
      justify-content: center;
      gap: 20px;
      margin-bottom: 40px;
      animation: fadeIn 3s ease forwards;
    }

    .countdown div {
      background: rgba(255, 255, 255, 0.1);
      padding: 20px;
      border-radius: 15px;
      min-width: 80px;
      font-size: 1.4rem;
      font-weight: bold;
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
      transition: transform 0.3s;
    }

    .countdown div:hover {
      transform: scale(1.05);
    }

    .countdown span {
      display: block;
      font-size: 2rem;
      color: #fff;
    }

    .newsletter {
      animation: fadeIn 3.5s ease forwards;
    }

    input[type="email"] {
      padding: 12px 18px;
      border-radius: 25px;
      border: none;
      outline: none;
      font-size: 1rem;
      width: 260px;
      max-width: 100%;
      margin-right: 10px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    }

    button {
      padding: 12px 20px;
      border-radius: 25px;
      background-color: #fff;
      color: #ef476f;
      font-weight: bold;
      font-size: 1rem;
      border: none;
      cursor: pointer;
      transition: background-color 0.3s ease, transform 0.2s ease;
    }

    button:hover {
      background-color: #ffe0e9;
      transform: scale(1.05);
    }

    @media (max-width: 600px) {
      h1 {
        font-size: 2.2rem;
      }
      .countdown {
        flex-direction: column;
        gap: 10px;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Our Website is under maintanance</h1>
    <p>We're back in just few days</p>

    <div class="countdown" id="countdown">
      <div><span id="days">00</span>Days</div>
      <div><span id="hours">00</span>Hours</div>
      <div><span id="minutes">00</span>Minutes</div>
      <div><span id="seconds">00</span>Seconds</div>
    </div>
    <p id="footer" class="text-sm text-white/60">
      Thank you for your patience and support.<br/>
      Stay tuned — the best of KitabiAdda is coming your way. 💙📚
    </p>
  </div>

  <script>
    const launchDate = new Date("April 16, 2025 00:00:00").getTime();
    const countdown = document.getElementById('countdown');

    const timer = setInterval(() => {
      const now = new Date().getTime();
      const distance = launchDate - now;

      const days = Math.floor(distance / (1000 * 60 * 60 * 24));
      const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
      const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
      const seconds = Math.floor((distance % (1000 * 60)) / 1000);

      document.getElementById("days").innerText = days;
      document.getElementById("hours").innerText = hours;
      document.getElementById("minutes").innerText = minutes;
      document.getElementById("seconds").innerText = seconds;

      if (distance < 0) {
        clearInterval(timer);
        countdown.innerHTML = "<h2>We're Live!</h2>";
      }
    }, 1000);
  </script>
</body>
</html>