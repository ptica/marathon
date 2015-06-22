var AppDispatcher = require('../dispatcher/AppDispatcher');
var EventEmitter = require('events').EventEmitter;
var BookingConstants = require('../constants/BookingConstants');
var assign = require('object-assign');

var CHANGE_EVENT = 'change';

var _rooms = {};

/**
 * Get ROOMS from server API.
 * @param	{start} moment
 * @param	{end} moment
 * @param	{price_type} int
 * @param	{beds} number
 */
function get_rooms(start, end, price_type, beds) {

}

/**
 * Receive ROOMS from server API.
 * @param	{rooms} rooms
 */
function receive_rooms(rooms) {

}


var RoomStore = assign({}, EventEmitter.prototype, {
	/**
	 * Get the entire collection of Rooms.
	 * @return {object}
	 */
	getAll: function() {
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
	var text;

	switch(action.actionType) {
		case BookingConstants.BOOKING_RECIEVE_ROOMS:
			if (text !== '') {
				create(text);
				RoomStore.emitChange();
			}
			break;

		default:
			// no op
	}
});

module.exports = RoomStore;
