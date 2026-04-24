<!DOCTYPE html>
<html lang="en">
<script src="/admin_assets/plugins/tinymce/tinymce.min.js"></script>
@section('title')
Add Blog
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
       <h1 class="m-0">Add Blog</h1>
     </div><!-- /.col -->
     <div class="col-sm-6">
       
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
     <div class="card">
      <div class="card-header bg-light">Add Blog</div>
      <div class="card-body">
       
        @include('admin.includes.success')
        <!-- form start -->
        <form name="BlogsFrom" action="{{ route('market.save_blogs') }}" method="POST" enctype="multipart/form-data">   
         @csrf

         <div class="row">

          <div class="col-md-6">
            <div class="form-group">
              <label>
                Post Title <code>*</code>
                <small>50 to 60 characters</small>
              </label>
              <input 
              type="text" 
              name="title" 
              class="form-control title" 
              id="title" 
              maxlength="60" 
              placeholder="Post Title (50-60 Characters)" 
              required 
              value="{{ old('title') }}"
              >
              <span id="titleCharacterCount">60</span> characters remaining
            </div>
            <p class="help-block text-danger">
              <span id="titleErrorText" style="display: none;">Title must be between 50 and 60 characters.</span>
              @error('title')
              {{$message}}
              @enderror
            </p>
          </div>

          <div class="col-md-6">
           <div class="form-group">
            <label>Feature Image<code>*</code> <small>Max Size 2 MB, jpeg,png,jpg,svg</small></label>
            <input type="file" name="picture" class="form-control" required value="{{ old('picture') }}">        
          </div>
          <p class="help-block text-danger">
            @error('picture')
            {{$message}}
            @enderror
          </p>
        </div>


        <div class="col-md-12">
         <div class="form-group">
          <label>Post Details <code>*</code></label>
          <textarea name="detail" class="form-control" id="myTextarea" placeholder="Post Details">{{ old('detail') }}</textarea>       
        </div>
        <p class="help-block text-danger">
          @error('detail')
          {{$message}}
          @enderror
        </p>
      </div>


      <div class="col-md-6">
    <div class="form-group">
        <label>Blog URL / Slug <code>*</code></label>
        <div class="input-group mb-3">
            <input 
                type="text" 
                name="url" 
                id="url" 
                class="form-control" 
                placeholder="e.g. my-awesome-blog-post" 
                required 
                value="{{ old('url') }}"
            >      
        </div>
        <small class="text-muted">This will be used in the URL: yoursite.com/blog/{slug}</small>
        <p class="help-block text-danger">
            @error('url')
                {{$message}}
            @enderror
        </p>
    </div>
</div>
    


    <div class="col-md-6">
      <label><b>Meta Keywords</b> <code>*</code>
        <small>500 characters maximum</small>
      </label>
      <input type="text" name="keywords" placeholder="meta keywords separate with comma" class="form-control"  required value="{{ old('keywords') }}">
      <p class="help-block text-danger">
        @error('keywords')
        {{$message}}
        @enderror
      </p>
    </div>

    <div class="col-md-12">
      <label>
        <b>Meta Description</b> <code>*</code>
        <small>110 to 160 characters</small>
      </label>
      <textarea name="short_description" id="description" maxlength="160" 
      class="form-control" placeholder="Meta Description (110-160 Characters)" 
      required>{{ old('short_description') }}</textarea>
      <span id="descriptionCharacterCount">160</span> characters remaining
      <p class="help-block text-danger">
        <span id="descriptionErrorText" style="display: none;">Meta description must be between 110 and 160 characters.</span>
        @error('short_description')
        {{$message}}
        @enderror
      </p>
    </div>

    <div class="col-md-12">
      <label><b>Meta Schema</b></label>
      <textarea name="page_schema" class="form-control" placeholder="Meta Schema">{{ old('page_schema') }}</textarea>
      <p class="help-block text-danger">
        @error('page_schema')
        {{$message}}
        @enderror
      </p>
    </div>

    <div class="d-flex flex-wrap justify-content-between mt-2">
      <div class="custom-checkbox">
        <input type="checkbox" name="is_commentable" value="1" checked>
        <label >Allow Blog Comments</label>
        <span class="checkbox"></span>
      </div>
    </div>

  </div>
</div>

<!-- /.card-body -->
<div class="card-footer text-center">
  <a href="/dashboard" class="btn btn-danger">Cancel</a>
  <button type="submit" class="btn btn-primary">Add Blog</button>
</div>
</form>




<!-- /.card -->

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
<script type="text/javascript">

  $(document).ready(function() {

    $('.title').on('focusout', function() {

      var blog_title = $(this).val();
      //alert(blog_title);

      var hyphenatedStr = blog_title.replace(/[^a-zA-Z0-9]/g, '-');
      // Remove multiple hyphens
      hyphenatedStr = hyphenatedStr.replace(/-+/g, '-');

      // Remove hyphens from the beginning and end of the string
      hyphenatedStr = hyphenatedStr.replace(/^-|-$/g, '');

      hyphenatedStr = hyphenatedStr.toLowerCase();
      
      $('#url').val(hyphenatedStr);
      
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
