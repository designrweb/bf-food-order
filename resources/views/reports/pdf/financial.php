<?php

use App\Location;

/**
 * @var array    $incomingTransactions
 * @var array    $manuallyBookedMoney
 * @var array    $orderedMeals
 * @var array    $spontaneousOrders
 * @var array    $voucherOrders
 * @var Location $location
 * @var string   $startDate
 * @var string   $endDate
 */
?>

<table style=" margin: 5mm auto; border:none; background: white;  width: 90%;">
  <tr style="border:none;">
    <td style="border:none;">
      <p style="font-weight: bold;"><?= __('reports.Full Service Providing') ?></p>
      <p style="font-weight: bold;"><?= $location->name ?></p>
      <p>Umsatzerlöse vom <?= $startDate ?> bis <?= $endDate ?> </p>
    </td>
    <td style="border:none;">

    </td>
  </tr>
</table>
<table style="margin: 0 auto;  background: white;  width: 90%">
  <tr style="background: #95c024;">
    <th>Pos</th>
    <th>Menge</th>
    <th>Bezeichnung</th>
    <th>Gesamtpreis</th>
  </tr>
  <tr>
    <td>01</td>
    <td><?= count($incomingTransactions['items']) ?></td>
    <td><?= __('reports.Incoming transactions') ?></td>
    <td><?= number_format($incomingTransactions['total'], 2) ?> &euro;</td>
  </tr>
  <tr>
    <td>02</td>
    <td><?= count($manuallyBookedMoney['items']) ?></td>
    <td><?= __('reports.Manually booked money') ?></td>
    <td><?= number_format($manuallyBookedMoney['total'], 2, ',', '.') ?> &euro;</td>
  </tr>
  <tr>
    <td>03</td>
    <td><?= count($orderedMeals['items']) ?></td>
    <td><?= __('reports.Ordered meals') ?></td>
    <td><?= number_format($orderedMeals['total'], 2, ',', '.') ?> &euro;</td>
  </tr>
  <tr>
    <td>04</td>
    <td><?= count($spontaneousOrders['items']) ?></td>
    <td><?= __('reports.Spontaneous orders') ?></td>
    <td><?= number_format($spontaneousOrders['total'], 2, ',', '.') ?> &euro;</td>
  </tr>
  <tr>
    <td>05</td>
    <td><?= count($voucherOrders['items']) ?></td>
    <td><?= __('reports.Voucher orders') ?></td>
    <td><?= number_format($voucherOrders['total'], 2, ',', '.') ?> &euro;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td style="font-weight: bold;">Gesamtsumme</td>
      <?php $total = $voucherOrders['total']
          + $spontaneousOrders['total']
          + $manuallyBookedMoney['total']
          + $orderedMeals['total']
          + $incomingTransactions['total']; ?>
    <td><?= number_format($total, 2, ',', '.') ?> &euro;</td>
  </tr>
</table>
<pagebreak>
  <h3 style="margin-left: 10mm;"><?= __('reports.Incoming transactions') ?></h3>
  <table class="no-border" style="margin: 0 auto; width: 90%;">
    <tr>
      <th>Kontonummer</th>
      <th>Kontoname</th>
      <th>Lieferdatum</th>
      <th>Buchungsdatum</th>
      <th>Betrag</th>
    </tr>
      <?php foreach ($incomingTransactions['items'] as $item): ?>
        <tr>
          <td><?= $item['customer_id'] ?></td>
          <td><?= $item['customer_name'] ?></td>

          <td><?= $item['delivery_date'] ?></td>
          <td><?= $item['posted_date'] ?></td>
          <td><?= number_format($item['amount'], 2, ',', '.') ?> &euro;</td>
        </tr>
      <?php endforeach; ?>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><strong><?= number_format($incomingTransactions['total'], 2, ',', '.') ?> &euro;</strong></td>
    </tr>
  </table>

  <h3 style="margin-left: 10mm;"><?= __('reports.Manually booked money') ?></h3>
  <table class="no-border" style="margin: 0 auto; width: 90%;">
    <tr>
      <th>Kontonummer</th>
      <th>Kontoname</th>
      <th>Lieferdatum</th>
      <th>Buchungsdatum</th>
      <th>Betrag</th>
    </tr>
      <?php foreach ($manuallyBookedMoney['items'] as $item): ?>
        <tr>
          <td><?= $item['customer_id'] ?></td>
          <td><?= $item['customer_name'] ?></td>
          <td><?= $item['delivery_date'] ?></td>
          <td><?= $item['posted_date'] ?></td>
          <td><?= number_format($item['amount'], 2, ',', '.') ?> &euro;</td>
        </tr>
      <?php endforeach; ?>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><strong><?= number_format($manuallyBookedMoney['total'], 2, ',', '.') ?> &euro;</strong></td>
    </tr>
  </table>

  <h3 style="margin-left: 10mm;"><?= __('reports.Ordered meals') ?></h3>
  <table class="no-border" style="margin: 0 auto; width: 90%;">
    <tr>
      <th>Kontonummer</th>
      <th>Kontoname</th>
      <th>Lieferdatum</th>
      <th>Buchungsdatum</th>
      <th>Betrag</th>
    </tr>
      <?php foreach ($orderedMeals['items'] as $item): ?>
        <tr>
          <td><?= $item['customer_id'] ?></td>
          <td><?= $item['customer_name'] ?></td>
          <td><?= $item['delivery_date'] ?></td>
          <td><?= $item['posted_date'] ?></td>
          <td><?= number_format($item['amount'], 2, ',', '.') ?> &euro;</td>
        </tr>
      <?php endforeach; ?>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><strong><?= number_format($orderedMeals['total'], 2) ?> &euro;</strong></td>
    </tr>
  </table>

  <h3 style="margin-left: 10mm;"><?= __('reports.Spontaneous orders') ?></h3>
  <table class="no-border" style="margin: 0 auto; width: 90%;">
    <tr>
      <th>Kontonummer</th>
      <th>Kontoname</th>
      <th>Lieferdatum</th>
      <th>Buchungsdatum</th>
      <th>Betrag</th>
    </tr>
      <?php foreach ($spontaneousOrders['items'] as $item): ?>
        <tr>
          <td><?= $item['customer_id'] ?></td>
          <td><?= $item['customer_name'] ?></td>
          <td><?= $item['delivery_date'] ?></td>
          <td><?= $item['posted_date'] ?></td>
          <td><?= number_format($item['amount'], 2, ',', '.') ?> &euro;</td>
        </tr>
      <?php endforeach; ?>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><strong><?= number_format($spontaneousOrders['total'], 2, ',', '.') ?> &euro;</strong></td>
    </tr>
  </table>

  <h3 style="margin-left: 10mm;"><?= __('reports.Voucher orders') ?></h3>
  <table class="no-border" style="margin: 0 auto; width: 90%;">
    <tr>
      <th>Kontonummer</th>
      <th>Kontoname</th>
      <th>Lieferdatum</th>
      <th>Buchungsdatum</th>
      <th>Betrag</th>
    </tr>
      <?php foreach ($voucherOrders['items'] as $item): ?>
        <tr>
          <td><?= $item['customer_id'] ?></td>
          <td><?= $item['customer_name'] ?></td>
          <td><?= $item['delivery_date'] ?></td>
          <td><?= $item['posted_date'] ?></td>
          <td><?= number_format($item['amount'], 2, ',', '.') ?> &euro;</td>
        </tr>
      <?php endforeach; ?>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><strong><?= number_format($voucherOrders['total'], 2, ',', '.') ?> &euro;</strong></td>
    </tr>
  </table>
