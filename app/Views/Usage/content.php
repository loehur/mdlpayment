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
        <label class="mb-2"><b>Data Pembelian/Pembayaran Oprasional Usaha</b></label>
        <div class="row">
            <div class="col-auto mr-auto">
                <form id="form" action="<?= $this->BASE_URL ?>Usage/simpan" method="post">
                    <div class="row mb-2">
                        <div class="col">
                            <input type="text" class="form-control form-control-sm" name="note" placeholder="Keterangan" required>
                        </div>
                        <div class="col">
                            <input type="text" class="form-control form-control-sm" name="id" placeholder="ID Pelanggan" required>
                        </div>
                        <div class="col">
                            <input type="number" class="form-control form-control-sm" name="limit" placeholder="Limit Bulanan" required>
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
                    echo "<tbody>";
                    foreach ($data as $h => $a) {
                        echo "<tr>";
                        echo "<td><b>" . $a['note'] . "</b><br>" . $a['customer_id'] . "</td>";
                        echo "<td class='text-end'><span class='edit' data-id='" . $a['id'] . "'>" . $a['limit_bulanan'] . "</span></td>";
                        echo "<td nowrap class='text-end'>
                        <a class='ajax text-danger text-decoration-none' href='" . $this->BASE_URL . "Usage/del/" . $a['id'] . "'><i class='fas fa-times-circle'></i></a>
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
                    if (response == 1) {
                        location.reload(true);
                    } else if (response == 0) {
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
            var value = $(this).html();
            var value_before = value;
            var span = $(this);

            span.html("<input type='text' id='value_' value='" + value + "'>");

            $("#value_").focus();
            $("#value_").focusout(function() {
                var value_after = $(this).val();
                if (value_after === value_before) {
                    span.html(value);
                    click = 0;
                } else {
                    $.ajax({
                        url: '<?= $this->BASE_URL ?>Usage/updateCell',
                        data: {
                            'id': id,
                            'value': value_after,
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