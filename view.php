<!DOCTYPE html>
<html>
  <head>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <script
      src="https://code.jquery.com/jquery-3.2.1.min.js"
      integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
      crossorigin="anonymous"></script>
		<script src="//code.jquery.com/ui/1.11.0/jquery-ui.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>

    <div class="container">
      <h1>Lending Bot</h1>
      <?php foreach ($messages as $key => $message): ?>
        <div class="alert alert-success alert-dismissable">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <?php if (is_array($message)): ?>
            <?php
              print_r($message);
             ?>
          <?php else: ?>
            <?= $message ?>
          <?php endif; ?>
        </div>
      <?php endforeach; ?>

      <div class="table-responsive">
        <table class="table data-table table-striped table-bordered">
          <thead>
            <tr>
            <th>Date</th>
              <th>Currency</th>
              <th>Rate</th>
              <th>Amount</th>
              <th>Fees</th>
              <th>Duration</th>
              <th>Auto Renew</th>
            </tr>
          </thead>
          <?php foreach ($activeLoans as $key => $loan): ?>
            <tr>
              <td>
                <?php
                // $datetime is something like: 2014-01-31 13:05:59
                  // $time = strtotime();
                  $datetime = new DateTime($loan['date']);
                  $datetime->add(new DateInterval('PT2H'));
                  // $la_time = new DateTimeZone('CST6CDT');
                  // $datetime->setTimezone($la_time);
                  $datetime->sub(new DateInterval('PT7H'));
                  echo $datetime->format('Y-m-d h:i a');
                  // echo $myFormatForView;
                 ?>

              </td>
              <td><?= $loan['currency'] ?></td>
              <td><?= $loan['rate']*100 ?>%</td>
              <td><?= $loan['amount'] ?></td>
              <td><?= $loan['fees'] ?></td>
              <td><?= $loan['duration'] ?> day(s)</td>
              <td><?= $loan['autoRenew'] ?></td>
            </tr>
          <?php endforeach; ?>
        </table>
      </div>


      <?php if ($lent): ?>
      <iframe width="560" height="315" src="https://www.youtube.com/embed/ApGJpmO70dM?autoplay=1" frameborder="0" allowfullscreen></iframe>
      <?php endif; ?>
    </div>

    <script type="text/javascript">
      setInterval(function() {
        window.location.reload();
      }, 5*60000);
      jQuery(document).ready(function(){
        $(document).ready(function() {
            $('table').DataTable({
              "order": [[ 0, "desc" ]]
            });
        } );
      });
    </script>

  </body>
</html>
