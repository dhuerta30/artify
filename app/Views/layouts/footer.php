<footer class="main-footer">
    <div class="float-right d-none d-sm-block">
        <b>Version</b> 3.2.0
    </div>
    <strong>Copyright &copy; <?php echo date('Y')?></strong> Todos los derechos reservados.
</footer>

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- Bootstrap 4 -->
<script src="<?=$_ENV["BASE_URL"]?>theme/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?=$_ENV["BASE_URL"]?>theme/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script>
    $('#loader').show();
    setTimeout(function() {
    $('#loader').hide();
    }, 1500);
</script>
</body>

</html>