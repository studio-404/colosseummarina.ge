<?php defined('DIR') OR exit ?>
<!--Breadcrumb Section-->
		<section id="breadcrumb-section" data-bg-img="<?php echo content($imagen); ?>">
			<div class="inner-container container">
				<div class="ravis-title">
					<div class="inner-box">
						<div class="title"><?php echo $title;?></div>
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

		<!--Contact Section-->
		<section id="contact-section">
			<div class="inner-container container">
				<div class="t-sec">

					<div class="contact-info">
						<div class="contact-inf-box">
							<div class="icon-box">
								<i class="fa fa-home"></i>
							</div>
							<div class="text">
								<?php echo s('address');?>
							</div>
						</div><br /><br />
						<div class="contact-inf-box">
							<div class="icon-box">
								<i class="fa fa-envelope"></i>
							</div>
							<div class="text">
								<?php echo s('feedback');?>
							</div>
						</div>
						<div class="contact-inf-box">
							<div class="icon-box">
								<i class="fa fa-envelope"></i>
							</div>
							<div class="text">
								<?php echo s('feedback2');?>
							</div>
						</div>
						<div class="contact-inf-box">
							<div class="icon-box">
								<i class="fa fa-envelope"></i>
							</div>
							<div class="text">
								<?php echo s('feedback3');?>
							</div>
						</div> <br /><br />                                               
						<div class="contact-inf-box">
							<div class="icon-box">
								<i class="fa fa-phone"></i>
							</div>
							<div class="text">
								<?php echo s('tel1');?>
							</div>
							<div class="icon-box">
								<i class="fa fa-phone"></i>
							</div>
							<div class="text">
								<?php echo s('tel2');?>
							</div>
							<div class="icon-box">
								<i class="fa fa-phone"></i>
							</div>
							<div class="text">
								<?php echo s('tel3');?>
							</div>                                                        
						</div>
					</div>
				</div>

				<div class="b-sec clearfix">
					<div class="contact-form col-md-6">
						<form action="#" id="contact-form-box">
							<div class="field-row">
								<input type="text" name="name" id="contact-name" placeholder="<?php echo l('first.name');?> :" required>
							</div>
							<div class="field-row">
								<input type="text" name="phone" id="contact-phone" placeholder="<?php echo l('contact.phone');?> :">
							</div>
							<div class="field-row">
								<input type="email" name="email" id="contact-email" placeholder="<?php echo l('email.address');?> :" required>
							</div>
							<div class="field-row">
								<textarea placeholder="<?php echo l('contact.msg');?>" name="message" id="contact-message" required></textarea>
							</div>
							<div class="message-box"></div>
							<div class="field-row">
								<input type="submit" value="<?php echo l('send');?>">
							</div>
						</form>
					</div>
					<div id="google-map" class="col-md-6" data-marker="<?php echo WEBSITE;?>/assets/img/marker.png"></div>
				</div>
			</div>
		</section>
		<!--End of Contact Section-->