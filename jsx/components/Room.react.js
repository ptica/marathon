var React = require('react');
var RoomStore = require('../stores/RoomStore');

var Room = React.createClass({
	componentDidMount: function () {
	},
	componentWillUnmount: function() {
 	},
	/**
	* Event handler for 'change' events coming from the ???Store
	*/
	_onChange: function() {
	},
	render: function() {
		return (
			<div className="room">{this.props.room.Room.name}</div>
		);
	}
});

module.exports = Room;
