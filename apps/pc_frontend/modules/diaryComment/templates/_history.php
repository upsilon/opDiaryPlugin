<?php use_helper('opDiary') ?>

<?php if (count($list)): ?>
<div id="homeRecentList_<?php echo $gadget->id ?>" class="dparts homeRecentList"><div class="parts">
<div class="partsHeading"><h3><?php echo __('Diary Comment History') ?></h3></div>
<div class="block">

<ul class="articleList">
<?php foreach ($list as $diaryCommentUpdate): ?>
<?php $diary = $diaryCommentUpdate->Diary ?>
<li><span class="date"><?php echo op_format_date($diaryCommentUpdate->last_comment_time, 'XShortDateJa') ?></span><?php echo op_diary_link_to_show($diary, true, false) ?>
<!-- Like Plugin -->
<?php echo link_to('<i class="icon-thumbs-up"></i><span class="like-list" data-like-id="' . $diary->getId() . '" data-like-target="D">いいね！</span>', op_diary_url_for_show($diary)) ?>
</li>
<?php endforeach; ?>
</ul>

<div class="moreInfo">
<ul class="moreInfo">
<li><?php echo link_to(__('More'), '@diary_comment_history') ?></li>
</ul>
</div>

</div>
</div></div>
<?php endif; ?>
