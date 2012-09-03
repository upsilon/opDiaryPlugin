<?php
$options = array(
  'button' => __('Save'),
  'isMultipart' => true,
);

if (true)
{
  $title = __('Post a diary');
}
else
{
  $title = __('Edit the diary');
}
?>
<script type="text/javascript" src="/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="/js/op_emoji.js"></script>
<script type="text/javascript">
//<![CDATA[
$(function(){ $("#diary_body").opEmoji(); });
//]]>
function op_get_relative_uri_root(){ return "<?php echo $relativeUrlRoot;?>";}
</script>
<div class="row">
  <div class="gadget_header span12"><?php echo __($title) ?></div>
</div>

<div class="row">
  <div class="span12">
    <label class="control-label span12"><?php echo __('Title') ?></label>
    <input type="text" name="title" id="title" class="span12">
    <label class="control-label span12"><?php echo __('Body') ?></label>
<a id="diary_body_button_op_emoji_docomo" href="#" onclick="$('#diary_body').opEmoji('togglePallet', 'epDocomo'); return false;">
<img alt="" src="/images/deco_op_emoji_docomo.gif" /></a>
    <input type="textarea" name="body" id="diary_body" class="span12">
    <label class="control-label span12"><?php echo __('Public flag') ?></label>
    <ul class="radio_list">
      <li><input name="public_flag" value="4" id="diary_public_flag_4" class="input_radio" type="radio">&nbsp;<label for="diary_public_flag_4"><?php echo __('Public to web'); ?></label></li>
      <li><input name="public_flag" value="1" id="diary_public_flag_1" checked="checked" class="input_radio" type="radio">&nbsp;<label for="diary_public_flag_1"><?php echo __('Public to sns'); ?></label></li>
      <li><input name="public_flag" value="2" id="diary_public_flag_2" class="input_radio" type="radio">&nbsp;<label for="diary_public_flag_2"><?php echo __('Public to friends'); ?></label></li>
      <li><input name="public_flag" value="3" id="diary_public_flag_3" class="input_radio" type="radio">&nbsp;<label for="diary_public_flag_3"><?php echo __('Public to none'); ?></label></li>
    </ul>
    <input type="submit" name="submit" value="<?php echo __('Send') ?>" class="btn btn-primary span12" />
  </div>
</div>
