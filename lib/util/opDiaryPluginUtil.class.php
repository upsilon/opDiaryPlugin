<?php

class opDiaryPluginUtil
{
  public static function sendNotification(Member $fromMember, Member $toMember, Diary $diary)
  {
    $url = '/diary/'.$diary->id;
    
    sfApplicationConfiguration::getActive()->loadHelpers(array('I18N'));

    if ($toMember->id === $diary->member_id)
    {
      $message = format_number_choice('[1]1 diary has new comments|(1,Inf]%1% diaries have new comments', array('%1%'=>'1'), 1);
    }
    else
    {
      $message = __('Diary of %1% have new comments', array('%1%' => $diary->Member->name));
    }
    
    opNotificationCenter::notify($fromMember, $toMember, $message, array('category'=>'other', 'url'=>$url, 'icon_url'=>null));
  }
}
