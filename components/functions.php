<?php

/**
 * Prints the data and continues executing the code.
 *
 * @param $data
 * @return void
 */
function printData($data): void
{
    echo '<pre>';
    print_r($data);
    echo '</pre>';
}

/**
 * Print data and die (pdd). Prints the data and stops executing the code.
 *
 * @param $data
 * @return void
 */
function pdd($data)
{
    echo '<pre>';
    print_r($data);
    echo '</pre>';

    die();
}
