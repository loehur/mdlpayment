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
                <form id="form" action="<?= $this->BASE_URL ?>Register/tambah_staff" method="post">
                    <div class="row mb-2">
                        <div class="col">
                            <label>Nama Panggilan</label>
                            <input type="text" class="form-control form-control-sm" id="nama" name="nama" placeholder="Nama Panggilan" required>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col">
                            <label>Nomor HP / ID Loket</label>
                            <input type="text" class="form-control form-control-sm" id="HP" name="HP" placeholder="Nomor HP" required>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col">
                            <label>PIN Transaksi</label>
                            <input type="password" class="form-control form-control-sm" name="pin" placeholder="PIN Transaksi" required>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col">
                            <label class="ml-3"><small>Default [Password: abcdef], [PIN: 123456]</small></label>
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
<hr>
<div class="content">
    <div class="container-fluid px-4">
        <div class="row">
            <div class="col-md-6 border pb-1">
                <table class="table table-borderless table-sm mb-0 pb-0">
                    <?php
                    $no = 0;
                    echo "<tbody>";
                    foreach ($data as $h => $a) {
                        echo "<tr>";
                        foreach ($a as $key => $value) {
                            switch ($key) {
                                case "password":
                                    $pass_ = $value;
                                    break;
                                case "pin":
                                    $pin_ = $value;
                                    break;
                                case "no_user":
                                    echo "<td><span style='cursor:pointer' data-value='" . $value  . "' data-mode='" . $key . "'>" . $value . "</span><br>";
                                    break;
                                case "nama":
                                    echo "<span style='cursor:pointer' data-value='" . $value  . "' data-mode='" . $key . "'>" . $value . "</span></td>";
                                    break;
                                case "insertTime":
                                    echo "<td><span style='cursor:pointer' data-value='" . $value  . "' data-mode='" . $key . "'>" . $value . "</span>";
                                    break;
                                case "en":
                                    echo "<br>Status:";
                                    if ($value == $this->model('Validasi')->enc($pass_ . $pin_)) { ?>
                                        <span class='text-success'><b>Active</b></span>
                                    <?php } else { ?>
                                        <span class='text-secondary text-bold'><b>Blocked</b></span>
                                    <?php } ?>
                    <?php break;
                            }
                        }
                        echo "<td nowrap>
                        <br><a class='text-danger border px-2 rounded text-decoration-none' href='" . $this->BASE_URL . "Staff/updateCell_Staff/en/0/" . $a['no_user'] . "'>Block</a>
                        </td>";
                        echo "</tr>";
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
<script type="text/javascript" src="<?= $this->ASSETS_URL ?>plugins/bootstrap-5.2.2-dist/js/bootstrap.bundle.min.js"></script>

<script>
    $(document).ready(function() {
        $("#info").fadeOut();
        $("form").on("submit", function(e) {
            $("#spinner").show();
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                data: $(this).serialize(),
                type: $(this).attr("method"),
                success: function(response) {
                    if (response == 1) {
                        location.reload(true);
                    } else if (response == 0) {
                        window.location.href = "<?= $this->BASE_URL ?>Login/logout";
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