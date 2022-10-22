<?php $d = $data['par']; ?>
<hr class="m-0 p-1">
<div class="content mb-2">
    <div class="container-fluid">
        <div class="row">
            <div class="col border ml-3 mr-3 pt-2 pb-2 rounded border-danger">
                <span class="text-danger">
                    <b><?= $d['des'] . "<br>" . $d['nominal'] . "<br>" . $data['detail'] ?></b>
                </span>
            </div>
        </div>
    </div>
</div>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-auto">
                <div id="info"></div>
                <form id="form" action="<?= $this->BASE_URL ?>Register/insert" method="post">
                    <div class="row mb-2">
                        <div class="col">
                            <input type="text" class="form-control form-control-sm" name="customer_id" placeholder="No. <?= $d['des'] ?>" required>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col">
                            <input type="pass" class="form-control form-control-sm" name="pin" placeholder="PIN Transaksi" required>
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
<script src="<?= $this->ASSETS_URL ?>js/selectize.min.js"></script>

<script>
    $(document).ready(function() {
        $('select.tize').selectize();
    });
</script>