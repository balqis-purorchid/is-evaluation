<nav class="navbar navbar-default">
	<div class="container-fluid">
		<div class="navbar-header">
		 	<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
	        <span class="sr-only">Toggle navigation</span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	      </button>
	      <a class="navbar-brand" href='<?php echo base_url();?>home'><?php echo $this->session->userdata('orgname');?></a>
	    </div>

		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav navbar-right">
		        <li><a href='<?php echo base_url();?>create_bsc'>Buat Scorecard</a></li>
		        <li><a href='<?php echo base_url();?>organisasi/editorg'>Akun Organisasi</a></li>
		        <li><a href='<?php echo base_url();?>organisasi/responden'>Akun Responden</a></li>
		        <li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Status <span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="#">Nilai Per Sistem</a></li>
						<li><a href="<?php echo base_url();?>responden">Akun Responden</a></li>
						<li><a href="#">Something else here</a></li>
					</ul>
				</li>
		        <li><a href='<?php echo base_url();?>home/do_logout'>Log Out</a></li>
		    </ul>
		</div>
	</div>
</nav>