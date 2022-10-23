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
                            <label>PIN Transaksi</label>
                            <input type="password" class="form-control form-control-sm" name="pin" placeholder="PIN Transaksi" required>
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
<span class="ml-3">Default, Password: abcdef, PIN: 123456</span>
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
                            <th>Ops</th>
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
                        echo "<td>
                        <a href='" . $this->BASE_URL . "Staff/updateCell_Staff/en/0/" . $a['no_user'] . "'><i class='text-danger fas fa-times-circle'></i></a>
                        <a href='" . $this->BASE_URL . "Staff/updateCell_Staff/en/1/" . $a['no_user'] . "'><i class='fas fa-check-circle'></i></a>
                        </td>";
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