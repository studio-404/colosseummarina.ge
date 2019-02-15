<?php defined('DIR') OR exit; ?>
	<section id="content">
	
		<!-- PAGE HEADER -->
		<div class="title-color">
			<div class="container">
				<h2><?php echo $title;?></h2>
				<ol class="breadcrumb">
					<?php echo location();?>
				</ol>
			</div>
		</div>
		
		<!-- RESERVATION CONTENT -->
		<div class="container">
			<div class="reser-tab reser-tab-x">
				<div class="tabbable tabs-left">
					<div class="tab-content col-sm-12 col-md-12">
						<div class="col-sm-12 col-md-12" id="returnedMSG" style="padding:10px 0px; color:#9f1118; font-size: 22px;"></div>
						<div class="tab-pane active" id="a">
							<div class="row">
								<div class="col-xs-12 col-sm-6 col-md-6">
									<h6><?php echo l('arrival.date');?> <font color="re">*</font></h6>
									<div class="form-group">
										<div id="datetimepicker1" class="input-group date">
											<input type="text" value="<?=date('d/m/Y')?>" class="form-control" data-label="arrival date" data-required="required">
											<span class="input-group-addon">
											<span class="fa fa-calendar"></span>
											</span>
										</div>
									</div>
								</div>
								<div class="col-xs-12 col-sm-6 col-md-6">
									<h6><?php echo l('departure.date');?> <font color="re">*</font></h6>
									<div class="form-group">
										<div id="datetimepicker2" class="input-group date">
											<input type="text" value="<?=date('d/m/Y')?>" class="form-control" data-label="departure date" data-required="required">
											<span class="input-group-addon">
											<span class="fa fa-calendar"></span>
											</span>
										</div>
									</div>
								</div>
								<div class="col-xs-12 col-sm-12 col-md-6">
									<div class="row">
										<div class="form-inline">
											<div class="form-group col-md-4">
												<h6><?php echo l('of.rooms');?> <font color="re">*</font></h6>
												<input type="text" class="form-control" value="1" data-label="# of rooms" data-required="required">
											</div>
											<div class="form-group col-md-4">
												<h6><?php echo l('of.adults');?></h6>
												<input type="text" class="form-control" value="0" data-label="# of adults">
											</div>
											<div class="form-group col-md-4">
												<h6><?php echo l('of.children');?></h6>
												<input type="text" class="form-control" value="0" data-label="# of children">
											</div>
										</div>
									</div>
								</div>
								<div class="col-xs-12 col-sm-12 col-md-6">
									<h6><?php echo l('room.type');?> <font color="re">*</font></h6>
									<select id="get_value1" data-label="room type" data-required="required">
									</select>
									
								</div>
                                
                                
                                <!--end booking-->
                                
							</div>
							<div class="row detail-type2">
								<div class="col-xs-12 col-sm-4 col-md-6">
									<h6><?php echo l('first.name');?> <font color="re">*</font></h6>
									<input type="text" class="form-control" placeholder="" data-label="first name" data-required="required">
								</div>
								<div class="col-xs-12 col-sm-6 col-md-6">
									<h6><?php echo l('last.name');?> <font color="re">*</font></h6>
									<input type="text" class="form-control" placeholder="" data-label="last name" data-required="required">
								</div>
							</div>
							<div class="row detail-type2">
								<div class="col-xs-12 col-sm-4 col-md-6">
									<h6><?php echo l('email.address');?> <font color="re">*</font></h6>
									<input type="text" class="form-control" placeholder="" data-label="email address" data-required="required">
								</div>
								<div class="col-xs-12 col-sm-8 col-md-6">
									<h6><?php echo l('address');?> <font color="re">*</font></h6>
									<input type="text" class="form-control" placeholder="" data-label="address" data-required="required">
								</div>
							</div>
							<div class="row detail-type2">
								<div class="col-xs-12 col-sm-4 col-md-5">
									<h6><?php echo l('city');?> <font color="re">*</font></h6>
									<input type="text" class="form-control" placeholder="" data-label="city" data-required="required">
								</div>
								<div class="col-xs-12 col-sm-8 col-md-7">
									<div class="row">
										<div class="col-xs-12 col-sm-4 col-md-4">
											<h6><?php echo l('state');?></h6>
											<input type="text" class="form-control" placeholder="" data-label="State">
										</div>
										<div class="col-xs-12 col-sm-4 col-md-4">
											<h6><?php echo l('postal.code');?></h6>
											<input type="text" class="form-control" placeholder="" data-label="postal code">
										</div>
										<div class="col-xs-12 col-sm-4 col-md-4">
											<h6><?php echo l('country');?> <font color="re">*</font></h6>
											<input type="text" class="form-control" placeholder="" data-label="country" data-required="required">
										</div>
									</div>
								</div>
							</div>
							<div class="row detail-type2">
								<div class="col-xs-12 col-sm-4 col-md-6">
									<h6><?php echo l('contact.phone');?> <font color="re">*</font></h6>
									<input type="text" class="form-control" placeholder="" data-label="phone" data-required="required">
								</div>
								<div class="col-xs-12 col-sm-6 col-md-6">
									<h6><?php echo l('fax');?></h6>
									<input type="text" class="form-control" placeholder="" data-label="fax">
								</div>
							</div>

							<button class="btn btn-default btn-availble" type="submit" onclick="sendEmail()"><?php echo l('send');?></button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>