<?php
require __DIR__.'/vendor/autoload.php';

use App\Kernel;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\ORM\EntityManagerInterface;

$kernel = new Kernel('dev', true);
$kernel->boot();
$container = $kernel->getContainer();

/** @var EntityManagerInterface $em */
$em = $container->get(EntityManagerInterface::class);
/** @var UserPasswordHasherInterface $hasher */
$hasher = $container->get(UserPasswordHasherInterface::class);

$user = new User();
$user->setEmail('admin@test.com');
$user->setRoles(['ROLE_ADMIN']);
$user->setPassword($hasher->hashPassword($user, 'admin123'));

$em->persist($user);
$em->flush();

echo "Admin créé avec email admin@test.com et password admin123\n";

