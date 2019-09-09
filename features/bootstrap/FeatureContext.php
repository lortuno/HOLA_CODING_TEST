<?php

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

/**
 * Defines application features from the specific context.
 */
class FeatureContext extends BasicContext
{
    /**
     * @When I fill in the input box :selector with :term
     */
    public function iFillInTheInputBoxWith($selector, $term)
    {
        $inputBox = $this->assertSession()
            ->elementExists('css', $selector);

        $inputBox->setValue($term);
    }
}
