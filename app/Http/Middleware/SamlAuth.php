<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use SimpleSAML_Configuration;
use SAML2_Compat_Ssp_Container;
use SAML2_Compat_ContainerSingleton;
use SAML2_AuthnRequest;
use SAML2_HTTPRedirect;

class SamlAuth {

    public function handle($request, Closure $next)
    {
         if (!Auth::check()) {
            SimpleSAML_Configuration::setConfigDir(config('saml.config-path'));
	        $container = new SAML2_Compat_Ssp_Container();
	        SAML2_Compat_ContainerSingleton::setContainer($container);
	        $request = new SAML2_AuthnRequest();
	        $request->setIssuer(url('/'));
	        $request->setDestination('https://shib.weber.edu/simplesaml/saml2/idp/SSOService.php');
	        $binding = new SAML2_HTTPRedirect();
	        $binding->send($request);
        }

        return $next($request);
    }
}
