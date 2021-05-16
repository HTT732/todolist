$(document).ready(function() {
	// Create work
	$('#createWork').on('click', function () {
		var workName 	= $('#workName');
		var startingDay = $('#startingDay');
		var endingDay 	= $('#endingDay');
		var status 		= $('#status');

		//create work
		if (validate([workName, startingDay, endingDay, status]) && checkDate(startingDay.val(), endingDay.val())) {
			var data =  {
				'workName':workName.val(),
				'startingDay':startingDay.val(),
				'endingDay':endingDay.val(),
				'status':status.val()
			};

			var url = 'controller/create.php';
			
			//call ajax create work
			ajaxCreateOrEdit(data, url, 'create');
		}
	});

	// Edit click
	$('#listWork').on('click', '.edit-btn', function () {
		$work = $(this).closest('.my-work');

		// get data
		workName = $work.find('.work-name').html();
		startingDay = $work.find('.starting-day').html();
		endingDay = $work.find('.ending-day').html();
		status = $work.find('.progress-bar').attr('data-status');
		id = $(this).attr('data-id');

		// binding data
		$('#workNameInput').val(workName);
		$('#startingDayInput').val(startingDay);
		$('#endingDayInput').val(endingDay);
		$('#statusSelect').val(status);
		$('#updateBtn').attr('data-id', id);
	});

	// update click
	$('#updateBtn').on('click', function () {
		workName = $('#workNameInput');
		startingDay = $('#startingDayInput');
		endingDay = $('#endingDayInput');
		statusSelect = $('#statusSelect');
		id = $(this).attr('data-id');

		if (validate([workName, startingDay, endingDay, statusSelect]) && checkDate(startingDay.val(), endingDay.val())) {
			data = {
				'workName':workName.val(),
				'startingDay':startingDay.val(),
				'endingDay':endingDay.val(),
				'status':statusSelect.val(),
				'id':id
			};

			url = 'controller/edit.php';

			ajaxCreateOrEdit(data, url, 'edit');
		}
	});

	// delete work
	$('#listWork').on('click', '.delete-btn', function () {
		id = $(this).attr('data-id');
		url = 'controller/delete.php';

		$('#deleteWork').click(function () {
			// call ajax
			ajaxDelete(id, url);
		});
		
	});

	// check field is required
	function isRequired(data = '') {
		if (data.length == 0) {
			return false;
		}
		return true;
	}

	function showErrorValidate(el, message) {
		$parent = el.closest('div');
		$parent.find('.error').html(message);
	}

	function getMessageError(el) {
		label = el.closest('div').find('label').html();
		return 'Please choose a ' + label;
	}

	function validate(dataElement) {
		check = true;
		for(i = 0; i < dataElement.length; i++) {
			$el = dataElement[i];

			if(!isRequired($el.val().trim())) {
				check = false;
				showErrorValidate($el, getMessageError($el));
			} else {
				$el.closest('div').find('.error').html('');
			}
		}
		return check;
	}

	function checkDate(start, end) {
		var start = new Date(start);
		var end = new Date(end);

		if (start > end){
			$('#errorModal #contentError').html('\"Ending day\" must be greater than \"Starting day.\"');
			$('#errorModal').modal('toggle');
			return false;
		}
		return true;
	}

	// call ajax to edit or update
	function ajaxCreateOrEdit(data, url, action) {
		$.ajax({
			url: url,
			type: 'POST',
			dataType: 'json',
			data: data,
			async: true,
			success: function(id){
				if (action == 'create') {
					var html = "<div class='my-work card col-12 mt-3 px-2'>"+
								"<div class='row'>"+
									"<div class='col-8 card-body'>"+
										"<h6 class='card-title work-name'>"+data.workName+"</h6>"+
										"<div class='card-footer p-0 border-0 work-time'>"+
											"<li class='far fa-calendar'><span class='ml-1 starting-day'>"+data.startingDay+"</span></li>"+
											"<span class='mx-2'>-</span>"+
											"<li class='far fa-calendar-check'><span class='ml-1 ending-day'>"+data.endingDay+"</span></li>"+
										"</div>"+
									"</div>"+
									"<div class='col-3 card-body text-center row align-items-center'>"+
										"<div class='progress p-0'>"+
											"<div data-status="+data.status+" class='progress-bar' role='progressbar' style='width: 100%' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100'></div>"+
										"</div>"+
									"</div>"+
									"<div class='col-1 card-body text-center'>"+
										"<button type='button' data-bs-toggle='modal' data-bs-target='#editModal' class='edit-btn btn btn-primary mb-1' data-id='"+id+"'>"+
											"<li class='far fa-edit'></li>"+
										"</button>"+
										"<button type='button' data-bs-toggle='modal' data-bs-target='#deleteModal' class='delete-btn btn btn-secondary mt-1' data-id='"+id+"'>"+
											"<li class='far fa-trash-alt'></li>"+
										"</button>"+
									"</div>"+
								"</div>"+
							"</div>";
					$(html).prependTo($('#listWork'));

					// reset value input
					$('#formCreate input, select').val("");
				}

				if (action == 'edit') {
					$btnEdit = $('.my-work').find('button[data-id='+data.id+']');
					$currentWork = $btnEdit.closest('.my-work');

					$currentWork.find('.work-name').html(data.workName);
					$currentWork.find('.starting-day').html(data.startingDay);
					$currentWork.find('.ending-day').html(data.endingDay);
					$currentWork.find('.progress-bar').attr('data-status', data.status);

					$('#editModal .btn-close').click();
				}
			},
			error: function(error){
				if (action == 'create') {
					$('#formCreate .error-create').html(error);
				}

				if (action == 'edit') {
					$('#errorModal #contentError').html(error.responseText);
					$('#errorModal').modal('toggle');
				}
				$('#editModal .btn-close').click();
			}
		});
	}

	// call ajax to delete work
	function ajaxDelete(id, url) {
		$.ajax({
			url: url,
			type: 'POST',
			dataType: 'json',
			data:{
				'id':id
			},
			async: true,
			success: function(){
				$work = $('#listWork button[data-id='+id+']').closest('.my-work');
				$('#deleteModal .btn-close').click();
				$work.fadeOut('slow').remove();
			},
			error: function(error){
				$('#deleteModal .btn-close').click();
				$('#errorModal #contentError').html(error.responseText);
				$('#errorModal').modal('toggle');
			}
		});
	}
});