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
                <div id="info"></div>
                <form class="pin" action="<?= $this->BASE_URL ?>Register/ganti_pin" method="post">
                    <div class="row mb-2">
                        <div class="col">
                            <label>Reset Code</label>
                            <input type="text" class="form-control form-control-sm" name="reset_code" placeholder="Reset Code" required>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col">
                            <label>PIN Baru</label>
                            <input type="password" class="form-control form-control-sm" minlength="6" id="pin" name="pin" placeholder="PIN Transaksi BARU" required>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col">
                            <label>Ulangi PIN Baru</label>
                            <input type="password" class="form-control form-control-sm" minlength="6" id="repin" name="repin" placeholder="Ulangi PIN Transaksi" required>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col">
                            <button type="submit" class="btn btn-sm btn-success btn-block">
                                Simpan PIN Transaksi
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>