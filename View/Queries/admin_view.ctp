<div class="queries view">
	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				<h1><?php echo __('Query'); ?></h1>
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
								<li><?php echo $this->Html->link('<span class="glyphicon glyphicon-edit"></span>&nbsp&nbsp;' . __('Edit Query'), array('action' => 'edit', $query['Query']['id']), array('escape' => false)); ?> </li>
								<li><?php echo $this->Form->postLink('<span class="glyphicon glyphicon-remove"></span>&nbsp;&nbsp;' . __('Delete Query'), array('action' => 'delete', $query['Query']['id']), array('escape' => false), __('Are you sure you want to delete # %s?', $query['Query']['id'])); ?> </li>
								<li><?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span>&nbsp&nbsp;' . __('List Queries'), array('action' => 'index'), array('escape' => false)); ?> </li>
								<li><?php echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span>&nbsp&nbsp;' . __('New Query'), array('action' => 'add'), array('escape' => false)); ?> </li>
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
							<?php echo h($query['Query']['id']); ?>
						</td>
					</tr>
					<tr>
						<th><?php echo __('Query'); ?></th>
						<td>
							<?php echo h($query['Query']['query']); ?>
						</td>
					</tr>
					<tr>
						<th><?php echo __('Ord'); ?></th>
						<td>
							<?php echo h($query['Query']['ord']); ?>
						</td>
					</tr>
				</tbody>
			</table>
		</div><!-- end col md 9 -->

	</div>
</div>

