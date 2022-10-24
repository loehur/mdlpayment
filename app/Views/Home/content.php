<div id="content"></div>

<!-- SCRIPT -->
<script src="<?= $this->ASSETS_URL ?>js/jquery-3.6.0.min.js"></script>
<script src="<?= $this->ASSETS_URL ?>js/popper.min.js"></script>
<script src="<?= $this->ASSETS_URL ?>plugins/bootstrap-5.1/bootstrap.bundle.min.js"></script>

<script>
    $(document).ready(function() {
        load();

        setInterval(function() {
            cek_antri_pre();
            cek_proses_pre();

            cek_proses_post();
        }, 5000);
    });

    function load() {
        $("div#content").load('<?= $this->BASE_URL ?>Home/load_content');
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

    function eksekusi_antri_pre() {
        $.ajax({
            url: "<?= $this->BASE_URL ?>IAK/topup",
            data: [],
            type: "POST",
            success: function(res) {
                if (res == 1) {
                    location.reload(true);
                } else {
                    alert(res);
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
                    location.reload(true);
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
                    location.reload(true);
                }
            },
        });
    }
</script>