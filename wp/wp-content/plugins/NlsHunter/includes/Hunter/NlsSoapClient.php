<?php


/**
 * Description of NlsSoapClient
 *
 * @author nurielmeni
 */
class NlsSoapClient extends SoapClient
{
    function __doRequest($request, $location, $action, $version, $one_way = NULL) 
    {
        set_exception_handler([$this, 'handleException']);
        if (strpos($location, 'SecurityService')) { 
            $namespace = "http://NilooSoft.com";

            $request = preg_replace('/<ns1:(\w+)/', '<$1 xmlns="' . $namespace . '"', $request, 1);
            $request = preg_replace('/<ns1:(\w+)/', '<$1', $request);
            $request = str_replace(array('/ns1:', 'xmlns:ns1="' . $namespace . '"'), array('/', ''), $request);
        }
        // parent call
        return parent::__doRequest($request, $location, $action, $version);
    }
    public function handleException($e)
    {
        if (strpos($e->getMessage(), 'Security Service Evaluate Failed') !== false) {
            header('Location: ' . esc_url( home_url( '/' ) ));
            die();
        }
        restore_exception_handler();
        throw $e;
    }
}
