<?php

$googleSheets = new GoogleSheets($token->access_token, 'TimelineSheet', 'Sheet1');

// listado
$rows = $googleSheets->getRows();
?>
<table class="table">
<tr>
    <th>Start Date</th>
    <th>End Date</th>
    <th>HeadLine</th>
    <th>Text</th>
    <th>Media</th>
    <th>Media Credit</th>
    <th>Media Caption</th>
    <th>Media Thumbnail</th>
    <th>Type</th>
    <th>Tags</th>
    <th>ID</th>
    <th>Acciones</th>
</tr>
<?php 
    foreach ($rows as $row) {
        $editHref = '/timeline/edit/' . $row['id'];
        $deleteHref = '/timeline/delete/' . $row['id'];
?>
<tr>
    <td><?php echo($row['startdate']) ?></td>
    <td><?php echo($row['enddate']) ?></td>
    <td><?php echo($row['headline']) ?></td>
    <td><?php echo($row['text']) ?></td>
    <td><?php echo($row['media']) ?></td>
    <td><?php echo($row['mediacredit']) ?></td>
    <td><?php echo($row['mediacaption']) ?></td>
    <td><?php echo($row['mediathumbnail']) ?></td>
    <td><?php echo($row['type']) ?></td>
    <td><?php echo($row['tag']) ?></td>
    <td><?php echo($row['id']) ?></td>
    <td><a href="<?php echo($editHref) ?>" title="Edit">Edit</a></td>
    <td><a href="<?php echo($deleteHref) ?>" title="Delete">Delete</a></td>
</tr>
<?php 
    }
?>
</table>
