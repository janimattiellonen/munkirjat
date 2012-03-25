<?php

class Bookshelf_Model_StatisticsModel extends \Munkirjat\Model
{
	/**
	 * 
	 * @return int
	 */
	public function getBookCount()
	{
		$qb = $this->getQueryBuilder();
		
		$qb->select('count(b.id) AS amount')
			->from('\Model\Entity\Book', 'b');
		

		$book = $qb->getQuery()->getSingleResult();

		return isset($book['amount']) ? $book['amount'] : 0;
	}	

	/**
	 * 
	 * @return int
	 */
	public function getUnreadBookCount()
	{
		$qb = $this->getQueryBuilder();
		
		$qb->select('count(b.id) AS unread_amount')
			->from('\Model\Entity\Book', 'b')
			->where('b.isRead IS NULL OR b.isRead = 0');
        
		$book = $qb->getQuery()->getSingleResult();

		return isset($book['unread_amount']) ? $book['unread_amount'] : 0;
	}	
	
	/**
	 * 
	 * @return int
	 */
	public function getUnratedBookCount()
	{
		$qb = $this->getQueryBuilder();
		
		$qb->select('count(b.id) AS unrated_amount')
			->from('\Model\Entity\Book', 'b')
			->where('b.rating = 0');

		$book = $qb->getQuery()->getSingleResult();

		return isset($book['unrated_amount']) ? $book['unrated_amount'] : 0;
	}		
		
	
	/**
	 * Returns how many pages have been read.
	 * 
	 * @return int
	 */
	public function getReadPageCount()
	{
		$qb = $this->getQueryBuilder();
		
		$qb->select('sum(b.pageCount) as page_count')
						->from('\Model\Entity\Book', 'b')
						->where('b.isRead = 1');
						
		$book = $qb->getQuery()->getSingleResult();

		return isset($book['page_count']) ? $book['page_count'] : 0;
	}
	
	/**
	 * Groups several book statistics.
	 * 
	 * @return array
	 */
	public function getBookStatistics()
	{
		$stats = array(
			'read_page_count' => $this->getReadPageCount(),
			'book_count' => $this->getBookCount(),
		    'unread_book_count' => $this->getUnreadBookCount(),
		    'unrated_book_count' => $this->getUnratedBookCount(),
		    'average_pace' => $this->getAverageBookReadPace(),
			'slowest_pace' => $this->getSlowestBookReadPace(),
			'fastest_pace' => $this->getFastestBookReadPace(),
		    'average_rating' => $this->getAverageRating(),
		);
		
		return $stats;
	}
	
	/**
	 * @param int $date (unix timestamp) 
	 * @param int $range
	 * 
	 * @return array
	 */
	public function getAddedBookCountBetween($date = null, $range = 10)
	{
        $now = time();
        
    	//echo date('Y-m-d', $date) . "\n";
    
    	if($range > 6)
    	{
    		$range = 6;
    	}
    	else if($range < 1)
    	{
    		$range = 1;
    	}
    
    	if(!isset($date) || $date > $now)
    	{		
    		$startDateStr = date('Y-m-d 00:00:00', strtotime('-' . ($range * 2) . ' months') );
    		$endDateStr = date('Y-m-d 23:59:59');
    	}
    	else
    	{
    		$startDateStr = date('Y-m-d 00:00:00', strtotime('-' . $range . ' months', $date) );
    		$endDateStr = date('Y-m-d 23:59:59', strtotime('+' . $range . ' months', $date) );
    	}
    	
    	//echo "start date: $startDateStr<br>end date: $endDateStr<br><br>";
		
		$conn = $this->getEntityManager()->getConnection();
		$stmt = $conn->prepare("SELECT
                  COUNT(*) AS amount,
                  MONTH(created_at) AS month,
                  YEAR(created_at) AS year,
                  UNIX_TIMESTAMP(created_at) * 1000 AS created_at
                FROM
                  book
                WHERE
                  created_at BETWEEN :start AND :end
                GROUP BY
                  MONTH(created_at), 
                  YEAR(created_at)
                ORDER BY
                	created_at");

		$stmt->bindValue('start', $startDateStr);
		$stmt->bindValue('end', $endDateStr);
		
		$stmt->execute();
		
		$rows = array();
		
		while($row = $stmt->fetch() )
		{
		    $rows[] = $row;
		}
		
		return $rows;
	}
	
	public function getAverageBookReadPace()
	{
		$conn = $this->getEntityManager()->getConnection();
		$stmt = $conn->prepare("
		SELECT 
          AVG(DATEDIFF(finished_Reading, started_reading)) AS pace
        FROM 
          book
        WHERE 
          is_read = 1
          AND started_reading IS NOT NULL
          AND finished_reading IS NOT NULL");
	    
		$stmt->execute();
		
		$row = $stmt->fetch();
		
		if(isset($row['pace']) )
		{
		    return $row['pace'];
		}
	}
	
	public function getFastestBookReadPace()
	{
		$conn = $this->getEntityManager()->getConnection();
		$stmt = $conn->prepare("
		SELECT 
          MIN(DATEDIFF(finished_Reading, started_reading)) AS pace
        FROM 
          book
        WHERE 
          is_read = 1
          AND started_reading IS NOT NULL
          AND finished_reading IS NOT NULL");
	    
		$stmt->execute();
		
		$row = $stmt->fetch();
		
		if(isset($row['pace']) )
		{
		    return $row['pace'];
		}
	}
	
	public function getSlowestBookReadPace()
	{
		$conn = $this->getEntityManager()->getConnection();
		$stmt = $conn->prepare("
		SELECT 
          MAX(DATEDIFF(finished_Reading, started_reading)) AS pace
        FROM 
          book
        WHERE 
          is_read = 1
          AND started_reading IS NOT NULL
          AND finished_reading IS NOT NULL");
	    
		$stmt->execute();
		
		$row = $stmt->fetch();
		
		if(isset($row['pace']) )
		{
		    return $row['pace'];
		}
	}
	
	public function getAverageRating()
	{
		$conn = $this->getEntityManager()->getConnection();
		$stmt = $conn->prepare("
		SELECT 
          AVG(rating) AS rating
        FROM 
          book
        WHERE 
          rating != 0 && rating IS NOT NULL");
	    
		$stmt->execute();
		
		$row = $stmt->fetch();
		
		if(isset($row['rating']) )
		{
		    return $row['rating'];
		}
	}
	
	public function getBookCountByLanguages()
	{
		$conn = $this->getEntityManager()->getConnection();
		$stmt = $conn->prepare("
		SELECT
          b.language_id,
          count(b.language_id) AS amount
        FROM
          book AS b
        GROUP BY 
          b.language_id
        ORDER BY 
          b.language_id");
	    
		$stmt->execute();
		
		$rows = array();
		
		while($row = $stmt->fetch() )
		{
		    $rows[] = $row;
		}
		
		return $rows;
	}
	
	public function getGenreDistribution()
	{
		$conn = $this->getEntityManager()->getConnection();
		$stmt = $conn->prepare("
		SELECT
          g.name,
          count(g.id) AS amount
        FROM 
          genre AS g
          JOIN book_genre AS bg ON g.id = bg.genre_id
          JOIN book AS b ON b.id = bg.book_id
        GROUP BY
          g.id");
	    
		$stmt->execute();
		
		$rows = array();
		
		while($row = $stmt->fetch() )
		{
		    $rows[] = $row;
		}
		
		return $rows;
	}
}