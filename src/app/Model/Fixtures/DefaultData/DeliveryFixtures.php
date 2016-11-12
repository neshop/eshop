<?php

namespace App\Model\Fixtures\DefaultData;

use App\Model\Eshop\Delivery;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class DeliveryFixtures extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $cpost = new Delivery('cpost', 'Česká pošta - balík do ruky');
        $ppl = new Delivery('ppl', 'PPL');
        $dpd = new Delivery('dpd', 'DPD');

        $manager->persist($cpost);
        $manager->persist($ppl);
        $manager->persist($dpd);

        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 100;
    }
}
