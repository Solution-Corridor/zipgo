<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
  @include('user.includes.general_style')
  <title>Sample</title>

  <!-- Optional: Add Font Awesome or Heroicons if you want more icons -->
  <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"> -->
</head>

<body class="min-h-screen text-gray-200 flex items-start justify-center bg-gradient-to-b from-[#0B0B12] to-[#0F0F1E]">

  <div class="w-full max-w-[420px] min-h-screen relative" style="background: #0B0B12;">

    @include('user.includes.top_greetings')

    <!-- ================== RED ELIGIBILITY MESSAGE BAR ================== -->



    @include('user.includes.bottom_navigation')

  </div> <!-- end container -->

</body>

</html>