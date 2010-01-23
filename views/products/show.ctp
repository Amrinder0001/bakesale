<div class="hproduct">
<h1><?php echo $this->pageTitle = $this->data['Product']['name']; ?></h1>
<div class="productwrapper">
    <div class="details">
        <div class="price">
    <?php echo $price->format($this->data); ?>
        </div>
        <?php echo $images->mainImage($this->data['Product'], true);?>
    	<?php echo $this->element('add_to_cart_form'); ?>
     </div>
	<div class="description">
    <?php echo $bs->adminLink(); ?>
    <?php echo $description->out($this->data['Product']['description']); ?>
	</div>
    <?php if(isset($this->data['Brand']['id'])) { ?>
    <p><?php echo sprintf(__('Other %s products', true), $seo->link($this->data['Brand'], 'brands')); ?></p>
    <?php } ?>
</div>
<?php if(!empty($this->data['Product']['images'])) { 
    echo $images->extraImageList($this->data['Product']);
}
?>
</div>