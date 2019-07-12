<?php

namespace Metrogistics\AzureSocialite;

use Illuminate\Support\Arr;
use Laravel\Socialite\Two\User;
use Laravel\Socialite\Two\AbstractProvider;
use Laravel\Socialite\Two\ProviderInterface;
use Laravel\Socialite\Two\InvalidStateException;

class AzureOauthProvider extends AbstractProvider implements ProviderInterface
{
    const IDENTIFIER = 'AZURE_OAUTH';
    protected $scopes = ['User.Read'];
    protected $scopeSeparator = ' ';
    protected $response = '';

    protected function getAuthUrl($state)
    {
        return $this->buildAuthUrlFromBase('https://login.microsoftonline.com/common/oauth2/authorize', $state);
    }

    protected function getTokenUrl()
    {
        return 'https://login.microsoftonline.com/common/oauth2/token';
    }

    protected function getTokenFields($code)
    {
        return array_merge(parent::getTokenFields($code), [
            'grant_type' => 'authorization_code',
            'resource' => 'https://graph.microsoft.com',
        ]);
    }

    protected function getGroupsByToken($token)
    {
        $response = $this->getHttpClient()->get('https://graph.microsoft.com/v1.0/me/memberOf', [
            'headers' => [
                'Authorization' => 'Bearer '.$token,
            ],
        ]);

        $raw_groups = json_decode($response->getBody(), true);
        $group_array = [];

        if(!empty($raw_groups['value'])){
            foreach($raw_groups['value'] as $group){
                $group_array['groups'][$group['displayName']] = $group;
            }
        }

        return $group_array;
    }

    protected function getUserByToken($token)
    {
        $response = $this->getHttpClient()->get('https://graph.microsoft.com/v1.0/me/', [
            'headers' => [
                'Authorization' => 'Bearer '.$token,
            ],
        ]);

        return json_decode($response->getBody(), true);
    }

    public function user()
    {
        if ($this->hasInvalidState()) {
            throw new InvalidStateException;
        }

        $this->response = $this->getAccessTokenResponse($this->getCode());

        $user = $this->mapUserToObject($this->getUserByToken(
            $token = Arr::get($this->response, 'access_token')
        ), $this->response);

        $user->idToken = Arr::get($this->response, 'id_token');
        $user->expiresAt = time() + Arr::get($this->response, 'expires_in');

        return $user->setToken($token)
                    ->setRefreshToken(Arr::get($this->response, 'refresh_token'));
    }

    protected function mapUserToObject(array $user)
    {
        $groups = $this->getGroupsByToken(
            $token = Arr::get($this->response, 'access_token')
        );

        $user = array_merge($user, $groups);

        return (new User())->setRaw($user)->map([
            'id'                => $user['id'],
            'name'              => $user['displayName'],
            'email'             => $user['userPrincipalName'],

            'businessPhones'    => $user['businessPhones'],
            'displayName'       => $user['displayName'],
            'givenName'         => $user['givenName'],
            'jobTitle'          => $user['jobTitle'],
            'mail'              => $user['mail'],
            'mobilePhone'       => $user['mobilePhone'],
            'officeLocation'    => $user['officeLocation'],
            'preferredLanguage' => $user['preferredLanguage'],
            'surname'           => $user['surname'],
            'userPrincipalName' => $user['userPrincipalName'],
        ]);
    }
}
