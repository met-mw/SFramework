<?php
namespace App\Models;


use SORM\DataSource;
use SORM\Entity;

/**
 * Class Structure
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $structure_id
 * @property string $path
 * @property string $frame
 * @property int $module_id
 * @property int $is_main
 * @property int $anchor
 * @property int $priority
 * @property string $seo_title
 * @property string $seo_description
 * @property string $seo_keywords
 * @property int $active
 * @property int $deleted
 */
class Structure extends Entity
{

    protected $tableName = 'structure';

    public function prepareRelations()
    {
        $this->field('structure_id')
            ->addRelationMTO(DataSource::factory(Structure::cls()));

        $this->field()
            ->addRelationOTM(DataSource::factory(Structure::cls()), 'structure_id');
    }

    public function getStructureFragments()
    {
        /** @var Structure[] $aStructures */
        $aStructures = $this->findRelationCache($this->getPrimaryKeyName(), Structure::cls());
        if (empty($aStructures)) {
            $oStructures = DataSource::factory(Structure::cls());
            $oStructures->builder()
                ->where("structure_id={$this->id}")
                ->whereAnd()
                ->where('anchor=1');

            $aStructures = $oStructures->findAll();

            foreach ($aStructures as $oStructure) {
                $this->addRelationCache('id', $oStructure);
                $oStructure->addRelationCache('structure_id', $this);
            }
        }

        return $aStructures;
    }

    public function getParentStructure()
    {
        /** @var Structure[] $aStructures */
        $aStructures = $this->findRelationCache('structure_id', Structure::cls());
        if (empty($aStructures)) {
            $oStructures = DataSource::factory(Structure::cls());
            $oStructures->builder()
                ->where("id={$this->structure_id}");

            $aStructures = $oStructures->findAll();
            foreach ($aStructures as $oStructure) {
                $oStructure->addRelationCache('id', $this);
            }
        }

        return $aStructures[0];
    }

}