var React = require('react');
var RoomStore = require('../stores/RoomStore');
var Room = require('./Room.react');
var BookingActions = require('../actions/BookingActions');

/**
* Decimal adjustment of a number.
*
* @param {String}  type  The type of adjustment.
* @param {Number}  value The number.
* @param {Integer} exp   The exponent (the 10 logarithm of the adjustment base).
* @returns {Number} The adjusted value.
*/
function decimalAdjust(type, value, exp) {
	// If the exp is undefined or zero...
	if (typeof exp === 'undefined' || +exp === 0) {
	  return Math[type](value);
	}
	value = +value;
	exp = +exp;
	// If the value is not a number or the exp is not an integer...
	if (isNaN(value) || !(typeof exp === 'number' && exp % 1 === 0)) {
	  return NaN;
	}
	// Shift
	value = value.toString().split('e');
	value = Math[type](+(value[0] + 'e' + (value[1] ? (+value[1] - exp) : -exp)));
	// Shift back
	value = value.toString().split('e');
	return +(value[0] + 'e' + (value[1] ? (+value[1] + exp) : exp));
}

// Decimal round
if (!Math.round10) {
	Math.round10 = function(value, exp) {
	  return decimalAdjust('round', value, exp);
	};
}

/**
 * Retrieve the current data from the RoomStore
 */
