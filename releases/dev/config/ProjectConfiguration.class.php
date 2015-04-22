<?php

require_once dirname(__FILE__).'/../lib/vendor/symfony-1.4/lib/autoload/sfCoreAutoload.class.php';
sfCoreAutoload::register();
require_once dirname(__FILE__).'/../vendor/autoload.php';

class ProjectConfiguration extends sfProjectConfiguration
{
  public function setup()
  {
    $this->enablePlugins(array(
	'sfDoctrinePlugin',
	'sfDoctrineGuardPlugin',
	'csSettingsPlugin',
    ));
  }

  public function configureDoctrine(Doctrine_Manager $manager)
  {
    if (extension_loaded('apc')) {
      $cacheDriver = new Doctrine_Cache_Apc();
    } else {
      // Basically a dummy driver so we can be sure useResultCache won't break
      // when in the code due to no cache driver available
      $cacheDriver = new Doctrine_Cache_Array();
    }

    $manager->setAttribute(Doctrine_Core::ATTR_QUERY_CACHE, $cacheDriver);
    $manager->setAttribute(Doctrine_Core::ATTR_RESULT_CACHE, $cacheDriver);
  }
}
