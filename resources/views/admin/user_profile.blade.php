@php
$user = Auth::user();
@endphp
<!DOCTYPE html>
<html lang="en">
<title>User Profile</title>
<!-- Start top links -->
@include('admin.includes.headlinks')

<!-- end top links -->

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
  <div class="wrapper">
    <!-- Start navbar -->
    @include('admin.includes.navbar')
    <!-- end navbar -->

    <!-- Start Sidebar -->
    @include('admin.includes.sidebar')
    <!-- end Sidebar -->

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Profile</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">User Profile</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              @include('admin.includes.success')
            </div>
            <div class="col-md-3">

              <!-- Profile Image -->
              <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                  <div class="text-center">
                    @php if($user->user_pic==''){@endphp
                    <img class="profile-user-img img-fluid img-circle"
                      src="/{{ $user->pic }}"
                      onerror="this.src='/admin_assets/img/avatar5.png'"
                      alt="User Profile Picture" style="width: 100px; height: 100px;">
                    @php } @endphp
                    @php if($user->user_pic!=''){@endphp
                    <img class="profile-user-img img-fluid img-circle" src="/{{ $user->pic }}" onerror="this.src='/admin_assets/img/avatar5.png'" alt="User Profile Picture" style="width: 100px; height: 100px;">
                    @php } @endphp
                  </div>

                  <h3 class="profile-username text-center">{{$user['name'] }}</h3>

                  <p class="text-muted text-center">@php
                    if($user['level']==0)
                    {
                    echo 'Admin';
                    }
                    @endphp</p>

                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->

            </div>
            <!-- /.col -->
            <div class="col-md-9">
              <div class="card">

                <div class="card-header p-2">
                  <ul class="nav nav-pills">

                    <li class="nav-item"><a class="nav-link active" href="#edit_profile" data-toggle="tab">Edit Profile</a></li>
                    <li class="nav-item"><a class="nav-link" href="#change_password" data-toggle="tab">Change Password</a></li>
                  </ul>
                </div><!-- /.card-header -->
                <div class="card-body">
                  <div class="tab-content">


                    <div class="active tab-pane" id="edit_profile">
                      <form name="ProfileForm" action="/update_profile" method="POST" enctype="multipart/form-data" class="form-horizontal">

                        @csrf
                        <input type="hidden" name="id" value="{{$user['id']}}">
                        <input type="hidden" name="password" value="{{$user['password']}}">

                        <div class="row mb-2">

                          <div class="col-md-6">
                            <label for="inputName">Full Name</label>
                            <input type="text" name="name" class="form-control" id="inputName" placeholder="Full Name" value="{{$user['name']}}">
                          </div>
                          <div class="col-md-6">
                            <label for="inputPhone">Phone</label>
                            <input type="text" name="phone" class="form-control" id="inputPhone" placeholder="Phone" value="{{$user['phone']}}">
                          </div>
                          <div class="col-md-6">
                            <label for="inputWhatsApp">WhatsApp</label>
                            <input type="text" name="whatsapp" class="form-control" id="inputWhatsApp" placeholder="WhatsApp" value="{{$user['whatsapp']}}">
                          </div>

                          <div class="col-md-6">
                            <label for="inputName">Email</label>
                            <input type="email" name="email" class="form-control" id="inputName" placeholder="Email" value="{{$user['email']}}">
                          </div>

                          <div class="col-md-6">
                            <label for="inputName">Picture</label>
                            <input type="file" name="pic" class="form-control" id="inputName">
                            <input type="hidden" name="hidden_pic" value="{{$user['pic']}}" class="form-control">
                          </div>

                          <div class="col-md-12 mt-2 card-footer text-center">
                            <a href="/dashboard" class="btn btn-danger">Cancel</a>
                            <button type="submit" class="btn btn-info">Update Profile</button>
                          </div>

                        </div>

                      </form>
                    </div>
                    <!-- /.tab-pane -->

                    <div class="tab-pane" id="change_password">

