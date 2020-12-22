<?php
	$this->load->view('admin/admin_header_view');
?>
<div class="wrapper">
	<?php
		$this->load->view('admin/admin_nav_view');
	?>
	<div class="main">
		<?php
			$this->load->view('admin/admin_top_nav_view');
		?>	
		<main class="content">
			<div class="container-fluid p-0">		
				<div class="card">
					<div class="card-header">
						<h1 class="card-title">Visiting User Data</h3>
					</div>
					<div class="card-body">
						<table class="table table-hover datatables-basic" width="100%;">
							<thead>
								<th>Sr. No.</th>
								<th>User Name</th>
								<th>User Email</th>
								<th>User Contact</th>
								<th>User Score</th>
								<th>Test Date</th>
							</thead>
							<tbody>
								<?php $count=1; foreach($score as $score){?>
									<tr>
										<td style="width:15%;"><?=$count?></td>
										<td style="width:15%;"><?=$score['guest_name']?></td>
										<td style="width:15%;"><?=$score['guest_email']?></td>
										<td style="width:15%;"><?=$score['contact']?></td>
										<td style="width:15%;"><?=$score['guest_score']?></td>
										<td style="width:15%;"><?=$score['test_date']?></td>
									</tr>
								<?php $count++; }?>								
							</tbody>
						</table>
					</div>
				</div>
			</div>	
		</main>
<?php
	$this->load->view('admin/admin_footer_view');
?>
<script type="text/javascript">
	$(".datatables-basic").DataTable({
			responsive: true
		});
</script>
