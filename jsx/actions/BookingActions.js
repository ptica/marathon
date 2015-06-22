var AppDispatcher = require('../dispatcher/AppDispatcher');
var BookingConstants = require('../constants/BookingConstants');

var BookingActions = {
	recieveRooms: function(rooms) {
		AppDispatcher.dispatch({
			actionType: BookingConstants.BOOKING_RECIEVE_ROOMS,
			rooms: rooms
		});
	},

	/**
	 * @param	{string} text
	 */
	create: function(text) {
		AppDispatcher.dispatch({
			actionType: BookingConstants.BOOKING_CREATE,
			text: text
		});
	},

	/**
	 * @param	{string} id The ID of the ToDo item
	 * @param	{string} text
	 */
	updateText: function(id, text) {
		AppDispatcher.dispatch({
			actionType: BookingConstants.BOOKING_UPDATE_TEXT,
			id: id,
			text: text
		});
	},

	/**
	 * Toggle whether a single ToDo is complete
	 * @param	{object} todo
	 */
	toggleComplete: function(todo) {
		var id = todo.id;
		var actionType = todo.complete ?
				BookingConstants.BOOKING_UNDO_COMPLETE :
				BookingConstants.BOOKING_COMPLETE;

		AppDispatcher.dispatch({
			actionType: actionType,
			id: id
		});
	},

	/**
	 * Mark all ToDos as complete
	 */
	toggleCompleteAll: function() {
		AppDispatcher.dispatch({
			actionType: BookingConstants.BOOKING_TOGGLE_COMPLETE_ALL
		});
	},

	/**
	 * @param	{string} id
	 */
	destroy: function(id) {
		AppDispatcher.dispatch({
			actionType: BookingConstants.BOOKING_DESTROY,
			id: id
		});
	},

	/**
	 * Delete all the completed ToDos
	 */
	destroyCompleted: function() {
		AppDispatcher.dispatch({
			actionType: TodoConstants.BOOKING_DESTROY_COMPLETED
		});
	}

};

module.exports = BookingActions;
