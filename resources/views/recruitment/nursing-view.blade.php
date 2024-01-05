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
  <div style="width:70%; margin:0 auto;">
    <div style="margin-top: 150px;">
      <strong style="margin: 0; font-family: Arial, Helvetica, sans-serif; margin-bottom: 5px; display: block; font-size: 13px;">Ms.
      <?php echo $candidate_offer->name ?></strong>
      <p style="margin: 0; font-family: Arial, Helvetica, sans-serif; margin-bottom: 5px;  font-size: 13px; font-weight: normal;"><?php echo $candidate_offer->address ?>,
      </p>
      <p style="margin: 0; font-family: Arial, Helvetica, sans-serif; margin-bottom: 5px; font-size: 13px; font-weight: normal;"><?php echo $candidate_offer->location ?>,</p>
      <p style="margin: 0; font-family: Arial, Helvetica, sans-serif; margin-bottom: 5px; font-size: 13px;"><strong> <?php echo $candidate_offer->state ?>-<?php echo $candidate_offer->pincode ?>
      <?php echo date('Y-m-d'); ?></strong></p>
    </div>
    <br />
    <br />
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
      With reference to the personal interview you had with us, we are pleased to confirm your appointment with our
      Institute
      as
      <br />
      <strong> Assistant Professor.</strong>
      <br />
      <br />
      We have been given to understand by you that you will be busy with your present work and will be in a position to
      join
      about <?php echo ucfirst(\Carbon\Carbon::parse($candidate_offer->date_jo)->format('Y-m-d')) ?>.
      <br />
      <br />
      Keeping this in mind, this letter is being issued to you, which you are requested to sign and return as a token of
      acceptance. The package in which you have been appointed has been made clear to you.
    </p>

    <p style="margin: 0; font-family: Arial, Helvetica, sans-serif; margin-bottom: 5px; font-size: 12px; font-weight: normal;">
      Yours faithfully,
    </p>
    <br />
    <br />
    <p style="margin: 0; font-family: Arial, Helvetica, sans-serif; margin-bottom: 5px; font-size: 13px;">
      <strong>
        For: Priyamvada Birla Institute of Nursing Unit of: Belle Vue Clinic
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