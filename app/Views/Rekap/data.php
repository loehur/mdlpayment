<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 border pb-1">
                <b>
                    <div class="pt-2 pb-2 mb-2 border-bottom">PRA BAYAR</div>
                </b>
                <table class="table table-sm table-borderless">
                    <tr>
                        <td class="text-right">ID</td>
                        <td class="text-right">Price</td>
                        <td class="text-right">Sell</td>
                        <td class="text-right">Margin</td>
                    </tr>
                    <?php
                    $margin_total = 0;
                    foreach ($data['pre'] as $dp) {
                        $margin = $dp['price_sell'] - $dp['price_master'];
                    ?>
                        <tr>
                            <td class="text-right">#<?= $dp['id'] ?></td>
                            <td class="text-right"><?= number_format($dp['price_master']) ?></td>
                            <td class="text-right"><?= number_format($dp['price_sell']) ?></td>
                            <td class="text-right"><?= number_format($margin) ?></td>
                        </tr>
                    <?php
                        $margin_total += $margin;
                    }
                    ?>
                    <tr>
                        <td class="text-right" colspan="4"><b><?= number_format($margin_total) ?></b></td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6 border pb-1">
                <b>
                    <div class="pt-2 pb-2 mb-2 border-bottom">PASCA BAYAR</div>
                </b>
                <table class="table table-sm table-borderless">
                    <tr>
                        <td class="text-right">ID</td>
                        <td class="text-right">Price</td>
                        <td class="text-right">Sell</td>
                        <td class="text-right">Admin</td>
                    </tr>
                    <?php
                    $margin_total = 0;
                    foreach ($data['post'] as $dp) {
                        $margin = $dp['price_sell'] - $dp['price'];
                    ?>
                        <tr>
                            <td class="text-right">#<?= $dp['id'] ?></td>
                            <td class="text-right"><?= number_format($dp['price']) ?></td>
                            <td class="text-right"><?= number_format($dp['price_sell']) ?></td>
                            <td class="text-right"><?= number_format($margin) ?></td>
                        </tr>
                    <?php
                        $margin_total += $margin;
                    }
                    ?>
                    <tr>
                        <td class="text-right" colspan="4"><b><?= number_format($margin_total) ?></b></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>