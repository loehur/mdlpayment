<div class="content">
    <div class="container-fluid">
        <div class="row ms-1">
            <div class="col-auto">
                <h6><b><?= strtoupper($data['type']) ?></b></h6>
            </div>
        </div>
        <div class="row ms-1">
            <?php
            if ($data['jenis'] == 1) {
                foreach ($data['data'] as $a) { ?>
                    <div class="col-auto pb-1 pt-1 px-2 me-2 mb-2 border border-success rounded">
                        <a class="text-decoration-none" href="<?= $this->BASE_URL ?>Transaksi/product_code/<?= str_replace(' ', '_SPACE_', $a) ?>/<?= $data['type'] ?>/<?= $data['jenis'] ?>"><?= strtoupper($a) ?></a>
                    </div>
                <?php  }
            } else {
                foreach ($data['data']['product_code'] as $key => $a) { ?>
                    <div class="col-auto pb-1 pt-1 px-2 me-2 mb-2 border border-success rounded">
                        <a class="text-decoration-none" href="<?= $this->BASE_URL ?>Transaksi/product_code/<?= $key  ?>/<?= $data['type'] ?>/<?= $data['jenis'] ?>"><?= strtoupper($a) ?></a>
                    </div>
            <?php }
            } ?>
        </div>
    </div>
</div>

<!-- SCRIPT -->
<script src="<?= $this->ASSETS_URL ?>js/jquery-3.6.0.min.js"></script>
<script src="<?= $this->ASSETS_URL ?>js/popper.min.js"></script>
<script src="<?= $this->ASSETS_URL ?>plugins/bootstrap-5.1/bootstrap.bundle.min.js"></script>
<script src="<?= $this->ASSETS_URL ?>js/selectize.min.js"></script>