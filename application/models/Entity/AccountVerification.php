<?php
namespace Model\Entity;

use Model\Entity;

/**
 * @Entity
 * @Table(name="accountverification")
 */
class AccountVerification extends Entity
{
	/**
	 * @Column(name="id", type="integer")
	 * @Id
	 * @GeneratedValue(strategy="AUTO")
	 */
	protected $id;
	
	/**
	 * @Column(name="hash", type="string", length=40)
	 */	
	protected $hash;
	
	/**
	 * 
	 * @OneToOne(targetEntity="User")
	 * @JoinColumn(name="user_id", referencedColumnName="id")
	 */
	protected $user;
	
	/**
	 * @Column(name="verification_date", type="datetime")
	 */
	protected $verificationDate;
	
	/**
	 * @Column(name="verified", type="integer", length=1)
	 */
	protected $verified;
	
	public function setId($id)
	{
		$this->id = $id;
	}

	public function getId()
	{
		return $this->id;
	}	
	
	public function setHash($hash)
	{
		$this->hash = $hash;
	}
	
	public function getHash()
	{
		return $this->hash;
	}
	
	/**
	 * 
	 * @param \Model\Entity\User $user
	 */
	public function setUser($user)
	{
		$this->user = $user;
	}
		
	/**
	 * @return \Model\entity\User
	 */
	public function getUser()
	{
		return $this->user;
	}
	
	public function setVerificationDate(\DateTime $date)
	{
		$this->verificationDate = $date;
	}
	
	/**
	 * @return \DateTime
	 */
	public function getVerificationDate()
	{
		return $this->verificationDate;
	}
	
	public function setVerified($verified)
	{
		$this->verified = $verified;
	}
	
	public function isVerified()
	{
		return $this->verified;
	}
}