<?php
use_helper('opAsset');
op_smt_use_stylesheet('/opDiaryPlugin/css/smt-diary.css', 'last');
?>
<script id="diaryEntry" type="text/x-jquery-tmpl">
  <div class="row">
    <h3 class="gadget_header span12">${$item.formatTitle()}</h3>
  </div>
  <div class="row">
    <h3 class="span9">${title}</h3>
    <div class="btn-group span3">
      <a href="/diary/edit/${id}" class="btn"><i class="icon-pencil"></i></a>
      <a href="" class="btn"><i class="icon-remove"></i></a>
    </div>
  </div>
  <div class="row body">
    <div class="span12">{{html body}}</div>
  </div>
  <div class="row images">
    {{each images}}
      <div class="span4"><a href="${$value.filename}" target="_blank">{{html $value.imagetag}}</a></div>
    {{/each}}
  </div>
  {{tmpl "#diarySiblings"}}
  <div class="row" id="comments">
  {{if comments}}
    {{tmpl(comments) "#diaryComment"}}
  {{/if}}
  </div>
  <div class="row" id="commentForm">
    <div class="span1">
    &nbsp;
    </div>
    <textarea id="comment_body"></textarea>
    <input type="submit" class="btn" id="postComment" value="投稿">
  </div>
  {{tmpl "#diarySiblings"}}
</script>

<script id="diaryComment" type="text/x-jquery-tmpl">
  <div class="row">
    <div class="span1">
      &nbsp;
    </div>
    <div class="span3">
      <a href="${member.profile_url}"><img src="${member.profile_image}" class="rad10" width="57" height="57"></a>
    </div>
    <div class="span8">
      <div>
        <a href="${member.profile_url}">{{if member.screen_name}} ${member.screen_name} {{else}} ${member.name} {{/if}}</a>
        {{html body}}
      </div>
      <div class="row">
        <span>${ago}</span>
        {{if deletable}}
        <a href="#" class="deleteComment"><i class="icon-remove"></i></a>
        {{/if}}
      </div>
    </div>
  </div>
</script>

<script id="diarySiblings" type="text/x-jquery-tmpl">
  <div class="row siblings">
    <div class="span12 center">
      {{if next}}
      <a href="/diary/${next.id}" class="btn span5">新しい日記</a>
      {{else}}
      <div class="disabled btn span5">新しい日記</div>
      {{/if}}
      {{if prev}}
      <a href="/diary/${prev.id}" class="btn span5">古い日記</a>
      {{else}}
      <div class="disabled btn span5">古い日記</div>
      {{/if}}
    </div>
  </div>
</script>

<script type="text/javascript">
var diary_id = <?php echo $id ?>;
function getEntry(params)
{
  params.id = diary_id;
  $('#loading').show();
  $.getJSON( openpne.apiBase + 'diary/show.json',
    params,
    function(json)
    {
      var entry = $('#diaryEntry').tmpl(json.data, {
        formatTitle: function(){
          var _date = new Date(this.data.created_at.replace(/-/g,'/'));
          return _date.getMonth() + '月' + _date.getDay() + '日の日記';
        }
      });
      $('#show').html(entry);
      $('#loading').hide();
    }
  );
}

function toggleSubmitState()
{
  $('input[name=submit]').toggle();
}

$(function(){
  getEntry({apiKey: openpne.apiKey});

  $(document).on('click', '#postComment',function(){
    toggleSubmitState();
    var params = {
      apiKey: openpne.apiKey,
      diary_id: diary_id,
      body: $('textarea#comment_body').val()
    };

    $.post(openpne.apiBase + "diary_comment/post.json",
      params,
      'json'
    )
    .success(
      function(res){
        $('#comments').append($('#diaryComment').tmpl(res.data));
        $('textarea#comment_body').val('');
      }
    )
    .error(
      function(res){
        console.log(res);
      }
    )
    .complete(
      function(res){
        toggleSubmitState();
      }
    );
  })
})
</script>
<div class="row">
  <div id="show"></div>
</div>
<div class="row">
  <div id="loading" class="center">
    <?php echo op_image_tag('ajax-loader.gif');?>
  </div>
</div>

