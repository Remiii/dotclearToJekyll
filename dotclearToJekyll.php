#!/usr/bin/php

<?php

require_once './markdownify/markdownify.php' ;
$md = new Markdownify ;

echo "Start script\n" ;

$row = 1 ;

if ( ( $handleRead = fopen ( 'dataInput/data.csv' , 'r' ) ) !== FALSE )
{
    while ( ( $data = fgetcsv ( $handleRead , 10000 , ',' , '\'' ) ) !== FALSE )
    {

        echo "\nLigne: $row\n" ;
        $row++ ;

        $filePath = 'dataOutput' ;
        $fileName = substr ( $data [ 0 ] , 0 , 10 ) . '-' . $data [ 2 ] . '.' . 'md' ;
        $fileContent =
            "---\n"
            . "layout: post\n"
            . "title: " . str_replace ( '\\' , '' , $data [ 1 ] ) . "\n"
            . "---\n"
            . "\n"
            . '#' . str_replace ( '\\' , '' , $data [ 1 ] ) . "\n"
            . str_replace ( '\\' , '' , str_replace ( '\n' , '' , $md->parseString ( $data [ 5 ] ) ) ) ;

        $handleWrite = fopen ( $filePath . '/' . $fileName , 'x+' ) ;
        fputs ( $handleWrite , $fileContent ) ;
        fclose ( $handleWrite ) ;

    }

    fclose ( $handleRead ) ;

}

echo "\nEnd\n" ;

?>
