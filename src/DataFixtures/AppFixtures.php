<?php

namespace App\DataFixtures;

use App\Entity\Message;
use App\Entity\Thread;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // On configure dans quelles langues nous voulons nos données
        $faker = \Faker\Factory::create('fr_FR');

        for ($i = 1; $i <= 20; $i++) {
            $thread = new Thread();
            $thread->setSubject($faker->sentence())
                    ->setAuthor($faker->name())
                    ->setEmail($faker->email())
                    ->setText($faker->paragraph())
                    ->setCreatedAt(new \Datetime());

            $manager->persist($thread);

            for ($j = 1; $j <= 50; $j++) {
                $message = new Message();
                $message->setSubject($faker->sentence())
                    ->setAuthor($faker->name())
                    ->setEmail($faker->email())
                    ->setText($faker->paragraph())
                    ->setCreatedAt(new \Datetime())
                    ->setThread($thread);

                $manager->persist($message);
            }
        }
        $manager->flush();
    }
}
