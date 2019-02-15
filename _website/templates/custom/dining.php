<?php defined('DIR') OR exit ?>
	<section id="content" class="about-main">
	
		<!-- PAGE HEADER -->
		<div class="title-color">
			<h2>Hotel Location</h2>
			<ol class="breadcrumb">
				<li><a href="./index.html">Home</a></li>
				<li class="active"><a href="./location.html">Location</a></li>
			</ol>
		</div>

		<!-- ABOUT -->
		<div class="about-content">
			<div class="db-map">
				<div class="dbi-inner"><iframe src="<?php echo content($imagen);?>" width="100%" height="100%" frameborder="0" style="border:0" allowfullscreen></iframe>
				</div>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-6">
			</div>
			<div class="col-xs-12 col-sm-12 col-md-6">
				<div class="row">
					<div class="right-about">
						<?php echo content($content); ?>
						<div class="clearfix"></div>
					</div>
				</div>
			</div>
		</div>
	</section>