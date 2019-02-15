        <div id="content">
            	
            <div class="title1"><h2><?php echo (l()=='ge') ? 'კალათა' : 'basket'; ?></h2></div>

            	<div id="contact">
						<!-- Selected Start -->
						<div id="selected">
							<div class="top fix">
								<div style="width: 323px;"><?php echo l('product.title') ?></div>
								<div style="width: 153px;"><?php echo l('price') ?></div>
								<div style="width: 200px;"><?php echo l('amount') ?></div>
								<div style="width: 153px;"><?php echo l('quantity') ?></div>
								<div ><?php echo l('delete') ?></div>
							</div>
							<div class="cent">
<?php
	$amt=0;
	foreach($basket as $b) :
		$amt = $amt + $b["prc"] * $b["quantity"];
?>
								<div class="list fix">
									<div class="img"><a href="#"><img src="<?php echo $b["photo1"];?>" width="95" height="73" alt="" /></a></div>
									<div class="name"><a href="#"><?php echo $b["title"];?></a></div>
									<div class="price"><span><?php echo $b["prc"];?> </span> <?php echo l('val') ?></div>
									<div class="number-part fix">
										<div class="number">
											<input type="text" name="quantity" value="<?php echo $b["quantity"];?>" />
										</div>
										<div class="icon">
											<div class="plus"><a href="<?php echo href($id).'?pid='.$b["id"].'&action=add';?>"><img src="_website/images/plus.png" width="11" height="11" alt="" /></a></div>
											<div class="minus"><a href="<?php echo href($id).'?pid='.$b["id"].'&action=sub';?>"><img src="_website/images/minus.png" width="11" height="4" alt="" /></a></div>
										</div>
									</div>
									<div class="price"><span><?php echo $b["prc"] * $b["quantity"];?> </span> <?php echo l('val') ?></div>
									<div class="delete"><a href="<?php echo href($id).'?pid='.$b["id"].'&action=del';?>">&nbsp </a></div>
								</div>	
<?php 
	endforeach;
?>
							</div>
						</div>					
						<!-- Selected End -->

						<!-- Full Start -->
						<div id="full" class="fix">
							<div class="full"><?php echo l('total.amount') ?>:<span class="price"><?php echo $amt;?> <?php echo l('val') ?></span></div>
						</div>	
						<!-- Full End -->

						<!-- pay Start -->
						<div id="pay" class="fix">
<!--
							<div class="list fix">
								<div class="radio"><input type="radio" name="" value="" /></div>
								<div class="img"><img src="images/bank.png" width="53" height="40" alt="" /></div>
								<div class="name">საკრედიტო ბარათის მეშვეობით</div>
							</div>

							<div class="list fix">
								<div class="radio"><input type="radio" name="" value="" /></div>
								<div class="img"><img src="images/paybox.png" width="48" height="48" alt="" /></div>
								<div class="name">სწრაფი გადახდის აპარატების მეშვეობით</div>
							</div>
-->							
							<div class="pay"><a href="javascript:showOrder();"><?php echo l('order') ?></a></div>
						</div>	
						<!-- pay End -->
<script>
	function showOrder() {
		$('#order').slideToggle('slow');
	}
</script>


						<!--start order-->
                   		<div id="order" style="display:none;">
                            <!--start contact-form-->
                            <div id="contact-form" class="fix">
                            	<form action="">
                                    <div class="list fix">
                                        <div class="name"><?php echo l('fullname') ?>:</div>					
                                        <div class="input">
                                            <input type="text" name="fullname" value="" />
                                        </div>
                                    </div>
                                    <div class="list fix">
                                        <div class="name"><?php echo l('Telephone') ?>:</div>					
                                        <div class="input">
                                            <input type="text" name="phone" value="" />
                                        </div>
                                    </div>
                                    <div class="list fix">
                                        <div class="name"><?php echo l('contact.email') ?>:</div>					
                                        <div class="input">
                                            <input type="text" name="email" value="" />
                                        </div>
                                    </div>
                                    <div class="list fix">
                                        <div class="name"><?php echo l('contact.address') ?>:</div>					
                                        <div class="input">
                                            <input type="text" name="address" value="" />
                                        </div>
                                    </div>
                                    <div class="list fix">
                                        <div class="name"> &nbsp; </div>					
                                        <div class="submit">
                                            <input type="submit" name="" value="<?php echo l('contact.send') ?>" />
                                        </div>
                                    </div>		
                                </form>				
                            </div>
                            <!--end contact-form-->
                        </div>
                        <!--end order-->
                </div>
                <!--end contact-->
        </div>
        <!--end content-->
