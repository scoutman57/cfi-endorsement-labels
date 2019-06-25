<!-- #!/usr/local/bin/php -q -->
<?php



function readall($datafile)
{
  $data = fopen( $datafile, 'r' );
  $line = fgetcsv( $data );
  $i=0;
  while( $line )
  {
    $enddata[$i] = $line;
    $line = fgetcsv( $data );
    $i++;
  }
  return $enddata;
}

function readdata($datafile)
{
  $data = fopen( $datafile, 'r' );
  $line = fgetcsv( $data );
  $i=0;
  while( $line )
  {
    if( ((int)($line[0])) == 0 )
    {
      $line = fgetcsv( $data );
      continue;
    }
    $enddata[$i] = $line;
    $line = fgetcsv( $data );
    $i++;
  }
  return $enddata;
}



?>
