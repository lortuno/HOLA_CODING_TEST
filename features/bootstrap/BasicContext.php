<?php

use Behat\MinkExtension\Context\RawMinkContext;
use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;

class BasicContext extends RawMinkContext implements Context, SnippetAcceptingContext
{
    protected $session;

    protected $request;

    protected $client;

    public function __construct()
    {
    }

    /**
     * @When I click :linkName
     */
    public function iClick($linkName)
    {
        $this->getPage()->clickLink($linkName);
    }

    /**
     * Setea el parámetro.
     *
     * @param   string  $param
     * @param   mixed   $value
     */
    public function setParameter($param, $value)
    {
        $paramValue = $this->getContainer()->setParameter($param, $value);
    }

    /**
     * @return \Behat\Mink\Element\DocumentElement
     */
    public function getPage()
    {
        return $this->getSession()->getPage();
    }

    /**
     * @return \Doctrine\ORM\EntityManager
     */
    public function getEntityManager()
    {
        return $this->getContainer()->get('doctrine.orm.entity_manager');
    }
}
