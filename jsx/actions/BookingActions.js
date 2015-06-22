var AppDispatcher    = require('../dispatcher/AppDispatcher');
var BookingConstants = require('../constants/BookingConstants');

var BookingActions = {
	// Rooms list has just arrived!
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
	},
	//
	selectBeds: function(count) {
		AppDispatcher.dispatch({
			actionType: BookingConstants.SET_BEDS,
			data: count
		});
	},
	setDates: function(start, end) {
		AppDispatcher.dispatch({
			actionType: BookingConstants.SET_NIGHTS,
			data: {
				start: start,
				end: end
			}
		});
	}
};

module.exports = BookingActions;
