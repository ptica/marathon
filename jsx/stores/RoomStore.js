var AppDispatcher = require('../dispatcher/AppDispatcher');
var EventEmitter = require('events').EventEmitter;
var BookingConstants = require('../constants/BookingConstants');
var assign = require('object-assign');

var CHANGE_EVENT = 'change';

var _rooms = [];
var _selected_room_id = null;

/**
 * Receive ROOMS from server API.
 * @param	{rooms} rooms
 */
function receive_rooms(rooms) {
	_rooms = rooms;
}

/**
 *
 * @param	{rooms} rooms
 */
function set_selected_room(room_id) {
	_selected_room_id = room_id;
}

var RoomStore = assign({}, EventEmitter.prototype, {
	/**
	 * Get the entire collection of Rooms.
	 * @return {object}
	 */
	getRooms: function() {
		return _rooms;
	},

	getSelectedRoom: function() {
		return _selected_room_id;
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
		case BookingConstants.RECEIVE_ROOMS:
			receive_rooms(action.data);
			RoomStore.emitChange();
			break;

		case BookingConstants.SET_SELECTED:
			set_selected_room(action.data);
			RoomStore.emitChange();
			break;

		default:
		// no op
	}
});

module.exports = RoomStore;
