<?php
function get_groups_from_that_category($category){
echo $select="SELECT groups.group_id FROM groups WHERE groups.group_category LIKE '%$category%'";


}


?>