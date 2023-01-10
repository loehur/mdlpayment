<?php $a = $data;
if ($a['jenis'] == 1) {
    $des = $a['des'];
} else {
    $des = $a['type'];
}
?>

<style>
    td {
        vertical-align: top;
    }
</style>

<hr class="m-0 p-1">
<div class="content mb-2">
    <div class="container-fluid">
        <div class="row">
            <div class="col border mx-3 pt-2 pb-2 rounded border-success">
                <?php if ($data['jenis'] == 1) { ?>
                    <table class="">
                        <tr>
                            <td>Product</td>
                            <td>:</td>
                            <td><?= $a["des"] ?></td>
                        </tr>
                        <tr>
                            <td>Nominal</td>
                            <td>:</td>
                            <td><?= $a["nominal"] ?></td>
                        </tr>
                        <tr>
                            <td nowrap class="pr-1">Customer ID</td>
                            <td class="pr-1">:</td>
                            <td><b><span id="cust_id"></span></b></td>
                        </tr>
                        <?php if ($a['type'] == 'pln') { ?>
                            <tr>
                                <td nowrap class="pr-1">Customer Name</td>
                                <td class="pr-1">:</td>
                                <td><b><span id="cust_name"></span></b></td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <td>Detail</td>
                            <td>:</td>
                            <td><?= $a["detail"] ?></td>
                        </tr>
                        <tr>
                            <td>Harga</td>
                            <td>:</td>
                            <td>Rp<?= number_format($a['harga']) ?></td>
                        </tr>
                    </table>
                <?php } else { ?>
                    <table class="">
                        <tr>
                            <td>Product</td>
                            <td>:</td>
                            <td><?= $a["des"] ?></td>
                        </tr>
                        <tr>
                            <td class="pr-1">Customer ID</td>
                            <td class="pr-1">:</td>
                            <td class="text-success"><b><span id="cust_id_post"></span></b></td>
                        </tr>
                        <tr>
                            <td class="pr-1">Customer Name</td>
                            <td class="pr-1">:</td>
                            <td class="text-success"><b><span id="cust_name_post"></span></b></td>
                        </tr>
                        <tr>
                            <td>Period</td>
                            <td>:</td>
                            <td><span id="period"></span></td>
                        </tr>
                        <tr>
                        <tr>
                            <td>Nonimal</td>
                            <td>:</td>
                            <td>Rp<span id="nominal"></span></td>
                        </tr>
                        <tr>
                            <td>Admin Server</td>
                            <td>:</td>
                            <td>Rp<span id="adm_server"></span></td>
                        </tr>
                        <tr>
                            <td>Admin Counter</td>
                            <td>:</td>
                            <td>Rp<span id="adm_counter"></span></td>
                        </tr>
                        <tr>
                            <td>Total Tagihan</td>
                            <td>:</td>
                            <td class="text-success"><b>Rp<span id="total_bill"></span></b></td>
                        </tr>
                    </table>
                    <b>
                    <?php } ?>
            </div>
        </div>
    </div>
</div>
<hr>
<div class="content pt-2" style="padding-bottom: 70px; background-color:aliceblue">
    <div class="container-fluid">
        <div class="row">
            <div class="col-auto">
                <div id="info"></div>
                <form action="<?= $this->BASE_URL ?>Transaksi/proses/<?= $a["jenis"] ?>/<?= $a["code"] ?>" method="post">
                    <div class="row mb-2">
                        <div class="col">
                            <label>No. <?= strtoupper($des) ?></label>
                            <input id="cust_id<?= $a['jenis'] ?>" type="text" class="form-control form-control-sm" autocomplete="off" name="customer_id" placeholder="No. <?= $des ?>" autocomplete="off" required>
                        </div>
                    </div>

                    <?php if ($a['type'] == 'pln' && $data['jenis'] == 1) { ?>
                        <div class="row mb-2">
                            <div class="col">
                                <button type="button" id="cekPLN" class="btn cek btn-sm btn-success btn-block">
                                    Cek ID
                                </button>
                            </div>
                            <div class="col">
                                <span class="loader loader2"></span>
                            </div>
                        </div>
                    <?php } ?>

                    <?php if ($data['jenis'] == 2) { ?>
                        <div class="row mb-2">
                            <div class="col-auto">
                                <button type="button" id="cekPOST" class="btn cek btn-sm btn-success btn-block">
                                    Cek Tagihan
                                </button>
                            </div>
                            <div class="col">
                                <span class="loader loader2"></span>
                            </div>
                        </div>
                    <?php } ?>

                    <div class="row mb-2">
                        <div class="col">
                            <label>PIN Transaksi</label>
                            <input type="password" class="form-control form-control-sm" name="pin" placeholder="PIN Transaksi" autocomplete="new-password" required>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col">
                            <button type="submit" class="btn btn-sm btn-primary btn-block">
                                <?= $data['jenis'] == 1 ? "Proses" : "Bayar" ?>
                            </button>
                        </div>
                        <div class="col">
                            <span class="loader loader1"></span>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- SCRIPT -->
<script src="<?= $this->ASSETS_URL ?>js/jquery-3.6.0.min.js"></script>
<script src="<?= $this->ASSETS_URL ?>js/popper.min.js"></script>
<script src="<?= $this->ASSETS_URL ?>plugins/bootstrap-5.1/bootstrap.bundle.min.js"></script>

<script>
    $(document).ready(function() {
        $("#info").hide();
        $(".loader1").hide();
        $(".loader2").hide();

        $("form").on("submit", function(e) {
            e.preventDefault();

            var jenis = '<?= $a['jenis'] ?>';

            if (jenis == 1) {
                var type = '<?= $a['type'] ?>';
                if (type == 'pln') {
                    var customer_name = $("span#cust_name").html();
                    if (customer_name == '') {
                        $("#info").hide();
                        $("#info").fadeIn(1000);
                        $("#info").html('<div class="alert alert-danger" role="alert">Mohon Cek ID terlebih dahulu!</div>')
                        return;
                    }
                }
            } else {
                var customer_name = $("span#cust_name_post").html();
                if (customer_name == '') {
                    $("#info").hide();
                    $("#info").fadeIn(1000);
                    $("#info").html('<div class="alert alert-danger" role="alert">Cek Tagihan terlebih dahulu!</div>')
                    return;
                }
            }

            $.ajax({
                url: $(this).attr('action'),
                data: $(this).serialize(),
                type: $(this).attr("method"),
                beforeSend: function() {
                    $("button[type=submit]").hide();
                    $(".loader1").show();
                },
                success: function(response) {
                    if (response == 1) {
                        window.location.href = "<?= $this->BASE_URL ?>Home";
                    } else if (response === "0") {
                        window.location.href = "<?= $this->BASE_URL ?>Login/logout";
                    } else {
                        $("#info").hide();
                        $("#info").fadeIn(1000);
                        $("#info").html('<div class="alert alert-danger" role="alert">' + response + '</div>')
                    }
                },
                complete: function() {
                    $("button[type=submit]").show();
                    $(".loader1").hide();
                }
            });
        });

        $("input#cust_id1").on("change, keyup", function() {
            $("span#cust_id").html("<span class='text-success'>" + $(this).val() + "</span>");
            $("span#cust_name").html("");
        })

        $("input#cust_id2").on("change, keyup", function() {
            $("span#cust_id_post").html($(this).val());
            resetPost();
        })

        $("button#cekPLN").on("click", function(e) {
            e.preventDefault();
            var customer_id = $("input[name=customer_id").val();
            $("#info").hide();
            $("#cust_name").html("");
            $.ajax({
                url: "<?= $this->BASE_URL ?>IAK/inquiry/pln",
                data: {
                    'customer_id': customer_id
                },
                type: "POST",
                dataType: 'JSON',
                beforeSend: function() {
                    $("button.cek").hide();
                    $(".loader2").show();
                },
                success: function(res) {
                    if (res.data.rc == "00") {
                        $("#info").hide();
                        $("#info").fadeIn(1000);
                        $("#info").html('<div class="alert alert-success" role="alert">' + res.data.name + '</div>')
                        $("#cust_name").html("<span class='text-success'>" + res.data.name + "</span>");
                        $("#cust_id").html("<span class='text-success'>" + res.data.customer_id + "</span>");
                    } else {
                        $("#info").hide();
                        $("#info").fadeIn(1000);
                        $("#info").html('<div class="alert alert-danger" role="alert">' + res.data.message + '</div>')
                    }
                },
                complete: function() {
                    $("button.cek").show();
                    $(".loader2").hide();
                }
            });
        });
        $("button#cekPOST").on("click", function(e) {
            e.preventDefault();
            $("#info").hide();
            var customer_id = $("input[name=customer_id").val();
            $.ajax({
                url: "<?= $this->BASE_URL ?>IAK/inquiry/post",
                data: {
                    'customer_id': customer_id,
                    'code': '<?= $a['code'] ?>'
                },
                type: "POST",
                dataType: 'JSON',
                beforeSend: function() {
                    $("button.cek").hide();
                    $(".loader2").show();
                },
                success: function(res) {
                    if (res.data.response_code == '00') {
                        setPost(res.data);
                    } else {
                        $("#info").hide();
                        $("#info").fadeIn(1000);
                        $("#info").html('<div class="alert alert-danger" role="alert">' + res.data.message + '</div>');
                    }
                },
                complete: function() {
                    $("button.cek").show();
                    $(".loader2").hide();
                }
            });
        });

        function setPost(res) {
            $("#cust_name_post").html(res.tr_name);
            $("span#adm_server").html(res.admin);
            $("span#period").html(res.period);
            $("span#nominal").html(res.nominal);
            $("span#adm_counter").html(res.adm_counter)
            $("span#total_bill").html(res.total_bill);
        }

        function resetPost() {
            $("#cust_name_post").html("");
            $("span#adm_server").html("");
            $("span#period").html("");
            $("span#nominal").html("");
            $("span#adm_counter").html("")
            $("span#total_bill").html("");
        }
    });
</script>