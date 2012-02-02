<?php
namespace Model\Service;

use \Model\Entity\AccountVerification;

class AccountService extends \Model\Service
{
	public function createCode($userId)
	{
		return md5($userId . '-' . time() . rand() );
	}
	
	public function saveCode($userId, $code)
	{
		$em = self::getEntityManager();
		
		$av = new AccountVerification();
		$av->setHash($code);
		$av->setUser($em->getReference('\Model\Entity\User', $userId) );
		
		$em->persist($av);
		$em->flush();
	}
	
	/**
	 * 
	 * @param mixed $userId
	 * 
	 * @return string account verification code
	 */
	public function getCodeFor($userId)
	{
		$em = self::getEntityManager();
		
		$av = $em->getRepository('\Model\Entity\AccountVerification')->findBy(array('user' => $userId) );
		
		return count($av) == 1 ? $av[0]->getHash() : null;
	}
		
	public function sendAccountVerificationEmail($userId)
	{
		$code = $this->getCodeFor($userId);
		
		$config = \Zend_Registry::get('config');
		
		$user = self::getEntityManager()->getRepository('Model\Entity\User')->find($userId);
		
		$url = $config->app->hostname . '/user/account/activate/' . $user->getUsername() . '/' . $code;
		
		$message = $this->_createAccountVerificationMessage($user, $code, $url);
		die($message);
		$mail = new \Zend_Mail();
		$mail->addTo($user->getEmail(), $user->getFirstname() . ' ' . $user->getLastname() );
		$mail->setFrom($config->app->mail->account_verification->from-address, $config->app->mail->account_verification->from_name);
		$mail->setSubject();
		$mail->setBodyText($message);
		$mail->send(new \Zend_Mail_Transport_Smtp() );
	}
	
	/**
	 * @param \Model\Entity\User $user
	 * 
	 * @return string
	 */
	protected function _createAccountVerificationMessage(\Model\Entity\User $user, $code, $url)
	{
		$config = \Zend_Registry::get('config');
		
		$template = file_get_contents($config->app->mail->account_verification->mail_template);
		
		if(!$template)
		{
			throw new Exception('Account verification template was not found. User id:' . $user->getId() );
		}
		
		$search = array(
			'[firstname]',
			'[lastname]',
			'[url]',
		);
		
		$replace = array(
			$user->getFirstname(),
			$user->getLastname(),
			$url,
		);
		
		return str_replace($search, $replace, $template);
	}
	
	/**
	 * Activates user.
	 * @param string $username
	 * @param string $hash
	 * 
	 * @return boolean true if activated, false if activation could not be done
	 */
	public function activateAccount($username, $hash)
	{
		$em = $this->getEntityManager();
		
		$user = $em->getRepository('\Model\Entity\User')->findOneBy(array('username' => $username) );
		
		if(!$user)
		{
			return false;
		}
		
		$av = $em->getRepository('\Model\Entity\AccountVerification')->findOneBy(array('user' => $user->getId(), 'hash' => $hash, 'verified' => null) );
		
		if(!$av)
		{
			return false;
		}
		
		$av->setVerified(true);
		$av->setVerificationDate(new \DateTime("now") );
		$em->persist($av);
		$em->flush($av);
		
		return true;
	}
}