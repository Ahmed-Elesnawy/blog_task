<?php

namespace App\Tests;

use App\DataFixtures\UserFixtures;
use App\Entity\User;
use App\Repository\UserRepository;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class PostCommentTest extends WebTestCase
{

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;
    public $client = null;
    protected  $databaseTool;


    protected function setUp(): void
    {
//        $kernel = self::bootKernel();
//
//        $this->entityManager = $kernel->getContainer()
//            ->get('doctrine')
//            ->getManager();


        $this->client = static::createClient();
//        $this->databaseTool = $kernel->getContainer()->get(DatabaseToolCollection::class);

        self::ensureKernelShutdown();

    }
    public function testNotLoggedUserRedirectedToLoginPage(): void
    {

        $crawler = $this->client->request('GET', '/posts/1');

        // assert redirect to login page
        $this->assertResponseRedirects();
    }


//    public function testLoggedUserCanShowPostPageAndComments(): void
//    {
//
//        $this->login();
//
//        $crawler = $this->client->request('GET', '/posts/1');
//
//        $this->assertResponseIsSuccessful();
//    }
//
//
//    private function logIn()
//    {
//        $session = self::$container->get('session');
//
//
//        $this->databaseTool->loadFixtures([
//            UserFixtures::class
//        ]);
//
//        // somehow fetch the user (e.g. using the user repository)
//        $user = $this->entityManager
//            ->getRepository(User::class)
//            ->find(1);
//
//        $firewallName = 'secure_area';
//        // if you don't define multiple connected firewalls, the context defaults to the firewall name
//        // See https://symfony.com/doc/current/reference/configuration/security.html#firewall-context
//        $firewallContext = 'secured_area';
//
//        // you may need to use a different token class depending on your application.
//        // for example, when using Guard authentication you must instantiate PostAuthenticationGuardToken
//        $token = new UsernamePasswordToken($user, null, $firewallName, $user->getRoles());
//        $session->set('_security_'.$firewallContext, serialize($token));
//        $session->save();
//
//        $cookie = new Cookie($session->getName(), $session->getId());
//        $this->client->getCookieJar()->set($cookie);
//    }


}
