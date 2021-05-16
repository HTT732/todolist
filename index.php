<?php 
include 'model/database.php';
$db = new Database();
?>

<!DOCTYPE html>
<html>
<head>
	<title>Todo Lists</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- css -->
	<link href="public/library/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="public/library/fontawesome-5.15.3/css/all.min.css">
	<link rel="stylesheet" type="text/css" href="public/css/style.css">

	<!-- script -->
	<script type="text/javascript" src="public/js/jquery-3.6.0.js"></script>
	<script src="public/library/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script type="text/javascript" src="public/js/app.js"></script>
</head>
<body>
	<div class="container">
		<section id="header">
			<nav class="navbar navbar-expand-lg navbar-dark">
				<div class="container-fluid">
					<div class="collapse navbar-collapse" id="navbarSupportedContent">
						<ul class="navbar-nav me-auto mb-2 mb-lg-0">
							<li class="nav-item">
								<a class="nav-link active fas fa-clipboard-list" aria-current="page" href="#"> Todo List</a>
							</li>
							<li class="nav-item">
								<a class="nav-link far fa-calendar-alt" href="view/calendar.php"> Calendar</a>
							</li>
						</ul>
					</div>
				</div>
			</nav>
		</section>

		<section id="content" class="my-3">
			<div class="row p-0 m-0">
				<form id="formCreate" class="row p-0 m-0 pt-2" action="index.html" onsubmit="return false">
					<div class="col-12 mb-3">
						<label for="workName" class="form-label">Work Name</label>
						<input type="text" class="form-control" id="workName" placeholder="Enter your text...">
						<div class='error text-danger'></div>
					</div>
					<div class="col-md-4">
						<label for="startingDay" class="form-label">Starting Day</label>
						<input type="date" class="form-control" id="startingDay" >
						<div class='error text-danger'></div>
					</div>
					<div class="col-md-4">
						<label for="endingDay" class="form-label">Ending Day</label>
						<input type="date" class="form-control" id="endingDay" >
						<div class='error text-danger'></div>
					</div>	
					<div class="col-md-4">
						<label for="status" class="form-label">Status</label>
						<select id="status" class="form-select">
							<option selected value=''>Choose...</option>
							<option value="Planning">Planning</option>
							<option value="Doing">Doing</option>
							<option value="Complete">Complete</option>
						</select>
						<div class='error text-danger'></div>
					</div>
					<div class='error-create text-danger'></div>
					<div class="d-flex justify-content-end">
						<button id="createWork" type="submit" class="btn btn-outline-danger my-4">Add</button>
					</div>
				</form>
				<div class="row col-6 mt-3 text-center">
					<div class="col">
						<div class="alert bg-info p-0" role="alert">
							<strong>Planning</strong>
						</div>
					</div>
					<div class="col">
						<div class="alert bg-warning p-0" role="alert">
							<strong>Doing</strong>
						</div>
					</div>
					<div class="col">
						<div class="alert bg-success p-0" role="alert">
							<strong>Complete</strong>
						</div>
					</div>
				</div>
				<div id="listWork" class="pb-2">
					
					<?php 
						$table = 'work';
						$data = $db->getArray($table);

						if (!empty($data)) {
							foreach($data as $value) {
					?>

					<div class="my-work card col-12 mt-3 px-2">
						<div class="row">
							<div class="col-8 card-body">
								<h6 class="work-name card-title"><?php echo $value['work_name']; ?></h6>
								<div class="card-footer p-0 border-0 work-time">
									<li class="far fa-calendar"><span class="starting-day"><?php echo $value['starting_day']; ?></span></li>
									<span class="mx-1">-</span>
									<li class="far fa-calendar-check"><span class="ending-day"><?php echo $value['ending_day']; ?></span></li>
								</div>
							</div>
							<div class="col-3 card-body text-center row align-items-center">
								<div class="progress p-0">
									<div class="progress-bar w-100" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" data-status="<?php echo $value['status'] ?>"></div>
								</div>
							</div>
							<div class="col-1 card-body text-center">
								<button type="button" class="edit-btn btn btn-primary mb-1" data-id='<?php echo $value['id']; ?>' data-bs-toggle="modal" data-bs-target="#editModal">
									<li class="far fa-edit"></li>
								</button>
								<button type="button" class="delete-btn btn btn-secondary mt-1" data-id='<?php echo $value['id'];?>' data-bs-toggle="modal" data-bs-target="#deleteModal">
									<li class="far fa-trash-alt"></li>
								</button>
							</div>
						</div>
					</div>
				<?php }}; ?>
				</div>
			</div>
		</section>
	</div> <!-- end container -->

	<!-- Edit Modal -->
	<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Edit work</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<form id="formEdit" class="row" onsubmit="return false">
					<div class="col-12 mb-3">
						<label for="workName" class="form-label">Work Name</label>
						<input type="text" class="form-control" id="workNameInput" placeholder="Enter your text...">
						<div class='error text-danger'></div>
					</div>
					<div class="col-md-4">
						<label for="startingDay" class="form-label">Starting Day</label>
						<input type="date" class="form-control" id="startingDayInput" >
						<div class='error text-danger'></div>
					</div>
					<div class="col-md-4">
						<label for="endingDay" class="form-label">Ending Day</label>
						<input type="date" class="form-control" id="endingDayInput" >
						<div class='error text-danger'></div>
					</div>	
					<div class="col-md-4">
						<label for="status" class="form-label">Status</label>
						<select id="statusSelect" class="form-select">
							<option selected value=''>Choose...</option>
							<option value="Planning">Planning</option>
							<option value="Doing">Doing</option>
							<option value="Complete">Complete</option>
						</select>
						<div class='error text-danger'></div>
					</div>
					<div class='error-create text-danger'></div>
				</form>
				</div>
				<div class="modal-footer">
					<button id="updateBtn" type="button" class="btn btn-outline-danger">Update</button>
				</div>
			</div>
		</div>
	</div>

	<!-- Confirm delete modal -->
	<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel2" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel2">Delete work</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<p>Do you want to delete it?</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
					<button type="button" id="deleteWork" class="btn btn-primary">Yes</button>
				</div>
			</div>
		</div>
	</div>

	<!-- show error -->
	<div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="contentError" aria-hidden="true" data-bs-backdrop="false">
		<div class="modal-dialog">
			<div class="modal-content p-0">
				<div class="modal-header alert alert-danger m-0">
					<p id="contentError">Delete work</p>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
			</div>
		</div>
	</div>

</body>
</html>