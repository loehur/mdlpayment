		<b>
			<nav class="navbar navbar-dark bg-light navbar-expand mx-auto border-bottom p-0 fixed-top" style="max-width: <?= $max_width ?>;min-width: <?= $min_width ?>;">
				<ul class="navbar-nav nav-justified w-100">
					<li class="nav-item">
						<a href="<?= $this->BASE_URL ?>Home" class="<?= $class_menu ?>">
							<i class="fas fa-home"></i><br>Home</a>
					</li>
					<li class="nav-item">
						<a href="<?= $this->BASE_URL ?>Transaksi" class="<?= $class_menu ?>">
							<i class="fas fa-cash-register"></i><br>Transaksi
						</a>
					</li>
					<li class="nav-item">
						<a href="<?= $this->BASE_URL ?>Penarikan" class="<?= $class_menu ?>"><i class="fas fa-receipt"></i><br>Penarikan</a>
					</li>
					<li class="nav-item">
						<a href="<?= $this->BASE_URL ?>Akun" class="<?= $class_menu ?>"><i class="fas fa-user"></i><br>Akun</a>
					</li>
					<li class="nav-item">
						<a href="<?= $this->BASE_URL ?>Login_99/logout" class="<?= $class_menu ?>"><i class="fas fa-sign-out-alt"></i><br>Logout</a>
					</li>
				</ul>
			</nav>
		</b>