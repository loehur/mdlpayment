<?php
$class_col = "col-md-3 mb-2 px-1";
$class_btn = "btn btn-sm shadow-sm btn-outline-success w-100";
?>


<div class="row ms-1">
    <div class="col-auto">
        <h6><b><?= strtoupper($data['des']) ?></b></h6>
    </div>
</div>
<div class="content" style="padding-bottom: 70px;">
    <div class="container-fluid">
        <div class="row mx-0">
            <?php
            foreach ($data['data'] as $key => $a) {

                print_r($a);
            ?>
                <div class="<?= $class_col ?>">
                    <a class="<?= $class_btn ?>" href="<?= $this->BASE_URL ?>Transaksi/confirmation/<?= $key ?>/<?= $a[0] ?>/<?= $data['type'] ?>/<?= $data['jenis'] ?>/<?= $a[2] ?>?deskripsi=<?= urlencode($data['des']) ?>">
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