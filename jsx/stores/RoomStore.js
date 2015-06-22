var AppDispatcher = require('../dispatcher/AppDispatcher');
var EventEmitter = require('events').EventEmitter;
var BookingConstants = require('../constants/BookingConstants');
var assign = require('object-assign');

var CHANGE_EVENT = 'change';

var _rooms = [];
var _rooms_by_id = {null: {Room: {id:null}, Price: 0}};
var _selected_room_id = null;
var _selected_beds = 1;
var _start = moment('7.9.2015', 'D.M.YYYY');
var _end   = moment('12.9.2015', 'D.M.YYYY');

function receive_rooms(rooms) {
	// Receive ROOMS from server API.
	_rooms = rooms;

	// construct lookup table
	for (var key in rooms) {
		var id = rooms[key].Room.id;
		_rooms_by_id[id] = rooms[key];
	}
}

function set_selected_room(room_id) {
	_selected_room_id = room_id;
}

function set_selected_beds(count) {
	_selected_beds = count;
}

function set_selected_nights(data) {
	_start = moment(data.start, 'D.M.YYYY');
	_end = moment(data.end, 'D.M.YYYY');
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
		return _rooms_by_id[_selected_room_id];
	},

	getSelectedBeds: function() {
		return _selected_beds;
	},

	getNightsCount: function() {
		var nights_count = _end.diff(_start, 'days');
		if (nights_count < 0) nights_count = 0;
		console.log('nights_count:' + nights_count);
		return nights_count;
	},

	getStart: function() {
		return _start;
	},

	getEnd: function() {
		return _end;
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

		case BookingConstants.SET_BEDS:
			set_selected_beds(action.data);
			RoomStore.emitChange();
			break;

		case BookingConstants.SET_NIGHTS:
			set_selected_nights(action.data);
			RoomStore.emitChange();
			break;

		default:
		// no op
	}
});

module.exports = RoomStore;
