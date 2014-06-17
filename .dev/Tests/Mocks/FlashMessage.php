<?php
namespace Molajo\User\Mocks;

use CommonApi\User\FlashMessageInterface;

class MockFlashmessage implements FlashMessageInterface
{
    public function getFlashmessage($type = null)
    {

    }

    public function setFlashmessage($type, $message)
    {
        file_put_contents(
            __DIR__ . '/setFlashMessage.json',
            json_encode('Type: ' . $type . ' ' . ' Message: ' . $message)
        );
    }

    public function deleteFlashmessage($type = null)
    {

    }
}
