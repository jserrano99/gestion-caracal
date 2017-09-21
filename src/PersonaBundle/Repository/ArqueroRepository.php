<?php

namespace PersonaBundle\Repository;


/**
 * Description of CompeticionRepository
 *
 * @author jose
 */
class ArqueroRepository extends \Doctrine\orm\EntityRepository {
	
	public function createAlphabeticalQueryBuilder() {
		return $this->createQueryBuilder('id');
	}
	
	
}
