<div class="content mb-2">
    <div class="container-fluid">
        <div class="row">
            <div class="col-auto mb-2">
                <a href="<?= $this->BASE_URL ?>Transaksi/product_type/1"><button class="btn btn-sm btn-outline-info">PRABAYAR</button></a>
            </div>
            <div class="col mr-auto mb-2">
                <a href="<?= $this->BASE_URL ?>Transaksi/product_type/2"><button class="btn btn-sm btn-outline-success text-nowrap">PASCA BAYAR</button></a>
            </div>
            <div class="col float-right">
                <span class="float-right">Saldo</span><br>
                <h6><b class="float-right text-success"><?= number_format($data['saldo']) ?></b></h6>
            </div>
        </div>
    </div>
</div>
<hr class="m-0 mb-2 p-1">
<!-- SCRIPT -->
<script src="<?= $this->ASSETS_URL ?>js/jquery-3.6.0.min.js"></script>
<script src="<?= $this->ASSETS_URL ?>js/popper.min.js"></script>
<script src="<?= $this->ASSETS_URL ?>plugins/bootstrap-5.1/bootstrap.bundle.min.js"></script>