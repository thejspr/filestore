<script>
    $(document).ready(function(){
        alternateRowColor('#shares');
    });

    var getUniqueId = (function() {var id=0;return function() {if (arguments[0]==0) {id=1;return 0;} else return id++;}})();

    function addShare() {
        $.ajax({
            url: 'index.php?r=fileShare/GetForm&id=<?= $model->id?>&unique_id='+getUniqueId(),
            success: function(data) {
                $('#shares tbody').prepend(data);
                alternateRowColor('#shares');
            }
        });
    }

    function saveShare(unique_id) {
        var user_id = $('#shareduser-'+unique_id).val();
        $.ajax({
            url: 'index.php?r=FileShare/Create&file_id=<?= $model->id?>&user_id='+user_id,
            success: function(data) {
                $('#shares tbody').prepend(data);
                $('#new-'+unique_id).remove();
                alternateRowColor('#shares');
            }
        });
    }

    function cancelShare(unique_id) {
        $('#new-'+unique_id).hide('slow', function(){
            $('#new-'+unique_id).remove();
            alternateRowColor('#shares');
        });
        
    }

    function deleteShare(id) {
        $.ajax({
            url: 'index.php?r=fileShare/delete&id='+id,
            success: function() {
                $('#row-'+id).hide('slow', function(){ $('#row-'+id).remove(); });
                alternateRowColor('#shares');
            }
        });
    }
</script>
<h1>Edit file shares</h1>
<?php
$this->menu=array(
    array('label'=>'Back', 'url'=>array('view', 'id'=>$model->id)),
    array('label'=>'Edit File', 'url'=>array('update', 'id'=>$model->id)),
    array('label'=>'Delete File', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this file?')),
); ?>
<h3><?= $model->file_name; ?></h3>
    <div class="add-share">
        <a href="javascript:addShare()">
         Add share <img src="images/icons/add.png" alt="Add Share" />
        </a>
    </div>
<table id="shares">
    <thead>
        <tr>
            <th class="username">User</th>
            <th class="action">Delete Share</th>
        </tr>
    </thead>
    <tbody>
        <? foreach ($shares as $share) { ?>
        <tr id="row-<?=$share->id?>">
            <td class="username">
                <?= User::model()->findByPk($share->user_id)->username ?>
            </td>
            <td class="action">
                <a href="javascript:deleteShare(<?=$share->id?>)"><img src="images/icons/delete.png" alt="Delete Share" /></a>
            </td>
        </tr>
        <? } ?>
    </tbody>
</table>