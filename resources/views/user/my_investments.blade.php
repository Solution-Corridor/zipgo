<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
  @include('user.includes.general_style')
  <title>My Investments</title>
</head>

<body class="min-h-screen bg-[#0A0A0F]">

  <!-- Mobile-like container -->
  <div class="mx-auto max-w-[420px] min-h-screen bg-[#0A0A0F] shadow-2xl shadow-black/50 relative">

    <!-- Top Greeting + Add / Ref (updated: sharp top corners, rounded bottom) -->
    @include('user.includes.top_greetings')




    <!-- Bottom Navigation -->
    @include('user.includes.bottom_navigation')

  </div> <!-- end mobile container -->

  <script>
    lucide.createIcons();
  </script>

</body>

</html>