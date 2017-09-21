<?php

namespace CataBundle\Entity;

/**
 * Modos
 */
class Modo
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $descripcion;
	
	public function __toString() {
        return $this->descripcion;
    }
    

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return Modos
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }
}

