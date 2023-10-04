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
    <div class="container-fluid px-4">
        <div class="row">
            <div class="col border pb-1 pt-2">
                <label><span class="ml-3"><b>Penarikan Kas Staff</b></span></label>
                <hr>
                <table class="table table-borderless table-sm mb-0 pb-0">
                    <thead class="d-none">
                        <tr>
                            <th>No. HP</th>
                            <th>Nama</th>
                            <th>Registered</th>
                            <th>Status</th>
                            <th>Ops</th>
                        </tr>
                    </thead>
                    <?php
                    $no = 0;
                    echo "<tbody>";
                    foreach ($data['kas'] as $a) {
                        $id = $a['id'];
                        echo "<tr>";
                        echo "<td>" . $a['insertTime'] . " <span class='text-info'>" . $a['keterangan'] . "</span></td>";
                        echo "</tr>";
                        echo "<tr>";
                        echo "<td>" . $a['no_user'] . "</td>";
                        echo "<td align='right'>" . number_format($a['jumlah']) . "</td>";

                        switch ($a['kas_status']) {
                            case 1:
                                echo "<td align='right'>";
                                echo "<i class='text-success fas fa-check-circle'></i>";
                                echo "</td>";
                                break;
                            case 0;
                                echo "<td align='right'><a class='text-danger text-decoration-none' href='" . $this->BASE_URL . "Approval/penarikan/" . $id . "/2'><i class='fas fa-times-circle'></i> Tolak</a></td>";
                                echo "<td align='right'><a class='text-success text-decoration-none' href='" . $this->BASE_URL . "Approval/penarikan/" . $id . "/1'><i class='fas fa-check-circle'></i> Terima</a></td>";
                                break;
                            case 2;
                                echo "<td align='right'>";
                                echo "<span class='text-danger'>Ditolak</span>";
                                echo "</td align='right'>";
                                break;
                        }
                        echo "</td>";
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
            $("#spinner").show();
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
    });
</script>