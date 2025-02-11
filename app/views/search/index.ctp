
<h2><?php __('Search Results'); ?></h2>
<?php $v = (isset($_REQUEST['q'])? $_REQUEST['q']: 'Search...'); ?>
<form method="get" action="<?php echo Configure::read('localhost_string'); ?>/search/">
	<input type="text" value="<?php echo $v; ?>" onFocus="if(this.value == 'Search...') this.value = '';" onBlur="if(this.value == '') this.value = 'Search...';" size="84px" name="q" />
	<input type="submit" value="Search" />
</form>
<hr style="margin-left:20px;" />

<?php foreach($result as $r) { ?>

<h3 style="color:#ffffde">
	<?php echo $this->Html->link($r['title'], 
		array('controller' => $r['controller'], 
			  'action' => $r['action'], $r['parameter']), 
		array('style' => 'style="color:#ffffde"')); ?>
</h3>
<p>
<?php echo htmlspecialchars($r['excerpt']) . '...'; ?>
</p>
<br/>
<?php } ?>