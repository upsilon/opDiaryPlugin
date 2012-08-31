<?php
class SmtDiaryForm extends PluginDiaryForm
{
  public function setup()
  {
    $_temp_conf = sfConfig::get('app_diary_is_upload_images', true);
    sfConfig::set('app_diary_is_upload_images', false);
    parent::setup();
    sfConfig::set('app_diary_is_upload_images', $_temp_conf);

    $this->widgetSchema['body'] = new opSmtWidgetFormRichTextarea();
  }


}
