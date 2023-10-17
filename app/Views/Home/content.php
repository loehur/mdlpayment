<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-auto me-auto">
                Outlate/Staff
                <h6><b class="text-success"><?= ($this->userData['nama'] == $this->setting['nama']) ? $this->setting['nama'] : $this->setting['nama'] . "/" . $this->userData['nama']; ?></b></h6>
            </div>
            <div class="col-auto">
                <span class="float-right">Kas</span><br>
                <h6><b class="text-success"><?= number_format($data['kas']) ?></b></h6>
            </div>
            <?php if ($this->userData['no_user'] == $this->userData['no_master']) { ?>
                <div class="col-auto">
                    <span class="float-right">Saldo</span><br>
                    <h6><b class="text-success"><?= number_format($data['saldo']) ?></b></h6>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<ul class="nav nav-tabs mx-2 mt-2" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Pra Bayar <small><span id="pre_antri"></span></small></button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Pasca Bayar <small><span id="post_antri"></span></small></button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="manual-tab" data-bs-toggle="tab" data-bs-target="#manual" type="button" role="tab" aria-controls="manual" aria-selected="false">Manual <small><span id="manual_antri"></span></small></button>
    </li>
</ul>
<div class="tab-content mx-1 pt-1" id="myTabContent">
    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
        <div class="content">
            <div class="container-fluid">
                <div class="row" id="load_pre">
                </div>
            </div>
        </div>
    </div>
    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
        <div class="content">
            <div class="container-fluid">
                <div class="row" id="load_post"></div>
            </div>
        </div>
    </div>
    <div class="tab-pane fade" id="manual" role="tabpanel" aria-labelledby="manual-tab">
        <div class="content">
            <div class="container-fluid">
                <div class="row" id="load_manual"></div>
            </div>
        </div>
    </div>
</div>


<div class="content" style="padding-bottom:80px">
    <div class="container-fluid">
    </div>
</div>

<script src="<?= $this->ASSETS_URL ?>js/jquery-3.6.0.min.js"></script>
<script src="<?= $this->ASSETS_URL ?>js/popper.min.js"></script>
<script src="<?= $this->ASSETS_URL ?>plugins/bootstrap-5.2.2-dist/js/bootstrap.bundle.min.js"></script>


<script>
    $(document).ready(function() {
        load_pre();
        load_post();
        load_manual();

        setInterval(function() {
            cek_antri_pre();
            cek_proses_pre();
            cek_proses_post();
            cek_manual();
        }, 5000);
    });

    function load_pre() {
        $("div#load_pre").load('<?= $this->BASE_URL ?>Home/load_pre');
    }

    function load_post() {
        $("div#load_post").load('<?= $this->BASE_URL ?>Home/load_post');
    }

    function load_manual() {
        $("div#load_manual").load('<?= $this->BASE_URL ?>Home/load_manual');
    }

    // PREPAID FUNCTIONS
    function cek_antri_pre() {
        var antri_pre_count = $("span#tr_antri_pre").html();
        if (antri_pre_count > 0) {
            eksekusi_antri_pre();
        }
    }

    function cek_proses_pre() {
        var proses_pre_count = $("span#tr_proses_pre").html();
        if (proses_pre_count > 0) {
            cek_pre();
        }
    }

    function cek_manual() {
        var antri_manual_count = $("span#tr_antri_manual").html();
        if (antri_manual_count > 0) {
            load_manual();
        }
    }

    function eksekusi_antri_pre() {
        $.ajax({
            url: "<?= $this->BASE_URL ?>IAK/topup",
            data: [],
            type: "POST",
            success: function(res) {
                if (res == 1) {
                    load_pre();
                }
            },
        });
    }

    function cek_pre() {
        $.ajax({
            url: "<?= $this->BASE_URL ?>IAK/topup_cek",
            data: [],
            type: "POST",
            success: function(res) {
                if (res == 1) {
                    load_pre();
                }
            },
        });
    }

    // POST FUNCTIONS
    function cek_proses_post() {
        var proses_post_count = $("span#tr_proses_post").html();
        if (proses_post_count > 0) {
            cek_post();
        }
    }

    function cek_post() {
        $.ajax({
            url: "<?= $this->BASE_URL ?>IAK/post_cek",
            data: [],
            type: "POST",
            success: function(res) {
                if (res == 1) {
                    load_post();
                }
            },
        });
    }

    function Print(id) {
        var divContents = document.getElementById("print" + id).innerHTML;
        var a = window.open('');
        a.document.write('<html>');
        a.document.write('<title>Print Page</title>');
        a.document.write(divContents);
        a.document.write('</body></html>');
        var window_width = $(window).width();
        a.print();

        if (window_width > 600) {
            a.close()
        } else {
            setTimeout(function() {
                a.close()
            }, 60000);
        }
    }
</script>