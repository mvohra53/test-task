<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Test Task</title>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/bootstrap.css">
</head>
<body>
	<div class="container">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h1 class="text-center">Edit profile</h1>
				<a href="<?=base_url()?>Welcome/users_list" class="btn btn-primary">Profile List</a>
			</div>
			<form method="POST" enctype="multipart/form-data">
				<div class="panel-body">
					<?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>
					<?php
					if($this->session->flashdata('error')!= ""){
						?>
						<p class="alert alert-danger"><?=$this->session->flashdata('error');?></p>
						<?php
					}
					?>
					<div class="form-group">
						<label>First Name*</label>
						<input type="text" name="first_name" class="form-control" required value="<?=$user_data->first_name?>" />
					</div>
					<div class="form-group">
						<label>Last Name*</label>
						<input type="text" name="last_name" class="form-control" required value="<?=$user_data->last_name?>" />
					</div>
					<div class="form-group">
						<label>Email</label>
						<input type="email" class="form-control" disabled value="<?=$user_data->email?>" />
					</div>
					<div class="form-group">
						<label>Phone No.*</label>
						<input type="text" name="phone_no" class="form-control" required value="<?=$user_data->phone_no?>" />
					</div>
					<div class="form-group">
						<label>Job Title</label>
						<select name="job_title" class="form-control" value="<?=$user_data->job_title?>">
							<option value="CXO" <?=($user_data->job_title == 'CXO')?'selected="selected"':''?>>CXO</option>
							<option value="VP" <?=($user_data->job_title == 'VP')?'selected="selected"':''?>>VP</option>
							<option value="PM" <?=($user_data->job_title == 'PM')?'selected="selected"':''?>>PM</option>
							<option value="Other <?=($user_data->job_title == 'Other')?'selected="selected"':''?>">Other</option>
						</select>
					</div>
					<div class="form-group">
						<label>Profile Photo</label>
						<input type="file" name="profile_pic" class="form-control" />
					</div>
				</div>
				<div class="panel-footer text-center">
					<button class="btn btn-primary btn-lg">Submit</button>
				</div>
			</form>
		</div>
	</div>
	<script type='text/javascript' src="<?php echo base_url(); ?>assets/js/jquery.js"></script>
	<script type='text/javascript' src="<?php echo base_url(); ?>assets/js/bootstrap.js"></script>
</body>
</html>