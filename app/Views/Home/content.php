<?php
?>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-auto mr-auto">
                Outlate/Staff
                <h6><b class="text-success"><?= $this->userData['nama'] ?></b></h6>
            </div>
            <div class="col-auto">
                <span class="float-right">Kas</span><br>
                <h6><b class="text-success"><?= number_format($data['total_pre']) ?></b></h6>
            </div>
            <div class="col-auto">
                <span class="float-right">Saldo</span><br>
                <h6><b class="text-success"><?= number_format($data['saldo']) ?></b></h6>
            </div>
        </div>
    </div>
</div>
<hr>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <?php foreach ($data['data_pre'] as $a) {
            ?>
                <div class="col-auto">
                    <table class="table table-sm mb-1 pb-0 border">
                        <tr>
                            <td><?= $a['product_code'] ?><br><?= $a['updateTime'] ?></td>
                            <td>#<?= $a['tr_id'] ?><br><?= $a['customer_id'] ?></td>
                            <td>Rp<?= number_format($a['price_sell']) ?><br><?= $a['message'] ?></td>
                            <td></td>
                        </tr>
                    </table>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<!-- SCRIPT -->
<script src="<?= $this->ASSETS_URL ?>js/jquery-3.6.0.min.js"></script>
<script src="<?= $this->ASSETS_URL ?>js/popper.min.js"></script>
<script src="<?= $this->ASSETS_URL ?>plugins/bootstrap-5.1/bootstrap.bundle.min.js"></script>