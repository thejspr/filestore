<?
$odd = true;
foreach ($entries as $entry) {
    $class = "log-entry";
    $class .= $odd ? " odd" : "";
    $username = Yii::app()->user->id == $entry->user_id ? "" : User::model()->findByPk($entry->user_id)->username;
    
    if ($entry->isFolder == 0) {
        $item_name = File::model()->findByPk($entry->item_id)->file_name;
        $controller = "file";
    } else {
        $item_name = Folder::model()->findByPk($entry->item_id)->folder_name;
        $controller = "folder";
    }
        
    echo "<div class='$class'>";
    echo CHtml::link($username, array('user/view','id'=>$entry->user_id));
    echo " ".$entry->message." ";
    echo CHtml::link(substr($item_name,0,min(strlen($item_name), 15)), array($controller.'/view','id'=>$entry->item_id));
    echo "</div>";
    $odd = !$odd;
}    
?>