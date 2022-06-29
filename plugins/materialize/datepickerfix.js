(function() {
	var pickerElemList = document.querySelectorAll('.datepicker');
	var numPickers = pickerElemList.length;
	for(var i = 0; i < numPickers; i++) {
		pickerElemList[i].addEventListener('mousedown', function(e) {
			e.preventDefault();
		});
	}
})();