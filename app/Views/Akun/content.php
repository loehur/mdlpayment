<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-auto mr-auto">
                <div id="info"></div>
            </div>
        </div>
    </div>
</div>
<hr>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-auto mr-auto">
                <form id="form" class="pass" action="<?= $this->BASE_URL ?>Register/ganti_password" method="post">
                    <div class="row mb-2">
                        <div class="col">
                            <input type="password" class="form-control form-control-sm" name="reset_code" placeholder="Reset Code" required>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col">
                            <input type="password" class="form-control form-control-sm" minlength="6" id="password" name="password" placeholder="Password Baru" required>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col">
                            <input type="password" class="form-control form-control-sm" minlength="6" id="repass" name="repass" placeholder="Ulangi Password" required>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col">
                            <button type="submit" class="btn btn-sm btn-primary btn-block">
                                Ubah Password
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<hr>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-auto mr-auto">
                <div id="info"></div>
                <form id="form" class="pin" action="<?= $this->BASE_URL ?>Register/ganti_pin" method="post">
                    <div class="row mb-2">
                        <div class="col">
                            <input type="password" class="form-control form-control-sm" name="reset_code" placeholder="Reset Code" required>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col">
                            <input type="password" class="form-control form-control-sm" minlength="6" id="pin" name="pin" placeholder="PIN Transaksi" required>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col">
                            <input type="password" class="form-control form-control-sm" minlength="6" id="repin" name="repin" placeholder="Ulangi PIN Transaksi" required>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col">
                            <button type="submit" class="btn btn-sm btn-primary btn-block">
                                Ubah PIN Transaksi
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- SCRIPT -->
<script src="<?= $this->ASSETS_URL ?>js/jquery-3.6.0.min.js"></script>
<script src="<?= $this->ASSETS_URL ?>js/popper.min.js"></script>
<script src="<?= $this->ASSETS_URL ?>plugins/bootstrap-5.1/bootstrap.bundle.min.js"></script>

<script>
    $(document).ready(function() {
        $("#info").fadeOut();
        $("form.pass").on("submit", function(e) {
            e.preventDefault();
            if ($('#password').val() != $('#repass').val()) {
                $("#info").hide();
                $("#info").fadeIn(1000);
                $("#info").html('<div class="alert alert-danger" role="alert">Konfirmasi Password tidak cocok!</div>')
                return;
            }
            $.ajax({
                url: $(this).attr('action'),
                data: $(this).serialize(),
                type: $(this).attr("method"),
                success: function(response) {
                    if (response == 1) {
                        $("#info").hide();
                        $('form').trigger("reset");
                        $("#info").fadeIn(1000);
                        $("#info").html('<div class="alert alert-success" role="alert">Perubahan Password berhasil!</div>')
                    } else {
                        $("#info").hide();
                        $("#info").fadeIn(1000);
                        $("#info").html('<div class="alert alert-danger" role="alert">' + response + '</div>')
                    }
                },
            });
        });
        $("form.pin").on("submit", function(e) {
            e.preventDefault();
            if ($('#pin').val() != $('#repin').val()) {
                $("#info").hide();
                $("#info").fadeIn(1000);
                $("#info").html('<div class="alert alert-danger" role="alert">Konfirmasi PIN tidak cocok!</div>')
                return;
            }
            $.ajax({
                url: $(this).attr('action'),
                data: $(this).serialize(),
                type: $(this).attr("method"),
                success: function(response) {
                    if (response == 1) {
                        $("#info").hide();
                        $('form').trigger("reset");
                        $("#info").fadeIn(1000);
                        $("#info").html('<div class="alert alert-success" role="alert">Perubahan PIN berhasil!</div>')
                    } else {
                        $("#info").hide();
                        $("#info").fadeIn(1000);
                        $("#info").html('<div class="alert alert-danger" role="alert">' + response + '</div>')
                    }
                },
            });
        });
    });
</script>