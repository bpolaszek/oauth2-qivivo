<?php

namespace BenTools\Qivivo\Tests\OAuth2\Provider;

use BenTools\Qivivo\OAuth2\Provider\Qivivo;
use Mockery as m;

class QivivoTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Qivivo
     */
    protected $provider;

    protected function setUp()
    {
        $this->provider = new Qivivo([
            'clientId' => 'mock_client_id',
            'clientSecret' => 'mock_secret',
            'redirectUri' => 'none',
        ]);
    }

    protected function getJsonFile($file, $encode = false)
    {
        $json = file_get_contents(dirname(dirname(dirname(__FILE__))).'/'.$file);
        $data = json_decode($json, true);

        if ($encode && json_last_error() == JSON_ERROR_NONE) {
            return $data;
        }

        return $json;
    }

    public function tearDown()
    {
        m::close();
        parent::tearDown();
    }

    public function testAuthorizationUrl()
    {
        $url = $this->provider->getAuthorizationUrl();
        $uri = parse_url($url);
        parse_str($uri['query'], $query);

        $this->assertArrayHasKey('client_id', $query);
        $this->assertArrayHasKey('redirect_uri', $query);
        $this->assertArrayHasKey('state', $query);
        $this->assertArrayHasKey('scope', $query);
        $this->assertArrayHasKey('response_type', $query);
        $this->assertArrayHasKey('approval_prompt', $query);
        $this->assertNotNull($this->provider->getState());
    }

    public function testScopes()
    {
        $options = ['scope' => [uniqid(),uniqid()]];

        $url = $this->provider->getAuthorizationUrl($options);

        $this->assertContains(urlencode(implode(' ', $options['scope'])), $url);
    }

    public function testGetAuthorizationUrl()
    {
        $url = $this->provider->getAuthorizationUrl();
        $uri = parse_url($url);

        $this->assertEquals('data.qivivo.com', $uri['host']);
        $this->assertEquals('/oauth/authorize', $uri['path']);
    }

    public function testGetBaseAccessTokenUrl()
    {
        $params = [];

        $url = $this->provider->getBaseAccessTokenUrl($params);
        $uri = parse_url($url);

        $this->assertEquals('data.qivivo.com', $uri['host']);
        $this->assertEquals('/oauth/token', $uri['path']);
    }

    public function testGetAccessToken()
    {
        $accessToken = $this->getJsonFile('access_token_response.json');
        $response = m::mock('Psr\Http\Message\ResponseInterface');
        $response->shouldReceive('getBody')->andReturn($accessToken);
        $response->shouldReceive('getHeader')->andReturn(['content-type' => 'json']);
        $response->shouldReceive('getStatusCode')->andReturn(200);

        $client = m::mock('GuzzleHttp\ClientInterface');
        $client->shouldReceive('send')->times(1)->andReturn($response);
        $this->provider->setHttpClient($client);

        $token = $this->provider->getAccessToken('authorization_code', ['code' => 'mock_authorization_code']);

        $this->assertEquals('mock_access_token', $token->getToken());
        $this->assertNull($token->getRefreshToken());
    }

    /**
     * @expectedException \BenTools\Qivivo\OAuth2\Provider\Exception\ResourceOwnerException
     **/
    public function testUserData()
    {
        $token = m::mock('League\OAuth2\Client\Token\AccessToken');
        $user = $this->provider->getResourceOwner($token);
    }

    /**
     * @expectedException \BenTools\Qivivo\OAuth2\Provider\Exception\ResourceOwnerException
     **/
    public function testCreateResourceOwner()
    {
        $token = m::mock('League\OAuth2\Client\Token\AccessToken');
        $class = new \ReflectionClass('BenTools\Qivivo\OAuth2\Provider\Qivivo');
        $method = $class->getMethod('createResourceOwner');
        $method->setAccessible(true);
        $user = $method->invokeArgs($this->provider, array([], $token));
    }

}
