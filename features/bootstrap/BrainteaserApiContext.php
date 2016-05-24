<?php
use Behat\Behat\Context\Context as BehatContext;
use Behat\WebApiExtension\Context\WebApiContext;
use GuzzleHttp\Client;
use PHPUnit_Framework_Assert as Assertions;

class BrainteaserApiContext extends WebApiContext implements BehatContext
{
    /**
     * @param string $baseUrl
     */
    public function __construct($baseUrl)
    {
        $this->setClient(
            new Client(['base_uri' => $baseUrl])
        );
    }

    /**
     * @BeforeSuite
     */
    public static function bootstrapSuite()
    {
        echo 'Bootstrap Suite - Recreate the database, the database will be reseeded before each scenario';
        shell_exec('make setup-db');
    }

    /**
     * @BeforeScenario
     */
    public static function refreshDatabase()
    {
        shell_exec('make reseed-db');
    }

    /**
     * @Then the response should be json
     */
    public function theResponseIsJson()
    {
        $contentType = $this->getResponse()->getHeader('Content-Type');
        if (!is_array($contentType)) {
            $contentType = array($contentType);
        }
        Assertions::assertEquals('application/json', array_shift($contentType));
    }

    /**
     * @param $httpStatusCode
     * @throws Exception
     *
     * @Then /^the response status code should be (\d+)$/
     */
    public function theResponseStatusCodeShouldBe($httpStatusCode)
    {
        $this->theResponseCodeShouldBe($httpStatusCode);
    }

    /**
     * @param string $headerName
     * @param string $regExPattern
     *
     * @throws \Exception
     *
     * @Then /^the response has a "([^"]*)" header which looks like "([^"]*)"$/
     */
    public function theResponseShouldHaveHeaderWhichLooksLike($headerName, $regExPattern)
    {
        Assertions::assertArrayHasKey($headerName, $this->getResponse()->getHeaders());
        $headerValues = $this->getResponse()->getHeader($headerName);
        if (!is_array($headerValues)) {
            $headerValues = array($headerValues);
        }
        $found = false;
        foreach ($headerValues as $headerValue) {
            try {
                Assertions::assertRegExp($regExPattern, $headerValue);
            } catch (\Exception $e) {
                continue;
            }
            $found = true;
            break;
        }

        Assertions::assertTrue(
            $found,
            sprintf(
                'Failed asserting that header "%s" matches regex "%s"',
                $headerName,
                $regExPattern
            )
        );
    }

    /**
     * @param string $errorCode
     *
     * @Then /^the response should contain json with error-code "([^"]*)"$/
     */
    public function theResponseShouldContainJsonWithErrorCode($errorCode)
    {
        $this->theResponseIsJson();

        $responseBody = json_decode($this->getResponse()->getBody(), true);
        Assertions::assertArrayHasKey('error', $responseBody);
        Assertions::assertArrayHasKey('message', $responseBody['error']);
        Assertions::assertEquals(400, $responseBody['error']['http_code']);
        Assertions::assertEquals($errorCode, $responseBody['error']['code']);
    }
    
    /**
     * Fix typehint from baseclass
     *
     * @return \GuzzleHttp\Psr7\Response
     */
    public function getResponse()
    {
        return $this->response;
    }
}