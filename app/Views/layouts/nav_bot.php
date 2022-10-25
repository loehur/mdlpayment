		<!-- Bottom Navbar -->
		<?php
		if ($this->userData['user_tipe'] == 1) {
		?>

			<b>
				<nav class="navbar navbar-dark table-light navbar-expand border-top fixed-bottom m-auto p-0" style="max-width: 750px;min-width: <?= $min_width ?>;">
					<ul class="navbar-nav nav-justified w-100">
						<li class="nav-item">
							<a href="<?= $this->BASE_URL ?>Staff" class="nav-link text-secondary text-nowrap"><i class="fas fa-users"></i><br>Staff</a>
						</li>
						<li class="nav-item">
							<a href="<?= $this->BASE_URL ?>SetHarga" class="nav-link text-secondary text-nowrap"><i class="fas fa-tags"></i><br>Set Harga</a>
						</li>
						<li class="nav-item">
							<a href="<?= $this->BASE_URL ?>Approval" class="nav-link text-secondary text-nowrap"><i class="fas fa-check-double"></i><br>Approval</a>
						</li>
						<li class="nav-item">
							<a href="<?= $this->BASE_URL ?>Setor" class="nav-link text-secondary text-nowrap">
								<i class="fas fa-wallet"></i><br>Setoran
							</a>
						</li>
						<li class="nav-item">
							<a href="#" class="nav-link text-secondary text-nowrap">
								<i class="fas fa-chart-line"></i><br>Rekap
							</a>
						</li>
					</ul>
				</nav>
			</b>

		<?php } ?>