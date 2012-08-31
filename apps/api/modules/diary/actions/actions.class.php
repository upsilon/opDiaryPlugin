<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * diary actions.
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
    $this->member = sfContext::getInstance()->getUser()->getMember();
  }

  public function executeList(sfWebRequest $request)
  {
    $this->isSearchEnable =  Doctrine::getTable('SnsConfig')->get('op_diary_plugin_search_enable', '1');

    $query = Doctrine::getTable('Diary')->createQuery('c')
      ->where('member_id = ?', $this->member->getId())
      ->limit(sfConfig::get('op_json_api_limit', 15));
    //var_dump($query->getSqlQuery());die();

    $this->diaries = $query->execute();
    $this->setTemplate('array');
  }

}
