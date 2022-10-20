<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-auto mr-auto">
                <div id="info"></div>
            </div>
        </div>
    </div>
</div>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-auto mr-auto">
                <form id="form" action="<?= $this->BASE_URL ?>Register/tambah_staff" method="post">
                    <div class="row mb-2">
                        <div class="col">
                            <input type="text" class="form-control form-control-sm" id="nama" name="nama" placeholder="Nama Panggilan" required>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col">
                            <input type="text" class="form-control form-control-sm" id="HP" name="HP" placeholder="Nomor HP" required>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col">
                            <input type="password" class="form-control form-control-sm" minlength="6" id="password" name="password" placeholder="Password" required>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col">
                            <input type="password" class="form-control form-control-sm" minlength="6" id="repass" name="repass" placeholder="Ulangi Password" required>
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
                                Tambah Staff
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-auto mr-auto">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>No. HP</th>
                            <th>Nama</th>
                            <th>Registered</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <?php
                    $no = 0;
                    echo "<tbody>";
                    foreach ($data as $h => $a) {
                        echo "<tr>";
                        foreach ($a as $key => $value) {
                            switch ($key) {
                                case "no_user":
                                case "nama":
                                case "insertTime":
                                case "en":
                                    echo "<td><span style='cursor:pointer' data-value='" . $value . "' data-mode='" . $key . "'>" . $value . "</span></td>";
                            }
                        }
                        echo "</tr>";
                        $no++;
                    }
                    echo "</tbody>";
                    ?>
                </table>
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
        $("form").on("submit", function(e) {
            $("#spinner").show();
            e.preventDefault();
            if ($('#password').val() != $('#repass').val()) {
                $("#info").hide();
                $("#info").fadeIn(1000);
                $("#info").html('<div class="alert alert-danger" role="alert">Konfirmasi Password tidak cocok!</div>')
                return;
            }
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
                        location.reload(true);
                    } else {
                        $("#info").hide();
                        $("#info").fadeIn(1000);
                        $("#info").html('<div class="alert alert-danger" role="alert">' + response + '</div>');
                    }
                },
            });
        });
    });
</script>