<?php defined('DIR') OR exit ?>
		<section id="room-top-section" style="height:500px !important;">
			<!-- Event Slider -->
			<section id="room-slider">
			<?php foreach($images as $image) : ?>
				<div class="items" >
					<div class="img-container" data-bg-img="<?php echo $image['path'];?>"  style="height:500px !important;"></div>
				</div>
			<?php endforeach; ?> 
			</section>
			<!-- End of Event Slider -->
			<div class="inner-container container">
				<div class="room-title-box">
					<h1 class="title"><?php echo $title;?></h1>
				</div>
			</div>
		</section>

		<div id="slide-show-section" class="container">
			<div class="desc">
				<?php echo content($content); ?>
			</div>

		</div>