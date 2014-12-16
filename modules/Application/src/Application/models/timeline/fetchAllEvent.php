<?php

function fetchAllEvent()
{

    $googleSheets = new GoogleSheets($token->access_token, 'TimelineSheet', 'Sheet1');
        
    return $events;
}