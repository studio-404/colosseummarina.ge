<?php defined('DIR') OR exit ?>
		<!-- End of Header Section -->

		<section id="room-top-section">
			<!-- Event Slider -->
			<section id="room-slider">
			<?php foreach($images as $image) : ?>
				<div class="items">
					<div class="img-container" data-bg-img="<?php echo $image['path'];?>"></div>
				</div>
			<?php endforeach; ?> 
			</section>
			<!-- End of Event Slider -->
			<div class="inner-container container">
				<div class="room-title-box">
					<h1 class="title"><?php echo $title;?></h1>
					<div class="price">
						<div class="title"><?php echo l('price');?> :</div>
						<div class="value">
								<?php 
								if($id=='4'){
									echo s('standard_price'); 
									}
									else if($id=='5'){
										echo s('superior_price'); 
										}
										else if($id=='6'){
											echo s('executive_price'); 
											}
											else if($id=='7'){
												echo s('family_price'); 
												}
												else if($id=='8'){
													echo s('junior_price'); 
													}
													else if($id=='9'){
														echo s('terrace_price'); 
														}
										
								?>
                        </div>
					</div>
				</div>
			</div>
		</section>

		<section class="room-desc">
			<div class="inner-container container">
				<div class="l-sec col-md-8">
					<div class="description">
						<?php echo content($description); ?>
					</div>
					<div class="icons-container">
						<ul class="list-inline">
                        	<?php // echo content($content); ?>
<!--							<li title="Smart TV"><i class="ravis-icon-hotel-tv" title="Smart TV"></i></li>
							<li title="გარდერობი"><i class="ravis-icon-towel-on-hanger"></i></li>
							<li title="ზღვის/აუზის ხედი"><i class="ravis-icon-swimming-pool-sign"></i></li>
							<li title=""><i class="ravis-icon-surveillance-camera"></i></li>
							<li title="ელექტრონული სეიფი"><i class="ravis-icon-hotel-left-luggage"></i></li>
							<li title="თმის საშრობი"><i class="ravis-icon-hair-dryer"></i></li>
							<li title="მინი ბარი"><i class="ravis-icon-fast-food-burger-and-drink"></i></li>-->
						</ul>
					</div>
				</div>
				<div class="r-sec col-md-4">

					<form id="room-booking-form" action="http://31.146.81.94:50080/V8Client/Inquiry.aspx" target="_blank"><!-- Do Not remove the classes -->
						<!--<div class="input-daterange">
							<div class="field-row">
								<input placeholder="Check in" class="datepicker-fields check-in" type="text"
									   name="start"/>
								<i class="fa fa-calendar"></i>
							</div>
							<div class="field-row">
								<input placeholder="Check out" class="datepicker-fields check-out" type="text"
									   name="end"/>
								<i class="fa fa-calendar"></i>
							</div>
						</div>
						<div class="field-row">
							<select name="room-type">
								<option value="">Adult</option>
								<option value="2">1</option>
								<option value="3">2</option>
								<option value="4">3</option>
								<option value="5">4</option>
								<option value="6">5</option>
							</select>
						</div>
						<div class="field-row">
							<select name="guest">
								<option value="">Child</option>
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5">5</option>
							</select>
						</div>-->
						<div class="field-row">
							<input type="submit" value="Book Now">
						</div>
					</form>

				</div>

			</div>
		</section>