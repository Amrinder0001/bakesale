<h1><?php echo $this->pageTitle = $this->data['Product']['name']; ?></h1>
<div class="productwrapper">
    <div class="details">
		<?php echo $images->mainImage($this->data['Product'], true, 374, 398);?>
    </div>
	
	<div class="description">
	<div class="description-dt">
    <?php echo $bs->adminLink(); ?>
    <?php echo $description->out($this->data['Product']['description']); ?>
	</div>
	<div class="price">
		<?php echo $price->format($this->data); ?>
    </div>
	
	
	<?php echo $this->element('add_to_cart_form');?>
	
	<?php if(isset($this->data['Brand']['id'])) { ?>
    <p class="ml2"><?php echo sprintf(__('Other %s products', true), $seo->link($this->data['Brand'], 'brands')); ?></p>
    <?php } ?>
	</div>
    
</div>
<?php if(!empty($this->data['Product']['images'])) { 
		echo $images->extraImageList($this->data['Product']);
}
?>
