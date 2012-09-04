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
<?php use_helper('opAsset');?>
<?php op_smt_use_javascript('jquery-ui.min.js', 'last'); ?>
<?php op_smt_use_javascript('op_emoji.js', 'last'); ?>
<?php op_smt_use_javascript('Selection.js', 'last'); ?>
<?php op_smt_use_javascript('decoration.js', 'last'); ?>
<script type="text/javascript">
function op_get_relative_uri_root()
{
  return "<?php echo $relativeUrlRoot;?>";
}

function getParams()
{
  var query = $('form').serializeArray(),
  json = {apiKey: openpne.apiKey};

  for (i in query)
  {
    json[query[i].name] = query[i].value
  }

  return json;
}

function toggleSubmitButton()
{
  $('#loading').toggle();
  $('input[name=submit]').toggle();
}

$(document).ready(function(){
  $("#diary_body").opEmoji();

  $("#post_diary").click(function(){
    $('#successMessage').html('');
    toggleSubmitButton();
    var params = getParams();

    $.post(openpne.apiBase + "diary/post.json",
      params,
      'json'
    )
    .success(
      function(res){
        $('#title').val('');
        $('#diary_body').val('');
        $('#success').show();
        var _mes = $('#successMessageTemplate').tmpl(res['data']);
        $('#successMessage').html(_mes);
      }
    )
    .error(
      function(res){
        console.log(res);
      }
    )
    .complete(
      function(res){
        toggleSubmitButton();
      }
    );
  });
})
</script>
<script id="successMessageTemplate" type="text/x-jquery-tmpl">
    投稿しました<br/>
    <a href="/diary/${id}">日記を見る</a>
</script>
<div class="row">
  <div class="gadget_header span12"><?php echo __($title) ?></div>
</div>

<div class="row">
  <div class="span12">
    <form>
    <label class="control-label span12"><?php echo __('Title') ?></label>
    <input type="text" name="title" id="title" class="span12">
    <label class="control-label span12"><?php echo __('Body') ?></label>
<a id="diary_body_button_op_emoji_docomo" href="#" onclick="$('#diary_body').opEmoji('togglePallet', 'epDocomo'); return false;">
<img alt="" src="/images/deco_op_emoji_docomo.gif" /></a>
    <textarea name="body" id="diary_body" class="span12" rows="10"></textarea>
    <label class="control-label span12"><?php echo __('Public flag') ?></label>
    <ul class="radio_list">
    <?php foreach($publicFlags as $key=>$value):?>
      <li><input name="public_flag" value="<?php echo $key;?>" id="diary_public_flag_<?php echo $key;?>" class="input_radio" type="radio" <?php if($checked == $key) echo 'checked'?>>&nbsp;<label for="diary_public_flag_<?php echo $key;?>"><?php echo $value;?></label></li>
    <?php endforeach; ?>
    </ul>
    </form>
    <div class="center">
      <input type="submit" name="submit" value="<?php echo __('Post') ?>" id="post_diary" class="btn btn-primary span12" />
    </div>
  </div>
  <div id="loading" class="center hide">
    <?php echo op_image_tag('ajax-loader.gif');?>
  </div>
  <div id="successMessage" class="center">
  </div>
</div>
