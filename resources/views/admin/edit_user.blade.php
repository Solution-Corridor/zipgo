<!DOCTYPE html>
<html lang="en">

@section('title')
Edit User
@endsection

@include('admin.includes.headlinks')

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
  <div class="wrapper">

    @include('admin.includes.navbar')
    @include('admin.includes.sidebar')

    <div class="content-wrapper">
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Edit User</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Edit User</li>
              </ol>
            </div>
          </div>
        </div>
      </div>

      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">

              <div class="card card-primary card-outline">
                <div class="card-header">
                  <h3 class="card-title">Edit User #{{ $user->id }}</h3>
                </div>

                <div class="card-body">
                  @include('includes.success')

                  <form action="{{ route('user.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf


                    <input type="hidden" name="id" value="{{ $user->id }}">

                    <div class="row">

                      <!-- Name -->
                      <div class="col-md-3">
                        <div class="form-group">
                          <label>Full Name </label>
                          <input type="text" name="name" class="form-control"
                            value="{{ old('name', $user->name) }}">
                        </div>
                      </div>


                      <div class="col-md-3">
                        <div class="form-group">
                          <label>Username <span class="text-danger">*</span></label>
                          <input type="text" name="username" class="form-control"
                            value="{{ old('username', $user->username) }}" required>
                        </div>
                      </div>

                      <!-- Phone -->
                      <div class="col-md-3">
                        <div class="form-group">
                          <label>Phone <span class="text-danger">*</span></label>
                          <input type="text" name="phone" class="form-control"
                            value="{{ old('phone', $user->phone) }}" required>
                        </div>
                      </div>

                      <!-- WhatsApp -->
                      <div class="col-md-3">
                        <div class="form-group">
                          <label>WhatsApp <span class="text-danger">*</span></label>
                          <input type="text" name="whatsapp" class="form-control"
                            value="{{ old('whatsapp', $user->whatsapp) }}" required>
                        </div>
                      </div>

                      <!-- Email -->
                      <div class="col-md-3">
                        <div class="form-group">
                          <label>Email</label>
                          <input type="email" name="email" class="form-control"
                            value="{{ old('email', $user->email) }}"
                            placeholder="Optional">
                        </div>
                      </div>

                      

                      <!-- Balance -->
                      <div class="col-md-3">
                        <div class="form-group">
                          <label>Balance ({{ number_format($user->balance, 2) }})</label>
                          <input type="number" name="balance" step="0.01" class="form-control"
                            value="{{ old('balance', $user->balance) }}" required>
                        </div>
                      </div>

                      <!-- Type (Role) -->
                      <div class="col-md-3">
                        <div class="form-group">
                          <label>User Type <span class="text-danger">*</span></label>
                          <select name="type" class="form-control" required>
                            <option value="0" {{ $user->type == '0' ? 'selected' : '' }}>Admin</option>
                            <option value="1" {{ $user->type == '1' ? 'selected' : '' }}>User</option>
                            <option value="2" {{ $user->type == '2' ? 'selected' : '' }}>Expert</option>
                          </select>
                        </div>
                      </div>

                      <!-- Status -->
                      <div class="col-md-3">
                        <div class="form-group">
                          <label>Status <span class="text-danger">*</span></label>
                          <select name="status" class="form-control" required>
                            <option value="1" {{ $user->status == 1 ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ $user->status == 0 ? 'selected' : '' }}>Inactive / Banned</option>
                          </select>
                        </div>
                      </div>

                      
                      <!-- Profile Picture -->
                      <div class="col-md-12 mt-3">
                        <div class="row">
                          <div class="col-md-3">
                            <label>Current Picture</label><br>
                            <img src="/{{ $user->pic }}"
                              alt="Profile" class="img-thumbnail"
                              style="max-height: 90px; object-fit: cover;">
                          </div>

                          <div class="col-md-6">
                            <div class="form-group">
                              <label>Upload New Picture (optional)</label>
                              <div class="custom-file">
                                <input type="file" name="pic" class="custom-file-input" accept="image/*">
                                <label class="custom-file-label" for="pic">Choose file...</label>
                              </div>
                              @error('pic')
                              <span class="text-danger">{{ $message }}</span>
                              @enderror
                            </div>
                          </div>

                          <div class="col-md-3">
                            <div class="form-group">
                              <label>Password</label>
                              <div class="input-group">
                                <input
                                  type="password"
                                  name="password"
                                  class="form-control"
                                  autocomplete="new-password"
                                  autocorrect="off"
                                  autocapitalize="off"
                                  spellcheck="false">
                                <div class="input-group-append">
                                  <span class="input-group-text" style="cursor:pointer;" onclick="togglePassword(this)">
                                    <i class="fa fa-eye"></i>
                                  </span>
                                </div>
                              </div>
                            </div>
                          </div>



                        </div>
                      </div>
                    </div>

                </div> <!-- /.row -->

                <div class="card-footer text-right mt-4">
                  <a href="{{ url('/users') }}" class="btn btn-secondary">Cancel</a>
                  <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Update User
                  </button>
                </div>

                </form>
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


  <script>
    function togglePassword(element) {
      const input = element.closest('.input-group').querySelector('input');
      const icon = element.querySelector('i');

      if (input.type === "password") {
        input.type = "text";
        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash");
      } else {
        input.type = "password";
        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");
      }
    }
  </script>

</body>

</html>