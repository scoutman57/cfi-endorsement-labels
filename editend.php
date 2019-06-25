<!-- #!/usr/local/bin/php -q -->
<?php

require('phplib.php');

$endorsementlist = readdata( 'endorsements.csv' );
$labellist = readall( 'labelspecs.csv' );

print "<html><head><title>Endorsements</title>";
?>

<script type="text/javascript">

function updatevals()
{
  var lcode = document.getElementById("labelcode").value;
  var lArray = <?php echo json_encode( $labellist ) ?>;
  document.getElementById("B1").disabled = false;

  for (var i=0; i < lArray.length; i++)
  {
    if( lcode == lArray[i][0] )
    {
      document.getElementById("labelspersheet").value = lArray[i][1];
      document.getElementById("labelcols").value =      lArray[i][2];
      document.getElementById("labelvertinit").value =  lArray[i][3];
      document.getElementById("labelvert").value =      lArray[i][4];
      document.getElementById("labelhorizinit").value = lArray[i][5];
      document.getElementById("labelhoriz").value =     lArray[i][6];
      document.getElementById("labelrightmar").value =  lArray[i][7];
      document.getElementById("linespace").value =      lArray[i][8];
      document.getElementById("fontsize").value =       lArray[i][9];

    }

  }

}

</script>

<?php
print "</head><body><h2>CFI Endorsements</h2>";
print "<form action=\"pdfit.php\" method=\"POST\">";
print "<table>";

$cfino = $_POST['cfino'];
$exp = $_POST['cfiexp'];

if(!empty($_POST['checklist']))
{
  $count=1;
  foreach($_POST['checklist'] as $selected)
  {
    $endno = ((int)($selected));
    $desc = $endorsementlist[$endno-1][2];
    $text = $endorsementlist[$endno-1][3];
    $note = $endorsementlist[$endno-1][4];
    $ssig = $endorsementlist[$endno-1][5];
    if( array_key_exists( 'sig', $_POST ) )
      if( $_POST['sig'] && $ssig!="ssig" )
        $text = $text . "\nSigned______________________ Date_________ \n$cfino  Exp $exp";
    print "<tr><td colspan=2>$desc</td>";
    print "<tr><td><textarea rows=\"6\" cols=\"70\" name=\"textlist[]\" value=\"$count\">";
    print "$text</textarea></td>\n";
    print "<td valign=\"top\">$note</td>";
    print "</tr>";
    $count++;

  }
}

print"</table>";
print"<p>Avery label template:<select name=\"labelcode\" id=\"labelcode\" onchange=\"updatevals()\">";

print"<option value=\"\"> </option>";

for( $i=0; $i<count($labellist); $i++ )
{
  $labelcode=$labellist[$i][0];
  print"<option value=\"$labelcode\">$labelcode</option>";
}

print <<<END2
</select>
<p>Labels to skip:<input type="text" size="1" name="skip" value="0">
<p><input type="submit" id="B1" disabled="true" name="B1" value="Make labels">


<p>Hopefully the prefilled values here (after selecting a label template above) work ok,<br>but adjust as necessary if needed:
<table>
<tr><td>Labels per sheet: </td><td><input type"text" name="labelspersheet" id="labelspersheet" size="3"></td></tr>
<tr><td>Columns per sheet: </td><td><input type"text" name="labelcols" id="labelcols" size="3"></td></tr>
<tr><td>Initial vertical: </td><td><input type"text" name="labelvertinit" id="labelvertinit" size="3"></td></tr>
<tr><td>Recurring vertical: </td><td><input type"text" name="labelvert" id="labelvert" size="3"></td></tr>
<tr><td>Initial horizontal: </td><td><input type"text" name="labelhorizinit" id="labelhorizinit" size="3"></td></tr>
<tr><td>Recurring horizontal: </td><td><input type"text" name="labelhoriz" id="labelhoriz" size="3"></td></tr>
<tr><td>Right-side margin: </td><td><input type"text" name="labelrightmar" id="labelrightmar" size="3"></td></tr>
<tr><td>Line spacing: </td><td><input type"text" name="linespace" id="linespace" size="3"></td></tr>
<tr><td>Font size: </td><td><input type"text" name="fontsize" id="fontsize" size="3"></td></tr>
</table>

</form>
</body></html>


END2;

?>

