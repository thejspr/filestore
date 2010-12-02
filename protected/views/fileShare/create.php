<tr id="row-<?=$model->id?>">
    <td class="username">
        <?= User::model()->findByPk($model->user_id)->username ?>
    </td>
    <td class="action">
        <a href="javascript:deleteShare(<?=$model->id?>)"><img src="images/icons/delete.png" alt="Delete Share" /></a>
    </td>
</tr>