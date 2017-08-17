<?php

namespace ModelBundle\Entity;

/**
 * UsuariosConexiones
 */
class UsuariosConexiones
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \DateTime
     */
    private $fcconexion = 'CURRENT_TIMESTAMP';

    /**
     * @var string
     */
    private $ip;

    /**
     * @var string
     */
    private $dsconexion;

    /**
     * @var \ModelBundle\Entity\Usuarios
     */
    private $usuario;


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
     * Set fcconexion
     *
     * @param \DateTime $fcconexion
     *
     * @return UsuariosConexiones
     */
    public function setFcconexion($fcconexion)
    {
        $this->fcconexion = $fcconexion;

        return $this;
    }

    /**
     * Get fcconexion
     *
     * @return \DateTime
     */
    public function getFcconexion()
    {
        return $this->fcconexion;
    }

    /**
     * Set ip
     *
     * @param string $ip
     *
     * @return UsuariosConexiones
     */
    public function setIp($ip)
    {
        $this->ip = $ip;

        return $this;
    }

    /**
     * Get ip
     *
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * Set dsconexion
     *
     * @param string $dsconexion
     *
     * @return UsuariosConexiones
     */
    public function setDsconexion($dsconexion)
    {
        $this->dsconexion = $dsconexion;

        return $this;
    }

    /**
     * Get dsconexion
     *
     * @return string
     */
    public function getDsconexion()
    {
        return $this->dsconexion;
    }

    /**
     * Set usuario
     *
     * @param \ModelBundle\Entity\Usuarios $usuario
     *
     * @return UsuariosConexiones
     */
    public function setUsuario(\ModelBundle\Entity\Usuarios $usuario = null)
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get usuario
     *
     * @return \ModelBundle\Entity\Usuarios
     */
    public function getUsuario()
    {
        return $this->usuario;
    }
}

