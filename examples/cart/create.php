<?php
include('Cart.php');
include('Form.php');

$Booking = new Booking();

if($_SERVER['REQUEST_METHOD'] == 'POST') {

  $Form = new Form($Booking->form(),$_POST);
  $response = $Booking->create($_POST);

  if($response['request']['status'] == 'OK') {
    // successful transactions will return a url to be redirected to for payment or an invoice.
    header("Location: {$response['request']['data']['url']}");
    exit;

  } else {
    $Form->msg($response['request']['error']['details'],$response['request']['status']);
  }
} else {
  $Form = new Form($Booking->form());
}
header('Content-type: text/html; charset=utf-8');
?>
<html>
<head>
  <style style="text/css">
    body { font:90% "Helvetica Neue",Helvetica,Arial,sans-serif; }
    label { width: 10em; display: block; text-align: right; font-weight: bold; float: left; margin-right: 1em; }
    input, select, textarea { width: 20em; display: block; }
		label[type="radio"] { display: inline-block; float: none; width: 2em; }
		input[type="radio"] { display: inline-block; width: 1em; margin-right: 5em; }
    .msg.ERROR { color: firebrick; font-weight: bold; }
    i.required { color: orange;  margin: 0 -7px 0 2px; }
    #debug-info { background: #eee; width: 30%; padding: 1em; margin: 1em; box-shadow: inset 0px 0px 3px 0px #333; }
    #debug-info strong { display: block; margin: 1em; }
    fieldset{border: none;}
  </style>
</head>
<body>
  <h1>Checkfront Shopping Cart Demo</h1>
  <form method="post" action="<?php echo $_SERVER['SCRIPT_NAME']?>">
    <fieldset>
    <?php
      echo $Form->msg();

      if(!count($Form->fields)) {
        echo '<p>ERROR: Cannot fetch fields.</p>';
      } else {
        foreach($Form->fields as $field_id => $data) {
          if(!in_array($field_id, array('msg','errors','mode'))) {
            if(!empty($data['define']['layout']['lbl'])) {
              $label = "<label for='{$field_id}'>" . $data['define']['layout']['lbl'] . ":";
              if($data['define']['required']){
                $label .= '<i class="required">*</i>';
              }
              $label .= '</label>';
              echo $label;
            }
            echo $Form->render($field_id);
            echo '<br />';
          }
        }
        echo '<center><button type="submit"> Continue </button></center>';

		echo $Form->fields['custom_policy_msg']['msg']['txt'];
      }
    ?>
      <div id="debug-info">
        <h4>Debug Information</h4>
        <span>Cart ID:</span>
        <input type="text" readonly="readonly" name="cart_id" value="<?php echo session_id()?>" />
        <div><?php if (!empty($Booking->Checkfront->error)) print_r($Booking->Checkfront->error)?></div>
      </div>
    </fieldset>
  </form>
</body>
</head>
</html>
