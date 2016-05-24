<?php
namespace Brainteaser\InfrastructureBundle\Persistence\Types;

use Brainteaser\Domain\Exercise\Tile;
use Brainteaser\Domain\Exercise\TileSet;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class TileSetType extends Type
{
    const TILESET_TYPE = 'tileset';

    /**
     * @param array $fieldDeclaration
     * @param AbstractPlatform $platform
     * @return string
     */
    public function getSQLDeclaration(
        array $fieldDeclaration,
        AbstractPlatform $platform
    ) : string {
        return 'TILESET';
    }

    /**
     * @param string $value
     * @param AbstractPlatform $platform
     * @return TileSet
     */
    public function convertToPHPValue($value, AbstractPlatform $platform) : TileSet
    {
        $tilesData = json_decode($value, true);
        $tiles = array_map(function($tileData) {
            return new Tile($tileData['x'], $tileData['y']);
        }, $tilesData);
        return new TileSet($tiles);
    }

    /**
     * @param TileSet $value
     * @param AbstractPlatform $platform
     * @return string
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform) : string
    {
        $tilesData = array_map(function(Tile $tile) {
            return [
                'x' => $tile->getX(),
                'y' => $tile->getY()
            ];
        }, (array) $value->getIterator());

        return json_encode(array_values($tilesData));
    }

    /**
     * @return string
     */
    public function getName() : string
    {
        return self::TILESET_TYPE;
    }
}