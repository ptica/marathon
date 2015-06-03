<div class="priceTypes index">
	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
					<ul class="nav nav-pills pull-right">
						<li><?php echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;' . __('New Price Type'), array('action' => 'add'), array('escape' => false)); ?></li>
						<li><?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;' . __('List Locations'), array('controller' => 'locations', 'action' => 'index'), array('escape' => false)); ?> </li>
						<li><?php echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;' . __('New Location'), array('controller' => 'locations', 'action' => 'add'), array('escape' => false)); ?> </li>
					</ul>
					<h1><?php echo __('Price Types'); ?></h1>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-3">
			<?php echo $this->element('admin_navigation'); ?>
		</div><!-- end col md 3 -->

		<div class="col-md-9">
			<div id="sortablePriceTypes" class="list-group">
				<?php foreach ($priceTypes as $item) {?>
					<div class="list-group-item" data-item-id="<?php echo h($item['PriceType']['id']); ?>">
						<span class="glyphicon glyphicon-move" aria-hidden="true"></span>
						<?php echo $this->Html->link($item['PriceType']['name'], '/admin/price_types/edit/'.$item['PriceType']['id']); ?>
					</div>
				<?php } ?>
			</div>
		</div> <!-- end col md 9 -->
	</div><!-- end row -->


</div>
