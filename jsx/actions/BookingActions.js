var AppDispatcher    = require('../dispatcher/AppDispatcher');
var BookingConstants = require('../constants/BookingConstants');

var BookingActions = {
	receiveRooms: function(rooms) {
		AppDispatcher.dispatch({
			actionType: BookingConstants.RECEIVE_ROOMS,
			data: rooms
		});
	},
	// Set currently selected room_id
	selectRoom: function(room_id) {
		AppDispatcher.dispatch({
			actionType: BookingConstants.SET_SELECTED,
			data: room_id
		});
	}
};

module.exports = BookingActions;
