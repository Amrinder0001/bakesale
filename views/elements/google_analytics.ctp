<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
  var pageTracker = _gat._getTracker("<?php echo Configure::read('Site.google_analytics');?>");
  pageTracker._trackPageview();
<?php if($this->params['controller'] == 'orders' && $this->params['action'] == 'success' && !empty($this->data)) {?>
  pageTracker._addTrans(
    "<?php echo $this->data['Order']['number'] ?>",   // Order ID
    "",                            // Affiliation
    "<?php echo $this->data['Order']['total'] ?>",    // Total
    "<?php echo $this->data['Order']['tax']; ?>",                                     // Tax
    "<?php echo $this->data['Order']['shipping_handling']; ?>",                                        // Shipping
    "<?php echo $this->data['Order']['city'] ?>",     // City
    "<?php echo $this->data['Order']['state'] ?>",    // State
    "<?php echo $this->data['Order']['state'] ?>"     // Country
  );
<?php foreach($this->data['LineItem'] as $row) { ?>
  pageTracker._addItem(
    "<?php echo $this->data['Order']['number'] ?>",   // Order ID
    "<?php echo $row['product_id'] ?>",        // SKU
    "<?php echo $row['product']?>",            // Product Name 
    "<?php echo $row['subproduct']?>",            // Category
    "<?php echo $row['price'] ?>",             // Price
    "<?php echo $row['quantity'] ?>"         // Quantity
  );
<?php } ?>
  pageTracker._trackTrans();
<?php } ?>
</script>