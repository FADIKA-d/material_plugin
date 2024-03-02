<?php

namespace App\DataFixtures;

use App\Entity\Material;
use App\Entity\VAT;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $vat1 = new VAT();
        $vat1->setVATLabel("normal");
        $vat1->setValue(0.2);
        $manager->persist($vat1);

        $vat2 = new VAT();
        $vat2->setVATLabel("intermediaire");
        $vat2->setValue(0.1);
        $manager->persist($vat2);

        $vat3 = new VAT();
        $vat3->setVATLabel("reduite");
        $vat3->setValue(0.055);
        $manager->persist($vat3);

        $vats = [$vat1, $vat2, $vat3];

        $faker = \Faker\Factory::create("fr_FR");
        for ($i = 0; $i < 50; $i++) {
            $material = new Material();
            $material->setName($faker->word);
            $material->setPriceBeforeTax($faker->randomFloat(2, 50, 10000));
            $material->setVAT($vats[mt_rand(0, 2)]);
            $material->setPriceIncVAT($material->getPriceBeforeTax() * (1 + $material->getVAT()->getValue()));
            $material->setQuantity(mt_rand(1, 20));
            $material->setCreatedAt(\DateTimeImmutable::createFromMutable($faker->dateTimeBetween("-30 days","now")));

            $manager->persist($material);
        }
        $manager->flush();
    }
}
