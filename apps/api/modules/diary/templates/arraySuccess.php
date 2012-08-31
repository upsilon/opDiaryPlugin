<?php
use_helper('opDiary');

$data = array();

foreach ($diaries as $diary)
{
  $data[] = op_api_diary($diary);
}

return array(
  'status' => 'success',
  'data' => $data,
);
