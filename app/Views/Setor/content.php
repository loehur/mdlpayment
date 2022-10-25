<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-auto mr-auto">
                <button type="button" class="btn btn-sm btn-primary m-2 pl-1 pr-1 pt-0 pb-0 buttonTambah" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    (+) Setoran</b>
                </button>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <?php
            foreach ($data['data_topup'] as $z) { ?>
                <div class="col-md-6 border pb-1">
                    <table class="table table-borderless table-sm mb-0 pb-0">
                        <tbody>
                            <?php
                            $id = $z['id_topup'];
                            $stBayar = "<b>Proses</b>";
                            $active = "";

                            switch ($z['topup_status']) {
                                case 0:
                                    $stBayar = "<b><span class='text-warning'>Proses</span></b>";
                                    break;
                                case 1:
                                    $stBayar = "<b><span class='text-success'>Sukses</span></b>";
                                    break;
                            }

                            $classTR = "";
                            $dibuat = substr($z['insertTime'], 8, 2) . "-" . substr($z['insertTime'], 5, 2) . "-" . substr($z['insertTime'], 0, 4)
                            ?>
                            <tr class="<?= $classTR ?>">
                                <td><small>#<?= $dibuat ?></small><br><?= strtoupper($z['bank']) . " " . $z['rek'] . "<br>" . $z['nama'] ?></td>
                                <td><small>Jumlah/Status</small><br><b><?= number_format($z['jumlah']) ?><br><small><?= $stBayar ?></b></small></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            <?php
            } ?>
        </div>
    </div>
</div>


<form class="ajax" action="<?= $this->BASE_URL; ?>Setor/insert" method="POST">
    <div class="modal" id="exampleModal">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Setoran</h5>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Jumlah</label>
                                    <input type="number" name="f1" step="10000" min="50000" class="form form-control form-control-sm">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Metode Bayar</label>
                                    <select name="f2" class="bayar form-control form-control-sm" style="width: 100%;" required>
                                        <?php foreach ($data['bank'] as $b) { ?>
                                            <option value="<?= $b['id_bank'] ?>"><?= $b['bank'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary">Proses</button>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- SCRIPT -->
<script src="<?= $this->ASSETS_URL ?>js/jquery-3.6.0.min.js"></script>
<script src="<?= $this->ASSETS_URL ?>js/popper.min.js"></script>
<script src="<?= $this->ASSETS_URL ?>plugins/bootstrap-5.1/bootstrap.bundle.min.js"></script>

<script>
    $("form").on("submit", function(e) {
        e.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            data: $(this).serialize(),
            type: $(this).attr("method"),
            success: function() {
                location.reload(true);
            },
        });
    });
</script>