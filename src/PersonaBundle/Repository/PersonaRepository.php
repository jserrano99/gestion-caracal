<?php

namespace PersonaBundle\Repository;


/**
 * Description of PersonaRepository
 *
 * @author jose
 */
class PersonaRepository extends \Doctrine\orm\EntityRepository {
	
	public function createAlphabeticalQueryBuilder() {
		return $this->createQueryBuilder('id');
	}
	
	
}
