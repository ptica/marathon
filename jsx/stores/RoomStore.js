var AppDispatcher = require('../dispatcher/AppDispatcher');
var EventEmitter = require('events').EventEmitter;
var BookingConstants = require('../constants/BookingConstants');
var assign = require('object-assign');

var CHANGE_EVENT = 'change';

var _rooms = [];

/**
 * Receive ROOMS from server API.
 * @param	{rooms} rooms
 */
function receive_rooms(rooms) {
	_rooms = rooms;
}


var RoomStore = assign({}, EventEmitter.prototype, {
	/**
	 * Get the entire collection of Rooms.
	 * @return {object}
	 */
	getRooms: function() {
		return _rooms;
	},

	emitChange: function() {
		this.emit(CHANGE_EVENT);
	},

	/**
	 * @param {function} callback
	 */
	addChangeListener: function(callback) {
		this.on(CHANGE_EVENT, callback);
	},

	/**
	 * @param {function} callback
	 */
	removeChangeListener: function(callback) {
		this.removeListener(CHANGE_EVENT, callback);
	}
});

// Register callback to handle all updates
AppDispatcher.register(function(action) {
	switch(action.actionType) {
		case BookingConstants.BOOKING_RECEIVE_ROOMS:
			receive_rooms(action.data);
			RoomStore.emitChange();
			break;

		default:
		// no op
	}
});

module.exports = RoomStore;
