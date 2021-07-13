<footer class="main-footer">
    
    <strong>Copyright &copy; <?php echo date("Y")?> - <?php echo date('Y', strtotime('+1 years'))?> <a href="http://youthfireit.com">YouthFireIT</a>.</strong> All rights
    reserved.
</footer>
          <script src="<?= base_url() . 'admin_file/admin/' ?>plugins/jQuery/jquery-2.2.3.min.js"></script>
          <!-- Bootstrap 3.3.6 -->
          <script src="<?= base_url() . 'admin_file/admin/' ?>bootstrap/js/bootstrap.min.js"></script>
          <!-- DataTables -->
          <script src="<?= base_url() . 'admin_file/admin/' ?>plugins/datatables/jquery.dataTables.min.js"></script>
          <script src="<?= base_url() . 'admin_file/admin/' ?>plugins/datatables/dataTables.bootstrap.min.js"></script>
          <!-- SlimScroll -->
          <script src="<?= base_url() . 'admin_file/admin/' ?>plugins/slimScroll/jquery.slimscroll.min.js"></script>
          <!-- FastClick -->
          <script src="<?= base_url() . 'admin_file/admin/' ?>plugins/fastclick/fastclick.js"></script>
          <!-- AdminLTE App -->
          <script src="<?= base_url() . 'admin_file/admin/' ?>dist/js/app.min.js"></script>
          <!-- AdminLTE for demo purposes -->
          <script src="<?= base_url() . 'admin_file/admin/' ?>dist/js/demo.js"></script>
          <script type="text/javascript" src="<?= base_url() . 'jquery-ui-1.11.4.custom/jquery-ui.js' ?>"></script>
          <script src="<?= base_url() . 'admin_file/admin/' ?>plugins/ckeditor/ckeditor.js"></script>
          <!-- page script -->

          <script>
            $(function () {
                $("#example1").DataTable();
                $('#example2').DataTable({
                    "paging": true,
                    "lengthChange": false,
                    "searching": false,
                    "ordering": true,
                    "info": true,
                    "autoWidth": false
                });
            });

        </script>

    </body>
    </html>