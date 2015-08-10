<?php
	//debug($bookings);
	App::import('Model', 'Booking');
	$this->Booking = new Booking();
?>
<div class="bookings index">
	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
					<ul class="nav nav-pills pull-right">
							<li><?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;' . __('List Bookings'), array('action'=>'index'), array('escape'=>false)); ?></li>
					</ul>
					<h1><?php echo __('Payments'); ?></h1>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<?php echo $this->Form->create('Booking'); ?>
				<table cellpadding="0" cellspacing="0" class="table table-striped">
					<thead>
						<tr>
							<th><?php echo $this->Paginator->sort('name'); ?></th>
							<th><?php echo $this->Paginator->sort('room_id'); ?></th>
							<th><?php echo $this->Paginator->sort('start', 'Date'); ?></th>
							<th><?php echo $this->Paginator->sort('email'); ?></th>
							<th class="r">Room + Addons</th>
							<th class="r">Lunches</th>
							<th class="r">Total</th>
						</tr>
					</thead>
					<tbody>
					<?php foreach ($bookings as $booking) { ?>
						<tr>
							<td><?php echo h($booking['Booking']['name']); ?></td>
							<td>
								<?php
									$title = '-';
									if (isset($booking['Room']['name'])) {
										$title  = $booking['Booking']['beds'] . '@';
										$title .= $booking['Room']['name'] . '@';
										$title .= @$locations[$booking['Room']['location_id']];
									}
									$url = array('controller' => 'bookings', 'action' => 'edit', $booking['Booking']['id']);
									echo @$this->Html->link($title, $url);
								?>
							</td>
							<td><?php echo $booking['Booking']['date_txt']; ?></td>
							<td><?php echo h($booking['Booking']['email']); ?></td>
							<?php
								$price = $this->Booking->get_price($booking, $per_partes=true);
							?>
							<td class="r"><?php echo h($price['accomodation']); ?></td>
							<td class="r"><?php echo h($price['meals']); ?></td>
							<td class="r"><?php echo h($booking['Booking']['web_price']); ?></td>
						</tr>
					<?php } ?>
					</tbody>
				</table>
			</form>

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

		</div> <!-- end col md 12 -->
	</div><!-- end row -->

	<div class="row">
		<div class="col-md-3">
			<?php echo $this->element('admin_navigation'); ?>
		</div><!-- end col md 3 -->
	</div>

</div>
