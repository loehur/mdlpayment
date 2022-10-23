<?php $a = $data; ?>
<hr class="m-0 p-1">
<div class="content mb-2">
    <div class="container-fluid">
        <div class="row">
            <div class="col border ml-3 mr-3 pt-2 pb-2 rounded border-danger">
                <span class="text-danger">
                    <b><?= $a["des"] . " " . $a["nominal"] . ", " . $a["detail"] . "<br><b>Harga Rp" . number_format($a['harga']) ?></b>
                </span>
            </div>
        </div>
    </div>
</div>
<hr>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-auto">
                <div id="info"></div>
                <form action="<?= $this->BASE_URL ?>Transaksi/proses/<?= $a["jenis"] ?>/<?= $a["code"] ?>" method="post">
                    <div class="row mb-2">
                        <div class="col">
                            <label>No. <?= $a['des'] ?></label>
                            <input type="text" class="form-control form-control-sm" name="customer_id" placeholder="No. <?= $a['des'] ?>" required>
                        </div>
                    </div>

                    <?php if ($a['type'] == 'pln' || $a['type'] == 'game') { ?>
                        <div class="row mb-2">
                            <div class="col">
                                <button type="button" id="cekPLN" class="btn btn-sm btn-success btn-block">
                                    Cek ID
                                </button>
                            </div>
                        </div>
                    <?php } ?>

                    <div class="row mb-2">
                        <div class="col">
                            <label>PIN Transaksi</label>
                            <input type="password" class="form-control form-control-sm" name="pin" placeholder="PIN Transaksi" required>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col">
                            <button type="submit" class="btn btn-sm btn-primary btn-block">
                                Proses
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
        $("form").on("submit", function(e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                data: $(this).serialize(),
                type: $(this).attr("method"),
                success: function(response) {
                    if (response == 1) {
                        window.location.href = "<?= $this->BASE_URL ?>Home";
                    } else if (response == 0) {
                        window.location.href = "<?= $this->BASE_URL ?>Login/logout";
                    } else {
                        $("#info").hide();
                        $("#info").fadeIn(1000);
                        $("#info").html('<div class="alert alert-danger" role="alert">' + response + '</div>')
                    }
                },
            });
        });

        $("button#cekPLN").on("click", function(e) {
            e.preventDefault();
            var customer_id = $("input[name=customer_id").val();
            $.ajax({
                url: "<?= $this->BASE_URL ?>IAK/inquiry/pln",
                data: {
                    'customer_id': customer_id
                },
                type: "POST",
                success: function(response) {
                    $("#info").hide();
                    $("#info").fadeIn(1000);
                    $("#info").html('<div class="alert alert-success" role="alert">' + response + '</div>')
                },
            });
        });
    });
</script>