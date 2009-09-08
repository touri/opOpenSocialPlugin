<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * PluginMemberApplication
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    opOpenSocialPlugin
 * @subpackage model
 * @author     Shogo Kawahara <kawahara@tejimaya.net>
 */
abstract class PluginMemberApplication extends BaseMemberApplication
{
  protected
    $applicationSettings = null,
    $userSettings = null;

  protected function getSettings($type)
  {
    $result = array();
    $settings = Doctrine::getTable('MemberApplicationSetting')
      ->createQuery()
      ->where('type = ?', $type)
      ->andWhere('member_application_id = ?', $this->getId())
      ->execute();
    foreach ($settings as $setting)
    {
      $result[$setting->getName()] = $setting->getValue();
    }
    return $result;
  }

  protected function setSetting($type, $name, $value)
  {
    $object = Doctrine::getTable('MemberApplicationSetting')
      ->createQuery()
      ->where('type = ?', $type)
      ->andWhere('member_application_id = ?', $this->getId())
      ->andWhere('name = ?', $name)
      ->fetchOne();
    if (!$object)
    {
      $object = new MemberApplicationSetting();
      $object->setMemberApplication($this);
      $object->setType($type);
      $object->setName($name);
    }
    $object->setValue($value);
    $object->save();
  }

 /**
  * get application settings
  *
  * @return array
  */
  public function getApplicationSettings()
  {
    if (is_null($this->applicationSettings))
    {
      $this->applicationSettings = $this->getSettings('application');
    }

    return $this->applicationSettings;
  }
 
 /**
  * get application setting
  *
  * @param string $name
  * @param string $default 
  * @return string
  */
  public function getApplicationSetting($name, $default = null)
  {
    $settings = $this->getApplicationSettings();
    if (isset($settings[$name]))
    {
      return $settings[$name];
    }

    return $default;
  }

 /**
  * set application setting
  *
  * @param string $name
  * @param string $value
  */
  public function setApplicationSetting($name, $value)
  {
    $this->getApplicationSettings();
    $this->setSetting('application', $name, $value);
    $this->applicationSettings[$name] = $value;
  }

 /**
  * get user settings
  *
  * @return array
  */
  public function getUserSettings()
  {
    if (is_null($this->userSettings))
    {
      $this->userSettings = $this->getSettings('user');
    }

    return $this->userSettings;
  }

 /**
  * get user setting
  *
  * @param string $name
  * @param string $default 
  * @return string
  */
  public function getUserSetting($name, $default = null)
  {
    $settings = $this->getUserSettings();
    if (isset($settings[$name]))
    {
      return $settings[$name];
    }

    return $default;
  }

 /**
  * set user setting
  *
  * @param string $name
  * @param string $value
  */
  public function setUserSetting($name, $value)
  {
    $this->getUserSettings();
    $this->setSetting('user', $name, $value);
    $this->userSettings[$name] = $value;
  }

 /**
  * is viewable
  *
  * @param integer $memberId
  * @return boolean
  */
  public function isViewable($memberId = null)
  {
    if (is_null($memberId))
    {
      $memberId = sfContext::getInstance()->getUser()->getMemberId();
    }

    if ($this->getMemberId() == $memberId || $this->getPublicFlag() == 'public')
    {
      return true;
    }

    if ($this->getPublicFlag() == 'friends')
    {
      $relation = Doctrine::getTable('MemberRelationship')->retrieveByFromAndTo($this->getMemberId(), $memberId);
      return (boolean)($relation && $relation->isFriend());
    }

    return false;
  }
}
