<div class="row ml-1">
    <div class="col-auto">
        <h6><b><?= strtoupper($data['des']) ?></b></h6>
    </div>
</div>
<div class="content" style="padding-bottom: 70px;">
    <div class="container-fluid">
        <div class="row ml-1 mr-1">
            <?php
            foreach ($data['data'] as $key => $a) { ?>
                <div class="col-auto pb-1 pt-1 pr-2 pl-2 mr-2 mb-2 border border-success rounded">
                    <a class="text-decoration-none" href="<?= $this->BASE_URL ?>Transaksi/confirmation/<?= $key ?>/<?= $a[0] ?>/<?= $data['des'] ?>/<?= $data['type'] ?>/<?= $data['jenis'] ?>/<?= $a[2] ?>">
                        <?= $a[0] . ", " . $a[1] . "<br><b>Harga Rp" . number_format($a[2]) ?></b> <?= ($this->setting['v_price'] == 1) ? "<small>(" . number_format($a[3]) . ")</small>" : "" ?>
                    </a>
                </div>
            <?php  }
            ?>
        </div>
    </div>
    <hr>
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