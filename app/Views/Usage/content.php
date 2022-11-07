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
                <form id="form" action="<?= $this->BASE_URL ?>Usage/simpan" method="post">
                    <div class="row mb-2">
                        <div class="col">
                            <input type="text" class="form-control form-control-sm" name="id" placeholder="ID Pelanggan" required>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col">
                            <input type="number" class="form-control form-control-sm" name="limit" placeholder="Limit Bulanan" required>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col">
                            <button type="submit" class="btn btn-sm btn-primary btn-block">
                                Simpan
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
            <div class="col-md-6 border pb-1">
                <table class="table table-borderless table-sm mb-0 pb-0">

                    <?php
                    $no = 0;
                    echo "<tbody>";
                    foreach ($data as $h => $a) {
                        echo "<tr>";
                        foreach ($a as $key => $value) {
                            echo "<td><span style='cursor:pointer' data-value='" . $value  . "' data-mode='" . $key . "'>" . $value . "</span><br>";
                        }
                        echo "<td nowrap>
                        <a class='text-success text-decoration-none' href='" . $this->BASE_URL . "Usage/edit/" . $a['id'] . "'><i class='fas fa-edit'></i></a>
                        <a class='ajax text-danger text-decoration-none' href='" . $this->BASE_URL . "Usage/del/" . $a['id'] . "'><i class='fas fa-times-circle'></i></a>
                        </td>";
                        echo "</tr>";
                        $no++;
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
    });
</script>