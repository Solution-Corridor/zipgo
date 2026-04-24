<!-- jQuery -->
<script src="/admin_assets/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="/admin_assets/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="/admin_assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/admin_assets/js/adminlte.js"></script>
<!-- ChartJS -->
<script src="/admin_assets/plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="/admin_assets/plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="/admin_assets/plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="/admin_assets/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="/admin_assets/plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="/admin_assets/plugins/moment/moment.min.js"></script>
<script src="/admin_assets/plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="/admin_assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="/admin_assets/plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="/admin_assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="/admin_assets/js/pages/dashboard.js"></script>
<!--- select 2 ---->
<script src="/admin_assets/plugins/select2/js/select2.full.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="/admin_assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="/admin_assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="/admin_assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="/admin_assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="/admin_assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="/admin_assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="/admin_assets/plugins/jszip/jszip.min.js"></script>
<script src="/admin_assets/plugins/pdfmake/pdfmake.min.js"></script>
<script src="/admin_assets/plugins/pdfmake/vfs_fonts.js"></script>
<script src="/admin_assets/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="/admin_assets/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="/admin_assets/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<script src="/admin_assets/plugins/ekko-lightbox/ekko-lightbox.min.js"></script>
<script src="/admin_assets/plugins/filterizr/jquery.filterizr.min.js"></script>


<!-- AdminLTE App -->
<script src="/admin_assets/js/adminlte.min.js"></script>
<script src="/admin_assets/js/adminlte.js"></script>
<script src="/admin_assets/js/pages/dashboard3.js"></script>
<!-- Page specific script -->
<script>
  $(function () {
    $(document).on('click', '[data-toggle="lightbox"]', function(event) {
      event.preventDefault();
      $(this).ekkoLightbox({
        alwaysShowClose: true
      });
    });

    $('.filter-container').filterizr({gutterPixels: 3});
    $('.btn[data-filter]').on('click', function() {
      $('.btn[data-filter]').removeClass('active');
      $(this).addClass('active');
    });
  })
</script>
<!--- pre loader -->
<script>
  var myVar;
  function myFunction() {
    myVar = setTimeout(showPage, 5);
  }
  function showPage() {
    document.getElementById("loader").style.display = "none";
    document.getElementById("wrapper").style.display = "block";
  }
</script>

<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": true, "autoWidth": false, "ordering": true, "info": true,
      "buttons": ["excel", "pdf", "print"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>


<script>
  $(function () {
    $(".example3").DataTable({
      "paging": false,
      "lengthChange": true,
      "searching": false,
      "ordering": true,
      "info": false,
      "autoWidth": true,
      //"responsive": true,
      // "buttons": ["copy", "excel", "pdf", "print", "csv", "colvis"]
      "buttons": ["excel", "pdf", "print", "csv", "colvis"]
    }).buttons().container().appendTo('#example3_wrapper .col-md-6:eq(0)');    
  });
</script>

<script>
  $(function () {
    $(".example4").DataTable({
      "paging": false,
      "lengthChange": true,
      "searching": false,
      "ordering": true,
      "info": false,
      "autoWidth": true,
      //"responsive": true,
      // "buttons": ["copy", "excel", "pdf", "print", "csv", "colvis"]
      "buttons": ["excel", "pdf", "print", "csv", "colvis"]
    }).buttons().container().appendTo('#example4_wrapper .col-md-6:eq(0)');    
  });
</script>

<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })
  });
</script>


<?php /**PATH E:\xampp\htdocs\zipGo\resources\views/admin/includes/footer_links.blade.php ENDPATH**/ ?>