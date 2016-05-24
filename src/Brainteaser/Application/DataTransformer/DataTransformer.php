<?php
namespace Brainteaser\Application\DataTransformer;

interface DataTransformer
{
    /**
     * @param mixed $item
     * @return array
     */
    public function transform($item) : array;
}