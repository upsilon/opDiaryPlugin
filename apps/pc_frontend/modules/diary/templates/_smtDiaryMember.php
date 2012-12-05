<?php use_helper('Javascript', 'opUtil', 'opAsset') ?>
<script id="diaryEntry" type="text/x-jquery-tmpl">
<div class="row">
  <div class="span3">${ago}</div>
  <div class="span9"><a href="<?php echo public_path('diary') ?>/${id}">${title}</a>
    <!-- Like Plugin -->
    <span class="like-wrapper" style="display: none;">
      <a href="<?php echo public_path('diary') ?>/${id}">
        <i class="icon-thumbs-up"></i>
        <span class="like-list" data-like-id="${id}" data-like-target="D" no-href-clear="ture">いいね！</span>
      </a>
    </span>
  </div>
</div>
</script>

<script type="text/javascript">
$(function(){
  var params = {
    apiKey: openpne.apiKey,
    format: 'mini',
    id: <?php echo $member->getId() ?>,
    limit: 4
  }

  $.getJSON(openpne.apiBase + 'diary/search.json',
    params,
    function(res)
    {
      if (res.data.length > 0)
      {
        var entry = $('#diaryEntry').tmpl(res.data);
        $('#diary').append(entry);
        $('#readmore').show();
      }
    }
  )
})
</script>

<hr class="toumei" />
<div class="row">
  <div class="gadget_header span12">日記一覧</div>
</div>
<hr class="toumei" />
<div id="diary" style="margin-left: 0px;">
</div>

<div class="row hide" id="readmore">
<a href="<?php echo public_path('diary/listMember').'/'.$member->getId() ?>" class="btn btn-block span11"><?php echo __('More')?></a>
</div>
