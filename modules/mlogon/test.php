<?php

require_once ('kernel/common/template.php');

$Module = $Params['Module'];

$tpl = templateInit( );

$Result = array( );
$Result['content'] = $tpl->fetch( 'design:mlogon/test.tpl' );
?>