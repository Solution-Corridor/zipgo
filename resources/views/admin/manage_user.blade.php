<!DOCTYPE html>
<html lang="en">
<head>
 <title>Manage User</title>
<!-- Start top links -->
@include('admin.includes.headlinks')
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
 <div class="wrapper">
  <!-- Start navbar -->
  @include('admin.includes.navbar')
  <!-- end navbar -->

  <!-- Start Sidebar -->
  @include('admin.includes.sidebar')

<div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Manage User</h1>
            </div>
            
          </div>
        </div>
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
           <div class="card card-primary">
       <table id="example1" class="table table-bordered table-striped">
        <thead>
          <tr>
           <th>Sr#</th>
           <th>Name</th>
           <th>E-amil</th>
           <th>Password</th>
           <th>Gender</th>
           <th>Country</th>
           <th>Type</th>
           <th>Action</th>
         </tr>
       </thead>
       <tbody>
       <!--  -->       
        </tbody>
      </table>

    </div>
</div>
              
              
           
             
           </div>
           
        
        
    
       
     </section>
   @include('admin.includes.version')

   @include('admin.includes.footer_links')



 </body>
 </html>
