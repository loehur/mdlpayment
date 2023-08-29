<?php
$z = $data['data'] ?>
<table style="margin: auto; margin-top:50px">
  <tbody>
    <?php
    $id = $z['id_topup'];
    $dibuat = substr($z['insertTime'], 8, 2) . "-" . substr($z['insertTime'], 5, 2) . "-" . substr($z['insertTime'], 0, 4)                ?>
    <tr>
      <td colspan="3">No. Master: <b><?= $z['no_master'] ?></b></td>
    </tr>
    <tr>
      <td><small>Tanggal</small><br><?= $dibuat ?></td>
      <td><small>Jumlah</small><br><b><?= number_format($z['jumlah']) ?></td>
      <td><small>Metode</small><br><?= strtoupper($z['bank']) ?></td>
    </tr>
    <tr>
      <td colspan="3">Status: <b><?= $z['topup_status'] ?></b></td>
    </tr>
    <tr>
      <td><a href="<?= $this->BASE_URL . $data['_c'] ?>/confirm/<?= $id ?>/1"><button>Verify</button></a></td>
      <td></td>
      <td><a href="<?= $this->BASE_URL . $data['_c'] ?>/confirm/<?= $id ?>/3"><button>Reject</button></a></td>
    </tr>
  </tbody>
</table>