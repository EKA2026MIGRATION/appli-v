<?php $title = "TV EA Transport"; ?>


<div class="backgroundTvImg" style="background-image: url(<?= IMG ?>fond_tv.jpg); ?>;">

	<div class="nextRocket">
		Affichage de la prochaine fusée dans <span id="nbSecondes">12</span> secondes. 
	</div>

	<div class="talk-bubble tri-right border round btm-left-in">
	  <div class="talktext">
	    <p>Préparez vous camarades ! Décollage imminent ! </p>
	  </div>
	</div>

	<div class="owl-carousel owl-theme owl-loaded owl-drag">
		<div class="owl-stage-outer">
			<div class="owl-stage">
				
				<?php foreach($params->rides as $ride):?>
                        
       				<div class="owl-item" style="width:100vw; height:100vh;">
						<div class="item">

							<div class="rocketLaunch">Fusée <?= $ride->vehicle->name; ?>
									•   Décollage à  <?= $ride->start; ?> </div>

					
								<div class="driver">
									<?php if($ride->staff->person->photo == '') { $photoStaff = IMG."no_photo.jpg"; } else { $photoStaff = $ride->staff->person->photo; } ?>
									<img src="<?= $photoStaff ?>" alt="">
									<?php if(isset($ride->staff->staffId)): ?> 
										
									<h3 class="titleChild">	
										<?php echo $ride->staff->person->firstname; else: echo 'PAS DE DRIVER'; endif; ?>
									</h3>
								</div>
	                    		<?php $x = 0; foreach($ride->pickups as $pickup): $x++; ?>
	                     
	                                <?php if($pickup->child->photo == '') { $photo = IMG."no_photo.jpg"; } else { $photo = $pickup->child->photo; } ?>
	                                <div class="child child<?= $x; ?>">
	                                 <img src="<?= $photo ?>" alt="">
	                                 <h3 class="titleDriver"><?= $pickup->child->firstname; ?><br/><?= $pickup->child->lastname; ?> </h3>
	                             	</div>
	                            <?php endforeach; ?>	

						</div>
					</div>
					<?php endforeach; ?>
		
			</div>
		</div>
		<div class="owl-nav disabled">
			<button class="owl-prev" role="presentation" type="button"><span aria-label="Previous">‹</span></button><button class="owl-next" role="presentation" type="button"><span aria-label="Next">›</span></button>
		</div>
		<div class="owl-dots">
			<button class="owl-dot" role="button"><span></span></button><button class="owl-dot active" role="button"><span></span></button><button class="owl-dot" role="button"><span></span></button>
		</div>
	</div>

</div>
