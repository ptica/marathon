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
	onClick: function(e) {
		var $input = $(e.target).closest('.room').find('input');
		var room_id = $input.val();
		// set state on parent via a props.onClick callback
		this.props.onClick(room_id);
	},
	render: function() {
		var className = "room";
		if (this.props.selected) {
			className += " selected";
		}
		return (
			<div className={className} onClick={this.onClick}>
				<input checked={this.props.selected} ref={'room'+this.props.room.Room.id} type="checkbox" name="data[Room][id]" value={this.props.room.Room.id}/>
				<h2>
					<span>{this.props.room.Room.name}</span>
					<span className="location"> @ {this.props.room.Location.name}</span>
				</h2>
				<p>
					{this.props.room.Location.desc}
				</p>
				<div className="price">
					<span>{this.props.room.Price[0].price} CZK</span>
					<span className="notice">per bed per night</span>
				</div>

			</div>
		);
	}
});

module.exports = Room;
