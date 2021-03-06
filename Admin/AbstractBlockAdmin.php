<?php

namespace Symfony\Cmf\Bundle\BlockBundle\Admin;

use Sonata\DoctrinePHPCRAdminBundle\Admin\Admin;

/**
 * @author Nicolas Bastien <nbastien@prestaconcept.net>
 */
abstract class AbstractBlockAdmin extends Admin
{
    /**
     * @var string
     */
    protected $translationDomain = 'CmfBlockBundle';

    /**
     * {@inheritdoc}
     */
    public function getExportFormats()
    {
        return array();
    }

    /**
     * {@inheritdoc}
     */
    public function getNewInstance()
    {
        $new = parent::getNewInstance();
        if ($this->hasRequest()) {
            $parentId = $this->getRequest()->query->get('parent');
            if (null !== $parentId) {
                $new->setParentDocument($this->getModelManager()->find(null, $parentId));
            }
        }

        return $new;
    }
}
