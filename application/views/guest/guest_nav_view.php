<nav class="sidebar <?php if(isset($sidebar_collapsed)){ if($sidebar_collapsed){ echo 'sidebar-collapsed toggled'; }} ?>">
	<div class="sidebar-content">
		<a class="sidebar-brand" href="<?=base_url()?>Guest/">
 		 	
	   	<span class="align-middle">MCQ Website</span>
    </a>
		<ul class="sidebar-nav">			
			<li class="sidebar-item">
				<a href="#" data-toggle="collapse" class="sidebar-link">
          <i class="align-middle" data-feather="sliders" style="color:#0070c0;"></i> <span class="align-middle">Quiz Dashboard</span>
        </a>
			</li>
		</ul>
		<div class="sidebar-bottom d-none d-lg-block">
			<div class="media">
				<img class="rounded-circle mr-3" src="<?=base_url()?>public/images/default.png" alt="Cashier Admin" width="40" height="40">
				<div class="media-body">
					<h5 class="mb-1"><?=$cashier_details['employee_first_name']?></h5>
					<div>
						<i class="fas fa-circle text-success"></i> Online
					</div>
				</div>
			</div>
		</div>
	</div>
</nav>
