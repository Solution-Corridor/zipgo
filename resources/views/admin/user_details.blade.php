<!DOCTYPE html>
<html lang="en">

<head>
  <title>User Detail</title>
  @include('admin.includes.headlinks')
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
  <div class="wrapper">

    @include('admin.includes.navbar')
    @include('admin.includes.sidebar')

    <!-- Content Wrapper -->
    <div class="content-wrapper">

      <!-- Content Header -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-12">
              <h1>User Detail</h1>
            </div>
          </div>
        </div>
      </section>

      <!-- Main Content -->
      <section class="content">
        <div class="container-fluid">
          <div class="row">

            <!-- Left Sidebar Card -->
            <div class="col-md-3">
              <div class="card card-primary card-outline">
                <div class="card-body box-profile text-center">

                  @php
                  $imageUrl = $user->pic ? '/' . $user->pic : null;
                  $initials = strtoupper(substr($user->username ?? 'U', 0, 2));
                  @endphp

                  @if($imageUrl)
                  <img class="profile-user-img img-fluid img-circle mb-3"
                    src="{{ $imageUrl }}"
                    alt="User profile picture"
                    style="height:110px; width:110px; object-fit:cover;">
                  @else
                  <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-primary text-white fw-bold mb-3"
                    style="height:110px; width:110px; font-size:32px;">
                    {{ $initials }}
                  </div>
                  @endif

                  <h3 class="profile-username"><strong>{{ $user->username }}</strong>
                  <span class="badge badge-{{ $user->type == '0' ? 'danger' : ($user->type == '1' ? 'primary' : 'success') }} ml-2">
                      {{ $user->type == '0' ? 'Admin' : ($user->type == '1' ? 'User' : 'Expert') }}
                    </span>
                </h3>

                  <p class="text-muted">
                    <i class="fas fa-phone"></i> {{ $user->phone }}
                  </p>

                  @if($user->whatsapp)
                  <p class="text-muted">
                    <i class="fab fa-whatsapp"></i>
                    <a href="https://wa.me/{{ $user->whatsapp }}" target="_blank">
                      {{ $user->whatsapp }}
                    </a>
                  </p>
                  @endif

                  @if($user->email)
                  <p class="text-muted">
                    <i class="fas fa-envelope"></i> {{ $user->email }}
                  </p>
                  @endif

                  <p class="mt-3">
                    <strong><i class="fas fa-wallet mr-1"></i> Balance:
                      {{ number_format($user->balance ?? 0, 0) }}
                    </strong>
                  </p>

                  <p>
                    <strong><i class="fas fa-clock mr-1"></i>
                      Joined: {{ $user->created_at ? \Carbon\Carbon::parse($user->created_at)->format('d M Y, h:i A') : '—' }}
                    </strong>
                  </p>

                  <div class="mt-4">
                    <a href="{{ route('editUser', $user->id) }}" class="btn btn-sm btn-primary btn-block">
                      <i class="fas fa-edit"></i> Edit User
                    </a>
                  </div>

                </div>
              </div>
            </div>

            <!-- Right Side Tabs -->
            <div class="col-md-9">
              <div class="card">
                <div class="card-header p-2">
                  <ul class="nav nav-pills">

                    <li class="nav-item">
                      <a class="nav-link" href="#complaints" data-toggle="tab"><i class="fa fa-exclamation-triangle"></i> Complaints</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="#orders" data-toggle="tab"><i class="fa fa-shopping-cart"></i> Orders</a>
                    </li>
                  </ul>
                </div>

                <div class="card-body">
                  <div class="tab-content">



                    <!-- Complaints Tab -->
                    <div class="tab-pane active" id="complaints">
                      <div class="card card-outline card-warning">
                        <div class="card-header">
                          <h3 class="card-title">Complaints / Support Tickets</h3>
                        </div>
                        <div class="card-body table-responsive p-0">
                          <!-- Add complaints table here -->
                        </div>
                      </div>
                    </div>

                    <!-- Orders Tab -->
                    <div class="tab-pane" id="orders">
                      <div class="card card-outline card-secondary">
                        <div class="card-header">
                          <h3 class="card-title">Orders</h3>
                        </div>
                        <div class="card-body p-0">
                          <!-- Add orders content here -->
                        </div>
                      </div>
                    </div>

                  </div>
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