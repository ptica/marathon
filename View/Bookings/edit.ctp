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
			<?php
				$booking_id = $this->request->data['Booking']['id'];
				$token = $this->request->data['Booking']['token'];
			?>
			<div style="margin:2em 10em">
				<a class="btn btn-success" href="<?php echo @Router::url("/pay/$booking_id/$token"); ?>">Proceed to Payment</a>
			</div>
			    <div class="form-group">
				<label for="QueryQuery" class="col-sm-2 control-label"></label>
				<div class="col-sm-8 input-group">
				    <p class="form-control-static">Or you may review your registration details, even correct typos that are not price related and then save it below:</p>
				</div>
			    </div>
			<?php echo $this->Form->create('Booking', array('role'=>'form', 'class'=>'form-horizontal')); ?>
				<div class="form-group">
					<?php echo $this->Form->input('name', array('label'=>'Your Name', 'class'=>'form-control', 'placeholder'=>__('Name')));?>
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
				
				<?php if ($this->request->data['Booking']['room_id']) { ?>
					<?php
						$location_id   = $this->request->data['Room']['location_id'];
						$room_name     = $this->request->data['Room']['name'];
						$location_name = $locations[$location_id];
					?>
					<div class="form-group">
						<label for="BookingBeds" class="col-sm-2 control-label">Beds</label>
						<p class="form-control-static">
							<?php echo $this->request->data['Booking']['beds']; ?>
						</p>
					</div>
					<div class="form-group">
						<label for="BookingLocation" class="col-sm-2 control-label">Location</label>
						<p class="form-control-static">
							<?php echo "$room_name @ $location_name"; ?>
						</p>
					</div>
					<div class="form-group" style="margin-top:-15px; color: gray;">
						<label for="QueryQuery" class="col-sm-2 control-label"></label>
						<div class="col-sm-8 input-group">
							<p class="form-control-static">
								<?php echo $location_desc[$location_id]; ?>
							</p>
						</div>
					</div>
				<?php } ?>

				<div class="form-group">
					<?php echo $this->Form->input('Upsell', array('disabled'=>'disabled', 'multiple'=>'checkbox', 'class'=>'form-control', 'placeholder'=>__('Fellow Email')));?>
				</div>
				
				<div class="form-group">
					<?php echo $this->Form->input('start', array(
						'type' => 'text',
						'data-provide' => 'datepicker',
						'data-date-language' => Configure::read('Config.locale'),
						'class' => 'form-control',
						'label' => __('Arrival'),
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
						'label' => __('Departure'),
						'placeholder' => __('End'),
						'inputGroup' => array('append'=>'glyphicon-th'),
						//BEWARE: datepicker needs JS initialization
						'value' => $this->Time->format($this->data['Booking']['end'], '%-d.%-m.%Y'),
						'disabled'=>'disabled'
					));?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->input('email', array('label'=>'Your email', 'class'=>'form-control', 'placeholder'=>__('Email')));?>
				</div>
				<!--div class="form-group">
					<?php echo $this->Form->input('fellow_email', array('label'=>'Room Fellows', 'class'=>'form-control', 'placeholder'=>__('Fellow Email')));?>
				</div-->
				<?php if (!empty($booking['Booking']['Upsell'])) { ?>
					<div class="form-group">
						<?php echo $this->Form->input('Upsell', array('multiple'=>'checkbox', 'class'=>'form-control', 'placeholder'=>__('Fellow Email')));?>
					</div>
				<?php } ?>
				<div class="form-group">
					<?php echo $this->Form->input('Meal', array('label'=>'Lunches', 'disabled'=>'disabled', 'multiple'=>'checkbox', 'class'=>'form-control', 'placeholder'=>__('Meals')));?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->input('Query', array('label'=>'MTM Content', 'multiple'=>'checkbox', 'class'=>'form-control', 'placeholder'=>__('Queries')));?>
				</div>
				
				<div class="form-group totalPriceDiv">
					<label for="UpsellUpsell" class="col-sm-2 control-label">Total price</label>
					<div class="col-sm-7 input-group totalPrice"><span class="glyphicon glyphicon-tag"></span>&nbsp;&nbsp;<?php echo $this->request->data['Booking']['web_price']; ?> CZK</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-8">
						<?php echo $this->Form->submit(__('Save Updated Details'), array('class'=>'btn btn-primary','style'=>'margin-top:45px; margin-bottom:45px')); ?>
					</div>

				</div>

			<?php echo $this->Form->end() ?>

		</div><!-- end col md 12 -->
	</div><!-- end row -->
</div>
