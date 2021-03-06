<?php

namespace CorreoBundle\Repository;

/**
 * AdjuntoRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AdjuntoRepository extends \Doctrine\ORM\EntityRepository
{
    public function queryByCorreo($correo_id) {
        $em = $this->getEntityManager();
		$db = $em->getConnection();
        $query = " select * from adjuntos where correo_id = :correo_id";
        $stmt = $db->prepare($query);
		$params = [":correo_id" => $correo_id];
		$stmt->execute($params);
		$po = $stmt->fetchAll();
		return $po;
    }
}
