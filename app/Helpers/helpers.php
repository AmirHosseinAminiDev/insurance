<?php

if (!function_exists('gatewayService')) {
    /**
     * @return \App\Services\GatewayService
     */
    function gatewayService(): \App\Services\GatewayService
    {
        return resolve('GatewayService');
    }
}
