<?php use_helper('opDiary'); ?>

<?php $title = __('Diary Comment History') ?>
<?php if ($pager->getNbResults()): ?>
<div class="dparts recentList"><div class="parts">
<div class="partsHeading"><h3><?php echo $title ?></h3></div>
<?php echo op_include_pager_navigation($pager, 'diaryComment/history?page=%d'); ?>
<?php foreach ($pager->getResults() as $diaryCommentUpdate): ?>
<?php $diary = $diaryCommentUpdate->getDiary() ?>
<dl>
<dt><?php echo op_format_date($diaryCommentUpdate->getLastCommentTime(), 'XDateTimeJa') ?></dt>
<dd><?php echo link_to(op_diary_get_title_and_count($diary), 'diary_show', $diary) ?> (<?php echo $diary->getMember()->getName() ?>)</dd>
</dl>
<?php endforeach; ?>
<?php echo op_include_pager_navigation($pager, 'diaryComment/history?page=%d'); ?>
</div></div>
<?php else: ?>
<?php op_include_box('diaryList', __('There are no diaries.'), array('title' => $title)) ?>
<?php endif; ?>