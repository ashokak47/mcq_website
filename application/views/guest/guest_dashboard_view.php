<?php
	$this->load->view('guest/guest_header_view');
?>
<div class="wrapper">
	<?php
		$this->load->view('guest/guest_nav_view');
	?>
	<div class="main">
		<?php
			$this->load->view('guest/guest_top_nav_view');
		?>
		<main class="content">
			<div class="container-fluid p-0">
				
				<div class="row mt-5">
					<div class="col-md-12">
						<?php
							if(!empty($questions))
							{

								$count=1;
								foreach($questions as $key=>$ques){
									$correct_ans=array();
									foreach($ques as $k=>$q){												
									array_push($correct_ans,$q['correct_answer']);				
									?>
									<div class="card">
									<div class="card-header bg-primary">
										<h3 class="card-title"><?php  echo "Question  ".$count." :- ".$q['question'];?></h3>
										<!-- <h4><?php  echo "Category : ".$q['category'];?></h4>
										<h5><?php  echo "Type : ".$q['type'];?></h4>
										<h6><?php  echo "Difficulty : ".$q['difficulty'];?></h4> -->
									</div>
									<div class="card-body">
										<?php
										$ar = array_merge($q['incorrect_answers'],[$q['correct_answer']]);
										
										// print_r($ar);
										foreach($ar as $q=>$a){
										?>
										<input type="radio" name='user_answer<?=$count?>' class="answer" value="<?=$a?>"> <?=$a?><br/><br>
										<?php
										}
										?>
									</div>
									</div>
									<?php
									$count++;
									}
									
								}
							}	
						?>
					</div>
				</div>
				<div class="row mt-5">
					<div class="col-md-6">
						<form id="score_form" method="POST" action="#">
							<input type="hidden" name="guest_id" value="<?=$guest_id?>">
							<input type="hidden" name="guest_score">
							<button type="submit" class="btn btn-primary" >Submit </button>
						</form>
					</div>
					<div class="col-md-2">
						<h2 style="color:orange;">Score :</h2>
					</div>
					<div class="col-md-3"><h3 id="score_card"></h3></div>
				</div>
			</div>
		</main>
<?php
	$this->load->view('guest/guest_footer_view');
?>

<script type="text/javascript">
	$(document).ready(function(){
		$(document).ajaxStart(function() {
      $("#load_screen").show();
    });

    $(document).ajaxStop(function() {
      $("#load_screen").hide();
    });    
    
    $("#score_form").validate({
	  	errorElement: "div",
	    rules: {
	        "guest_id" : {
            required : true
	        }
	    },
	    submitHandler: function(form) {
				var formData = $("#score_form").serialize(); 
				$.ajax({
	        url: "<?=base_url()?>Guest/AddGuestScore",
	        data: formData,
	        type: "POST",
					cache: false,
	    		success: function(data) {
            if(data.success == 'true'){
            	alert(data.message);
            }
            else if (data.success == 'false'){                   
        	    alert(data.message);
            }
          },
          error: function(data){
  					$('.feedback').addClass('alert-danger');
  					$('.alert-message').html("").html(data.message); 
          }
				});
			},
		});
		var user_ans=[];
		var js_array = [<?php echo '"'.implode('","', $correct_ans).'"' ?>];
		var score=0;
		$(document).on('click','.answer',function(e){
			var ans=$(this).val();			
			user_ans.push($(this).val());
		
			if(js_array.includes(ans)){
				// alert("Correct Answer");
				score=score+1;

				$("#score_card").text(score);
				$("#score_form input[name=guest_score]").attr('value',score);
			}else{
				// alert("Wrong Answer");
			}
			
		});
	});
</script>
