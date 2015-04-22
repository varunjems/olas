<?php

class myUser extends sfBasicSecurityUser
{
  public function regenerateSession()
  {
    $this->storage->regenerate(true);
  }
}
