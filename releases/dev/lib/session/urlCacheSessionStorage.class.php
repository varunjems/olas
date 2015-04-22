<?php

/**
 * urlCacheSessionStorage manages session storage via a signed cookie and cache backend.
 *
 * This class stores the session data in via sfCache instance and with an id issued in a
 * signed cookie. Useful when you don't want to store the session.
 *
 * The difference between this and sfCacheSessionStorage is that this will
 * allow the session id to be added as a URL parameter
 *
 * @package    symfony
 * @subpackage storage
 * @author     David Ward <dward@wevad.com>
 */
class urlCacheSessionStorage extends sfCacheSessionStorage
{
  /**
   * Initialize this Storage.
   *
   * @param array $options  An associative array of initialization parameters.
   *                        session_name [required] name of session to use
   *                        session_cookie_path [required] cookie path
   *                        session_cookie_domain [required] cookie domain
   *                        session_cookie_lifetime [required] liftime of cookie
   *                        session_cookie_secure [required] send only if secure connection
   *                        session_cookie_http_only [required] accessible only via http protocol
   *
   * @return bool true, when initialization completes successfully.
   *
   * @throws <b>sfInitializationException</b> If an error occurs while initializing this Storage.
   */
  public function initialize($options = array())
  {
    // initialize parent
    parent::initialize(array_merge(array('session_name' => 'sfproject',
                                         'session_cookie_lifetime' => '+30 days',
                                         'session_cookie_path' => '/',
                                         'session_cookie_domain' => null,
                                         'session_cookie_secure' => false,
                                         'session_cookie_http_only' => true,
                                         'session_cookie_secret' => 'sf$ecret'), $options));

    // create cache instance
    if (isset($this->options['cache']) && $this->options['cache']['class'])
    {
      $this->cache = new $this->options['cache']['class'](is_array($this->options['cache']['param']) ? $this->options['cache']['param'] : array());
    }
    else
    {
      throw new InvalidArgumentException('sfCacheSessionStorage requires cache option.');
    }

    $this->context     = sfContext::getInstance();

    $this->dispatcher  = $this->context->getEventDispatcher();
    $this->request     = $this->context->getRequest();
    $this->response    = $this->context->getResponse();

    if (!empty($this->options['session_url_parm']) && $this->request->getParameter($this->options['session_url_param']))
    {
      $cookie = $this->request->getParameter($this->options['session_url_param']);
    }
    else
    {
      $cookie = $this->request->getCookie($this->options['session_name']);
    }

    if(strpos($cookie, '-') !== false)
    {
      // split cookie data id:signature(id+secret)
      list($id, $signature) = explode('-', $cookie, 2);

      if($signature == sha1($id.'-'.$this->options['session_cookie_secret']))
      {
        // cookie is valid
        $this->id = $cookie;
      }
      else
      {
        // cookie signature broken
        $this->id = null;
      }
    }
    else
    {
      // cookie format wrong
      $this->id = null;
    }

    if(empty($this->id))
    {
       $ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : 'localhost';
       $ua = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : 'ua';

       // generate new id based on random # / ip / user agent / secret
       $this->id = md5(rand(0, 999999).$ip.$ua.$this->options['session_cookie_secret']);
       $this->id = $this->id.'-'.sha1($this->id.'-'.$this->options['session_cookie_secret']);

       if(sfConfig::get('sf_logging_enabled'))
       {
         $this->dispatcher->notify(new sfEvent($this, 'application.log', array('New session created')));
       }

       // only send cookie when id is issued
       $this->response->setCookie($this->options['session_name'],
                                  $this->id,
                                  $this->options['session_cookie_lifetime'],
                                  $this->options['session_cookie_path'],
                                  $this->options['session_cookie_domain'],
                                  $this->options['session_cookie_secure'],
                                  $this->options['session_cookie_http_only']);

       $this->data = array();
    }
    else
    {
      // load data from cache
      $this->data = $this->cache->get($this->id, array());

      if(sfConfig::get('sf_logging_enabled'))
      {
        $this->dispatcher->notify(new sfEvent($this, 'application.log', array('Restored previous session')));
      }
    }
    session_id($this->id);
    $this->response->addCacheControlHttpHeader('private');

    return true;
  }


  /**
   * Regenerates id that represents this storage.
   *
   * @param boolean $destroy Destroy session when regenerating?
   *
   * @return boolean True if session regenerated, false if error
   *
   * @throws <b>sfStorageException</b> If an error occurs while regenerating this storage
   */
  public function regenerate($destroy = false)
  {
    if($destroy)
    {
      $this->data = array();
      $this->cache->remove($this->id);
    }

    // generate session id
    $this->id = md5(rand(0, 999999).$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT'].$this->options['session_cookie_secret']);
    $this->id = $this->id.'-'.sha1($this->id.'-'.$this->options['session_cookie_secret']);

    // save data to cache
    $this->cache->set($this->id, $this->data);

    // update session id in signed cookie
    $this->response->setCookie($this->options['session_name'],
                               $this->id,
                               $this->options['session_cookie_lifetime'],
                               $this->options['session_cookie_path'],
                               $this->options['session_cookie_domain'],
                               $this->options['session_cookie_secure'],
                               $this->options['session_cookie_http_only']);
    session_id($this->id);
    return true;
  }


}