function getAppState() {
	return {
		rooms: RoomStore.getRooms(),
		selected_room: RoomStore.getSelectedRoom(),
		selected_price_type_id: 2, // other // not used now !!!
		selected_beds: RoomStore.getSelectedBeds(),
		nights_count: RoomStore.getNightsCount(),
		selected_upsells: RoomStore.get_selected_upsells(),
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
		BookingActions.selectRoom(room_id);
	},
	selectUpsell: function (e) {
		var upsell_id = e.target.value;
		BookingActions.selectUpsell(upsell_id);
	},
	selectBeds: function (e) {
		var count = e.target.value;
		if (count === '' || ($.isNumeric(count) && count >= 0 && count < 5)) {
			BookingActions.selectBeds(count);
		} else {
			// to reset the input
			this.forceUpdate();
		}
	},
	countNights: function () {
		var start = this.refs.start.getDOMNode().value;
		var end = this.refs.end.getDOMNode().value;
		BookingActions.setDates(start, end);
	},
	get_selected_upsells_price: function () {
		var price = 0;
		var all_upsells = RoomStore.getUpsells(this.state.selected_room.Location.id);
		for (var key in all_upsells) {
			var upsell = all_upsells[key];
			if (upsell.id in this.state.selected_upsells) {
				price += upsell.price * this.state.nights_count * this.state.selected_beds;
			}
		}
		return price;
	},
	render: function() {
		// Rooms
		var all_rooms = this.state.rooms;
		var rooms = [];
		for (var key in all_rooms) {
			var selected = (this.state.selected_room.Room.id == all_rooms[key].Room.id);
			if (this.state.selected_beds <= all_rooms[key].Room.beds) {
				rooms.push(<Room key={key} selected={selected} room={all_rooms[key]} onClick={this.selectRoom}/>);
			}
		}
		if (rooms.length == 0) {
			rooms = <div className="none">Alas! No suitable room available.</div>;
		}

		// Upsells
		var all_upsells = RoomStore.getUpsells(this.state.selected_room.Location.id);
		var selected_upsells = this.state.selected_upsells;
		var upsells = [];
		for (var key in all_upsells) {
			var upsell = all_upsells[key];
			var checked = (upsell.id in selected_upsells);
			var dom_id = 'UpsellUpsell' + upsell.id;
			var input =
				<div className="checkbox" key={key}>
					<label htmlFor={dom_id} className="">
						<input checked={checked} onClick={this.selectUpsell} type="checkbox" name="data[Upsell][Upsell][]" value={upsell.id} id={dom_id}/>
						<div className="name">{upsell.name}</div>
						<div className="price">+ {upsell.price} CZK <span className="notice">per bed per night</span></div>
					</label>
				</div>;
			upsells.push(input);
		}

		if (upsells.length == 0) {
			upsells = <div className="none">No addons available for selected room.</div>;
		}

		// Others
		var selected_room = this.state.selected_room;
		var room_price  = selected_room.Price * this.state.nights_count * this.state.selected_beds;
		var upsell_price = this.get_selected_upsells_price();
		var total_price = Math.round10(room_price + upsell_price, -2).toFixed(2);

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
						<label htmlFor="BookingLastname" className="col-sm-2 control-label">Last name</label>
						<div className="col-sm-8 input-group">
							<input ref="lastname" name="data[Booking][secondname]" className="form-control" placeholder="Last name" maxLength="255" type="text" id="BookingLastname" required="required"/>
						</div>
					</div>

					<div className="form-group">
						<label htmlFor="BookingEmail" className="col-sm-2 control-label">Email</label>
						<div className="col-sm-8 input-group">
							<input ref="email" name="data[Booking][email]" className="form-control" placeholder="Email" maxLength="255" type="email" id="BookingEmail" required="required"/>
						</div>
					</div>

					<div className="form-group">
						<label htmlFor="BookingStart" className="col-sm-2 control-label">Arrival</label>
						<div className="col-sm-8 input-group">
							<div className="input-group">
								<input ref="start" onChange={this.countNights} defaultValue="7.9.2015" name="data[Booking][start]" className="form-control" data-provide="datepicker" placeholder="Start" type="text" id="BookingStart"/>
								<span className="input-group-addon"><i className="glyphicon glyphicon-th"></i></span>
							</div>
						</div>
					</div>

					<div className="form-group">
						<label htmlFor="BookingEnd" className="col-sm-2 control-label">Departure</label>
						<div className="col-sm-8 input-group">
							<div className="input-group">
								<input ref="end" onChange={this.countNights} defaultValue="12.9.2015" name="data[Booking][end]" className="form-control" data-provide="datepicker" placeholder="End" type="text" id="BookingEnd"/>
								<span className="input-group-addon"><i className="glyphicon glyphicon-th"></i></span>
							</div>
						</div>
					</div>

					<div className="form-group">
						<label htmlFor="BookingNights" className="col-sm-2 control-label">Nights</label>
						<div className="col-sm-8 input-group rooms">
							<div className="none">{this.state.nights_count}</div>
						</div>
					</div>

					{/*<div className="form-group">
						<label htmlFor="BookingPriceTypeId" className="col-sm-2 control-label">Price Type</label>
						<div className="col-sm-8 input-group">
							<input type="hidden" name="data[Booking][price_type_id]" value="" id="BookingPriceTypeId"/>
							<div className="checkbox"><label htmlFor="BookingPriceTypeId3" className=""><input type="checkbox" name="data[Booking][price_type_id][]" value="3" id="BookingPriceTypeId3"/> faculty quest</label></div>
							<div className="checkbox"><label htmlFor="BookingPriceTypeId1" className=""><input type="checkbox" name="data[Booking][price_type_id][]" value="1" id="BookingPriceTypeId1"/> student or lecturer</label></div>
							<div className="checkbox"><label htmlFor="BookingPriceTypeId2" className=""><input type="checkbox" name="data[Booking][price_type_id][]" value="2" id="BookingPriceTypeId2"/> other</label></div>
						</div>
					</div>*/}

					<div className="form-group">
						<label htmlFor="BookingBeds" className="col-sm-2 control-label">Beds</label>
						<div className="col-sm-8 input-group">
							<input ref="beds" value={this.state.selected_beds} onChange={this.selectBeds} name="data[Booking][beds]" className="form-control" placeholder="Beds" type="tel" id="BookingBeds" required="required"/>
						</div>
					</div>

					<div className="form-group">
						<label htmlFor="BookingRooms" className="col-sm-2 control-label">Rooms</label>
						<div className="col-sm-8 input-group rooms">
							{rooms}
						</div>
					</div>

					<div className="form-group">
						<label htmlFor="BookingFellowEmail" className="col-sm-2 control-label">Room Fellows</label>
						<div className="col-sm-8 input-group">
							<input ref="fellow_email" name="data[Booking][fellow_email]" className="form-control" placeholder="fill in emails of participants you want to share the room with (comma separated)" maxLength="255" type="text" id="BookingFellowEmail"/>
						</div>
					</div>

					<div className="form-group">
						<label htmlFor="UpsellUpsell" className="col-sm-2 control-label">Addons</label>
						<div className="col-sm-8 input-group upsells">
							<input type="hidden" name="data[Upsell][Upsell]" value="" id="UpsellUpsell"/>
							{upsells}
						</div>
					</div>

					<div className="form-group">
						<label htmlFor="UpsellUpsell" className="col-sm-2 control-label">Total price</label>
						<div className="col-sm-8 input-group totalPrice">{total_price} CZK</div>
					</div>

					<div className="form-group">
						<div className="col-sm-offset-2 col-sm-8">
							<div className="submit">
								<input className="btn btn-primary" type="submit" value="Register!"/>
							</div>
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
