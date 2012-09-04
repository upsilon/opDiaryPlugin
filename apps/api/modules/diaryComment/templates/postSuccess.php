<?php
use_helper('opDiary');
$data = op_api_diary_comment($comment);

return array(
  'status' => 'success',
  'data' => $data,
);
