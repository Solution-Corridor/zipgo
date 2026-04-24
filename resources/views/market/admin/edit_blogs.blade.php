<!DOCTYPE html>
<html lang="en">
<script src="/admin_assets/plugins/tinymce/tinymce.min.js"></script>
@section('title')
Edit Blogs
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
                            <h1 class="m-0">Edit Blogs</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Edit Blogs</li>
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
                                    <h3 class="card-title">Edit Blogs</h3>
                                </div>
                                <div class="card-body">
                                    <!-- form start -->
                                    @include('admin.includes.success')
                                    <form name="BlogsForm" action="{{ route('market.update_blogs') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="blog_id" value="{{ $blogs[0]['blog_id'] ?? '' }}">

    <div class="container-fluid">
        <div class="row">

            <!-- Title -->
            <div class="col-md-6">
                <div class="form-group">
                    <label><b>Title</b> <code>*</code> <small>(50-60 characters recommended)</small></label>
                    <input type="text" 
                           name="title" 
                           class="form-control" 
                           required 
                           maxlength="60"
                           value="{{ old('title', $blogs[0]['title'] ?? '') }}">
                    @error('title')
                        <p class="help-block text-danger">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Slug -->
            <div class="col-md-6">
                <div class="form-group">
                    <label><b>Slug / URL</b> <code>*</code></label>
                    <input type="text" 
                           name="slug" 
                           class="form-control" 
                           required 
                           placeholder="my-awesome-blog-post"
                           value="{{ old('slug', $blogs[0]['slug'] ?? '') }}">
                    @error('slug')
                        <p class="help-block text-danger">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Current Image + Upload -->
            <div class="col-md-12">
                <div class="form-group">
                    <label><b>Feature Image</b></label>
                    <div class="row">
                        <div class="col-md-2">
                            @if(!empty($blogs[0]['picture']))
                                <img src="{{ asset('uploads/market/blogs/' . $blogs[0]['picture']) }}" 
                                     style="height: 80px; width: 80px; border-radius: 5px; object-fit: cover;" 
                                     onerror="this.src='/assets/images/logo.png'">
                            @endif
                        </div>
                        <div class="col-md-10">
                            <input type="file" 
                                   name="pic" 
                                   class="form-control">
                            <small class="text-muted">Leave empty to keep current image. Max 2MB (jpeg, png, jpg, svg, webp)</small>
                            <input type="hidden" name="hidden_pic" value="{{ $blogs[0]['picture'] ?? '' }}">
                        </div>
                    </div>
                    @error('pic')
                        <p class="help-block text-danger">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Detail -->
            <div class="col-md-12">
                <div class="form-group">
                    <label><b>Post Details</b> <code>*</code></label>
                    <textarea name="detail" id="myTextarea" 
                              class="form-control" 
                              rows="8" 
                              required>{{ old('detail', $blogs[0]['detail'] ?? '') }}</textarea>
                    @error('detail')
                        <p class="help-block text-danger">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Keywords -->
            <div class="col-md-12">
                <div class="form-group">
                    <label><b>Meta Keywords</b> <small>(comma separated)</small></label>
                    <input type="text" 
                           name="keywords" 
                           class="form-control" 
                           placeholder="keyword1, keyword2, keyword3"
                           value="{{ old('keywords', $blogs[0]['keywords'] ?? '') }}">
                    @error('keywords')
                        <p class="help-block text-danger">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Short Description -->
            <div class="col-md-12">
                <div class="form-group">
                    <label><b>Meta Description</b> <small>(110-160 characters)</small></label>
                    <textarea name="short_description" 
                              class="form-control" 
                              maxlength="160"
                              rows="3">{{ old('short_description', $blogs[0]['short_description'] ?? '') }}</textarea>
                    @error('short_description')
                        <p class="help-block text-danger">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Page Schema -->
            <div class="col-md-12">
                <div class="form-group">
                    <label><b>Meta Schema / JSON-LD</b></label>
                    <textarea name="page_schema" 
                              class="form-control" 
                              rows="4">{{ old('page_schema', $blogs[0]['page_schema'] ?? '') }}</textarea>
                    @error('page_schema')
                        <p class="help-block text-danger">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Commentable Checkbox -->
            <div class="col-md-12 mt-3">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" 
                           name="is_commentable" 
                           value="1" 
                           class="custom-control-input"
                           {{ old('is_commentable', $blogs[0]['is_commentable'] ?? 0) == 1 ? 'checked' : '' }}>
                    <label class="custom-control-label">Allow comments on this blog</label>
                </div>
            </div>

        </div>
    </div>

    <div class="card-footer text-center mt-4">
        <a href="{{ route('market.blogs_list') }}" class="btn btn-danger">Cancel</a>
        <button type="submit" class="btn btn-primary">Update Blog</button>
    </div>
