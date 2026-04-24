   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="shortcut icon" href="/assets/images/favicon.png" type="image/x-icon">
   
   <!-- Tailwind CDN -->
   <script src="https://cdn.tailwindcss.com"></script>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

   @vite('resources/js/app.js')
   <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

   <!-- Lucide icons -->
   <script src="https://unpkg.com/lucide@latest"></script>

   <style>
       body {
           background: #0a0a0f;
           color: white;
           font-family: system-ui, -apple-system, sans-serif;
       }

       .gradient-primary {
           background: linear-gradient(90deg, #7c3aed, #3b82f6);
       }

       .glow {
           box-shadow: 0 0 30px rgba(124, 58, 237, 0.35);
       }

       .card {
           background: rgba(30, 30, 50, 0.55);
           backdrop-filter: blur(10px);
           border: 1px solid rgba(100, 100, 255, 0.18);
       }

       .orbit-dot {
           position: absolute;
           width: 8px;
           height: 8px;
           border-radius: 50%;
       }

       /* Remove number input arrows */
       input[type="number"]::-webkit-outer-spin-button,
       input[type="number"]::-webkit-inner-spin-button {
           -webkit-appearance: none;
           margin: 0;
       }
       input[type="number"] {
           -moz-appearance: textfield;
       }

       /* ==================== PULL TO REFRESH SUPPORT ==================== */
       html, body {
           overscroll-behavior-y: auto;        /* Enables native pull-to-refresh on Android Chrome */
       }

       /* Optional: Make it smoother and prevent unwanted bounce on some pages */
       /* You can override this to "none" on specific pages if needed (e.g. modals) */
   </style>

   <!-- Existing scripts... -->

   <meta name="csrf-token" content="{{ csrf_token() }}">

   