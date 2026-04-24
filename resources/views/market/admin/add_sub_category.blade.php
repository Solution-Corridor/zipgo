<!DOCTYPE html>
<html lang="en">
@section('title')
Add Sub Category
@endsection
<!-- Start top links -->
@include('admin.includes.headlinks')

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
  <div class="wrapper">
    <style>
      .strdngr {
        color: red;
      }
    </style>
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
              <h1 class="m-0"> Add Sub Category</h1>
            </div><!-- /.col -->
            <div class="col-sm-6"></div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <div class="card card-primary card-outline card-outline-tabs">
                <div class="card-header p-0 border-bottom-0">

                  <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill" href="#custom-tabs-four-home" role="tab" aria-controls="custom-tabs-four-home" aria-selected="true"><i class="fa fa-list"></i>&nbsp;&nbsp;List Sub Category</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="custom-tabs-four-profile-tab" data-toggle="pill" href="#custom-tabs-four-profile" role="tab" aria-controls="custom-tabs-four-profile" aria-selected="false"><i class="fa fa-plus"></i>&nbsp;&nbsp; Add Sub Category</a>
                    </li>
                  </ul>
                </div>
                <div class="card-body">
                  <div class="tab-content" id="custom-tabs-four-tabContent">
                    <div class="tab-pane fade show active" id="custom-tabs-four-home" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">

                      @include('admin.includes.success')
                      <div class="card card-primary">
                        <table id="example1" class="table table-bordered table-striped">
                          <thead>
                            <tr>
                              <th>Sr#</th>
                              <th>Parent Category</th>
                              <th>Feature Image</th>
                              <th>Sub Category Name</th>
                              <th>Product Count</th>
                              <th>Created At</th>
                              <th>SEO Status</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach ($sub_categories as $sub_category)
                            <tr>
                              <td>{{ $sub_category->sub_cat_id }}</td>
                              <td>
                                <a target="_blank" href="/{{ $sub_category->category_url }}">
                                  {{ $sub_category->parent_category_name }}
                                </a>
                              </td>
                              <td>
                                <a href="/{{ $sub_category->feature_image }}" target="_blank">
                                  <img src="/{{ $sub_category->feature_image }}"
                                    alt="{{ $sub_category->sub_cat_name }}"
                                    width="50" height="50">
                                </a>
                              </td>

                              <td>
                                <a target="_blank" href="/{{ $sub_category->category_url }}/{{ $sub_category->sub_cat_url }}">
                                  {{ $sub_category->sub_cat_name }}
                                </a>
                              </td>
                              <td>
                                {{ $sub_category->product_count }}
                                </a>
                              </td>
                              <td>{{ \Carbon\Carbon::parse($sub_category->created_at)->format('d-m-Y') }}</td>

                              <td>
        @php
            $titleCount = strlen($sub_category->meta_title ?? '');
            $descriptionCount = strlen($sub_category->meta_description ?? '');
        @endphp

        {{-- Meta Title --}}
        @if(!empty($sub_category->meta_title))
            <i class="fa fa-check-circle text-success"></i> 
            Title ({{ $titleCount }} characters)
        @else
            <i class="fa fa-times-circle text-danger"></i> 
            Title (0 characters)
        @endif
        <br>

        {{-- Meta Description --}}
        @if(!empty($sub_category->meta_description))
            <i class="fa fa-check-circle text-success"></i> 
            Description ({{ $descriptionCount }} characters)
        @else
            <i class="fa fa-times-circle text-danger"></i> 
            Description (0 characters)
        @endif
        <br>

        {{-- Schema --}}
        @if(!empty($sub_category->page_schema))
            <i class="fa fa-check-circle text-success"></i> Schema
        @else
            <i class="fa fa-times-circle text-danger"></i> Schema
        @endif
        <br>

        {{-- Meta Keywords --}}
        @if(!empty($sub_category->meta_keywords))
            <i class="fa fa-check-circle text-success"></i> Keywords
        @else
            <i class="fa fa-times-circle text-danger"></i> Keywords
        @endif
    </td>
                              <td>
                                <!-- Action buttons -->
                                <a href="{{ route('market.edit_sub_category', $sub_category->sub_cat_id) }}" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></a>
                                <form action="{{ route('market.delete_sub_category', $sub_category->sub_cat_id) }}" method="POST" style="display:inline-block;">
                                  @csrf
                                  @method('DELETE')
                                  <button type="submit" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure you want to delete this sub-category?');"><i class="fa fa-trash"></i></button>
                                </form>
                              </td>
                            </tr>
                            @endforeach
                          </tbody>
                        </table>


                      </div>
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-four-profile" role="tabpanel" aria-labelledby="custom-tabs-four-profile-tab">

                      <div class="card card-primary">
                        <!-- form start -->
                        <form action="{{ route('market.save_sub_category') }}" method="POST" enctype="multipart/form-data">
                          <div class="card-body">
                            <div class="row">
                              @csrf
                              <!-- Category -->
                              <div class="col-md-3">
                                <label><b>Category </b><span class="strdngr">*</span></label>
                                <select name="cat_id" class="form-control select2" required>
                                  <option value="">Select Category</option>
                                  @foreach ($categories as $category)
                                  <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                  @endforeach
                                </select>
                                @error('cat_id')
                                <p class="help-block text-danger">{{ $message }}</p>
                                @enderror
                              </div>
                              <!-- Sub Category Name -->
                              <div class="col-md-3">
                                <label><b>Sub Category Name </b><span class="strdngr">*</span></label>
                                <input type="text" name="sub_cat_name" class="form-control" placeholder="Enter Sub Category Name" value="{{ old('sub_cat_name') }}" required>
                                @error('sub_cat_name')
                                <p class="help-block text-danger">{{ $message }}</p>
                                @enderror
                              </div>
                              <!-- URL -->
                              <div class="col-md-3">
                                <label><b>URL </b><span class="strdngr">*</span></label>
                                <input type="text" name="sub_cat_url" class="form-control" placeholder="army-belt" value="{{ old('sub_cat_url') }}" required>
                                @error('sub_cat_url')
                                <p class="help-block text-danger">{{ $message }}</p>
                                @enderror
                              </div>
                              <!-- Feature Image -->
                              <div class="col-md-3">
                                <label><b>Feature Image </b><span class="strdngr">*</span></label>
                                <input type="file" name="feature_image" class="form-control" accept="image/*" required>
                                @error('feature_image')
                                <p class="help-block text-danger">{{ $message }}</p>
                                @enderror
                              </div>

                              <div class="col-md-12 mt-3">
                                <label><b>Meta Title </b><span class="strdngr">* </span><small>(45-70 characters)</small></label>
                                <input type="text" id="category_meta_title" name="meta_title" class="form-control"
                                  placeholder="Meta Title" value="{{ old('meta_title') }}" required maxlength="70">
                                <small id="meta_title_count" class="text-muted">0 / 70 characters</small>

                                @error('meta_title')
                                <p class="help-block text-danger">{{ $message }}</p>
                                @enderror
                              </div>

                              <div class="col-md-12 mt-3">
                                <label><b>Meta Description </b><span class="strdngr">* </span><small>(70-155 characters)</small></label>
                                <textarea id="category_meta_description" name="meta_description" class="form-control"
                                  placeholder="Meta Description" required maxlength="155" rows="3">{{ old('meta_description') }}</textarea>
                                <small id="meta_description_count" class="text-muted">0 / 155 characters</small>

                                @error('meta_description')
                                <p class="help-block text-danger">{{ $message }}</p>
                                @enderror
                              </div>

                              <script>
                                function updateCount(id, counterId, min, max) {
                                  let input = document.getElementById(id);
                                  let counter = document.getElementById(counterId);

                                  input.addEventListener('input', function() {
                                    let length = input.value.length;
                                    counter.textContent = length + " / " + max + " characters";

                                    if (length < min || length > max) {
                                      counter.style.color = "red";
                                    } else {
                                      counter.style.color = "green";
                                    }
                                  });
                                }

                                // Meta Title: 45–70
                                updateCount("category_meta_title", "meta_title_count", 45, 70);

                                // Meta Description: 70–155
                                updateCount("category_meta_description", "meta_description_count", 70, 155);
                              </script>


                              <div class="col-md-12 mt-3">
                                <label><b>Meta Keywords </b><span class="strdngr">*</span></label>
                                <input type="text" id="category_meta_keywords" name="meta_keywords" class="form-control"
                                  placeholder="Meta Keywords" value="{{ old('meta_keywords') }}" required>
                                @error('meta_keywords')
                                <p class="help-block text-danger">{{ $message }}</p>
                                @enderror
                              </div>

                              <div class="col-md-12 mt-3">
                                <label><b>Schema </b><span class="strdngr">*</span></label>
                                <textarea id="category_schema" name="page_schema" class="form-control"
                                  placeholder="Schema" rows="4" required>{{ old('page_schema') }}</textarea>
                                @error('page_schema')
                                <p class="help-block text-danger">{{ $message }}</p>
                                @enderror
                              </div>

                              <div class="col-md-12 mt-3">
                                <label><b>Category FAQs</b></label>

                                <div id="faq_wrapper">

                                  <!-- default FAQ item -->
                                  <div class="faq_item row mb-2">
                                    <div class="col-md-5">
                                      <input type="text" name="faq_question[]" class="form-control" placeholder="FAQ Question">
                                    </div>
                                    <div class="col-md-6">
                                      <input type="text" name="faq_answer[]" class="form-control" placeholder="FAQ Answer">
                                    </div>
                                    <div class="col-md-1">
                                      <button type="button" class="btn btn-danger removeFaq"><i class="fas fa-trash"></i></button>
                                    </div>
                                  </div>

                                </div>

                                <button type="button" class="btn btn-success mt-2" id="addFaq">+ Add FAQ</button>
                              </div>
                            </div>
                          </div>
                          <div class="card-footer text-center">
                            <a href="/dashboard" class="btn btn-danger">Cancel</a>
                            <button type="submit" name="btnClass" class="btn btn-primary">Add Sub Category</button>
                          </div>
                        </form>


                      </div>
                    </div>
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
      $(document).ready(function() {

        $("#addFaq").click(function() {
          $("#faq_wrapper").append(`
            <div class="faq_item row mb-2">
                <div class="col-md-5">
                    <input type="text" name="faq_question[]" class="form-control" placeholder="FAQ Question">
                </div>
                <div class="col-md-6">
                    <input type="text" name="faq_answer[]" class="form-control" placeholder="FAQ Answer">
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-danger removeFaq"><i class="fa fa-trash"></i></button>
                </div>
            </div>
        `);
        });

        $(document).on("click", ".removeFaq", function() {
          $(this).closest('.faq_item').remove();
        });

      });
    </script>

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