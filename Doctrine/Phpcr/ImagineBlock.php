<?php

namespace Symfony\Cmf\Bundle\BlockBundle\Doctrine\Phpcr;

use Symfony\Cmf\Bundle\MediaBundle\Doctrine\Phpcr\Image;
use Symfony\Cmf\Bundle\MediaBundle\ImageInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Block to hold an image
 */
class ImagineBlock extends AbstractBlock
{
    /**
     * @var Image
     */
    protected $image;

    /**
     * @var string
     */
    protected $label;

    /**
     * Optional link url to use on the image
     *
     * @var string
     */
    protected $linkUrl;

    /**
     * @var string
     */
    protected $filter;

    /**
     * @var \PHPCR\NodeInterface
     */
    protected $node;

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'cmf.block.imagine';
    }

    /**
     * Set label
     *
     * @param string $label
     */
    public function setLabel($label)
    {
        $this->label = $label;
    }

    /**
     * Get label
     *
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Set link url
     *
     * @param string $url
     */
    public function setLinkUrl($url)
    {
        $this->linkUrl = $url;
    }

    /**
     * Get link url
     *
     * @return string
     */
    public function getLinkUrl()
    {
        return $this->linkUrl;
    }

    /**
     * Sets the Imagine filter which is going to be used
     *
     * @param string $filter
     */
    public function setFilter($filter)
    {
        $this->filter = $filter;
    }

    /**
     * Get the Imagine filter
     *
     * @return string
     */
    public function getFilter()
    {
        return $this->filter;
    }

    /**
     * Set the image for this block.
     *
     * Setting null will do nothing, as this is what happens when you edit this
     * block in a form without uploading a replacement file.
     *
     * If you need to delete the Image, you can use getImage and delete it with
     * the document manager. Note that this block does not make much sense
     * without an image, though.
     *
     * @param ImageInterface|UploadedFile|null $image optional the image to update
     */
    public function setImage($image = null)
    {
        if (! $image) {
            return;
        }

        if (!$image instanceof ImageInterface && !$image instanceof UploadedFile) {
            $type = is_object($image) ? get_class($image) : gettype($image);

            throw new \InvalidArgumentException(sprintf(
                'Image is not a valid type, "%s" given.',
                $type
            ));
        }

        if ($this->image) {
            // existing image, only update content
            // TODO: https://github.com/doctrine/phpcr-odm/pull/262
            $this->image->copyContentFromFile($image);
        } elseif ($image instanceof ImageInterface) {
            $this->image = $image;
        } else {
            $this->image = new Image();
            $this->image->copyContentFromFile($image);
        }
    }

    /**
     * Get image
     *
     * @return Image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Get node
     *
     * @return \PHPCR\NodeInterface
     */
    public function getNode()
    {
        return $this->node;
    }
}
