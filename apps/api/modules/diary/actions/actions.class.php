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
    $this->member = sfContext::getInstance()->getUser()->getMember();
  }

  public function executePost(sfWebRequest $request)
  {
    $form = new SmtDiaryForm();
    $form->bind(
      $request->getParameter($form->getName())
    );

    if ($form->isValid())
    {
      $this->diary = $form->save();
      $this->setTemplate('array');
    }
    else
    {
      $error_messages = array_map(
          create_function('$e', 'return $e->getMessage();'),
          $form->getErrorSchema()->getErrors());
      var_dump($error_messages);
      $this->forward400($error_messages);
    }
  }

  public function executeList(sfWebRequest $request)
  {
    $query = Doctrine::getTable('Diary')->createQuery('c')
      ->where('member_id = ?', $this->member->getId())
      ->limit(sfConfig::get('op_json_api_limit', 15));

    $this->diaries = $query->execute();
    $this->setTemplate('array');
  }

}
