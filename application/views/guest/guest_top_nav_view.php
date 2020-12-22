
<nav class="navbar navbar-expand">
	<a class="sidebar-toggle d-flex mr-2">
		<i class="hamburger align-self-center"></i>
	</a>
			<li class="nav-item dropdown ">
				<a class="nav-link dropdown-toggle d-none d-sm-inline-block text-white " href="#" data-toggle="dropdown">
			    <img src="<?=base_url()?>public/images/default.png" class="avatar img-fluid rounded-circle mr-1 " alt="Guest" /> <span class="text-white font-weight-bold"><?=$guest_name?></span>
			  	</a>
				<div class="dropdown-menu dropdown-menu-right">				
					<a class="dropdown-item" href="#"><i class="align-middle mr-1" data-feather="user"></i> Profile</a>
					<a class="dropdown-item" href="<?=base_url()?>Guest/Login/">Sign out</a>
				</div>
			</li>
</nav>
