<?php $s = $data['saldo'] ?>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-auto mr-auto">
                Outlate/Staff
                <h6><b class="text-success"><?= ($this->userData['nama'] == $this->setting['nama']) ? $this->setting['nama'] : $this->setting['nama'] . "/" . $this->userData['nama']; ?></b></h6>
            </div>
            <div class="col-auto">
                <span class="float-right">Kas</span><br>
                <h6><b class="text-success"><?= number_format($s['kas']) ?></b></h6>
            </div>
            <div class="col-auto">
                <span class="float-right">Saldo</span><br>
                <h6><b class="text-success"><?= number_format($s['saldo']) ?></b></h6>
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
            </div>
        </div>
    </div>
</div>
<hr>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-auto mr-auto">
                <form action="<?= $this->BASE_URL ?>Penarikan/insert" method="post">
                    <div class="row mb-2">
                        <div class="col">
                            <label>Jumlah Penarikan</label>
                            <input type="number" class="form-control form-control-sm" name="jumlah" placeholder="Jumlah" required>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col">
                            <label>Keterangan (Optional)</label>
                            <input type="text" class="form-control form-control-sm" name="ket" placeholder="Keterangan">
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
                                Tarik Kas
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
            <div class="col-md-6 border pb-1">
                <table class="table table-borderless table-sm mb-0 pb-0">
                    <thead class="d-none">
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
                    foreach ($data['kas'] as $a) {
                        echo "<tr>";
                        echo "<td class='text-info'>" . $a['keterangan'] . "</td>";
                        echo "</tr>";
                        echo "<tr>";
                        echo "<td>" . $a['no_user'] . "</td>";
                        echo "<td>" . number_format($a['jumlah']) . "</td>";
                        echo "<td>" . $a['insertTime'] . "</td>";
                        echo "<td>";
                        switch ($a['kas_status']) {
                            case 1:
                                echo "<i class='text-success fas fa-check-circle'></i>";
                                break;
                            case 0;
                                echo "<span class='text-warning'>Proses</span>";
                                break;
                            case 2;
                                echo "<span class='text-danger'>Ditolak</span>";
                                break;
                        }
                        echo "</td>";
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