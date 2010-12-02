<? if(count($users) > 0) { ?>
<tr id = "new-<?= $unique_id ?>">
    <td class="username">
        User:
        <select id="shareduser-<?= $unique_id ?>">
            <?
                foreach ($users as $user) {
                    echo "<option value='$user->id'>$user->username</option>";
                }
            ?>
        </select>
    </td>
    <td class="action">
        <button type="Submit" onclick="javascript:saveShare(<?= $unique_id ?>)">Save</button>
        <button type="Submit" onclick="javascript:cancelShare('<?= $unique_id ?>')">Cancel</button>
    </td>
</tr>
<? } else { ?>
<script>alert("This file is already shared with all users in the system")</script>
<? } ?>