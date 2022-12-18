<div class="content" style="padding-bottom: 70px;">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 border pb-1">
                <b>
                    <div class="pt-2 pb-2 mb-2 border-bottom">PRA BAYAR <?= $data['mon'][1] . "/" . $data['mon'][0]  ?></div>
                </b>
                <table class="table table-sm table-borderless">
                    <tr>
                        <td class="text-end">ID</td>
                        <td class="text-end">Price</td>
                        <td class="text-end">Sell</td>
                        <td class="text-end">Margin</td>
                    </tr>
                    <?php
                    $margin_total = 0;
                    foreach ($data['pre'] as $dp) {
                        $margin = $dp['price_sell'] - $dp['price_master'];
                    ?>
                        <tr>
                            <td class="text-end">#<?= $dp['id'] ?></td>
                            <td class="text-end"><?= number_format($dp['price_master']) ?></td>
                            <td class="text-end"><?= number_format($dp['price_sell']) ?></td>
                            <td class="text-end"><?= number_format($margin) ?></td>
                        </tr>
                    <?php
                        $margin_total += $margin;
                    }
                    ?>
                    <tr>
                        <td class="text-end" colspan="4"><b><?= number_format($margin_total) ?></b></td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6 border pb-1">
                <b>
                    <div class="pt-2 pb-2 mb-2 border-bottom">PASCA BAYAR <?= $data['mon'][1] . "/" . $data['mon'][0]  ?></div>
                </b>
                <table class="table table-sm table-borderless">
                    <tr>
                        <td class="text-end">ID</td>
                        <td class="text-end">Price</td>
                        <td class="text-end">Sell</td>
                        <td class="text-end">Admin</td>
                    </tr>
                    <?php
                    $margin_total = 0;
                    foreach ($data['post'] as $dp) {
                        $margin = $dp['price_sell'] - $dp['price'];
                    ?>
                        <tr>
                            <td class="text-end">#<?= $dp['id'] ?></td>
                            <td class="text-end"><?= number_format($dp['price']) ?></td>
                            <td class="text-end"><?= number_format($dp['price_sell']) ?></td>
                            <td class="text-end"><?= number_format($margin) ?></td>
                        </tr>
                    <?php
                        $margin_total += $margin;
                    }
                    ?>
                    <tr>
                        <td class="text-end" colspan="4"><b><?= number_format($margin_total) ?></b></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>