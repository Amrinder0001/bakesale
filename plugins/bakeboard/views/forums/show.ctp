<h1><?php echo $this->pageTitle = $this->data['Forum']['name']; ?></h1>
<?php echo $html->link('Edit forum', array('action' => 'edit', 'id' => $this->data['Forum']['id'])) ?> <?php echo $html->link('Add topic', array('controller' => 'topics', 'action' => 'add', 'id' => $this->data['Forum']['id'])) ?>
<?php if(!empty($this->data['Topic'])) { ?>
<table class="topics">
  <tr>
    <th></th>
    <th></th>
    <th></th>
  </tr>
  <?php foreach ($this->data['Topic'] as $row){ ?>
  <tr>
    <td><?php echo $html->link($row['name'], array('controller' => 'topics', 'action' => 'show', 'id' => $row['id'])); ?></td>
    <td></td>
    <td></td>
  </tr>
  <?php } ?>
</table>
<?php } else { ?>
<p>No topics</p>
<?php } ?>
