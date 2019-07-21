<!DOCTYPE html>
<html>
<body>

<?php
$a1=array("a"=>"red","b"=>"green","c"=>"blue","d"=>"yellow");
$a2=array("e"=>"red","f"=>"green","g"=>"blue","h"=>"black","i"=>"white");

$result=array_diff($a1,$a2);
print_r($result);
print "<br>";
print_r(array_diff($a2,$a1));
?>

</body>
</html>