<form action="{{ route('change.password') }}" method="POST" class="form-horizontal">
    @csrf

    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Change Password</h3>
        </div>
        <div class="card-body">

            <!-- Current Password -->
            <div class="form-group row">
                <label for="current_password" class="col-sm-2 col-form-label">Current Password</label>
                <div class="col-sm-10">
                    <div class="input-group">
                        <input type="password" 
                               name="old_password" 
                               class="form-control @error('old_password') is-invalid @enderror" 
                               id="current_password" 
                               placeholder="Current Password"
                               value="{{ old('old_password') }}"
                               required>
                        <div class="input-group-append">
                            <span class="input-group-text toggle-password" 
                                  style="cursor: pointer;" 
                                  data-target="#current_password">
                                <!-- eye-slash (default) -->
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-slash" viewBox="0 0 16 16">
                                    <path d="M13.359 11.238C15.06 9.72 16 8 16 8s-3-5.5-8-5.5a7 7 0 0 0-2.79.588l.77.771A6 6 0 0 1 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755q-.247.248-.517.486z"/>
                                    <path d="M11.297 9.176a3.5 3.5 0 0 0-4.474-4.474l.823.823a2.5 2.5 0 0 1 2.829 2.829zm-2.943 1.299.822.822a3.5 3.5 0 0 1-4.474-4.474l.823.823a2.5 2.5 0 0 0 2.829 2.829"/>
                                    <path d="M3.68 5.842a.5.5 0 1 1-.707-.707l1-1a.5.5 0 0 1 .707.707l-1 1z"/>
                                    <path d="M8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
                                </svg>
                                <!-- eye (hidden at start) -->
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16" style="display:none;">
                                    <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
                                    <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                                </svg>
                            </span>
                        </div>
                        @error('old_password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- New Password -->
            <div class="form-group row">
                <label for="new_password" class="col-sm-2 col-form-label">New Password</label>
                <div class="col-sm-10">
                    <div class="input-group">
                        <input type="password" 
                               name="new_password" 
                               class="form-control @error('new_password') is-invalid @enderror" 
                               id="new_password" 
                               placeholder="New Password"
                               required>
                        <div class="input-group-append">
                            <span class="input-group-text toggle-password" 
                                  style="cursor: pointer;" 
                                  data-target="#new_password">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-slash" viewBox="0 0 16 16">
                                    <!-- same eye-slash SVG as above -->
                                    <path d="M13.359 11.238C15.06 9.72 16 8 16 8s-3-5.5-8-5.5a7 7 0 0 0-2.79.588l.77.771A6 6 0 0 1 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755q-.247.248-.517.486z"/>
                                    <path d="M11.297 9.176a3.5 3.5 0 0 0-4.474-4.474l.823.823a2.5 2.5 0 0 1 2.829 2.829zm-2.943 1.299.822.822a3.5 3.5 0 0 1-4.474-4.474l.823.823a2.5 2.5 0 0 0 2.829 2.829"/>
                                    <path d="M3.68 5.842a.5.5 0 1 1-.707-.707l1-1a.5.5 0 0 1 .707.707l-1 1z"/>
                                    <path d="M8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16" style="display:none;">
                                    <!-- same eye SVG as above -->
                                    <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
                                    <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                                </svg>
                            </span>
                        </div>
                        @error('new_password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Confirm New Password -->
            <div class="form-group row">
                <label for="new_password_confirmation" class="col-sm-2 col-form-label">Confirm Password</label>
                <div class="col-sm-10">
                    <div class="input-group">
                        <input type="password" 
                               name="new_password_confirmation" 
                               class="form-control" 
                               id="new_password_confirmation" 
                               placeholder="Confirm New Password"
                               required>
                        <div class="input-group-append">
                            <span class="input-group-text toggle-password" 
                                  style="cursor: pointer;" 
                                  data-target="#new_password_confirmation">
                                <!-- same SVGs as above -->
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-slash" viewBox="0 0 16 16">
                                    <!-- eye-slash SVG -->
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16" style="display:none;">
                                    <!-- eye SVG -->
                                </svg>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Update Password</button>
        </div>
    </div>
</form>

<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.toggle-password').forEach(function (toggle) {
        toggle.addEventListener('click', function () {
            const target = document.querySelector(this.getAttribute('data-target'));
            const type = target.getAttribute('type') === 'password' ? 'text' : 'password';
            target.setAttribute('type', type);

            // Swap SVGs
            const icons = this.querySelectorAll('svg');
            icons.forEach(icon => {
                icon.style.display = (icon.style.display === 'none') ? '' : 'none';
            });
        });
    });
});
</script>
                    </div>
                    <!-- /.tab-pane -->

                  </div>
                  <!-- /.tab-content -->
                </div><!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div><!-- /.container-fluid -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    

    <!------ Start Footer -->
    @include('admin.includes.version')
    <!------ end Footer -->

  </div>
  <!-- ./wrapper -->
  <!------ Start Footer links-->
  @include('admin.includes.footer_links')
  <!------ end Footer links -->

</body>

</html>

<style type="text/css">
  .des {
    padding: 8px;
    font-weight: 600;
    color: rgba(1, 41, 112, 0.6);
  }

  .par {
    padding: 8px;
  }
</style>