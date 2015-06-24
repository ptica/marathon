var AppDispatcher    = require('../dispatcher/AppDispatcher');
var BookingConstants = require('../constants/BookingConstants');

var BookingActions = {
	// Room list has just arrived!
	receiveRooms: function(rooms) {
		AppDispatcher.dispatch({
			actionType: BookingConstants.RECEIVE_ROOMS,
			data: rooms
		});
	},
	// Upsell list has just arrived!
	receiveUpsells: function(upsells) {
		AppDispatcher.dispatch({
			actionType: BookingConstants.RECEIVE_UPSELLS,
			data: upsells
		});
	},
	// Meals list has just arrived!
	receiveMeals: function(meals) {
		AppDispatcher.dispatch({
			actionType: BookingConstants.RECEIVE_MEALS,
			data: meals
		});
	},
	// Queries list has just arrived!
	receiveQueries: function(queries) {
		AppDispatcher.dispatch({
			actionType: BookingConstants.RECEIVE_QUERIES,
			data: queries
		});
	},
	// Set currently selected room_id
	selectRoom: function(room_id) {
		AppDispatcher.dispatch({
			actionType: BookingConstants.SET_SELECTED,
			data: room_id
		});
	},
	selectUpsell: function(upsell_id) {
		AppDispatcher.dispatch({
			actionType: BookingConstants.ADD_UPSELL,
			data: upsell_id
		});
	},
	selectMeal: function(id) {
		AppDispatcher.dispatch({
			actionType: BookingConstants.ADD_MEAL,
			data: id
		});
	},
	selectQuery: function(id) {
		AppDispatcher.dispatch({
			actionType: BookingConstants.ADD_QUERY,
			data: id
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
