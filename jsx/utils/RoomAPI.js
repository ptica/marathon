var BookingActions = require('../actions/BookingActions');

module.exports = {
	// Load mock product data into RoomStore via Action
	getRoomData: function(start, end) {
		var url = window.location.href;
		url = App.base + '/rooms/get';
		$.get(url, function(rooms) {
			rooms = JSON.parse(rooms);
			BookingActions.receiveRooms(rooms);
		});
	}
};
