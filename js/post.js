// MODULE: eonasdan timepicker
$('input[data-provide=datepicker]').datetimepicker({
    format: 'D.M.YYYY',
    minDate: '2015-09-02',
    maxDate: '2015-09-13',
    locale: 'en_GB'
})
.next().click(function() {
        // clicking an input-group-addon (next sibling)
        $(this).prev().focus();
});
$('input#CalendarItemStart').on('dp.hide', function (e) {
        // sensible default for BookingEnd
        var $end = $('input#CalendarItemEnd');
        $end.data('DateTimePicker').minDate(e.date);
        if (!$end.val()) {
            $end.data('DateTimePicker').date(e.date.add(1, 'h'));
        }
});
$('input[data-provide=datepicker]').on('dp.change', function (e) {
    // notify react Booking component of the change
    App.booking.countNights();
});

$('input#CalendarItemEnd').on('dp.hide', function (e) {
        // sensible default for BookingStart
        var $start = $('input#CalendarItemStart');
        $start.data('DateTimePicker').maxDate(e.date);
        if (!$start.val()) {
            $start.data('DateTimePicker').date(e.date.subtract(1, 'h'));
        }
});

// MODULE summernote
if ($().summernote) $('textarea[data-provide=wysiwyg]').summernote({
        lang: 'cs-CZ',
        height: 180,
        toolbar: [
                ['css', ['style']],
                ['style', ['bold', 'italic', 'underline', 'clear']],
        //      ['font', ['strikethrough', 'superscript', 'subscript', 'height']],
                ['para', ['ul', 'ol', 'paragraph', 'height']],
                ['insert', ['link', 'hr', 'table']],
                ['misc', ['codeview', 'fullscreen']],
                ['help', ['help']],
        ]
});

// MODULE sortable
$('.list-group').each(function (i,e) {
    var id = e.id;
    var $e = $(e);
    Sortable.create(document.getElementById(id), {
        handle: '.glyphicon-move',
        animation: 150,
        // dragging ended
        onEnd: function (/**Event*/ e) {
            var data = $e.find('[data-item-id]').map(function (i,v) {
                return {
                    'id': $(v).data('item-id'),
                    'ord': i
                };
            }).toArray();
            var url = $e.data('reorder-url') || window.location.href;
            $.post(url, {data:data});
        }
    });
});


App.fill = function () {
	$('form.fill input').not('[data-provide="datepicker"]').each(function (i,e) {
		var $e = $(e);
		var id = $e.attr('id');
		if (id) {
			$e.val(id.replace('Booking', ''));
		}
	});
	$('form.fill input[type="email"]').val('jan.ptacek@gmail.com');
	$('form.fill #BookingBeds').val(1);

	var b;
	b = moment('1.12.1970', 'D.M.YYYY');
	b = moment('30.12.1975', 'D.M.YYYY');
};

$('form.fill .submit input').on('click', function (event) {
	if (event.shiftKey) {
		App.fill();
		event.preventDefault();
		return false;
	}
});
