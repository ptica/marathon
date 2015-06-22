var AppDispatcher = require('../dispatcher/AppDispatcher');
var BookingConstants = require('../constants/BookingConstants');

var BookingActions = {
	receiveRooms: function(rooms) {
		AppDispatcher.dispatch({
			actionType: BookingConstants.BOOKING_RECEIVE_ROOMS,
			data: rooms
		});
	}
};

module.exports = BookingActions;
