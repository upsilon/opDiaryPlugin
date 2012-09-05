<?php
use_helper('opAsset');
op_smt_use_stylesheet('/opDiaryPlugin/css/smt-diary.css', 'last');

if (isset($id))
{
  $gadgetTitle = __('Diaries of %1%', array('%1%'=>$member->getName()));
}
else
{
  $gadgetTitle = __('Recently Posted Diaries');
  $id = 'null';
}
?>

<script id="diaryEntry" type="text/x-jquery-tmpl">
<div class="row entry">
  <div class="span3">
<a href="${member.profile_url}"><img src="${member.profile_image}" class="rad10" width="57" height="57"></a>
  </div>
  <div class="span9">
    <div>
      <span class="title">${title}</span>
      {{html body}}
      <a href="/diary/${id}" class="readmore">続き</a>
    </div>
    <div class="clearfix"></div>
    <div class="row">
      <p class="span3"><a href="${member.profile_url}">{{if member.screen_name}} ${member.screen_name} {{else}} ${member.name} {{/if}}</a></p>
      <p class="span6">${created_at}</p>
    </div>
  </div>
</div>
</script>
<script type="text/javascript">
function getList(params)
{
  var id = <?php echo $id ?>;
  if (id != null)
  {
    params.id = id;
  }
  console.debug(params);
  $('#loading').show();
  $.getJSON( openpne.apiBase + 'diary/list.json',
    params,
    function(json)
    {
      var entry = $('#diaryEntry').tmpl(json.data);
      $('#list').append(entry);
      if (json.next != false)
      {
        $('#loadmore').attr('x-page', json.next).show();
      }
      else
      {
        $('#loadmore').hide();
      }
      $('#loading').hide();
    }
  );
}

$(function(){
  getList({apiKey: openpne.apiKey});

  $('#loadmore').click(function(){
    var params = {
      apiKey: openpne.apiKey,
      page: $(this).attr('x-page')
    };
    getList(params);
  })
})
</script>
<div class="row">
  <h3 class="gadget_header span12"><?php echo $gadgetTitle; ?></h3>
</div>
<div id="list"></div>
<div class="row">
  <div id="loading" class="center">
    <?php echo op_image_tag('ajax-loader.gif');?>
  </div>
</div>
<div class="row">
  <button class="span12 btn small hide" id="loadmore">もっと読む</button>
</div>

