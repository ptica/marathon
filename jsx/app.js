var React = require('react');
var RoomAPI = require('./utils/RoomAPI');
var Booking = require('./components/Booking.react');

RoomAPI.getRoomData();

// initial render so we may setState
if ($('#Booking').length) {
	App.booking = React.render(<Booking/>, document.getElementById('Booking'));
}
