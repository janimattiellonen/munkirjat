<?php
namespace Model\Service;

class AuthService extends \Model\Service
{
	const APPLICATION_SALT = 'sfigwruygrwuy6E%sxtcyjh';
	
    public static function generateSalt()
    {
        // UUIDv4
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            // 32 bits for "time_low"
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),

            // 16 bits for "time_mid"
            mt_rand(0, 0xffff),

            // 16 bits for "time_hi_and_version",
            // four most significant bits holds version number 4
            mt_rand(0, 0x0fff) | 0x4000,

            // 16 bits, 8 bits for "clk_seq_hi_res",
            // 8 bits for "clk_seq_low",
            // two most significant bits holds zero and one for variant DCE1.1
            mt_rand(0, 0x3fff) | 0x8000,

            // 48 bits for "node"
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }
    
    public static function hash($salt, $value)
    {
        return hash('sha256', self::APPLICATION_SALT . $value . $salt);
    }  
      
    /**
     * 
     * @param string $username
     * @param string $password
     * 
     * @return boolean
     */
    public function authenticate($username, $password)
    {
		if(empty($username) || empty($password) )
		{
			return false;
		}

        $adapter = new \Jme\Auth\Adapter\Doctrine(
            self::$em,
            'Model\Entity\User',
            'username',
            'password',
            'salt',
            $username,
            $password,
            self::APPLICATION_SALT
        );
        
        $result = self::$auth->authenticate($adapter);		
		
		if($result->isValid() )
		{
        	$identity = $result->getIdentity();
			
        	$user = $identity['identity'];
        	
        	$data = array(
        	    'user_id' => $user->getId(),
        		'username' => $user->getUsername(),
                'full_name' => $user->getFullname(),
        	);
        	
	    	self::$auth->getStorage()->write($data); 
	    	
	    	return true;		    
		}
		
		return false;
    }
}