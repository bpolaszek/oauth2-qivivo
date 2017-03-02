<?php

namespace BenTools\Qivivo\OAuth2\Provider;

use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Token\AccessToken;
use League\OAuth2\Client\Tool\BearerAuthorizationTrait;
use Psr\Http\Message\ResponseInterface;

class Qivivo extends AbstractProvider
{

    const SCOPE_USER_BASIC_INFORMATION = 'user_basic_information';
    const SCOPE_READ_DEVICES = 'read_devices';
    const SCOPE_READ_THERMOSTATS = 'read_thermostats';
    const SCOPE_READ_WIRELESS_MODULES = 'read_wireless_modules';
    const SCOPE_READ_PROGRAMMATION = 'read_programmation';
    const SCOPE_UPDATE_PROGRAMMATION = 'update_programmation';
    const SCOPE_READ_HOUSE_DATA = 'read_house_data';
    const SCOPE_UPDATE_HOUSE_SETTINGS = 'update_house_settings';

    use BearerAuthorizationTrait;

    /**
     * Get authorization url to begin OAuth flow
     *
     * @return string
     */
    public function getBaseAuthorizationUrl()
    {
        return 'https://account.qivivo.com';
    }

    /**
     * Get access token url to retrieve token
     *
     * @return string
     */
    public function getBaseAccessTokenUrl(array $params)
    {
        return 'https://account.qivivo.com/oauth/token';
    }

    /**
     * Get provider url to fetch user details
     *
     * @param  AccessToken $token
     *
     * @return string
     *
     * @throws Exception\ResourceOwnerException
     */
    public function getResourceOwnerDetailsUrl(AccessToken $token)
    {
        throw new Exception\ResourceOwnerException;
    }

    /**
     * Get the default scopes used by this provider.
     *
     * This should not be a complete list of all scopes, but the minimum
     * required for the provider user interface!
     *
     * @return array
     */
    protected function getDefaultScopes()
    {
        return [
            self::SCOPE_READ_DEVICES,
            self::SCOPE_READ_THERMOSTATS,
        ];
    }

    /**
     * Returns the string that should be used to separate scopes when building
     * the URL for requesting an access token.
     *
     * @return string Scope separator, defaults to ','
     */
    protected function getScopeSeparator()
    {
        return ' ';
    }

    /**
     * Check a provider response for errors.
     *
     * @throws IdentityProviderException
     * @param  ResponseInterface $response
     * @param  string $data Parsed response data
     * @return void
     */
    protected function checkResponse(ResponseInterface $response, $data)
    {
        $statusCode = $response->getStatusCode();
        if ($statusCode >= 400) {
            throw new IdentityProviderException(
                isset($data['message']) ? $data['message'] : $response->getReasonPhrase(),
                $statusCode,
                $response
            );
        }
    }
    /**
     * Generate a user object from a successful user details request.
     *
     * @param object $response
     * @param AccessToken $token
     * @return \League\OAuth2\Client\Provider\ResourceOwnerInterface
     *
     * @throws Exception\ResourceOwnerException
     */
    protected function createResourceOwner(array $response, AccessToken $token)
    {
        throw new Exception\ResourceOwnerException;
    }
}
