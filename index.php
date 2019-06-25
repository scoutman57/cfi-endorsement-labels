<!-- #!/usr/local/bin/php -q -->
<?php

require('phplib.php');

$alllist = readall( 'endorsements.csv' );

print <<<END
<html><head><title>Endorsement Menu</title>

<script type="text/javascript">

function togglegroup(grp)
{
  var trlist = document.querySelectorAll("tr");
  var property = 'visible';
  for (i = 0; i < trlist.length; i++) {
    if( trlist[i].id.startsWith( 'endorsementrow.'+grp ) )
    {
      if( trlist[i].style.visibility == 'visible' )
        property = 'collapse';
      else
        property = 'visible';
      break;
    }
  }
  setgroup(grp,property);
}

function collapseall( property )
{
  var trlist = document.querySelectorAll("tr");
  for (i = 0; i < trlist.length; i++) {
    if( trlist[i].id.startsWith( 'endorsementrow.' ) )
      trlist[i].style.visibility = property;
  }
}

function setgroup(grp,property)
{
  var trlist = document.querySelectorAll("tr");
  for (i = 0; i < trlist.length; i++) {
    if( trlist[i].id.startsWith( 'endorsementrow.'+grp ) )
      trlist[i].style.visibility = property;
  }
}


</script>
</head>

<body onload="collapseall('collapse')">


<style>
/* Tooltip container */
.tooltip {
    position: relative;
    display: inline-block;
    border-bottom: 1px dotted black; /* If you want dots under the hoverable text */
}

/* Tooltip text */
.tooltip .tooltiptext {
    visibility: hidden;
    width: 300px;
    background-color: black;
    color: #fff;
    text-align: center;
    padding: 5px 0;
    border-radius: 6px;
 
    /* Position the tooltip text - see examples below! */
    position: absolute;
    z-index: 1;
}

/* Show the tooltip text when you mouse over the tooltip container */
.tooltip:hover .tooltiptext {
    visibility: visible;
}
</style>
END;

print "<h2>CFI Endorsement Menu</h2>";
print "<p>Click a red triangle to expland/ collapse a group, or: ";
print "<button onclick=\"collapseall('visible')\">Expand all</button> or ";
print "<button onclick=\"collapseall('collapse')\">Collapse all</button>";
print "<form action=\"editend.php\" method=\"POST\">";
print "<table border=1 width=700>";
$groupnum = 0;

for( $i=0; $i<count($alllist); $i++ )
{
  $num = ((int)($alllist[$i][0]));
  if ($num==0)
  {
    $group = $alllist[$i][1];
    $groupnum++;
    $groupnumtext = sprintf("%03d",$groupnum);
    print "<tr><td colspan=4>";
    print "<img src=\"redtri.png\" height=\"20\" width=\"20\" onclick=\"togglegroup('$groupnumtext')\">";
    print "<b>$group</b></td></tr>\n";
    #print "<br>$group\n";
  }
  else
  {
    $desc = $alllist[$i][2];
    $endtext = $alllist[$i][3];
    $groupnumtext = sprintf("%03d",$groupnum);
    $elid = "endorsementrow.$groupnumtext.$num";
    print "<tr id=\"$elid\"><td><input type=\"checkbox\" name=\"checklist[]\" value=\"$num\"> </td>";
    print "<td>$num</td>";
    print "<td>$desc</td>";
    print "<td><div class=\"tooltip\">Preview<span class=\"tooltiptext\">$endtext</span></div></td></tr>\n";
  }

}

print "</table><p>";
print "Check this box to include signature line:<input type=\"checkbox\" name=\"sig\">";
print "<br>CFI no: <input type=\"text\" name=\"cfino\" value=\"987654321CFI\">";
print "<br>Exp: <input type=\"text\" name=\"cfiexp\" value=\"12-31-99\">";
print "<p><input type=\"submit\" name=\"B1\" value=\"Load selected endorsements\">";
print "</form>";
print "<hr><font size=\"2\">Disclaimer";
print "<br>This endorsement tool is provided here without any accuracy guarantee nor warranty, expressed or implied.";
print "<br>Please consult FAA Advisory Circular 61-65 for up-to-date text and more information about these endorsements.";
print "<br>Text for this tool was pulled from AC 61-65H.";
print "<br>If you like this utility or have minor suggestions, I welcome feedback at rash at capnrash dot com.";
print "</body></html>";

?>

