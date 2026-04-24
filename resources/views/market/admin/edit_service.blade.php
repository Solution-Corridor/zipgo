<!DOCTYPE html>
<html lang="en">
@section('title')
Edit services
@endsection
<!-- Start top links -->
@include('admin.includes.headlinks')

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
   <div class="content-header">
    <div class="container-fluid">
     <div class="row mb-2">
      <div class="col-sm-6">
       <h1 class="m-0">Edit services</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
       <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item active">Edit services</li>
       </ol>
      </div><!-- /.col -->
     </div><!-- /.row -->
    </div><!-- /.container-fluid -->
   </div><!-- /.content-header -->

   <section class="content">
    <div class="container-fluid">
     <div class="row">
      <!-- left column -->
      <div class="col-md-12">
       <div class="card card-secondary">
        <div class="card-header">
         <h3 class="card-title">Edit services</h3>
         <div class="card-tools">

         </div>
        </div>
        <div class="card-body">
         <!-- form start -->
         @if ($errors->any())
         <div class="alert alert-danger">
          <ul>
           @foreach ($errors->all() as $error)
           <li>{{ $error }}</li>
           @endforeach
          </ul>
         </div>
         @endif
         @include('admin.includes.success')
         <form name="Editservices-Form" action="/update_service" method="POST" enctype="multipart/form-data">
          @csrf
          <input type="hidden" name="service_id" value="@php echo $services[0]['service_id'] @endphp">
          <div class="container-fluid">
           <div class="row">
            <div class="col-md-6">
             <div class="form-group">
              <label><b>Title</b><code>*</code></label>
              <input type="text" name="title" id="title" placeholder="Title" class="form-control" required value="{{$services[0]['title']}}">
              @error('title')
              <p class="help-block text-danger">{{ $title }}</p>
              @enderror
             </div>
            </div>
            <div class="col-md-2">
             <img src="/uploads/services/{{$services[0]['pic']}}" style="height: 60px; width: 60px;border-radius: 5px">

            </div>

            <div class="col-md-4">
             <div class="form-group">
              <label for="exampleInputBorder">Feature Image<code>*</code></label>
              <div class="input-group mb-3">
               <input type="file" name="pic" class="form-control" placeholder="Feature Image" required value="{{ old('pic') }}">
              </div>
              @error('pic')
              <p class="help-block text-danger">{{ $pic }}</p>
              @enderror
             </div>
            </div>
            <div class="col-md-12">
             <div class="form-group">
              <label><b>Detail</b><code>*</code></label>
              <textarea name="detail" class="form-control textarea" placeholder="Detail" value="">{{ old('detail') ?? $services[0]['detail'] }}</textarea>
             </div>
             @error('detail')
             <p class="help-block text-danger">{{ $detail }}</p>
             @enderror
            </div>

           </div>
          </div>

          <div class="card-footer text-center">
           <a href="/dashboard" class="btn btn-danger">Cancel</a>
           <button type="submit" class="btn btn-primary">Edit services</button>
          </div>
         </form>

        </div><!-- /.card -->
       </div><!--/.col (left) -->
      </div><!-- /.row -->
     </div><!-- /.container-fluid -->
    </section><!-- /.content -->
   </div><!-- /.content-wrapper -->

   @include('admin.includes.version')
  </div><!-- /.wrapper -->

  @include('admin.includes.footer_links')
 </body>

 </html>
