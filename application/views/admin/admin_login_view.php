<?php
	$this->load->view('universal/header_view');
?>
<main class="main d-flex w-100" id="login_page">
	<div class="container d-flex flex-column">
		<div class="row h-100">
			<div class="col-sm-6 col-md-4 col-lg-4 mx-auto d-table h-100">
				<div class="d-table-cell align-middle">
					<div class="card">
						<div class="card-body">
							<div class="m-sm-4">
								<div class="text-center">
									<i class=" fa fa-user"></i>
								</div>
								<form id="AdminLogin" method="POST" action="#">
									<div class="form-group">
										<label>User Name</label>
										<input class="form-control form-control-lg" type="email" name="admin_email" placeholder="Enter your email" required />
									</div>
									<div class="form-group">
										<label>Password</label>
										<input class="form-control form-control-lg" type="password" name="admin_password" placeholder="Enter your password" required />	
									</div>
									<div class="text-center mt-3">
										<button type="submit" class="btn btn-lg btn-primary">Login</button>
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
	  	
	  	$("#AdminLogin").validate({
		  	errorElement: "div",
		    rules: {
		        "admin_email" : {
		            required : true,
		            maxlength : 100
		        },
		        "admin_password" : {
		            required : true
		        }   
		    },
		    submitHandler: function(form) {
		    	var url_dash = "<?=base_url()?>Admin/Dashboard";
				var formData = $("#AdminLogin").serialize(); 
				$.ajax({
			        url: "<?=base_url()?>Admin/Login",
			        data: formData,
			        type: "POST",
							cache: false,
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

	
