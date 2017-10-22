<?php

namespace Pokeguys\Luosimao\Service;

class CheckLuosimao implements LuosimaoInterface
{
    /**
     * Validate Luosimao response
     *
     * @param string $response
     *
     * @return bool
     */
    public function check($response)
    {
        $parameters = http_build_query([
            'api_key'   => value(app('config')->get('luosimao.private_key')),
            'response' => $response
        ]);

        $url           = 'https://captcha.luosimao.com/api/site_verify';
        $checkResponse = null;

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HTTP_VERSION  , CURL_HTTP_VERSION_1_0 );
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, app('config')->get('luosimao.options.curl_timeout', 8));
        curl_setopt($curl, CURLOPT_POST, TRUE);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $parameters);
        $checkResponse = curl_exec($curl);

        if($checkResponse === false) {
            app('log')->error('[Luosimao] CURL error: '.curl_error($curl));
        }
        if (is_null($checkResponse) || empty($checkResponse)) {
            return false;
        }

        $decodedResponse = json_decode($checkResponse, true);
        return $decodedResponse['res'] === 'success';
    }
}
