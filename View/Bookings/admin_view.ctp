<div class="bookings view">
	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				<h1><?php echo __('Booking'); ?></h1>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-3">
			<?php echo $this->element('admin_navigation'); ?>
			<div class="actions">
				<div class="panel panel-default">
					<div class="panel-heading">Actions</div>
						<div class="panel-body">
							<ul class="nav nav-pills nav-stacked">
								<li><?php echo $this->Html->link('<span class="glyphicon glyphicon-edit"></span>&nbsp&nbsp;' . __('Edit Booking'), array('action' => 'edit', $booking['Booking']['id']), array('escape' => false)); ?> </li>
								<li><?php echo $this->Form->postLink('<span class="glyphicon glyphicon-remove"></span>&nbsp;&nbsp;' . __('Delete Booking'), array('action' => 'delete', $booking['Booking']['id']), array('escape' => false), __('Are you sure you want to delete # %s?', $booking['Booking']['id'])); ?> </li>
								<li><?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span>&nbsp&nbsp;' . __('List Bookings'), array('action' => 'index'), array('escape' => false)); ?> </li>
								<li><?php echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span>&nbsp&nbsp;' . __('New Booking'), array('action' => 'add'), array('escape' => false)); ?> </li>
										<li><?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span>&nbsp&nbsp;' . __('List Rooms'), array('controller' => 'rooms', 'action' => 'index'), array('escape' => false)); ?> </li>
										<li><?php echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span>&nbsp&nbsp;' . __('New Room'), array('controller' => 'rooms', 'action' => 'add'), array('escape' => false)); ?> </li>
										<li><?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span>&nbsp&nbsp;' . __('List Price Types'), array('controller' => 'price_types', 'action' => 'index'), array('escape' => false)); ?> </li>
										<li><?php echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span>&nbsp&nbsp;' . __('New Price Type'), array('controller' => 'price_types', 'action' => 'add'), array('escape' => false)); ?> </li>
										<li><?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span>&nbsp&nbsp;' . __('List Upsells'), array('controller' => 'upsells', 'action' => 'index'), array('escape' => false)); ?> </li>
										<li><?php echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span>&nbsp&nbsp;' . __('New Upsell'), array('controller' => 'upsells', 'action' => 'add'), array('escape' => false)); ?> </li>
							</ul>
						</div><!-- end body -->
				</div><!-- end panel -->
			</div><!-- end actions -->
		</div><!-- end col md 3 -->

		<div class="col-md-9">
			<table cellpadding="0" cellspacing="0" class="table table-striped">
				<tbody>
					<tr>
						<th><?php echo __('Id'); ?></th>
						<td>
							<?php echo h($booking['Booking']['id']); ?>
						</td>
					</tr>
					<tr>
								<th><?php echo __('Room'); ?></th>
								<td>
			<?php echo $this->Html->link($booking['Room']['name'], array('controller' => 'rooms', 'action' => 'view', $booking['Room']['id'])); ?>
			&nbsp;
		</td>
					</tr>
					<tr>
								<th><?php echo __('Price Type'); ?></th>
								<td>
			<?php echo $this->Html->link($booking['PriceType']['name'], array('controller' => 'price_types', 'action' => 'view', $booking['PriceType']['id'])); ?>
			&nbsp;
		</td>
					</tr>
					<tr>
						<th><?php echo __('Beds'); ?></th>
						<td>
							<?php echo h($booking['Booking']['beds']); ?>
						</td>
					</tr>
					<tr>
						<th><?php echo __('Start'); ?></th>
						<td>
							<?php echo h($booking['Booking']['start']); ?>
						</td>
					</tr>
					<tr>
						<th><?php echo __('End'); ?></th>
						<td>
							<?php echo h($booking['Booking']['end']); ?>
						</td>
					</tr>
					<tr>
						<th><?php echo __('Email'); ?></th>
						<td>
							<?php echo h($booking['Booking']['email']); ?>
						</td>
					</tr>
					<tr>
						<th><?php echo __('Fellow Email'); ?></th>
						<td>
							<?php echo h($booking['Booking']['fellow_email']); ?>
						</td>
					</tr>
				</tbody>
			</table>
		</div><!-- end col md 9 -->

	</div>
</div>

<div class="related row">
	<div class="col-md-12">
	<h3><?php echo __('Related Upsells'); ?></h3>
	<?php if (!empty($booking['Upsell'])): ?>
	<table cellpadding = "0" cellspacing = "0" class="table table-striped">
	<thead>
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('Desc'); ?></th>
		<th><?php echo __('Location Id'); ?></th>
		<th><?php echo __('Price'); ?></th>
		<th class="actions"></th>
	</tr>
	<thead>
	<tbody>
	<?php foreach ($booking['Upsell'] as $upsell): ?>
		<tr>
			<td><?php echo $upsell['id']; ?></td>
			<td><?php echo $upsell['name']; ?></td>
			<td><?php echo $upsell['desc']; ?></td>
			<td><?php echo $upsell['location_id']; ?></td>
			<td><?php echo $upsell['price']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('<span class="glyphicon glyphicon-search"></span>'), array('controller' => 'upsells', 'action' => 'view', $upsell['id']), array('escape' => false)); ?>
				<?php echo $this->Html->link(__('<span class="glyphicon glyphicon-edit"></span>'), array('controller' => 'upsells', 'action' => 'edit', $upsell['id']), array('escape' => false)); ?>
				<?php echo $this->Form->postLink(__('<span class="glyphicon glyphicon-remove"></span>'), array('controller' => 'upsells', 'action' => 'delete', $upsell['id']), array('escape' => false), __('Are you sure you want to delete # %s?', $upsell['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</tbody>
	</table>
<?php endif; ?>

	<div class="actions">
		<?php echo $this->Html->link(__('<span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;New Upsell'), array('controller' => 'upsells', 'action' => 'add'), array('escape' => false, 'class' => 'btn btn-default')); ?>	</div>
	</div><!-- end col md 12 -->
</div>
