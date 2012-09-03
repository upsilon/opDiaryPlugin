<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

function op_diary_link_to_show($diary, $withName = true, $withIcon = true)
{
  $html = '';

  $html .= link_to(op_diary_get_title_and_count($diary), op_diary_url_for_show($diary));

  if ($withName)
  {
    $html .= ' ('.$diary->getMember()->getName().')';
  }

  if ($withIcon)
  {
    $html .= op_diary_image_icon($diary);
  }

  return $html;

}

function op_diary_get_title_and_count($diary, $space = true, $width = 36)
{
  return sprintf('%s%s(%d)',
           op_truncate($diary->getTitle(), $width),
           $space ? ' ' : '',
           $diary->countDiaryComments());
}

function op_diary_image_icon($diary)
{
  $html = '';
  if ($diary->has_images)
  {
    $html = ' '.image_tag('icon_camera.gif', array('alt' => 'photo'));
  }

  return $html;
}

function op_diary_url_for_show($diary)
{
  $internalUri = '@diary_show?id='.$diary->getId();

  if ($count = $diary->countDiaryComments())
  {
    $internalUri .= '&comment_count='.$count;
  }

  return $internalUri;
}

function op_api_diary($diary)
{
  if($diary)
  {
    return array(
      'id'          => $diary->getId(),
      'member'      => op_api_member($diary->getMember()),
      'title'       => $diary->getTitle(),
      'body'        => $diary->getBody(),
      'public_flag' => $diary->getPublicFlag(),
      'updated_at'  => $diary->getUpdatedAt(),
      'created_at'  => $diary->getCreatedAt(),
    );
  }
}

function op_api_diary_image($image)
{
  if($image)
  {
    return array(
      'filename' => $image->getFile()->getName()
    );
  }
}

function op_api_diary_comment($comment)
{
  if($comment)
  {
    return array(
      'member' => op_api_member($comment->getMember()),
      'body'=> $comment->getBody(),
      'created_at' => $comment->getCreatedAt()
    );
  }
}
