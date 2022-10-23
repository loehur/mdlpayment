<div class="content">
    <div class="container-fluid">
        <div class="row ml-1">
            <div class="col-auto">
                <h6><b><?= strtoupper($data['type']) ?></b></h6>
            </div>
        </div>
        <div class="row ml-1">
            <?php
            foreach ($data['data'] as $a) { ?>
                <div class="col-auto pr-1 pl-1 mr-1 m-0 mb-2 border rounded">
                    <a class="text-decoration-none" href="<?= $this->BASE_URL ?>Transaksi/product_code/<?= $a ?>/<?= $data['type'] ?>/<?= $data['jenis'] ?>"><?= strtoupper($a) ?></a>
                </div>
            <?php  }
            ?>
        </div>
    </div>
</div>

<!-- SCRIPT -->
<script src="<?= $this->ASSETS_URL ?>js/jquery-3.6.0.min.js"></script>
<script src="<?= $this->ASSETS_URL ?>js/popper.min.js"></script>
<script src="<?= $this->ASSETS_URL ?>plugins/bootstrap-5.1/bootstrap.bundle.min.js"></script>
<script src="<?= $this->ASSETS_URL ?>js/selectize.min.js"></script>