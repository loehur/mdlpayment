<?php $currentMonth = date('m'); ?>
<?php $currentYear = date('Y'); ?>
<div class="content">
    <div class="container-fluid">
        <form action="<?= $this->BASE_URL ?>Rekap/profit" method="post">
            <div class="row">
                <div class="col-auto">
                    <label>Month</label>
                    <select name="m" class="form-control form-control-sm">
                        <option class="text-right" value="01" <?php if ($currentMonth == '01') {
                                                                    echo 'selected';
                                                                } ?>>01</option>
                        <option class="text-right" value="02" <?php if ($currentMonth == '02') {
                                                                    echo 'selected';
                                                                } ?>>02</option>
                        <option class="text-right" value="03" <?php if ($currentMonth == '03') {
                                                                    echo 'selected';
                                                                } ?>>03</option>
                        <option class="text-right" value="04" <?php if ($currentMonth == '04') {
                                                                    echo 'selected';
                                                                } ?>>04</option>
                        <option class="text-right" value="05" <?php if ($currentMonth == '05') {
                                                                    echo 'selected';
                                                                } ?>>05</option>
                        <option class="text-right" value="06" <?php if ($currentMonth == '06') {
                                                                    echo 'selected';
                                                                } ?>>06</option>
                        <option class="text-right" value="07" <?php if ($currentMonth == '07') {
                                                                    echo 'selected';
                                                                } ?>>07</option>
                        <option class="text-right" value="08" <?php if ($currentMonth == '08') {
                                                                    echo 'selected';
                                                                } ?>>08</option>
                        <option class="text-right" value="09" <?php if ($currentMonth == '09') {
                                                                    echo 'selected';
                                                                } ?>>09</option>
                        <option class="text-right" value="10" <?php if ($currentMonth == '10') {
                                                                    echo 'selected';
                                                                } ?>>10</option>
                        <option class="text-right" value="11" <?php if ($currentMonth == '11') {
                                                                    echo 'selected';
                                                                } ?>>11</option>
                        <option class="text-right" value="12" <?php if ($currentMonth == '12') {
                                                                    echo 'selected';
                                                                } ?>>12</option>
                    </select>
                </div>
                <div class="col-auto ps-0">
                    <label>Year</label>
                    <select name="y" class="form-control form-control-sm" onchange="hideAll()" style="width: auto;">
                        <?php

                        $yearStart = 2022;
                        while ($yearStart <= $currentYear) { ?>
                            <option class="text-right" value="<?= $yearStart ?>" <?php if ($currentYear == $yearStart) {
                                                                                        echo 'selected';
                                                                                    } ?>><?= $yearStart ?></option>
                        <?php $yearStart++;
                        }
                        ?>
                    </select>
                </div>
                <div class="col-auto ps-0 mt-auto">
                    <button type="submit" class="btn btn-sm btn-primary">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>
<hr>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-auto mr-auto">

            </div>
        </div>
    </div>
</div>