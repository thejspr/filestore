<?php

class StartupBehavior extends CBehavior
{
    public function attach($owner)
    {
            // set the event callback
            $owner->attachEventHandler('onBeginRequest', array($this, 'beginRequest'));
    }

    /**
     * This method is attached to the 'onBeginRequest' event above.
     **/
    public function beginRequest(CEvent $event)
    {
        if (Yii::app()->params['fb']) {
            $arr = $this->get_facebook_cookie(Yii::app()->params['fb_appid'], Yii::app()->params['fb_sec']);
            
            Yii::app()->setParams($arr);
        }
    }
    
    private function get_facebook_cookie($app_id, $application_secret) 
    {
        $args = array();
        $cookie = isset($_COOKIE['fbs_' . $app_id]);
        if ($cookie != null) {
            parse_str(trim($_COOKIE['fbs_' . $app_id], '\\"'), $args);
            ksort($args);
            $payload = '';
            foreach ($args as $key => $value) {
                if ($key != 'sig') {
                    $payload .= $key . '=' . $value;
                }
            }
            if (md5($payload . $application_secret) != $args['sig']) {
                      return null;
            }
        }
    
        return $args;
    }
}