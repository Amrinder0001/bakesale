<?php if($data['Content']['id'] != '21') { ?>
<?php if(isset($heading)) { ?>

<h1><?php echo $heading; ?></h1>
<?php } ?>
<?php echo $description->out($data['Content']['description']); ?> <?php echo $bs->adminLink(); ?>
<?php } else {
$base = FULL_BASE_URL . '/gallery/rss.php?dir=./gym/';
?>
<div id="gallery">
  <h1>Välineet</h1>
  <h2>Vapaat painot</h2>
  <?php echo $this->element('image_feed', array('url' => $base . 'vapaat_painot')) ?>
  <ul>
    <li>Leoko voimanostotanko </li>
    <li>Pro kyykkytanko </li>
    <li>Pro vetotanko </li>
  </ul>
  <h2>Penkit ja telineet</h2>
  <?php echo $this->element('image_feed', array('url' => $base . 'penkit_telineet')) ?>
  <h2>Painopakalliset laitteet</h2>
  <?php echo $this->element('image_feed', array('url' => $base . 'painopakalliset_laitteet')) ?>
  <ul>
    <li>2 x ylätalja (100 kg ja 200kg painopakalla)</li>
    <li>Alatalja (100 kg)</li>
    <li>Ristikkäistalja </li>
    <li> Reisiojentaja kone</li>
    <li> Reisikoukistus kone</li>
    <li> Ojentaja kone</li>
    <li> Hauiskone</li>
  </ul>
  <h2>Levykuormitteiset laitteet</h2>
  <?php echo $this->element('image_feed', array('url' => $base . 'levykuormitteiset_laitteet')) ?>
  <h2>Muut</h2>
  <?php echo $this->element('image_feed', array('url' => $base . 'muut')) ?></div>
<?php } ?>
