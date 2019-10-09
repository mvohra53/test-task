<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Test Task</title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/fancybox.css">
</head>
<body>
	<div class="container">
		<div class="panel panel-default">
			<div class="panel-heading">
                <h1 class="text-center">Profile List</h1>
                <a href="<?=base_url()?>" class="btn btn-primary">Add Profile</a>
			</div>
			<div class="panel-body table-response">
                <?php
                if($this->session->flashdata('success')!= ""){
                    ?>
                    <p class="alert alert-success"><?=$this->session->flashdata('success');?></p>
                    <?php
                }
                ?>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                           <th>Name</th>
                           <th>Email</th>
                           <th>Phone</th>
                           <th>Job Title</th>
                           <th>Profile Pic</th>
                           <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach($profile_list as $pl){
                            ?>
                            <tr>
                                <td><?=$pl->first_name." ".$pl->last_name?></td>
                                <td><?=$pl->email?></td>
                                <td><?=$pl->phone_no?></td>
                                <td><?=$pl->job_title?></td>
                                <td>
                                    <a href="<?=base_url()."uploads/".$pl->profile_pic?>" data-fancybox="gallery">
                                        <img src="<?=base_url()."uploads/".$pl->profile_pic?>" width="50px" height="50px" />
                                    </a>
                                </td>
                                <td>
                                    <a href="<?=base_url()."welcome/edit_profile/".$pl->ID?>" class="btn btn-info">
                                        Edit
                                    </a>
                                    <a href="<?=base_url()."welcome/delete_profile/".$pl->ID?>" class="btn btn-danger">
                                        Delete
                                    </a>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
		</div>
	</div>
	<script type='text/javascript' src="<?php echo base_url(); ?>assets/js/jquery.js"></script>
    <script type='text/javascript' src="<?php echo base_url(); ?>assets/js/bootstrap.js"></script>
    <script type='text/javascript' src="<?php echo base_url(); ?>assets/js/fancybox.js"></script>
</body>
</html>