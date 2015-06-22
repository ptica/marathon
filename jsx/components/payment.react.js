var React = require('react');
var BookingStore = require('../stores/BookingStore');

var Payment = React.createClass({
	getInitialState: function() {
		return {};
 	},
	get_price: function () {
	},
	render: function() {
		var price  = App.booking.get_price();
		var locale = App.locale;
		var booking_id = App.booking.get_booking_id();
		var payment_id = App.booking.get_payment_id();
		var csas_code  = App.booking.get_csas_code();
		var csas_price = App.booking.get_csas_price();
		var csas_locale = __('E-EN');
		var hidden = $('#step-4').length ? '' : 'hidden';
		return (
			<div>
				<div className="highlight">
					<h1>{__("Payment")}</h1>
					<div className="total">
						{__("MTM 2015 Registration")}
						<span className="price">{price}</span>
					</div>
				</div>
				<form id="payment_post" name="MERCHANTFORM" method="post" action="https://test.3dsecure.gpwebpay.com/kb/order.do">
					<input type="hidden" name="MERCHANTNUMBER" value={9671935009} />
					<input type="hidden" name="OPERATION" value="CREATE_ORDER" />
					<input type="hidden" name="AMOUNT" value={csas_price} />
					<input type="hidden" name="CURRENCY" value={csas_code} />
					<input type="hidden" name="DEPOSITFLAG" value="sale" />
					<input type="hidden" name="ORDERNUMBER" value={payment_id} />
					<input type="hidden" name="Xmerchantdesc" value={__("Your Order") + " " + booking_id} />
					<input type="hidden" name="Xlanguage" value={csas_locale} />
					<input type="hidden" name="Xorderid1" value={booking_id} />
				</form>
				<div className="navigation">
					<div className={hidden + " back-link"}><i /><i /> {__("Back")}</div>
					<button className="continue" id="csas_pay">{__("GO TO PAYMENT")}</button>
				</div>
			</div>
		);
	}
});

// initial render so we may setState
if ($('#Payment').length) {
	App.payment = React.render(<Payment/>, document.getElementById('Payment'));
}

module.exports = Payment;
