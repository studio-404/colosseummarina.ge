<?php defined('DIR') OR exit; ?> 
		<div class="slider-available-sec">
			<!-- Main Slider -->
			<section id="main-slider">
            	<?php echo getMainSlideImages_old(); ?>
			</section>
			<!-- End of Main Slider -->
		</div>

		<!--Welcome Section-->
		<section id="welcome-section">
			<div class="inner-container container">
               	<?php echo about_home();?>
			</div>
		</section>
		<!--End of Welcome Section-->

		<!--Luxury Room Section-->
		<section id="luxury-rooms" class="clearfix">
                    	<?php
                        if(l() == "ge"){
							echo room_home(3347);
							} else if (l() == "en"){
								echo room_home(3348);
								} else {
									echo room_home(3349);
									}
						?>
		</section>
		<!--End of Luxury Room Section-->

		<!-- Gallery -->
		<section id="gallery">
			<div class="inner-container container">

				<div class="ravis-title">
					<div class="inner-box">
						<?php echo gallery_info();?>
					</div>
				</div>

				<!-- Gallery Container -->
				<div class="gallery-container">
					<ul class="image-main-box clearfix">
                    	<?php echo gallery();?>
					</ul>
				</div>
			</div>
		</section>
		<!-- End of Gallery -->

		<!-- Testimonials Section -->
		<section id="testimonials-section" data-parallax="scroll" data-image-src="<?php echo WEBSITE;?>/assets/img/testimonails.jpg">
			<div class="inner-container container">
				<div class="owl-carousel owl-theme">
					<?php echo tripadvisor();?>
				</div>
			</div>
		</section>
		<!-- End of Testimonials Section -->

		<!-- Special Offers -->
		<!--<section id="special-offers">
			<div class="inner-container container">
				<div class="ravis-title">
					<div class="inner-box">
						<div class="title">Special Offers</div>
						<div class="sub-title">Choose the best package from the below</div>
					</div>
				</div>

				<div class="packages-container clearfix">
					<div class="package-box col-sm-6 col-md-4">
						<div class="main-inner-box" data-bg-img="<?php echo WEBSITE;?>/assets/img/packages/1.jpg">
							<div class="title-box">
								<div class="title">Silver</div>
								<div class="sub-title">Economy Package</div>
							</div>
							<div class="price-box">
								<div class="price">$300</div>
								<div class="type">Per Night</div>
							</div>
							<div class="detail-box">
								<ul>
									<li>
										<div class="inner-box">Flight Ticket</div>
									</li>
									<li>
										<div class="inner-box">Restaurant ( Lunch )</div>
									</li>
									<li>
										<div class="inner-box">Music Concert ( 30% Off )</div>
									</li>
									<li>
										<div class="inner-box">Airport Pick-up</div>
									</li>
									<li>
										<div class="inner-box">Sport Activities</div>
									</li>
								</ul>
							</div>
							<a href="#" class="ravis-btn btn-type-2">Select</a>
						</div>
					</div>
					<div class="package-box col-sm-6 col-md-4">
						<div class="main-inner-box" data-bg-img="<?php echo WEBSITE;?>/assets/img/packages/2.jpg">
							<div class="title-box">
								<div class="title">Gold</div>
								<div class="sub-title">Business package</div>
							</div>
							<div class="price-box">
								<div class="price">$450</div>
								<div class="type">Per Night</div>
							</div>
							<div class="detail-box">
								<ul>
									<li>
										<div class="inner-box">Flight Ticket</div>
									</li>
									<li>
										<div class="inner-box">Restaurant ( Lunch / Dinner )</div>
									</li>
									<li>
										<div class="inner-box">Music Concert ( 50% Off )</div>
									</li>
									<li>
										<div class="inner-box">Airport Pick-up</div>
									</li>
									<li>
										<div class="inner-box">Sport Activities</div>
									</li>
								</ul>
							</div>
							<a href="#" class="ravis-btn btn-type-2">Select</a>
						</div>
					</div>
					<div class="package-box col-sm-offset-3 col-sm-6 col-md-offset-0 col-md-4">
						<div class="main-inner-box" data-bg-img="<?php echo WEBSITE;?>/assets/img/packages/3.jpg">
							<div class="title-box">
								<div class="title">Diamond</div>
								<div class="sub-title">Luxury package</div>
							</div>
							<div class="price-box">
								<div class="price">$600</div>
								<div class="type">Per Night</div>
							</div>
							<div class="detail-box">
								<ul>
									<li>
										<div class="inner-box">Flight Ticket</div>
									</li>
									<li>
										<div class="inner-box">Restaurant ( Lunch / Dinner )</div>
									</li>
									<li>
										<div class="inner-box">Music Concert ( Free )</div>
									</li>
									<li>
										<div class="inner-box">Airport Pick-up</div>
									</li>
									<li>
										<div class="inner-box">Sport Activities ( Free )</div>
									</li>
								</ul>
							</div>
							<a href="#" class="ravis-btn btn-type-2">Select</a>
						</div>
					</div>
				</div>
			</div>
		</section>-->
		<!-- End of Special Offers -->