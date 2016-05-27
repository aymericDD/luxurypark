<?php
/**
 * Created by PhpStorm.
 * User: Rico
 * Date: 27/05/2016
 * Time: 02:25
 */

namespace GarageBundle\DataFixtures\ORM;


use Hautelook\AliceBundle\Alice\DataFixtureLoader;

class LoadBrandData extends DataFixtureLoader
{

    /**
     * Returns an array of file paths to fixtures
     *
     * @return array<string>
     */
    protected function getFixtures()
    {
        return array(
          __DIR__ . '/brand.yml'
        );
    }
}