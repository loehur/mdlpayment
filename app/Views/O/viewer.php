<div id="content" style="max-width: 600px; margin:auto"></div>
<script src="<?= $this->ASSETS_URL ?>js/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        content();
    });

    function content() {
        $("div#content").load('<?= $this->BASE_URL ?>O/content/<?= $data[0] ?>/<?= $data[1] ?>');
    }
</script>