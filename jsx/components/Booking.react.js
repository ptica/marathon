var React = require('react');
var RoomStore = require('../stores/RoomStore');
var Room = require('./Room.react');

/**
 * Retrieve the current data from the RoomStore
 */
function getAppState() {
	return {
		rooms: RoomStore.getRooms(),
		booking_id: false,
		payment_id: false,
		email: 'email@example.com'
	};
}

var Booking = React.createClass({
	getInitialState: function() {
		return getAppState();
	},
	componentDidMount: function () {
		RoomStore.addChangeListener(this._onChange);
	},
	componentWillUnmount: function() {
		RoomStore.removeChangeListener(this._onChange);
 	},
	/**
	* Event handler for 'change' events coming from the RoomStore
	*/
	_onChange: function() {
		this.setState(getAppState());
	},
	selectRoom: function (room_id) {
		console.log(room_id);
		//this.setState(getAppState());
	},
	render: function() {
		var all_rooms = this.state.rooms;
		var rooms = [];
		for (var key in all_rooms) {
			rooms.push(<Room key={key} room={all_rooms[key]} onClick={this.selectRoom}/>);
		}

		return (
			<div>
				<div className="row">
					<div className="col-md-12">
						<div className="page-header">
							<ul className="nav nav-pills nav-stacked pull-right">
								<li><span className="glyphicon glyphicon-tag"></span>&nbsp;&nbsp;PRICE</li>
							</ul>
							<h1>Registration</h1>
						</div>
					</div>
				</div>

				<div className="row">
				<div className="col-md-9">
				<form action="/admin/bookings/add" role="form" className="form-horizontal" id="BookingAdminAddForm" method="post" acceptCharset="utf-8">
					<div className="form-group">
						<label htmlFor="BookingFirstname" className="col-sm-2 control-label">First name</label>
						<div className="col-sm-8 input-group">
							<input ref="firstname" name="data[Booking][firstname]" className="form-control" placeholder="First name" maxLength="255" type="text" id="BookingSecondname" required="required"/>
						</div>
					</div>

					<div className="form-group">
						<label htmlFor="BookingSecondname" className="col-sm-2 control-label">Second name</label>
						<div className="col-sm-8 input-group">
							<input ref="secondname" name="data[Booking][secondname]" className="form-control" placeholder="Second name" maxLength="255" type="text" id="BookingSecondname" required="required"/>
						</div>
					</div>

					<div className="form-group">
						<label htmlFor="BookingEmail" className="col-sm-2 control-label">Email</label>
						<div className="col-sm-8 input-group">
							<input ref="email" name="data[Booking][email]" className="form-control" placeholder="Email" maxLength="255" type="email" id="BookingEmail" required="required"/>
						</div>
					</div>

					<div className="form-group">
						<label htmlFor="BookingStart" className="col-sm-2 control-label">Start</label>
						<div className="col-sm-8 input-group">
							<div className="input-group">
								<input ref="start" defaultValue="7.9.2015" name="data[Booking][start]" className="form-control" data-provide="datepicker" data-date-language="cs_CZ" placeholder="Start" type="text" id="BookingStart"/>
								<span className="input-group-addon"><i className="glyphicon glyphicon-th"></i></span>
							</div>
						</div>
					</div>

					<div className="form-group">
						<label htmlFor="BookingEnd" className="col-sm-2 control-label">End</label>
						<div className="col-sm-8 input-group">
							<div className="input-group">
								<input ref="end" defaultValue="12.9.2015" name="data[Booking][end]" className="form-control" data-provide="datepicker" data-date-language="cs_CZ" placeholder="End" type="text" id="BookingEnd"/>
								<span className="input-group-addon"><i className="glyphicon glyphicon-th"></i></span>
							</div>
						</div>
					</div>

					<div className="form-group">
						<label htmlFor="BookingPriceTypeId" className="col-sm-2 control-label">Price Type</label>
						<div className="col-sm-8 input-group">
							<input type="hidden" name="data[Booking][price_type_id]" value="" id="BookingPriceTypeId"/>
							<div className="checkbox"><label htmlFor="BookingPriceTypeId3" className=""><input type="checkbox" name="data[Booking][price_type_id][]" value="3" id="BookingPriceTypeId3"/> faculty quest</label></div>
							<div className="checkbox"><label htmlFor="BookingPriceTypeId1" className=""><input type="checkbox" name="data[Booking][price_type_id][]" value="1" id="BookingPriceTypeId1"/> student or lecturer</label></div>
							<div className="checkbox"><label htmlFor="BookingPriceTypeId2" className=""><input type="checkbox" name="data[Booking][price_type_id][]" value="2" id="BookingPriceTypeId2"/> other</label></div>
						</div>
					</div>

					<div className="form-group">
						<label htmlFor="BookingBeds" className="col-sm-2 control-label">Beds</label>
						<div className="col-sm-8 input-group">
							<input ref="beds" name="data[Booking][beds]" className="form-control" placeholder="Beds" type="number" id="BookingBeds" required="required"/>
						</div>
					</div>

					<div className="form-group">
						<label htmlFor="BookingRooms" className="col-sm-2 control-label">Rooms</label>
						<div className="col-sm-8 input-group rooms">
							{rooms}
						</div>
					</div>

					<div className="form-group">
						<label htmlFor="BookingFellowEmail" className="col-sm-2 control-label">Fellow Email</label>
						<div className="col-sm-8 input-group">
							<input ref="fellow_email" name="data[Booking][fellow_email]" className="form-control" placeholder="Fellow Email" maxLength="255" type="text" id="BookingFellowEmail"/>
						</div>
					</div>

					<div className="form-group">
						<label htmlFor="UpsellUpsell" className="col-sm-2 control-label">Upsell</label>
						<div className="col-sm-8 input-group">
							<input type="hidden" name="data[Upsell][Upsell]" value="" id="UpsellUpsell"/>
							<div className="checkbox"><label htmlFor="UpsellUpsell2" className=""><input type="checkbox" name="data[Upsell][Upsell][]" value="2" id="UpsellUpsell2"/> internet via RJ45</label></div>
							<div className="checkbox"><label htmlFor="UpsellUpsell1" className=""><input type="checkbox" name="data[Upsell][Upsell][]" value="1" id="UpsellUpsell1"/> breakfast</label></div>
						</div>
					</div>
				</form>
				</div>
				</div>
			</div>
		);
	}
});

module.exports = Booking;
