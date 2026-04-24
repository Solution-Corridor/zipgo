<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
  @include('user.includes.general_style')
  <title>Coming Soon</title>

  <!-- Optional: Add if not already in general_style -->
  <style>
    :root {
      --primary: #00f0ff;     /* cyan/neon */
      --accent: #7c3aed;      /* indigo/violet */
      --dark: #0A0A0F;
      --darker: #06060A;
    }

    body {
      background: linear-gradient(to bottom, var(--dark), var(--darker));
    }

    .glow-text {
      text-shadow: 0 0 20px rgba(0, 240, 255, 0.6), 0 0 40px rgba(124, 58, 237, 0.4);
    }

    .neon-border {
      border: 1px solid rgba(0, 240, 255, 0.2);
      box-shadow: 0 0 25px rgba(0, 240, 255, 0.15);
    }

    @keyframes pulse {
      0%, 100% { opacity: 0.7; }
      50% { opacity: 1; }
    }

    .pulse-glow {
      animation: pulse 4s infinite ease-in-out;
    }

    /* Simple typing animation */
    .typing {
      overflow: hidden;
      border-right: 3px solid var(--primary);
      white-space: nowrap;
      animation: typing 3.5s steps(40, end) forwards, blink 0.75s step-end infinite;
    }

    @keyframes typing {
      from { width: 0; }
      to { width: 100%; }
    }

    @keyframes blink {
      from, to { border-color: transparent; }
      50% { border-color: var(--primary); }
    }
  </style>
</head>

<body class="min-h-screen bg-[#0A0A0F] text-white font-sans">

  <!-- Mobile-like container -->
  <div class="mx-auto max-w-[420px] min-h-screen bg-[#0A0A0F] shadow-2xl shadow-black/50 relative overflow-hidden">

    <!-- Top Greeting + Notification / Add -->
    @include('user.includes.top_greetings')

    <!-- Main Coming Soon Content -->
    <main class="flex flex-col items-center justify-center px-6 py-16 text-center flex-grow">
      
      <!-- Big Headline -->
      <h1 class="text-5xl md:text-7xl font-extrabold tracking-tight glow-text text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 via-blue-500 to-indigo-600 pulse-glow mb-6">
        Coming Soon
      </h1>

      <!-- Subtitle with typing effect -->
      <p class="text-xl md:text-2xl text-cyan-300/90 mb-10 typing max-w-md">
        Something awesome is in the works...
      </p>

      <!-- Countdown (example: 30 days from now) -->
      <div class="grid grid-cols-4 gap-4 mb-12 w-full max-w-xs">
        <div class="bg-gradient-to-b from-indigo-950/80 to-blue-950/80 neon-border rounded-xl p-4 backdrop-blur-sm">
          <div class="text-3xl font-bold text-cyan-400" id="days">00</div>
          <div class="text-xs text-gray-400 mt-1">Days</div>
        </div>
        <div class="bg-gradient-to-b from-indigo-950/80 to-blue-950/80 neon-border rounded-xl p-4 backdrop-blur-sm">
          <div class="text-3xl font-bold text-cyan-400" id="hours">00</div>
          <div class="text-xs text-gray-400 mt-1">Hours</div>
        </div>
        <div class="bg-gradient-to-b from-indigo-950/80 to-blue-950/80 neon-border rounded-xl p-4 backdrop-blur-sm">
          <div class="text-3xl font-bold text-cyan-400" id="minutes">00</div>
          <div class="text-xs text-gray-400 mt-1">Mins</div>
        </div>
        <div class="bg-gradient-to-b from-indigo-950/80 to-blue-950/80 neon-border rounded-xl p-4 backdrop-blur-sm">
          <div class="text-3xl font-bold text-cyan-400" id="seconds">00</div>
          <div class="text-xs text-gray-400 mt-1">Secs</div>
        </div>
      </div>

      

      
    </main>

    <!-- Bottom Navigation -->
    @include('user.includes.bottom_navigation')

  </div> <!-- end mobile container -->

  <!-- Simple JS Countdown (adjust targetDate as needed) -->
  <script>
    lucide.createIcons();

    // Countdown to: e.g. March 15, 2026 — change this date
    const targetDate = new Date("2026-03-15T00:00:00").getTime();

    function updateCountdown() {
      const now = new Date().getTime();
      const distance = targetDate - now;

      if (distance < 0) {
        document.getElementById("days").innerText = "00";
        document.getElementById("hours").innerText = "00";
        document.getElementById("minutes").innerText = "00";
        document.getElementById("seconds").innerText = "00";
        return;
      }

      const days = Math.floor(distance / (1000 * 60 * 60 * 24));
      const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
      const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
      const seconds = Math.floor((distance % (1000 * 60)) / 1000);

      document.getElementById("days").innerText = String(days).padStart(2, '0');
      document.getElementById("hours").innerText = String(hours).padStart(2, '0');
      document.getElementById("minutes").innerText = String(minutes).padStart(2, '0');
      document.getElementById("seconds").innerText = String(seconds).padStart(2, '0');
    }

    setInterval(updateCountdown, 1000);
    updateCountdown(); // initial call
  </script>

</body>
</html>