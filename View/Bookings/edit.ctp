	<div class="bookings form">

	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				<ul class="nav nav-pills pull-right">
					<li><?php //echo $this->Form->postLink('<span class="glyphicon glyphicon-remove"></span>&nbsp;&nbsp;' . __('Delete'), array('action'=>'delete', $this->Form->value('Booking.id')), array('escape'=>false), __('Are you sure you want to delete # %s?', $this->Form->value('Booking.id'))); ?></li>
				</ul>
				<h1><?php echo __('Registration'); ?></h1>
			</div>
		</div>
	</div>



	<div class="row">
		<div class="col-md-3">
			<?php //echo $this->element('admin_navigation'); ?>
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
					<?php echo $this->Form->input('address', array('class'=>'form-control', 'placeholder'=>__('Address')));?>
				</div>

				<div class="form-group">
					<?php echo $this->Form->input('id', array('class'=>'form-control', 'placeholder'=>__('Id')));?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->input('beds', array('disabled'=>'disabled', 'class'=>'form-control', 'placeholder'=>__('Beds')));?>
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
						'value' => $this->Time->format($this->data['Booking']['start'], '%-d.%-m.%Y'),
						'disabled'=>'disabled'
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
						'value' => $this->Time->format($this->data['Booking']['end'], '%-d.%-m.%Y'),
						'disabled'=>'disabled'
					));?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->input('email', array('class'=>'form-control', 'placeholder'=>__('Email')));?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->input('fellow_email', array('class'=>'form-control', 'placeholder'=>__('Fellow Email')));?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->input('Upsell', array('disabled'=>'disabled', 'label'=>'Addons', 'class'=>'form-control', 'placeholder'=>__('Upsell')));?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->input('web_price', array('type'=>'text', 'value' => $this->data['Booking']['web_price'] . ' CZK', 'disabled'=>'disabled', 'label'=>'Price', 'class'=>'form-control', 'placeholder'=>__('Price')));?>
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
