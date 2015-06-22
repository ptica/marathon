var AppDispatcher = require('../dispatcher/AppDispatcher');
var EventEmitter = require('events').EventEmitter;
var BookingConstants = require('../constants/BookingConstants');
var assign = require('object-assign');

var CHANGE_EVENT = 'change';

var _todos = {};

/**
 * Create a BOOKING item.
 * @param	{string} text The content of the BOOKING
 */
function create(text) {
	// Hand waving here -- not showing how this interacts with XHR or persistent
	// server-side storage.
	// Using the current timestamp + random number in place of a real id.
	var id = (+new Date() + Math.floor(Math.random() * 999999)).toString(36);
	_todos[id] = {
		id: id,
		complete: false,
		text: text
	};
}

/**
 * Update a BOOKING item.
 * @param	{string} id
 * @param {object} updates An object literal containing only the data to be
 *		 updated.
 */
function update(id, updates) {
	_todos[id] = assign({}, _todos[id], updates);
}

/**
 * Update all of the BOOKING items with the same object.
 *		 the data to be updated.	Used to mark all BOOKINGs as completed.
 * @param	{object} updates An object literal containing only the data to be
 *		 updated.

 */
function updateAll(updates) {
	for (var id in _todos) {
		update(id, updates);
	}
}

/**
 * Delete a BOOKING item.
 * @param	{string} id
 */
function destroy(id) {
	delete _todos[id];
}

/**
 * Delete all the completed BOOKING items.
 */
function destroyCompleted() {
	for (var id in _todos) {
		if (_todos[id].complete) {
			destroy(id);
		}
	}
}

var BookingStore = assign({}, EventEmitter.prototype, {
	/**
	 * Tests whether all the remaining BOOKING items are marked as completed.
	 * @return {boolean}
	 */
	areAllComplete: function() {
		for (var id in _todos) {
			if (!_todos[id].complete) {
				return false;
			}
		}
		return true;
	},

	/**
	 * Get the entire collection of BOOKINGs.
	 * @return {object}
	 */
	getAll: function() {
		return _todos;
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
		case BookingConstants.BOOKING_CREATE:
			text = action.text.trim();
			if (text !== '') {
				create(text);
				BookingStore.emitChange();
			}
			break;

		case BookingConstants.BOOKING_TOGGLE_COMPLETE_ALL:
			if (BookingStore.areAllComplete()) {
				updateAll({complete: false});
			} else {
				updateAll({complete: true});
			}
			BookingStore.emitChange();
			break;

		case BookingConstants.BOOKING_UNDO_COMPLETE:
			update(action.id, {complete: false});
			BookingStore.emitChange();
			break;

		case BookingConstants.BOOKING_COMPLETE:
			update(action.id, {complete: true});
			BookingStore.emitChange();
			break;

		case BookingConstants.BOOKING_UPDATE_TEXT:
			text = action.text.trim();
			if (text !== '') {
				update(action.id, {text: text});
				BookingStore.emitChange();
			}
			break;

		case BookingConstants.BOOKING_DESTROY:
			destroy(action.id);
			BookingStore.emitChange();
			break;

		case BookingConstants.BOOKING_DESTROY_COMPLETED:
			destroyCompleted();
			BookingStore.emitChange();
			break;

		default:
			// no op
	}
});

module.exports = BookingStore;
