<?php

if (! function_exists('resourceCalls')) {
    function resourceCalls($request, $allowedIncludeResources)
    {
        $include = array_filter(explode(',', $request->include));
        $invalid = array_diff($include, $allowedIncludeResources);
        return ['valid' => $include, 'invalid' => $invalid];
    }
}