</form>


                                </div><!-- /.card -->
                            </div>
                            <!--/.col (left) -->
                        </div><!-- /.row -->
                    </div><!-- /.container-fluid -->
                </section><!-- /.content -->

            </div><!-- /.content-wrapper -->

            @include('admin.includes.version')
        </div><!-- /.wrapper -->

        @include('admin.includes.footer_links')

        <script>
            $(document).ready(function () {
                $('#title').on('input', function () {
            // Get the value of the title input
                    var titleValue = $(this).val().trim();

            // Replace spaces and special characters with hyphens and convert to lowercase for a simple slug
                    var slugValue = titleValue.replace(/[^a-zA-Z0-9]/g, '-').toLowerCase();

            // Remove consecutive hyphens
                    slugValue = slugValue.replace(/-+/g, '-');

            // Update the value of the slug input
                    $('#slug').val(slugValue);
                });
            });
        </script>

        <script type="text/javascript">
  tinymce.init({
    selector: '#myTextarea',
    placeholder: 'Type here...',
    plugins: 'preview importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media template codesample table charmap pagebreak nonbreaking anchor insertdatetime advlist lists wordcount help charmap quickbars emoticons',
    menubar: 'file edit view insert format tools table help',
    toolbar: 'undo redo | bold italic underline strikethrough | fontfamily fontsize blocks | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media template link anchor codesample | ltr rtl',
    toolbar_sticky: true,
    autosave_ask_before_unload: true,
    autosave_interval: '30s',
    autosave_prefix: '{path}{query}-{id}-',
    autosave_restore_when_empty: false,
    autosave_retention: '2m',
    image_advtab: true,
    // link_list: [
    //   { title: 'My page 1', value: 'https://www.codexworld.com' },
    //   { title: 'My page 2', value: 'http://www.codexqa.com' }
    // ],
    // image_list: [
    //   { title: 'My page 1', value: 'https://www.codexworld.com' },
    //   { title: 'My page 2', value: 'http://www.codexqa.com' }
    // ],
    // image_class_list: [
    //   { title: 'None', value: '' },
    //   { title: 'Some class', value: 'class-name' }
    // ],
    importcss_append: true,
    file_picker_callback: (callback, value, meta) => {
      /* Provide file and text for the link dialog */
      if (meta.filetype === 'file') {
        callback('https://www.google.com/logos/google.jpg', { text: 'My text' });
      }

      /* Provide image and alt text for the image dialog */
      if (meta.filetype === 'image') {
        callback('https://www.google.com/logos/google.jpg', { alt: 'My alt text' });
      }

      /* Provide alternative source and posted for the media dialog */
      if (meta.filetype === 'media') {
        callback('movie.mp4', { source2: 'alt.ogg', poster: 'https://www.google.com/logos/google.jpg' });
      }
    },
    templates: [
      { title: 'New Table', description: 'creates a new table', content: '<div class="mceTmpl"><table width="98%%"  border="0" cellspacing="0" cellpadding="0"><tr><th scope="col"> </th><th scope="col"> </th></tr><tr><td> </td><td> </td></tr></table></div>' },
      { title: 'Starting my story', description: 'A cure for writers block', content: 'Once upon a time...' },
      { title: 'New list with dates', description: 'New List with dates', content: '<div class="mceTmpl"><span class="cdate">cdate</span><br><span class="mdate">mdate</span><h2>My List</h2><ul><li></li><li></li></ul></div>' }
      ],
    template_cdate_format: '[Date Created (CDATE): %m/%d/%Y : %H:%M:%S]',
    template_mdate_format: '[Date Modified (MDATE): %m/%d/%Y : %H:%M:%S]',
    height: 400,
    image_caption: true,
    quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote quickimage quicktable',
    noneditable_class: 'mceNonEditable',
    toolbar_mode: 'sliding',
    contextmenu: 'link image table',
    content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:16px }'
  });
</script>

    </body>

    </html>
