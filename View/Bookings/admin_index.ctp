<div class="bookings index">
	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
					<ul class="nav nav-pills pull-right">
						<li><?php echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;' . __('New Booking'), array('action' => 'add'), array('escape' => false)); ?></li>
					</ul>
								<h1><?php echo __('Bookings'); ?></h1>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-3">
			<?php echo $this->element('admin_navigation'); ?>
					</div><!-- end col md 3 -->

		<div class="col-md-9">
			<table cellpadding="0" cellspacing="0" class="table table-striped">
				<thead>
					<tr>
						<th><?php echo $this->Paginator->sort('name'); ?></th>
						<th><?php echo $this->Paginator->sort('institution'); ?></th>
						<th><?php echo $this->Paginator->sort('country'); ?></th>
						<th><?php echo $this->Paginator->sort('room_id'); ?></th>
						<th><?php echo $this->Paginator->sort('beds'); ?></th>
						<th><?php echo $this->Paginator->sort('start'); ?></th>
						<th><?php echo $this->Paginator->sort('end'); ?></th>
						<th><?php echo $this->Paginator->sort('email'); ?></th>
						<th><?php echo $this->Paginator->sort('fellow_email'); ?></th>
						<th class="actions"></th>
					</tr>
				</thead>
				<tbody>
				<?php foreach ($bookings as $booking) { ?>
					<tr>
						<td><?php echo h($booking['Booking']['name']); ?></td>
						<td><?php echo h($booking['Booking']['institution']); ?></td>
						<td><?php echo h($booking['Booking']['country']); ?></td>
						<td>
							<?php echo @$this->Html->link($booking['Room']['name'], array('controller' => 'rooms', 'action' => 'view', $booking['Room']['id'])); ?>
						</td>
						<!--td>
							<?php echo $this->Html->link($booking['PriceType']['name'], array('controller' => 'price_types', 'action' => 'view', $booking['PriceType']['id'])); ?>
						</td-->
						<td class="c">
							<?php if (isset($booking['Room']['id'])) { echo h($booking['Booking']['beds']); } ?>
						</td>
						<td><?php echo $this->Time->format($booking['Booking']['start'], '%-d.%-m.&nbsp;%Y'); ?></td>
						<td><?php echo $this->Time->format($booking['Booking']['end'], '%-d.%-m.&nbsp;%Y'); ?></td>
						<td><?php echo h($booking['Booking']['email']); ?></td>
						<td><?php echo h($booking['Booking']['fellow_email']); ?></td>
						<td class="actions">
							<?php echo $this->Html->link('<span class="glyphicon glyphicon-edit"></span>', array('action' => 'edit', $booking['Booking']['id']), array('escape' => false)); ?>
							<?php echo $this->Form->postLink('<span class="glyphicon glyphicon-remove"></span>', array('action' => 'delete', $booking['Booking']['id']), array('escape' => false), __('Are you sure you want to delete # %s?', $booking['Booking']['id'])); ?>
						</td>
					</tr>
				<?php } ?>
				</tbody>
			</table>

			<p>
				<small><?php echo $this->Paginator->counter(array('format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')));?></small>
			</p>

			<?php
			$params = $this->Paginator->params();
			if ($params['pageCount'] > 1) {
			?>
			<ul class="pagination pagination-sm">
				<?php
					echo $this->Paginator->prev('&larr; Previous', array('class' => 'prev','tag' => 'li','escape' => false), '<a onclick="return false;">&larr; Previous</a>', array('class' => 'prev disabled','tag' => 'li','escape' => false));
					echo $this->Paginator->numbers(array('separator' => '','tag' => 'li','currentClass' => 'active','currentTag' => 'a'));
					echo $this->Paginator->next('Next &rarr;', array('class' => 'next','tag' => 'li','escape' => false), '<a onclick="return false;">Next &rarr;</a>', array('class' => 'next disabled','tag' => 'li','escape' => false));
				?>
			</ul>
			<?php } ?>

		</div> <!-- end col md 9 -->
	</div><!-- end row -->


</div>
