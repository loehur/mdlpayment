<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-auto mr-auto">
                <div id="info"></div>
            </div>
        </div>
    </div>
</div>
<hr>
<div class="content">
    <div class="container-fluid">
        <label class="mb-2"><b>Setup Biaya Transaksi Manual</b></label>
        <div class="row">
            <div class="col-auto mr-auto">
                <form id="form" action="<?= $this->BASE_URL . $this->CLASS ?>/simpan" method="post">
                    <div class="row mb-2">
                        <div class="col-auto pe-0 mb-1">
                            <select name="id_manual_jenis" class="form-select form-select-sm" aria-label=".form-select-sm example" required>
                                <option selected value="">Jenis</option>
                                <?php $manual = $this->model("M_DB_1")->get("manual_jenis");
                                foreach ($manual as $m) { ?>
                                    <option value="<?= $m['id_manual_jenis'] ?>"><?= $m['manual_jenis'] ?></option>
                                <?php }
                                ?>
                            </select>
                        </div>
                        <div class="col-auto pe-0 mb-1">
                            <input type="number" class="form-control form-control-sm" name="kelipatan" placeholder="Nominal Kelipatan" required>
                        </div>
                        <div class="col-auto pe-0 mb-1">
                            <input type="number" class="form-control form-control-sm" name="biaya" placeholder="Biaya" required>
                        </div>
                        <div class="col-auto pe-0 mb-1">
                            <input type="number" class="form-control form-control-sm" name="dasar_biaya" placeholder="Biaya Dasar" required>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col">
                            <button type="submit" class="btn btn-sm btn-primary btn-block">
                                Tambahkan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-auto mr-auto">
                <form id="form" action="<?= $this->BASE_URL . $this->CLASS ?>/update_wa_api" method="post">
                    <div class="row mb-2">
                        <div class="col-auto pe-0">
                            <input type="text" class="form-control form-control-sm" name="wa_api" placeholder="WA Api Token" required>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col">
                            <button type="submit" class="btn btn-sm btn-primary btn-block">
                                Update
                            </button>
                        </div>
                        <div class="col-auto text-primary ps-0 mt-auto">
                            <?php if (strlen($this->userData['wa_api']) > 0) { ?>
                                <a href="<?= $this->BASE_URL . $this->CLASS ?>/cek_group" target="_blank"><?= $this->userData['wa_api'] ?></a>
                            <?php } else {
                                echo "Belum Ter-set";
                            } ?>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-auto mr-auto">
                <form id="form" action="<?= $this->BASE_URL . $this->CLASS ?>/update_telegram" method="post">
                    <div class="row mb-2">
                        <div class="col-auto pe-0">
                            <input type="text" class="form-control form-control-sm" name="telegram" placeholder="WA Group ID" required>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col">
                            <button type="submit" class="btn btn-sm btn-primary btn-block">
                                Update
                            </button>
                        </div>
                        <div class="col-auto text-primary ps-0 mt-auto">
                            <?= (strlen($this->userData['telegram_id']) > 0) ? $this->userData['telegram_id'] : "Belum Ter-set"  ?>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<hr>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col border m-0 px-2">
                <table class="table table-sm table-striped">
                    <?php
                    $no = 0;
                    $manual_jenis = $this->model("M_DB_1")->get("manual_jenis");
                    echo "<tbody>";
                    foreach ($data as $h => $a) {
                        $jenis = "";
                        foreach ($manual_jenis as $mj) {
                            if ($mj['id_manual_jenis'] == $a['id_manual_jenis']) {
                                $jenis = $mj['manual_jenis'];
                            }
                        }
                        $id = $a['id_manual_set'];
                        echo "<tr>";
                        echo "<td><b>" . $jenis . "</b></td>";
                        echo "<td class='text-end'>
                        Dasar. Rp
                        <span class='edit' data-mode='1' data-id='" . $id . "'>" . $a['biaya_dasar'] . "</span>
                        <br>
                        +Rp
                        <span class='edit' data-mode='2' data-id='" . $id . "'>" . $a['biaya'] . "</span> 
                        / Rp
                        <span class='edit' data-mode='3' data-id='" . $id . "'>" . $a['kelipatan'] . "</span>
                        </td>";
                        echo "<td nowrap class='text-end'>
                        <a class='ajax text-danger text-decoration-none' href='" . $this->BASE_URL . $this->CLASS . "/del/" . $a['id_manual_set'] . "'><i class='fas fa-times-circle'></i></a>
                        </td>";
                        echo "</tr>";
                    }
                    echo "</tbody>";
                    ?>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="content" style="padding-bottom:80px">
    <div class="container-fluid">
    </div>
</div>


<!-- SCRIPT -->
<script src="<?= $this->ASSETS_URL ?>js/jquery-3.6.0.min.js"></script>
<script src="<?= $this->ASSETS_URL ?>js/popper.min.js"></script>
<script src="<?= $this->ASSETS_URL ?>plugins/bootstrap-5.1/bootstrap.bundle.min.js"></script>

<script>
    $(document).ready(function() {
        $("#info").fadeOut();

        $("form").on("submit", function(e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                data: $(this).serialize(),
                type: $(this).attr("method"),
                success: function(response) {
                    if (response == 0) {
                        location.reload(true);
                    } else if (response == 403) {
                        window.location.href = "<?= $this->BASE_URL ?>Login/logout";
                    } else {
                        $("#info").hide();
                        $("#info").fadeIn(1000);
                        $("#info").html('<div class="alert alert-danger" role="alert">' + response + '</div>');
                    }
                },
            });
        });

        $("a.ajax").click(function(e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr("href"),
                data: {},
                type: $(this).attr("method"),
                success: function(response) {
                    if (response == 1) {
                        location.reload(true);
                    } else {
                        $("#info").hide();
                        $("#info").fadeIn(1000);
                        $("#info").html('<div class="alert alert-danger" role="alert">' + response + '</div>');
                    }
                },
            });
        });

        var click = 0;
        $("span.edit").on('dblclick', function() {

            click = click + 1;
            if (click != 1) {
                return;
            }

            var id = $(this).attr('data-id');
            var mode = $(this).attr('data-mode');
            var value = $(this).html();
            var value_before = value;
            var span = $(this);

            span.html("<input type='text' id='value_' value='" + value + "'>");

            $("#value_").focus();
            $("#value_").focusout(function() {
                click = 0;
                var value_after = $(this).val();
                if (value_after === value_before) {
                    span.html(value);
                } else {
                    $.ajax({
                        url: '<?= $this->BASE_URL . $this->CLASS ?>/updateCell',
                        data: {
                            'id': id,
                            'value': value_after,
                            'mode': mode
                        },
                        type: 'POST',
                        dataType: 'html',
                        success: function(res) {
                            if (res == 0) {
                                span.html(value_after);
                            } else {
                                span.html("MySQL Error: [" + res + "]");
                            }
                        },
                    });
                }
            });
        });
    });
</script>