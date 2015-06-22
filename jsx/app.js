var React = require('react');
var RoomAPI = require('./utils/RoomAPI');
var Booking = require('./components/Booking.react');
var Payment = require('./components/Payment.react');

RoomAPI.getRoomData();

// initial render so we may setState
if ($('#Booking').length) {
	App.booking = React.render(<Booking/>, document.getElementById('Booking'));
}

// initial render so we may setState
if ($('#Payment').length) {
	//App.payment = React.render(<Payment/>, document.getElementById('Payment'));
}
