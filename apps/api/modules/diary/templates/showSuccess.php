<?php
use_helper('opDiary');
$data = array();

if (isset($diary))
{
  $data = op_api_diary($diary);
  $images = $diary->getDiaryImages();
  foreach($images as $image){
    $data['images'][] = op_api_diary_image($image);
  }
  $comments = $diary->getDiaryComments();
  foreach($comments as $comment){
    $_data = op_api_diary_comment($comment);
    $_data['deletable'] = $comment->isDeletable($memberId);
    $data['comments'][] = $_data;
  }
  $data['next'] = op_api_diary($diary->getNext($diary->getMemberId()));
  $data['prev'] = op_api_diary($diary->getPrevious($diary->getMemberId()));
}

return array(
  'status' => 'success',
  'data' => $data,
);
