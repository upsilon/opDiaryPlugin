<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * diary api actions.
 *
 * @package    OpenPNE
 * @subpackage action
 * @author     Shunsuke Watanabe <watanabe@craftgear.net>
 */
class diaryActions extends opJsonApiActions
{
  public function preExecute()
  {
    parent::preExecute();
    //myUser.class.php内でApiキーのチェックが行われているので
    //preExecuteでユーザ情報を取得してチェックを走らせる
    $this->member = $this->getUser()->getMember();
  }

  public function executePost(sfWebRequest $request)
  {
    $this->forward400If('' === (string)$request['title'], 'title parameter is not specified.');
    $this->forward400If('' === (string)$request['body'], 'body parameter is not specified.');
    $this->forward400If(!isset($request['public_flag']) || '' === (string)$request['public_flag'], 'public flag is not specified');

    if(isset($request['id']))
    {
      $diary = Doctrine::getTable('Diary')->findOneById($request['id']);
    }
    else
    {
      $diary = new Diary();
    }
    $diary->setMemberId($this->member->getId());
    $diary->setTitle($request['title']);
    $diary->setBody($request['body']);
    $diary->setPublicFlag($request['public_flag']);
    $diary->save();

    $this->diary = $diary;

    //TODO アクティビティに日記の投稿を表示するようにする
  }

  public function executeDelete(sfWebRequest $request)
  {
    $this->forward400If(!isset($request['id']) || '' === (string)$request['id'], 'id is not specified');

    $diary = Doctrine::getTable('Diary')->findOneById($request['id']);
    $isDeleted = $diary->delete();

    if ($isDeleted)
    {
      $this->id = $request['id'];
      //TODO アクティビティから日記の投稿を削除する
    }
    else
    {
      $this->forward400('failed to delete the entry. id:'.$request['id']);
    }

  }

  public function executeList(sfWebRequest $request)
  {
    $query = Doctrine::getTable('Diary')->createQuery('c')
      ->where('member_id = ?', $this->member->getId())
      ->limit(sfConfig::get('op_json_api_limit', 15));

    $this->diaries = $query->execute();
  }

}
