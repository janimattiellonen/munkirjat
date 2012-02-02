<?php
namespace Model\Entity;

use Model\Entity;

/**
 * @Entity(repositoryClass="Model\Repository\UserRepository")
 * @Table(name="user")
 */
class User extends Entity
{
	/**
	 * @Column(name="id", type="integer")
	 * @Id
	 * @GeneratedValue(strategy="AUTO")
	 */
	protected $id;
	
	/**
	 * @Column(name="username", type="string", length=30)
	 */
	protected $username;
	
	/**
	 * @Column(name="password", type="string", length=64)
	 */
	protected $password;
	
	/**
	 * @Column(name="salt", type="string", length=40)
	 */
	protected $salt;
	
	/**
	 * @Column(name="firstname", type="string", length=64)
	 */
	protected $firstname;
	
	/**
	 * @Column(name="lastname", type="string", length=64)
	 */	
	protected $lastname;
	
	/**
	 * @Column(name="email", type="string", length=128)
	 */	
	protected $email;
	
	
	/**
	 * @Column(name="enabled", type="integer", length=1)
	 */	
	protected $enabled;
	
	/**
	 * @Column(name="role", type="string", length=45)
	 */
	protected $role;

	public function setId($id)
	{
		$this->id = $id;
	}

	public function setUsername($pUsername)
	{
		$this->username = $pUsername;
	}

	public function setPassword($pPassword)
	{
		$this->password = $pPassword;
	}

	public function setSalt($pSalt)
	{
		$this->salt = $pSalt;
	}

	public function setFirstname($pFirstname)
	{
		$this->firstname = $pFirstname;
	}

	public function setLastname($pLastname)
	{
		$this->lastname = $pLastname;
	}

	public function setEmail($pEmail)
	{
		$this->email = $pEmail;
	}

	public function setEnabled($pEnabled)
	{
		$this->enabled = $pEnabled;
	}

	public function setRole($role)
	{
		$this->role = $role;
	}
		
	
	public function getId()
	{
		return $this->id;
	}
	
	public function getUsername()
	{
		return $this->username;
	}
	
	public function getPassword()
	{
		return $this->password;
	}
	
	public function getSalt()
	{
		return $this->salt;
	}
	
	public function getFirstname()
	{
		return $this->firstname;
	}
	
	public function getLastname()
	{
		return $this->lastname;
	}
	
	public function getFullname()
	{
	    return $this->firstname . ' ' . $this->lastname;
	}	
	
	public function getEmail()
	{
		return $this->email;
	}
	
	public function getEnabled()
	{
		return $this->enabled;
	}
	
	public function getRole()
	{
		return $this->role;
	}	
	
}