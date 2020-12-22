<?php
	$this->load->view('universal/header_view');
?>
<main class="main d-flex w-100" id="login_page" >
	<div class="container d-flex flex-column">
		<div class="row h-100">
			<div class="col-sm-6 col-md-6 col-lg-6 mx-auto d-table h-100">
				<div class="d-table-cell align-middle">
					<div class="card">
						<div class="card-body">
							<div class="m-sm-4">
								<div class="text-center">
									<h3>Registration Page</h3>
								</div>
								<form id="GuestRegistration" method="POST" action="#">
									<div class="form-group">
										<label>User Name</label>
										<input class="form-control form-control-lg" type="text" name="guest_name" placeholder="Enter your Name" required />
									</div>
									<div class="form-group">
										<label>User Contact Number</label>
										<input class="form-control form-control-lg" type="text" name="guest_number" placeholder="Enter your Contact Number" data-mask="0000000000" required />
									</div>
									<div class="form-group">
										<label>User Email</label>
										<input class="form-control form-control-lg" type="email" name="guest_email" placeholder="Enter your Email" required />
									</div>
									<div class="form-group">
										<label>User Password</label>
										<input class="form-control form-control-lg" type="password" name="guest_password" placeholder="Enter your password" required />	
									</div>
									<div class="text-center">
									    <button type="submit" class="btn btn-lg btn-primary">Register</button> &ensp;<a href="<?=base_url()?>Guest/Login">Already Have Register?</a>
									</div>
								</form>
							</div>
						</div>
					</div>
					<div class="alert alert-dismissible feedback" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
              			</button>
						<div class="alert-message">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</main>
<?php
	$this->load->view('universal/footer_view');
?>
<!-----------------Important Scripts--------------------->

<script type="text/javascript">
	$(document).ready(function(){

		$(document).ajaxStart(function() {
      $("#load_screen").show();
    });

    $(document).ajaxStop(function() {
      $("#load_screen").hide();
    });
	  	
	  $("#GuestRegistration").validate({
	  	errorElement: "div",
	    rules: {
	        "guest_name" : {
	            required : true,
	            maxlength : 100
	        },
					"guest_number" : {
	            required : true,
	            maxlength : 10
	        },
					"guest_email" : {
	            required : true,
	            maxlength : 100
	        },
	        "guest_password" : {
	            required : true
	        }   
	    },
	    submitHandler: function(form) {
		    var url_dash = "<?=base_url()?>Guest/Login";
				var formData = $("#GuestRegistration").serialize(); 
				$.ajax({
	        url: "<?=base_url()?>Guest/Register",
	        data: formData,
	        type: "POST",
	        crossDomain: true,
					cache: false,
	        dataType : "json",
	    		success: function(data) {
	          if(data.success == 'true'){ 
	         		if($('.feedback').hasClass('alert-danger')){
	              $('.feedback').removeClass('alert-danger').addClass('alert-success');
	            }
	            else{
	              $('.feedback').addClass('alert-success');
	            }
	            $('.alert-message').html("").html(data.message);
	            window.location.href = url_dash;
	          }
	          else if (data.success == 'false'){
	           	if($('.feedback').hasClass('alert-success')){
	              $('.feedback').removeClass('alert-success').addClass('alert-danger');
	            }
	            else{
	              $('.feedback').addClass('alert-danger');
	            }
	            $('.alert-message').html("").html(data.message);                    
	          }
	        },
	        error: function(data){
						$('.feedback').addClass('alert-danger');
						$('.alert-message').html("").html(data.message); 
	        }
				});
			},
		});
	
	});
</script>

	
