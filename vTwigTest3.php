<form action="vTwigTest4" method="POST">
<input name="operations" type="text" value="10"/>
<input type="submit" value="Save changes"/>
</form>

<?php
echo $_POST[operations];
?>