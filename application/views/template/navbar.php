<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <a class="navbar-brand" style="color: white;">IS Monitoring and Evaluation Tools</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav navbar-right">
        <li><a><span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-home" data-toggle="modal" data-target="#myModal"></span></a></li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->

  <div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Kembali ke beranda?</h4>
        </div>
        <div class="modal-body">
          <p>Instrumen penilaian belum selesai dibuat. Tetap batalkan dan kembali ke beranda?</p>
        </div>
        <div class="modal-footer">
          <a href="<?php echo base_url();?>home"><button type="button" class="btn btn-default">Ya</button></a>
        </div>
      </div>

    </div>
  </div>
</nav>
