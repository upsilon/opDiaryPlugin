<?php
use_helper('opDiary');

$data = array('comments'=>array());

if (count($comments))
{
  foreach ($comments as $comment)
  {
    $data['comments'][] = op_api_diary_comment($comment);
  }
}

return array(
  'status' => 'success',
  'data' => $data,
);
