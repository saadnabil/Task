<?php

function resource_collection($resource): array
{
    return json_decode($resource->response()->getContent(), true) ?? [];
}


