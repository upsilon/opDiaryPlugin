<?php
$options = array(
  'button' => __('Save'),
  'isMultipart' => true,
);

if (true)
{
  $title = __('Post a diary');
  $checked = 1;
}
else
{
  $title = __('Edit the diary');
}
?>
<script type="text/javascript" src="/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="/js/op_emoji.js"></script>
<script type="text/javascript" src="/js/Selection.js"></script>
<script type="text/javascript" src="/js/decoration.js"></script>
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
    <textarea name="body" id="diary_body" class="span12"></textarea>
    <label class="control-label span12"><?php echo __('Public flag') ?></label>
    <ul class="radio_list">
    <?php foreach($publicFlags as $key=>$value):?>
      <li><input name="public_flag" value="<?php echo $key;?>" id="diary_public_flag_<?php echo $key;?>" class="input_radio" type="radio" <?php if($checked == $key) echo 'checked'?>>&nbsp;<label for="diary_public_flag_<?php echo $key;?>"><?php echo $value;?></label></li>
    <?php endforeach; ?>
    </ul>
    <input type="submit" name="submit" value="<?php echo __('Send') ?>" class="btn btn-primary span12" />
  </div>
</div>
