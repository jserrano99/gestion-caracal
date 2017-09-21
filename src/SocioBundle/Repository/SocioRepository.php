<?php

namespace SocioBundle\Repository;


/**
 * Description of SocioRepository
 *
 * @author jose
 */
class SocioRepository extends \Doctrine\orm\EntityRepository {
	
	public function createAlphabeticalQueryBuilder() {
		return $this->createQueryBuilder('id');
	}
	
	public function siguienteSocio() {
		$em = $this->getEntityManager();
		$db = $em->getConnection();
		
		$query = "select max(nmsocio)+1 as nmsocio from socios";
		$stmt = $db->prepare($query);
		$params = [];
			
		$stmt->execute($params);
		$po = $stmt->fetch();
		if ($po["nmsocio"] == null) 
			return 1;
		else
		    return $po["nmsocio"];
	}
	
}
