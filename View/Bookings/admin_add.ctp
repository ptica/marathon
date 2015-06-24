<div class="bookings form">

	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
									<ul class="nav nav-pills pull-right">
							<li><?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;' . __('List Bookings'), array('action'=>'index'), array('escape'=>false)); ?></li>
					</ul>
								<h1><?php echo __('Admin Add Booking'); ?></h1>
			</div>
		</div>
	</div>



	<div class="row">
		<div class="col-md-3">
			<?php echo $this->element('admin_navigation'); ?>
					</div><!-- end col md 3 -->
		<div class="col-md-9">
			<?php echo $this->Form->create('Booking', array('role'=>'form', 'class'=>'form-horizontal')); ?>

				<div class="form-group">
					<?php echo $this->Form->input('name', array('class'=>'form-control', 'placeholder'=>__('Name')));?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->input('institution', array('class'=>'form-control', 'placeholder'=>__('Institution')));?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->input('country', array('class'=>'form-control', 'placeholder'=>__('Country')));?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->input('address', array('data-provide'=>'wysiwyg', 'class'=>'form-control', 'placeholder'=>__('Address')));?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->input('room_id', array('class'=>'form-control', 'placeholder'=>__('Room Id')));?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->input('price_type_id', array('class'=>'form-control', 'placeholder'=>__('Price Type Id')));?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->input('beds', array('class'=>'form-control', 'placeholder'=>__('Beds')));?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->input('start', array(
						'type' => 'text',
						'data-provide' => 'datepicker',
						'data-date-language' => Configure::read('Config.locale'),
						'class' => 'form-control',
						'label' => __('Start'),
						'placeholder' => __('Start'),
						'inputGroup' => array('append'=>'glyphicon-th'),
						//BEWARE: datepicker needs JS initialization
					));?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->input('end', array(
						'type' => 'text',
						'data-provide' => 'datepicker',
						'data-date-language' => Configure::read('Config.locale'),
						'class' => 'form-control',
						'label' => __('End'),
						'placeholder' => __('End'),
						'inputGroup' => array('append'=>'glyphicon-th'),
						//BEWARE: datepicker needs JS initialization
					));?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->input('email', array('class'=>'form-control', 'placeholder'=>__('Email')));?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->input('fellow_email', array('class'=>'form-control', 'placeholder'=>__('Fellow Email')));?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->input('web_price', array('class'=>'form-control', 'placeholder'=>__('Web Price')));?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->input('token', array('class'=>'form-control', 'placeholder'=>__('Token')));?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->input('Upsell', array('class'=>'form-control', 'placeholder'=>__('Created')));?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->input('Query', array('multiple'=>'checkbox', 'label'=> 'MTM Content', 'class'=>'form-control', 'placeholder'=>__('Created')));?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->input('Meal', array('multiple'=>'checkbox', 'label'=>'Meals','class'=>'form-control', 'placeholder'=>__('Created')));?>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-8">
						<?php echo $this->Form->submit(__('Submit'), array('class'=>'btn btn-primary')); ?>
					</div>

				</div>

			<?php echo $this->Form->end() ?>

		</div><!-- end col md 12 -->
	</div><!-- end row -->
</div>
