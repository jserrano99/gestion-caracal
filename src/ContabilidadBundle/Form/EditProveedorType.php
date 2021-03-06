<?php

namespace ContabilidadBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class EditProveedorType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nif', TextType::class, array (
                                    "label" => 'nif',
                                    "required" => false,
                                    "attr" => array ("class" => "form-control")))
                ->add('descripcion', TextType::class, array (
                                    "label" => 'Descripcíon',
                                    "required" => false,
                                    "attr" => array ("class" => "form-control")))
                 ->add('cuentaMayor', EntityType::class, array(
                                    "label"=> 'Cuenta Mayor',
                                    "placeholder" => " Seleccione Cuenta de Mayor.... ",
                                    "required" => false,
                                    "disabled"=> true,
                                    "class" => 'ContabilidadBundle:CuentaMayor',
                                    "attr" => array("class" => "form-control")))
                ->add('Guardar', SubmitType::class, array(
                                    "attr" => array("class" => "btn btn-success")));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ContabilidadBundle\Entity\Proveedor'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'contabilidadbundle_proveedor';
    }


}
