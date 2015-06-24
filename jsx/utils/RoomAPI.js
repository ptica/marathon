var BookingActions = require('../actions/BookingActions');

module.exports = {
	// Load mock product data into RoomStore via Action
	getRoomData: function(start, end) {
		var url = window.location.href;
		url = App.base + '/rooms/get';
		$.get(url, function(data) {
			data = JSON.parse(data);
			BookingActions.receiveRooms(data.rooms);
			BookingActions.receiveUpsells(data.upsells);
			BookingActions.receiveMeals(data.meals);
			BookingActions.receiveQueries(data.queries);
		});
	}
};
