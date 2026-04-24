<!DOCTYPE html>
<html lang="en">
@section('title')
Blog List
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
       <h1 class="m-0">Blog List</h1>
     </div><!-- /.col -->
     <div class="col-sm-6">
       <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item active">Blog List
        </li>
      </ol>
    </div><!-- /.col -->
  </div><!-- /.row -->
</div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<section class="content">
  <div class="container-fluid">
   <div class="row">
    <!-- left column -->
    <div class="col-md-12">
     <div class="card bg-light">
      <div class="card-header">Blog List</div>
      <div class="card-body">


        @include('admin.includes.success')
        <div class="card card-primary">
          <table id="example1" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Feature Image</th>
            <th>Title & SEO Info</th>
            <th>Comments</th>
            <th>Date</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($blog_list as $blog)
        <tr>
            <td>{{ $blog->blog_id }}</td>
            
            <!-- Feature Image -->
            <td>
                <a target="_blank" href="{{ url('blog/' . $blog->slug) }}">
                    <img src="{{ asset('uploads/market/blogs/' . $blog->picture) }}" 
                         style="width: 100px; height: 100px; border-radius: 5px; object-fit: cover;" 
                         onerror="this.onerror=null; this.src='/assets/images/logo.png';"
                         alt="{{ $blog->title }}">
                </a>
            </td>

            <!-- Title + SEO Info -->
            <td>
                <a target="_blank" href="{{ url('blog/' . $blog->slug) }}" style="text-decoration: none; color: inherit;">
                    <strong>{{ $blog->title }}</strong>
                    <br>
                    <small class="text-muted">Slug: <code>{{ $blog->slug }}</code></small>
                    
                    <!-- Title Length Indicator -->
                    @php
                        $titleLength = strlen($blog->title ?? '');
                        $titleColor = ($titleLength > 60) ? 'red' : (($titleLength < 50) ? 'orange' : 'green');
                    @endphp
                    <span style="color: {{ $titleColor }}; font-size: 0.9em;">
                        ({{ $titleLength }} chars)
                    </span>

                    <br><br>

                    <!-- Keywords -->
                    @if(!empty($blog->keywords))
                        @foreach(explode(',', $blog->keywords) as $keyword)
                            <span class="badge bg-primary">{{ trim($keyword) }}</span>
                        @endforeach
                    @else
                        <span class="text-muted">No keywords</span>
                    @endif

                    <br><br>

                    <!-- Short Description Status -->
                    @php
                        $descLength = strlen($blog->short_description ?? '');
                        $descColor = ($descLength > 160) ? 'red' : (($descLength < 110) ? 'orange' : 'green');
                    @endphp
                    <div>
                        <strong>Meta Description:</strong> 
                        <span style="color: {{ $descColor }};">({{ $descLength }} chars)</span>
                    </div>

                    <!-- Page Schema -->
                    <div>
                        <strong>Schema:</strong> 
                        <span class="{{ $blog->page_schema ? 'text-success' : 'text-muted' }}">
                            {{ $blog->page_schema ? '✓ Present' : '✗ Missing' }}
                        </span>
                    </div>

                    <!-- Commentable -->
                    <div>
                        <strong>Comments:</strong> 
                        <span class="{{ $blog->is_commentable == 1 ? 'text-success' : 'text-danger' }}">
                            {{ $blog->is_commentable == 1 ? 'Enabled' : 'Disabled' }}
                        </span>
                    </div>
                </a>
            </td>

            <!-- Comments Count -->
            <td>
                @php
                    $commentCount = DB::table('blog_comments')
                                    ->where('blog_id', $blog->blog_id)
                                    ->count();
                @endphp
                <span class="badge badge-info">{{ $commentCount }}</span>
            </td>

            <!-- Dates -->
            <td>
                <small style="color: blue;">
                    Created: {{ \Carbon\Carbon::parse($blog->created_at)->format('d M Y') }}
                </small><br>
                <small style="color: green;">
                    Updated: {{ \Carbon\Carbon::parse($blog->updated_at)->format('d M Y') }}
                </small>
            </td>

            <!-- Actions -->
            <td>
                <div class="btn-group" role="group">
                    <a href="{{ route('market.edit_blog', $blog->blog_id) }}" 
                       class="btn btn-info btn-xs mr-2" title="Edit">
                        <i class="fa fa-edit"></i>
                    </a>
                    <a onclick="return confirm('Are you sure you want to delete this blog?');" 
                       href="{{ route('market.delete_blog', $blog->blog_id) }}" 
                       class="btn btn-danger btn-xs" title="Delete">
                        <i class="fa fa-trash"></i>
                    </a>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

   </div>
 </div>



 <!-- /.card -->


</div>
<!--/.col (left) -->

</div>
<!-- /.row -->
</div>
</div>
<!-- /.container-fluid -->
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
