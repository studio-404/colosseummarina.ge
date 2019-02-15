<?php defined('DIR') OR exit ?>
<!--Breadcrumb Section-->
		<section id="breadcrumb-section" data-bg-img="<?php echo content($imagen); ?>">
			<div class="inner-container container">
				<div class="ravis-title">
					<div class="inner-box">
						<div class="title"><?php echo $title;?></div>
						<div class="sub-title"><?php echo content($description); ?></div>
					</div>
				</div>

				<div class="breadcrumb">
					<ul class="list-inline">
                    	<?php echo location();?>
					</ul>
				</div>
			</div>
		</section>
		<!--End of Breadcrumb Section-->

		<!--Welcome Section-->
		<section id="welcome-section" class="has-user">
			<div class="inner-container container">
	
				<div class="l-sec col-md-12">	
					<div class="content">
						<?php echo content($content); ?>
					</div>
				</div>
			</div>
		</section>
		<!--End of Welcome Section-->