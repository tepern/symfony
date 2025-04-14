<?php

namespace App\Form\DataTransformer;

use App\Entity\Tag;
use App\Repository\TagRepository;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\Common\Collections\ArrayCollection;

class TagTransformer implements DataTransformerInterface
{
    public function __construct(
        private readonly TagRepository $tagRepository,
    ) {
    }

    /**
     * Transforms an object (tag) to a string (number).
     *
     * @param  PersistentCollection<Tag> $tags
     * @return string
     */
    public function transform($tags): string
    {
        if (null === $tags) {
            return '';
        }
        
        $array = [];
        foreach ($tags as $tag) {
            /**@var Tag $tag */
            $array[] = $tag->getName();
        }

        return implode(',', $array);
    }

    /**
     * Transforms a string (number) to an object (tags).
     *
     * @param mixed $value
     * @throws TransformationFailedException if object (tags) is not found.
     */
    public function reverseTransform(mixed $value = null): ArrayCollection
    {
        if (!$value) {
            return new ArrayCollection();
        }
        
        $items = explode(",", $value);
        $items = array_map('trim', $items);
        $items = array_unique($items);
        
        $tags = new ArrayCollection();

        foreach ($items as $item) {
            $tag = $this->tagRepository->findOneBy(['name' => $item]);
            if (!$tag) {
                $tag = (new Tag())->setName($item);
            }
            
            $tags->add($tag);
        }

        return $tags;
    }
}