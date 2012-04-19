<?php

$Module = $Params['Module'];

$ini = eZINI::instance( );
$http = eZHTTPTool::instance( );

$Result = array( );
$Result['pagelayout'] = false;

$Result['content'] = '<pre>';

// QH Motion Logon
$UnistrokeString = ($Module->hasActionParameter( 'UniStroke' ) ? $Module->actionParameter( 'UniStroke' ) : $_POST['UniStroke']);
$UnistrokePoints = array( );

$Result['content'] .= var_export( $UnistrokeString, true ) . "<br/>\n";

$unistrokesCoordinates = explode( '/', $UnistrokeString );

if ( !$Module->hasActionParameter( 'UniStroke' ) )
{
    foreach ( $UnistrokeString as $coordinates )
    {
        $UnistrokePoints[] = array( 'x' => $coordinates[X], 'y' => $coordinates[Y] );
    }
}
else
{
    foreach ( $unistrokesCoordinates as $k => $unistrokeCoordinate )
    {
        list( $x, $y ) = explode( ',', $unistrokeCoordinate );
        if ( $x && $y )
        {
            $UnistrokePoints[$k]['x'] = $x;
            $UnistrokePoints[$k]['y'] = $y;
        }
    }
}

$Result['content'] .= var_export( $UnistrokePoints, true );

$recognizer = new phpDollar( );

$result = $recognizer->recognizeStroke( $UnistrokePoints );
$Result['content'] .= var_export( $result, true );

$Result['content'] .= "</pre>";
?>
