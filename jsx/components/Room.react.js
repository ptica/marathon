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
			<div className="room">
				<input type="checkbox" name="data[Room][id]" value="{this.props.room.Room.id}"/>
				<h2>
					<span>{this.props.room.Room.name}</span>
					<span className="location"> @ {this.props.room.Location.name}</span>
				</h2>
				<p>
					{this.props.room.Location.desc}
				</p>
				<div className="price">
					{this.props.room.Price[0].price}
				</div>

			</div>
		);
	}
});

module.exports = Room;
