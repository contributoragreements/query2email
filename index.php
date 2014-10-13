<?php
/* query2email converts a query, predictably from query2form and then submits
   both party A and party B for them to have a dicussion.

 */

include_once '../lib/shared.php';
include_once '../lib/email.php';
include_once '../lib/header.php';
?>

<?php

foreach ($input_errors as $key => $error)
{
    echo $error;
}

if ( ! $requirements_met )
{
    echo "<h4>REQUIREMENTS NOT MET</h4>\n";
    echo "</div></body></html>";
    exit;
}

// guess at what is the from field
$from = '';
if ( !empty($inputs['email']) )
   $from = $inputs['email'];
elseif ( !empty($inputs['email-address']) )
   $from = $inputs['email-address'];
elseif ( !empty($inputs['from']) )
   $from = $inputs['from'];



/*
echo "<pre>";
var_dump($inputs);
var_dump($configs);
echo "</pre>";
*/

$body_display = '';
echo '<table class="table table-striped table-bordered table-hover">' . "\n";
foreach ( $inputs as $key => $value )
{
    $body_display .= '<tr><td style="font-weight: bold">' . strtr(ucfirst($key), '-', ' ') . '</td>' . "<td>$value</td></tr>\n";
}
echo '<h3 class="alert alert-success">' . $configs['_success'] . "</h3>\n";
echo $body_display;
echo "</table>\n";


// email construction
$body = $configs['_success'] . "\n\n";
$body_party_b = "A form has been submitted.\n\n";
foreach ( $inputs as $key => $value )
{
    $body         .= strtr(ucfirst($key), '-', ' ') . ": $value\n";
    $body_party_b .= strtr(ucfirst($key), '-', ' ') . ": $value\n";
}

// remail($to, $from, $subject, $message, $files);
// email PARTY A
mailer($configs['_replyto'], $from, $configs['_subject'], $body_party_b);
// email PARTY B
mailer($from, $configs['_replyto'], $configs['_subject'], $body);


?>


<?php
include_once '../lib/footer.php';
