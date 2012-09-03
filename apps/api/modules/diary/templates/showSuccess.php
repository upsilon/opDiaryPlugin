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
    $data['comments'][] = op_api_diary_comment($comment);
  }
  $data['next'] = op_api_diary($diary->getNext($diary->getMemberId()));
  $data['prev'] = op_api_diary($diary->getPrevious($diary->getMemberId()));
}

return array(
  'status' => 'success',
  'data' => $data,
);
