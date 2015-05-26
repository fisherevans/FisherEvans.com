<?php
    if($_SESSION['phrase'] != $correctAdminPhrase) { exit; }
    
?>

<a href="/admin/menu">&lt;&lt;&lt; Back to Menu</a><br>
<a href="/admin/blog/new">Create new Post</a><br>
<form name="newNav" action="/admin/newnav" method="post">
<table cellspacing=0>
<?php
    foreach(fetchNavigation() as $nav) {
        echo "<tr><td>" . $nav['page_id'] . "</td><td>" . 
        $nav['sequence'] . "</td><td><a href='/admin/deletenav/" . 
        $nav['page_id'] . "' onclick=\"return confirm('are you sure?')\">Delete</a></td></tr>";
    }
?>
    <tr>
        <td>
            <select name="page_id">
                <?php
                    foreach(fetchPagesNotInNav() as $newPage) {
                        echo "<option value='" . $newPage['id'] . "'>" . $newPage['id'] . "</option>";
                    }
                ?>
            </select>
        </td>
        <td><input style="width:200px;" name="sequence" placeholder="Sequence" /></td>
        <td><a href="javascript:document.newNav.submit()">Add</a></td>
    </tr>
</table>
</form>