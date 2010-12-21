<?php
    $path = Yii::app()->params['filesPath'].$model->owner_id.'/'.$model->file_name;
    $file = Yii::app()->file->set($path, true);
    $file->send();
    
