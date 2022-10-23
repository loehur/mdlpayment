<?php
?>
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
        <div class="row">
            <div class="col-auto mr-auto">
                <div class="row mb-4">
                    <div class="col">
                        <form action="<?= $this->BASE_URL ?>Register/updateCell_Master/margin_prepaid" method="post">
                            <label>Margin Prabayar</label>
                            <input type="number" class="form-control form-control-sm" name="f1" value="<?= $this->setting['margin_prepaid'] ?>">
                            <button type="submit" class="btn mt-1 btn-sm btn-primary btn-block">
                                Simpan
                            </button>
                        </form>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col">
                        <form action="<?= $this->BASE_URL ?>Register/updateCell_Master/admin_postpaid" method="post">
                            <label>Admin Pascabayar</label>
                            <input type="number" class="form-control form-control-sm" name="f1" value="<?= $this->setting['admin_postpaid'] ?>">
                            <button type="submit" class="btn mt-1 btn-sm btn-primary btn-block">
                                Simpan
                            </button>
                        </form>
                    </div>
                </div>
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
                    } else {
                        $("#info").hide();
                        $("#info").fadeIn(1000);
                        $("#info").html('<div class="alert alert-danger" role="alert">' + response + '</div>')
                    }
                },
            });
        });
    });
</script>