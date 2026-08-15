<?php $title = "TV EA Gallery"; ?>


<div class="nextGallery">
 <span id="nbSecondes">12</span> secondes. 
</div>

<div class="owl-carousel owl-theme owl-loaded owl-drag">
	<div class="owl-stage-outer">
		<div class="owl-stage">
			
			<?php foreach($params->pic as $pic):
				if(strlen($pic) > 3): ?>
                    
   				<div class="owl-item" style="width:100vw; height:100vh;">
					<div class="item">
						<img src="<?= HOST ?>uploads/tv/<?= $pic ?>">
					</div>
				</div>
				<?php endif;
				endforeach; ?>
	
		</div>
	</div>
	<div class="owl-nav disabled">
		<button class="owl-prev" role="presentation" type="button"><span aria-label="Previous">‹</span></button><button class="owl-next" role="presentation" type="button"><span aria-label="Next">›</span></button>
	</div>
	<div class="owl-dots">
		<button class="owl-dot" role="button"><span></span></button><button class="owl-dot active" role="button"><span></span></button><button class="owl-dot" role="button"><span></span></button>
	</div>
</div>
