		<!-- Bottom Navbar -->
		<?php
		if ($this->userData['user_tipe'] == 1) {
		?>

			<b>
				<nav class="navbar navbar-dark bg-light navbar-expand border-top fixed-bottom m-auto p-0" style="max-width: <?= $max_width ?>;min-width: <?= $min_width ?>;">
					<ul class="navbar-nav nav-justified w-100">
						<li class="nav-item">
							<a href="<?= $this->BASE_URL ?>Staff" class="<?= $class_menu ?>"><i class="fas fa-users"></i><br>Staff</a>
						</li>
						<li class="nav-item">
							<a href="<?= $this->BASE_URL ?>SubMenu" class="<?= $class_menu ?>"><i class="fas fa-cog"></i><br>Set Up</a>
						</li>
						<li class="nav-item">
							<a href="<?= $this->BASE_URL ?>Approval" class="<?= $class_menu ?>"><i class="fas fa-check-double"></i><br>Approval</a>
						</li>
						<li class="nav-item">
							<a href="<?= $this->BASE_URL ?>Setor" class="<?= $class_menu ?>">
								<i class="fas fa-wallet"></i><br>Setoran
							</a>
						</li>
						<li class="nav-item">
							<a href="<?= $this->BASE_URL ?>Rekap" class="<?= $class_menu ?>">
								<i class="fas fa-chart-line"></i><br>Rekap
							</a>
						</li>
					</ul>
				</nav>
			</b>

		<?php } ?>

		<!-- SCRIPT -->
		<script src="<?= $this->ASSETS_URL ?>js/jquery-3.6.0.min.js"></script>
		<script src="<?= $this->ASSETS_URL ?>js/popper.min.js"></script>
		<script src="<?= $this->ASSETS_URL ?>plugins/bootstrap-5.2.2-dist/js/bootstrap.bundle.min.js"></script>