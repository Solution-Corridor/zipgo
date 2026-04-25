<!DOCTYPE html>
<html lang="en">
@section('title')
Dashboard
@endsection

@include('admin.includes.headlinks')

<head>
  <!-- Font Awesome 6 (free CDN) -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <style>
    /* ========== REDUCED HEIGHT CARDS WITH ICON ON LEFT ========== */
    /* The new horizontal layout dramatically cuts vertical space */
    .stats-row .card {
      border: none !important;
      border-radius: 1.2rem !important;
      background: #ffffff;
      transition: all 0.25s ease;
      box-shadow: 0 8px 20px -6px rgba(0, 0, 0, 0.05), 0 2px 6px rgba(0, 0, 0, 0.02);
      overflow: hidden;
      position: relative;
    }

    /* Gradient top border on hover (subtle elegance) */
    .stats-row .card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 3px;
      background: linear-gradient(90deg, #4f46e5, #06b6d4, #8b5cf6);
      opacity: 0;
      transition: opacity 0.25s;
      z-index: 2;
    }

    .stats-row .card:hover::before {
      opacity: 1;
    }

    .stats-row .card:hover {
      transform: translateY(-2px);
      box-shadow: 0 14px 28px -10px rgba(0, 0, 0, 0.12);
    }

    /* Horizontal flex layout: icon left, content right */
    .stats-row .card .card-body {
      padding: 0.9rem 1rem !important;
      display: flex;
      align-items: center;
      gap: 1rem;
    }

    /* Left icon container — smaller, rounded, still vibrant */
    .stat-icon-left {
      flex-shrink: 0;
      width: 52px;
      height: 52px;
      background: linear-gradient(135deg, rgba(79, 70, 229, 0.08) 0%, rgba(6, 182, 212, 0.08) 100%);
      border-radius: 20px;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: all 0.2s;
    }

    .stats-row .card:hover .stat-icon-left {
      transform: scale(1.02);
      background: linear-gradient(135deg, rgba(79, 70, 229, 0.12) 0%, rgba(6, 182, 212, 0.12) 100%);
    }

    .stat-icon-left i {
      font-size: 1.8rem;
      color: #4f46e5;
    }

    /* Individual brand colors for icons */
    .card-users .stat-icon-left i {
      color: #3b82f6;
    }

    .card-services .stat-icon-left i {
      color: #10b981;
    }

    .card-cities .stat-icon-left i {
      color: #f59e0b;
    }

    /* Right side text block */
    .stat-info {
      flex: 1;
      text-align: left;
    }

    .stat-title {
      font-size: 0.7rem;
      letter-spacing: 0.08em;
      font-weight: 700;
      text-transform: uppercase;
      color: #6b7280;
      margin-bottom: 0.2rem;
    }

    .stat-number {
      font-size: 2rem;
      font-weight: 800;
      line-height: 1.2;
      background: linear-gradient(135deg, #1f2937 0%, #2d3a4a 100%);
      background-clip: text;
      -webkit-background-clip: text;
      color: transparent;
      letter-spacing: -0.02em;
    }

    /* Compact footer — minimal info, but kept for extra context */
    .stat-footer {
      background: transparent !important;
      border-top: 1px solid rgba(0, 0, 0, 0.03) !important;
      padding: 0.45rem 1rem !important;
      font-size: 0.68rem;
      font-weight: 500;
      color: #6c757d;
      display: flex;
      align-items: center;
      gap: 5px;
    }

    .stat-footer i {
      font-size: 0.62rem;
      opacity: 0.7;
    }

    /* Remove any extra padding/margin that could increase height */
    .stats-row .col-md-4 {
      margin-bottom: 1rem !important;
    }

    /* Responsive: on smaller screens reduce icon size further */
    @media (max-width: 576px) {
      .stat-icon-left {
        width: 44px;
        height: 44px;
        border-radius: 16px;
      }

      .stat-icon-left i {
        font-size: 1.5rem;
      }

      .stat-number {
        font-size: 1.7rem;
      }

      .stat-title {
        font-size: 0.65rem;
      }

      .stats-row .card .card-body {
        padding: 0.7rem 0.8rem !important;
        gap: 0.8rem;
      }

      .stat-footer {
        padding: 0.35rem 0.8rem !important;
        font-size: 0.6rem;
      }
    }

    /* Smooth entrance animation (fast, not intrusive) */
    .stats-row .col-md-4 {
      animation: fadeSlideUp 0.35s ease backwards;
    }

    .stats-row .col-md-4:nth-child(1) {
      animation-delay: 0.03s;
    }

    .stats-row .col-md-4:nth-child(2) {
      animation-delay: 0.06s;
    }

    .stats-row .col-md-4:nth-child(3) {
      animation-delay: 0.09s;
    }

    @keyframes fadeSlideUp {
      from {
        opacity: 0;
        transform: translateY(10px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    /* Extra polish for consistent border radius */
    .stats-row .card .card-footer:last-child {
      border-radius: 0 0 1.2rem 1.2rem;
    }
  </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
  <div class="wrapper">

    @include('admin.includes.navbar')
    @include('admin.includes.sidebar')

    <div class="content-wrapper">
      <!-- Page Header -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-12">
              <h1 class="m-0 font-weight-bold text-dark" style="letter-spacing: -0.3px; font-size: 1.6rem;"> Dashboard</h1>
            </div>
          </div>
        </div>
      </section>

      <!-- Main Content -->
      <section class="content">
        <div class="container-fluid">
          <!-- Stats Row - HORIZONTAL CARDS (icon left, very compact height) -->
          <div class="row stats-row">
            <!-- Users Card (icon + text inline) -->
            <div class="col-md-4 col-sm-6 mb-3">
              <div class="card card-users">
                <div class="card-body">
                  <div class="stat-icon-left">
                    <i class="fas fa-users"></i>
                  </div>
                  <div class="stat-info">
                    <h6 class="stat-title">Total Users</h6>
                    <div class="stat-number">{{ $total_users ?? 0 }}</div>
                  </div>
                </div>
                <div class="card-footer stat-footer">
                  <i class="fas fa-user-check"></i> <span>Active accounts</span>
                </div>
              </div>
            </div>

            <!-- Services Card -->
            <div class="col-md-4 col-sm-6 mb-3">
              <div class="card card-services">
                <div class="card-body">
                  <div class="stat-icon-left">
                    <i class="fas fa-cogs"></i>
                  </div>
                  <div class="stat-info">
                    <h6 class="stat-title">Total Services</h6>
                    <div class="stat-number">{{ $total_services ?? 0 }}</div>
                  </div>
                </div>
                <div class="card-footer stat-footer">
                  <i class="fas fa-boxes"></i> <span>Available services</span>
                </div>
              </div>
            </div>

            <!-- Cities Card -->
            <div class="col-md-4 col-sm-6 mb-3">
              <div class="card card-cities">
                <div class="card-body">
                  <div class="stat-icon-left">
                    <i class="fas fa-city"></i>
                  </div>
                  <div class="stat-info">
                    <h6 class="stat-title">Total Cities</h6>
                    <div class="stat-number">{{ $total_cities ?? 0 }}</div>
                  </div>
                </div>
                <div class="card-footer stat-footer">
                  <i class="fas fa-map-marker-alt"></i> <span>Cities covered</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>

    @include('admin.includes.version')
  </div>

  @include('admin.includes.footer_links')
</body>

</html>