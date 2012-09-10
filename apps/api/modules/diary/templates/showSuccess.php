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
  $data['next'] = $diary->getNext($diary->getMemberId())->getId();
  $data['prev'] = $diary->getPrevious($diary->getMemberId())->getId();
  $data['editable'] = $diary->isAuthor($memberId);
}

return array(
  'status' => 'success',
  'data' => $data,
);
