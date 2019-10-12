<?php

namespace onefasteuro\ShopifyUtils;

class ShopifyUtils
{

    const URL_AUTHORIZE = 'https://%s.myshopify.com/admin/oauth/authorize?client_id=%s&scope=%s&state=%s&redirect_uri=%s';
    const URL_FOR_TOKEN = 'https://%s/admin/oauth/access_token';


    /**
     * Parses a GID and returns an id
     * @param $gid
     * @return int
     */
    public static function gidParse($gid)
    {
        return intval(preg_replace('/[^0-9]/', '', $gid));
    }

    /**
     * Restore an id into a GID
     * @param $id
     * @param $namespace
     * @return string
     */
    public static function gidRestore($id, $namespace)
    {
        $id = (int) $id;
        return sprintf('gid://shopify/%s/%d', $namespace, $id);
    }

    public static function formatDomain($domain, $protocol = false)
    {
        $domain = trim($domain);
        $domain = rtrim($domain, '/');

        $domain = str_replace(['http://', 'https://'], '', $domain);

        if(!preg_match('/\.myshopify\.com/', $domain)) {
            $domain = sprintf('%s.myshopify.com', $domain);
        }

        return ($protocol === false) ? $domain : sprintf('https://%s', $domain);
    }




    public function getOAuthUrl($shop_prefix, $client_id, $scope, $state, $return_url)
    {
        return sprintf(static::URL_AUTHORIZE, $shop_prefix, $client_id, $scope, $state, $return_url);

    }


}