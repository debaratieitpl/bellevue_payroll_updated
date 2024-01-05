<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Bellvue</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

</head>

<body>
  <div style="width:50%; margin:0 auto;">
    <div style="margin-top: 160px;">
      <strong style="margin: 0; font-family: Arial, Helvetica, sans-serif; margin-bottom: 5px; display: block; font-size: 13px;">Ms.
        <?php echo $candidate_offer->name ?>,</strong>
      <p style="margin: 0; font-family: Arial, Helvetica, sans-serif; margin-bottom: 5px;  font-size: 13px; font-weight: normal;"><?php echo $candidate_offer->address ?>,
      </p>
      <p style="margin: 0; font-family: Arial, Helvetica, sans-serif; margin-bottom: 5px; font-size: 13px; font-weight: normal;"><?php echo $candidate_offer->location ?>,</p>
      <p style="margin: 0; font-family: Arial, Helvetica, sans-serif; margin-bottom: 5px; font-size: 13px;"><strong><?php echo $candidate_offer->state ?>-<?php echo $candidate_offer->pincode ?></strong></p>
    </div>
    <br />
    <br />
    <p style="margin: 0; font-family: Arial, Helvetica, sans-serif; margin-bottom: 5px; font-size: 13px; text-align: right;"><?php echo date("Y-m-d")?></p>
    <h4 style="font-family: Arial, Helvetica, sans-serif; text-align: center; font-size: 12px;"><strong> Subject: Offer Letter </strong>
    </h4>

    <p style="margin: 0; font-family: Arial, Helvetica, sans-serif; margin-bottom: 5px; font-size: 12px; font-weight: normal; line-height: 16px;">
    <?php if(isset($candidate_offer) && $candidate_offer->gender === "Male"): ?>
    Sir,
<?php else: ?>
    Madam,
<?php endif; ?>
      <br />
      <br />
      With reference to the personal interview you had with us, we are pleased to confirm your appointment with our clinic as a 
      <br />
      <strong> Trainee Co-ordinator.</strong>
      <br />
      <br />
      We have been given to understand by you that you will be busy with your present work and will be in a position to join us on and from <strong><?php echo ucfirst(\Carbon\Carbon::parse($candidate_offer->date_jo)->format('Y-m-d')) ?></strong>
      <br />
      <br />
      Keeping this in mind, this letter is being issued to you, which you are requested to sign and return as a token of acceptance. The package in which you have been appointed has been made clear to you.
    </p>

    <p style="margin: 0; font-family: Arial, Helvetica, sans-serif; margin-bottom: 5px; font-size: 12px; font-weight: normal;">
      Yours faithfully,
    </p>
    <br />
    <br />
    <p style="margin: 0; font-family: Arial, Helvetica, sans-serif; margin-bottom: 5px; font-size: 13px;">
      <strong>
        For: BELLE VUE CLINIC
      </strong>
    </p>
    <br />
    <br />
    <p style="margin: 0; font-family: Arial, Helvetica, sans-serif; margin-bottom: 5px; font-size: 13px;"><strong>P. Tondon </strong></p>
    <p style="margin: 0; font-family: Arial, Helvetica, sans-serif; margin-bottom: 5px; text-decoration: underline; font-size: 13px;">
      <strong>Chief Executive
        Officer</strong>
    </p>
  </div>

</body>

</html>