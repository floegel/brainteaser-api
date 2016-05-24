<?php
namespace Brainteaser\Domain\Training;

use DateTime;

class TrainingFactory
{
    /**
     * @return Training
     */
    public function build() : Training
    {
        return new Training(
            '',
            new DateTime()
        );
    }
}
