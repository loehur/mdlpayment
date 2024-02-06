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
                    <form id="form" action="<?= $this->BASE_URL ?>Register/tambah_staff" method="post">
                        <div class="row mb-2">
                            <div class="col">
                                <label>Nama Panggilan</label>
                                <input type="text" class="form-control form-control-sm" id="nama" name="nama" placeholder="Nama Panggilan" required>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col">
                                <label>Nomor HP / ID Loket</label>
                                <input type="text" class="form-control form-control-sm" id="HP" name="HP" placeholder="Nomor HP" required>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col">
                                <label>PIN Transaksi</label>
                                <input type="password" class="form-control form-control-sm" name="pin" placeholder="PIN Transaksi" required>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col">
                                <label class="ml-3"><small>Default [Password: abcdef], [PIN: 123456]</small></label>
                                <button type="submit" class="btn btn-sm btn-primary btn-block">
                                    Tambah Staff
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
        <div class="container-fluid px-4">
            <div class="row">
                <div class="col border pb-1">
                    <small class="text-secondary">
                        * Jika Status Terblokir, maka harus menghubungi MDL Admin untuk mengaktifkan kembali<br>
                        ** Seller ON maka staff boleh berjualan, Off jika tidak boleh berjualan hanya untuk pemakaian saja
                    </small>
                    <hr class="p-0 m-0 mt-1">
                    <table class="table table-sm mb-0 pb-0">
                        <?php
                        $no = 0;
                        echo "<tbody>";
                        foreach ($data as $h => $a) {
                            $user_id = $a['no_user'];
                            $seller = $a['seller'];
                            echo "<tr>";
                            foreach ($a as $key => $value) {
                                switch ($key) {
                                    case "password":
                                        $pass_ = $value;
                                        break;
                                    case "pin":
                                        $pin_ = $value;
                                        break;
                                    case "no_user":
                                        echo "<td><span style='cursor:pointer' data-value='" . $value  . "' data-mode='" . $key . "'>" . $value . "</span><br>";
                                        break;
                                    case "nama":
                                        echo "<span style='cursor:pointer' data-value='" . $value  . "' data-mode='" . $key . "'>" . $value . "</span></td>";
                                        break;
                                    case "insertTime":
                                        echo "<td><span style='cursor:pointer' data-value='" . $value  . "' data-mode='" . $key . "'>" . $value . "</span>";
                                        break;
                                    case "en":
                                        echo "<br>Status:";
                                        if ($value == $this->model('Validasi')->enc($pass_ . $pin_)) { ?>
                                            <a class='text-danger border px-2 rounded text-decoration-none' href='<?= $this->BASE_URL . "Staff/updateCell_Staff/en/0/" . $user_id ?>'>Blok</a>
                                        <?php } else { ?>
                                            <span class='text-secondary text-bold'><b>Terblokir</b></span>
                                        <?php } ?>
                            <?php break;
                                }
                            }
                            ?>
                            <td>
                                Seller<br>
                                <button class="border-light rounded sell_permit" data-user="<?= $user_id ?>" data-value="<?= $seller ?>"><?= ($seller == 1) ? "On" : "Off" ?></button>
                            </td>
                            <?php
                            if ($value == $this->model('Validasi')->enc($pass_ . $pin_)) { ?>
                                <td nowrap>

                                </td>
                        <?php }
                            echo "</tr>";
                        }
                        echo "</tbody>";
                        ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class=" content" style="padding-bottom:80px">
        <div class="container-fluid">
        </div>
    </div>



    <!-- SCRIPT -->
    <script src="<?= $this->ASSETS_URL ?>js/jquery-3.6.0.min.js"></script>

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

        $(".sell_permit").click(function() {
            const val = $(this).attr("data-value");
            const user = $(this).attr("data-user");

            $.post("<?= $this->BASE_URL ?>Staff/updateSeller", {
                user: user,
                val: val
            }).done(function(res) {
                location.replace("<?= $this->BASE_URL ?>Staff");
            });
        })
    </script>