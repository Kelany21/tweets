<?php

function getDirection()
{
    return LaravelLocalization::getCurrentLocaleDirection() === 'rtl' ? 'right' : 'left';
}
